<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

        if (Auth::check()) {
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

            $userLocale = Auth::user()->locale ?? 'es';
            App::setLocale($userLocale);
            session(['locale' => $userLocale]);

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

        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'              => ['required', 'min:6', 'confirmed'],
            'locale'                => ['required', 'in:es,en'],
        ], [
            'name.required'         => __('El nombre es obligatorio.'),
            'email.required'        => __('El correo es obligatorio.'),
            'email.email'           => __('Debes ingresar un correo válido.'),
            'email.unique'          => __('Este correo ya está registrado.'),
            'password.required'     => __('La contraseña es obligatoria.'),
            'password.min'          => __('La contraseña debe tener al menos 6 caracteres.'),
            'password.confirmed'    => __('Las contraseñas no coinciden.'),
            'locale.required'       => __('Debes elegir un idioma.'),
            'locale.in'             => __('Idioma no válido.'),
        ]);

        // Crear usuario
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'type'      => 'client',
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
            'phone'         => null,
            'country'       => 'CO',
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
