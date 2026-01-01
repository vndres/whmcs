<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Client;
use App\Models\Product;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CpanelService;
use Illuminate\Support\Facades\Log;
use App\Services\RegistrarFactory;

class ServiceController extends Controller
{
    protected function ensureAdmin()
    {
        $user = Auth::user();
        if (!$user || $user->type !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
    }

    /**
     * Listado de servicios.
     */
     // ... dentro de la clase ServiceController

    public function registerDomain(Service $service)
    {
        $this->ensureAdmin();

        // 1. Validaciones
        if (!$service->product || $service->product->type !== 'domain') {
            return back()->withErrors('Este servicio no es un dominio.');
        }
        
        if (!$service->product->registrar) {
            return back()->withErrors('El producto no tiene un registrador configurado.');
        }

        try {
            // 2. Obtener instancia del registrador (GoDaddy o ResellerClub)
            $registrar = RegistrarFactory::make($service->product->registrar);

            // 3. Preparar datos
            // Nameservers: por defecto usar los del servidor asociado, o unos genéricos
            $ns = ['ns1.tuhosting.com', 'ns2.tuhosting.com']; 
            if ($service->server) {
                $ns = [$service->server->hostname, 'ns2.' . $service->server->hostname]; // Lógica simple de NS
            }

            // Datos del cliente
            $contact = $service->client->toArray(); 

            // 4. Ejecutar registro
            $result = $registrar->registerDomain(
                $service->domain,
                1, // 1 año por defecto, o leer de $service->billing_cycles
                $ns,
                $contact
            );

            // 5. Éxito
            $service->update([
                'status' => 'active',
                'activation_date' => now(),
            ]);

            return back()->with('success', '¡Dominio registrado exitosamente!');

        } catch (\Exception $e) {
            return back()->withErrors('Error al registrar dominio: ' . $e->getMessage());
        }
    }
     
    public function index(Request $request)
    {
        $this->ensureAdmin();

        $query = Service::with(['client', 'product', 'server'])
            ->orderByDesc('id');

        // Filtros simples opcionales
        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->integer('client_id'));
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->integer('product_id'));
        }

        $services = $query->paginate(20)->withQueryString();

        $clients  = Client::orderBy('first_name')->orderBy('last_name')->get();
        $products = Product::orderBy('name')->get();

        return view('admin.services.index', compact('services', 'clients', 'products'));
    }

    /**
     * Formulario para crear servicio.
     */
    public function create()
    {
        $this->ensureAdmin();

        $clients  = Client::orderBy('first_name')->orderBy('last_name')->get();
        $products = Product::where('is_active', 1)->orderBy('name')->get();
        $servers  = Server::where('is_active', 1)->orderBy('name')->get();

        $statuses = [
            'pending'   => 'Pendiente',
            'active'    => 'Activo',
            'suspended' => 'Suspendido',
            'cancelled' => 'Cancelado',
        ];

        return view('admin.services.create', compact('clients', 'products', 'servers', 'statuses'));
    }

    /**
     * Guardar nuevo servicio.
     */
    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'client_id'         => 'required|integer|exists:clients,id',
            'product_id'        => 'required|integer|exists:products,id',
            'server_id'         => 'nullable|integer|exists:servers,id',
            'status'            => 'required|string|in:pending,active,suspended,cancelled',
            'domain'            => 'nullable|string|max:190',
            'username'          => 'nullable|string|max:190',
            'password'          => 'nullable|string|max:190',
            'next_due_date'     => 'nullable|date',
            'activation_date'   => 'nullable|date',
            'cancellation_date' => 'nullable|date',
            'config_raw'        => 'nullable|string',
        ]);

        $validated['next_due_date']     = $request->input('next_due_date') ?: null;
        $validated['activation_date']   = $request->input('activation_date') ?: null;
        $validated['cancellation_date'] = $request->input('cancellation_date') ?: null;

        $configRaw = $request->input('config_raw');
        if ($configRaw) {
            $decoded = json_decode($configRaw, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $validated['config'] = $decoded;
            } else {
                $validated['config'] = null;
            }
        } else {
            $validated['config'] = null;
        }

        unset($validated['config_raw']);

        Service::create($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Servicio creado correctamente.');
    }

    /**
     * Formulario de edición.
     */
    public function edit(Service $service)
    {
        $this->ensureAdmin();

        $service->load(['client', 'product', 'server']);

        $clients  = Client::orderBy('first_name')->orderBy('last_name')->get();
        $products = Product::orderBy('name')->get();
        $servers  = Server::orderBy('name')->get();

        $statuses = [
            'pending'   => 'Pendiente',
            'active'    => 'Activo',
            'suspended' => 'Suspendido',
            'cancelled' => 'Cancelado',
        ];

        $configRaw = $service->config
            ? json_encode($service->config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            : '';

        return view('admin.services.edit', compact(
            'service',
            'clients',
            'products',
            'servers',
            'statuses',
            'configRaw'
        ));
    }

    /**
     * Actualizar servicio.
     */
    public function update(Request $request, Service $service)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'client_id'         => 'required|integer|exists:clients,id',
            'product_id'        => 'required|integer|exists:products,id',
            'server_id'         => 'nullable|integer|exists:servers,id',
            'status'            => 'required|string|in:pending,active,suspended,cancelled',
            'domain'            => 'nullable|string|max:190',
            'username'          => 'nullable|string|max:190',
            'password'          => 'nullable|string|max:190',
            'next_due_date'     => 'nullable|date',
            'activation_date'   => 'nullable|date',
            'cancellation_date' => 'nullable|date',
            'config_raw'        => 'nullable|string',
        ]);

        $validated['next_due_date']     = $request->input('next_due_date') ?: null;
        $validated['activation_date']   = $request->input('activation_date') ?: null;
        $validated['cancellation_date'] = $request->input('cancellation_date') ?: null;

        $configRaw = $request->input('config_raw');
        if ($configRaw) {
            $decoded = json_decode($configRaw, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $validated['config'] = $decoded;
            } else {
                $validated['config'] = $service->config;
            }
        } else {
            $validated['config'] = null;
        }

        unset($validated['config_raw']);

        $service->update($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    /**
     * Acción para aprovisionar (crear) el servicio en el servidor.
     */
    public function provision(Service $service)
    {
        $this->ensureAdmin();

        if (!$service->server) {
            return back()->withErrors('Este servicio no tiene un servidor asignado.');
        }

        if (!$service->username || !$service->password || !$service->domain) {
            return back()->withErrors('Faltan datos de acceso (usuario, pass, dominio) para crear la cuenta.');
        }

        try {
            // Instanciar el servicio de cPanel con el servidor del servicio
            $cpanel = new CpanelService($service->server);
            
            // Llamar a la API
            $cpanel->createAccount($service);

            // Si todo sale bien, actualizamos estado local
            $service->update([
                'status' => 'active',
                'activation_date' => now(),
            ]);

            return back()->with('success', '¡Cuenta creada exitosamente en cPanel/WHM!');

        } catch (\Exception $e) {
            return back()->withErrors('Error al aprovisionar: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar servicio.
     */
    public function destroy(Service $service)
    {
        $this->ensureAdmin();

        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Servicio eliminado correctamente.');
    }
}