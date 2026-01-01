<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    protected function ensureAdmin()
    {
        $user = Auth::user();
        if (!$user || $user->type !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
    }

    /**
     * Generar el siguiente número de factura tipo INV-0001
     */
    protected function generateNextInvoiceNumber(): string
    {
        $last = Invoice::orderByDesc('id')->first();

        if (!$last) {
            $next = 1;
        } else {
            $current = $last->number;
            // Buscar el último bloque numérico dentro del número
            if (preg_match('/(\d+)(?!.*\d)/', $current, $matches)) {
                $next = (int) $matches[1] + 1;
            } else {
                $next = $last->id + 1;
            }
        }

        return 'INV-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Listado de facturas
     */
    public function index(Request $request)
    {
        $this->ensureAdmin();

        $query = Invoice::query()->orderByDesc('id');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->integer('client_id'));
        }

        $invoices = $query->paginate(20)->withQueryString();
        $clients  = Client::orderBy('first_name')->orderBy('last_name')->get();

        $statuses = [
            'unpaid'   => 'Pendiente de pago',
            'paid'     => 'Pagada',
            'overdue'  => 'Vencida',
            'cancelled'=> 'Cancelada',
        ];

        return view('admin.invoices.index', compact('invoices', 'clients', 'statuses'));
    }

    /**
     * Formulario crear factura
     */
    public function create()
    {
        $this->ensureAdmin();

        $clients = Client::orderBy('first_name')->orderBy('last_name')->get();
        $statuses = [
            'unpaid'   => 'Pendiente de pago',
            'paid'     => 'Pagada',
            'overdue'  => 'Vencida',
            'cancelled'=> 'Cancelada',
        ];

        $suggestedNumber = $this->generateNextInvoiceNumber();

        return view('admin.invoices.create', compact('clients', 'statuses', 'suggestedNumber'));
    }

    /**
     * Guardar nueva factura
     */
    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'number'     => 'nullable|string|max:100',
            'client_id'  => 'required|integer|exists:clients,id',
            'issue_date' => 'required|date',
            'due_date'   => 'required|date',
            'status'     => 'required|string|in:unpaid,paid,overdue,cancelled',
            'currency'   => 'required|string|size:3',

            'items'                   => 'required|array|min:1',
            'items.*.description'     => 'required|string|max:255',
            'items.*.quantity'        => 'required|numeric|min:0.01',
            'items.*.unit_price'      => 'required|numeric',
            'items.*.tax_rate'        => 'nullable|numeric|min:0',
        ]);

        // Limpiar y normalizar items
        $itemsInput = collect($validated['items'])
            ->filter(fn ($item) => !empty($item['description']))
            ->values();

        if ($itemsInput->isEmpty()) {
            return back()
                ->withErrors(['items' => 'Debes agregar al menos un concepto de factura.'])
                ->withInput();
        }

        $subtotal = 0;
        $taxTotal = 0;

        $normalizedItems = [];

        foreach ($itemsInput as $item) {
            $qty  = (float) $item['quantity'];
            $unit = (float) $item['unit_price'];
            $taxR = isset($item['tax_rate']) ? (float) $item['tax_rate'] : 0.0;

            $lineSubtotal = $qty * $unit;
            $lineTax      = $lineSubtotal * ($taxR / 100);
            $lineTotal    = $lineSubtotal + $lineTax;

            $subtotal += $lineSubtotal;
            $taxTotal += $lineTax;

            $normalizedItems[] = [
                'description' => $item['description'],
                'quantity'    => $qty,
                'unit_price'  => $unit,
                'tax_rate'    => $taxR,
                'total'       => $lineTotal,
            ];
        }

        $invoiceNumber = $validated['number'] ?: $this->generateNextInvoiceNumber();

        $invoice = Invoice::create([
            'number'      => $invoiceNumber,
            'client_id'   => $validated['client_id'],
            'issue_date'  => $validated['issue_date'],
            'due_date'    => $validated['due_date'],
            'status'      => $validated['status'],
            'currency'    => strtoupper($validated['currency']),
            'subtotal'    => $subtotal,
            'tax_total'   => $taxTotal,
            'total'       => $subtotal + $taxTotal,
            'amount_paid' => 0.00,
        ]);

        foreach ($normalizedItems as $item) {
            InvoiceItem::create([
                'invoice_id'   => $invoice->id,
                'billable_id'  => null,
                'billable_type'=> null,
                'description'  => $item['description'],
                'quantity'     => $item['quantity'],
                'unit_price'   => $item['unit_price'],
                'tax_rate'     => $item['tax_rate'],
                'total'        => $item['total'],
            ]);
        }

        return redirect()
            ->route('admin.invoices.edit', $invoice)
            ->with('success', 'Factura creada correctamente.');
    }

    /**
     * Editar factura
     */
    public function edit(Invoice $invoice)
    {
        $this->ensureAdmin();

        $invoice->load('items', 'client');

        $clients = Client::orderBy('first_name')->orderBy('last_name')->get();
        $statuses = [
            'unpaid'   => 'Pendiente de pago',
            'paid'     => 'Pagada',
            'overdue'  => 'Vencida',
            'cancelled'=> 'Cancelada',
        ];

        return view('admin.invoices.edit', compact('invoice', 'clients', 'statuses'));
    }

    /**
     * Actualizar factura
     */
    public function update(Request $request, Invoice $invoice)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'number'     => 'required|string|max:100',
            'client_id'  => 'required|integer|exists:clients,id',
            'issue_date' => 'required|date',
            'due_date'   => 'required|date',
            'status'     => 'required|string|in:unpaid,paid,overdue,cancelled',
            'currency'   => 'required|string|size:3',

            'items'                   => 'required|array|min:1',
            'items.*.description'     => 'required|string|max:255',
            'items.*.quantity'        => 'required|numeric|min:0.01',
            'items.*.unit_price'      => 'required|numeric',
            'items.*.tax_rate'        => 'nullable|numeric|min:0',
        ]);

        $itemsInput = collect($validated['items'])
            ->filter(fn ($item) => !empty($item['description']))
            ->values();

        if ($itemsInput->isEmpty()) {
            return back()
                ->withErrors(['items' => 'Debes agregar al menos un concepto de factura.'])
                ->withInput();
        }

        $subtotal = 0;
        $taxTotal = 0;
        $normalizedItems = [];

        foreach ($itemsInput as $item) {
            $qty  = (float) $item['quantity'];
            $unit = (float) $item['unit_price'];
            $taxR = isset($item['tax_rate']) ? (float) $item['tax_rate'] : 0.0;

            $lineSubtotal = $qty * $unit;
            $lineTax      = $lineSubtotal * ($taxR / 100);
            $lineTotal    = $lineSubtotal + $lineTax;

            $subtotal += $lineSubtotal;
            $taxTotal += $lineTax;

            $normalizedItems[] = [
                'description' => $item['description'],
                'quantity'    => $qty,
                'unit_price'  => $unit,
                'tax_rate'    => $taxR,
                'total'       => $lineTotal,
            ];
        }

        $invoice->update([
            'number'      => $validated['number'],
            'client_id'   => $validated['client_id'],
            'issue_date'  => $validated['issue_date'],
            'due_date'    => $validated['due_date'],
            'status'      => $validated['status'],
            'currency'    => strtoupper($validated['currency']),
            'subtotal'    => $subtotal,
            'tax_total'   => $taxTotal,
            'total'       => $subtotal + $taxTotal,
            // amount_paid lo dejaremos para otro módulo (pagos)
        ]);

        // Borramos ítems anteriores y los recreamos
        $invoice->items()->delete();

        foreach ($normalizedItems as $item) {
            InvoiceItem::create([
                'invoice_id'   => $invoice->id,
                'billable_id'  => null,
                'billable_type'=> null,
                'description'  => $item['description'],
                'quantity'     => $item['quantity'],
                'unit_price'   => $item['unit_price'],
                'tax_rate'     => $item['tax_rate'],
                'total'        => $item['total'],
            ]);
        }

        return redirect()
            ->route('admin.invoices.edit', $invoice)
            ->with('success', 'Factura actualizada correctamente.');
    }

    /**
     * Eliminar factura
     */
    public function destroy(Invoice $invoice)
    {
        $this->ensureAdmin();

        $invoice->items()->delete();
        $invoice->delete();

        return redirect()
            ->route('admin.invoices.index')
            ->with('success', 'Factura eliminada correctamente.');
    }
}
