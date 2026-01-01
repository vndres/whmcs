<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
// Importamos el servicio de WhatsApp y Log
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        if ($lang = $request->query('lang')) {
            if (in_array($lang, ['es', 'en'])) {
                App::setLocale($lang);
                session(['locale' => $lang]);
            }
        } elseif (session()->has('locale')) {
            App::setLocale(session('locale'));
        }

        // Si ya está logueado, verificamos su rol para redirigir correctamente
        if (Auth::check()) {
            if (Auth::user()->type === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => __('El correo es obligatorio.'),
            'email.email'       => __('Debes ingresar un correo válido.'),
            'password.required' => __('La contraseña es obligatoria.'),
        ]);

        $remember = $request->boolean('remember');

        $loginData = [
            'email'     => $credentials['email'],
            'password'  => $credentials['password'],
            'is_active' => 1,
        ];

        if (Auth::attempt($loginData, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Configurar idioma del usuario
            $userLocale = $user->locale ?? 'es';
            App::setLocale($userLocale);
            session(['locale' => $userLocale]);

            // === 🚀 LÓGICA DE NOTIFICACIÓN WHATSAPP DE INICIO DE SESIÓN (AÑADIDA AQUÍ) ===
            try {
                // Necesitamos el número de teléfono limpio para enviar el WhatsApp.
                // Lo buscamos en la tabla 'clients' relacionada con el 'user'.
                // Usamos first() porque asumimos que 1 usuario = 1 cliente.
                $client = Client::where('user_id', $user->id)->first();
                $cleanPhone = $client ? $client->phone : null;

                if ($cleanPhone) {
                    $whatsapp = new WhatsAppService();
                    $ipAddress = $request->ip();
                    $loginTime = now()->format('d/m/Y H:i');

                    $mensaje = "🔒 *ALERTA DE SEGURIDAD* 🔒\n\n";
                    $mensaje .= "Se ha registrado un inicio de sesión en tu panel de Linea365 Clientes.\n\n";
                    $mensaje .= "👤 *Usuario:* {$user->name}\n";
                    $mensaje .= "⏰ *Hora:* {$loginTime}\n";
                    $mensaje .= "📍 *IP:* {$ipAddress}\n\n";
                    $mensaje .= "Si *no fuiste tú*, por favor, accede inmediatamente para cambiar tu contraseña.";
                    
                    // Enviar texto al número (limpio, sin el '+')
                    $whatsapp->send($cleanPhone, $mensaje);
                }

            } catch (\Exception $e) {
                // Log silencioso para no interrumpir el login si el bot falla
                Log::error("Error enviando WhatsApp de inicio de sesión: " . $e->getMessage());
            }
            // === FIN DE LA LÓGICA DE NOTIFICACIÓN ===

            // LÓGICA DE REDIRECCIÓN POR ROL
            if ($user->type === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // Si es cliente normal
            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withErrors([
                'email' => __('Estas credenciales no coinciden o el usuario está inactivo.'),
            ])
            ->withInput($request->only('email'));
    }

    public function showRegisterForm(Request $request)
    {
        if ($lang = $request->query('lang')) {
            if (in_array($lang, ['es', 'en'])) {
                App::setLocale($lang);
                session(['locale' => $lang]);
            }
        } elseif (session()->has('locale')) {
            App::setLocale(session('locale'));
        }

        // Redirección inteligente si ya está logueado
        if (Auth::check()) {
            if (Auth::user()->type === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. VALIDACIÓN
        $data = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:users,email'],
            // Validamos 'string' porque el frontend envía el número con formato internacional (ej: +57300...)
            'phone'     => ['required', 'string'],
            'password'  => ['required', 'min:6', 'confirmed'],
            'locale'    => ['required', 'in:es,en'],
        ], [
            'name.required'     => __('El nombre es obligatorio.'),
            'email.required'    => __('El correo es obligatorio.'),
            'email.email'       => __('Debes ingresar un correo válido.'),
            'email.unique'      => __('Este correo ya está registrado.'),
            'phone.required'    => __('El celular es obligatorio.'),
            'password.required' => __('La contraseña es obligatoria.'),
            'password.min'      => __('La contraseña debe tener al menos 6 caracteres.'),
            'password.confirmed'=> __('Las contraseñas no coinciden.'),
            'locale.required'   => __('Debes elegir un idioma.'),
            'locale.in'         => __('Idioma no válido.'),
        ]);

        // 2. LIMPIEZA DEL NÚMERO
        // El frontend envía "+573001234567". Quitamos el "+" para guardar "573001234567".
        $cleanPhone = str_replace('+', '', $data['phone']);

        // Crear usuario
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'type'      => 'client', // Por defecto el registro público es para clientes
            'locale'    => $data['locale'],
            'is_active' => 1,
        ]);

        // Crear cliente vinculado
        $names = explode(' ', $data['name'], 2);
        $firstName = $names[0] ?? $data['name'];
        $lastName  = $names[1] ?? '';

        Client::create([
            'user_id'       => $user->id,
            'uuid'          => Str::uuid()->toString(),
            'company_name'  => null,
            'first_name'    => $firstName,
            'last_name'     => $lastName,
            'email'         => $data['email'],
            'phone'         => $cleanPhone, // Guardamos el número limpio con código país
            'country'       => 'CO', // Puedes mejorarlo luego con detección de IP o enviándolo desde el front
            'state'         => null,
            'city'          => null,
            'address'       => null,
            'zip'           => null,
            'currency'      => 'USD',
            'language'      => $data['locale'],
            'is_active'     => 1,
            'credit_balance'=> 0,
        ]);

        Auth::login($user);

        App::setLocale($user->locale);
        session(['locale' => $user->locale]);

        // === NOTIFICACIÓN WHATSAPP DE BIENVENIDA ===
        try {
            $whatsapp = new WhatsAppService();
            
            // Mensaje de bienvenida profesional
            $mensaje = "👋 Hola *{$firstName}*, ¡Bienvenido a Linea365!\n\n";
            $mensaje .= "✅ *Cuenta creada exitosamente.*\n";
            $mensaje .= "Ya puedes acceder a tu panel de control para gestionar tus servicios.\n\n";
            $mensaje .= "📂 *Adjunto:* Te enviamos tu Guía de Inicio Rápido.";
            
            // Enviar texto al número internacional (sin el +)
            $whatsapp->send($cleanPhone, $mensaje);

            // Enviar archivo adjunto (Asegúrate de tener 'manual_bienvenida.pdf' en tu carpeta public)
            $rutaPDF = public_path('manual_bienvenida.pdf');
            
            // Intentamos enviar el archivo solo si existe para evitar errores
            if (file_exists($rutaPDF)) {
                $whatsapp->sendMedia($cleanPhone, $rutaPDF, "Guía de Inicio - Linea365");
            }

        } catch (\Exception $e) {
            // Log silencioso para no interrumpir el registro si el bot falla
            Log::error("Error enviando WhatsApp de bienvenida: " . $e->getMessage());
        }

        // El registro siempre es para clientes, así que va al dashboard normal
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}