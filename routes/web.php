<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\InvoiceController; 
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\ClientInvoiceController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;

use App\Models\Service;
use App\Models\Invoice;
use App\Models\Ticket;

// Página principal (landing)
Route::get('/', function () {
    return view('frontend.home');
})->name('home');

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas (solo usuarios logeados)
Route::middleware('auth')->group(function () {



Route::get('/dashboard', function () {
    $user   = auth()->user();
    $client = $user->client;

    $servicesCount = 0;
    $pendingInvoicesCount = 0;
    $openTicketsCount = 0;

    if ($client) {
        $servicesCount = Service::where('client_id', $client->id)->count();
        $pendingInvoicesCount = Invoice::where('client_id', $client->id)
            ->where('status', 'unpaid')
            ->count();
        $openTicketsCount = Ticket::where('client_id', $client->id)
            ->where('status', 'open')
            ->count();
    }

    return view('dashboard.index', compact(
        'user',
        'client',
        'servicesCount',
        'pendingInvoicesCount',
        'openTicketsCount'
    ));
})->name('dashboard');

       // Facturas del cliente
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');


  // 👇 Mis servicios
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
    
           // Listado de tickets del cliente
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');

    // Formulario para crear un ticket nuevo
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');

    // Guardar ticket nuevo
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

    // Detalle de un ticket
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');


    // Dominios
    Route::get('/domains', [DomainController::class, 'index'])->name('domains.index');
    Route::get('/domains/{domain}', [DomainController::class, 'show'])->name('domains.show');
    
        // Perfil del cliente
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
      // 💳 Facturas del cliente
    Route::get('/mis-facturas', [ClientInvoiceController::class, 'index'])
        ->name('client.invoices.index');

    Route::get('/mis-facturas/{invoice}', [ClientInvoiceController::class, 'show'])
        ->name('client.invoices.show');

    
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Productos / planes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // 👇 Servicios (hosting / dominios / otros)
    Route::get('/services', [AdminServiceController::class, 'index'])->name('services.index');
    Route::get('/services/create', [AdminServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [AdminServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [AdminServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [AdminServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [AdminServiceController::class, 'destroy'])->name('services.destroy');
    // 💳 Facturas
    Route::get('/invoices', [AdminInvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/create', [AdminInvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [AdminInvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}/edit', [AdminInvoiceController::class, 'edit'])->name('invoices.edit');
    Route::put('/invoices/{invoice}', [AdminInvoiceController::class, 'update'])->name('invoices.update');
    Route::delete('/invoices/{invoice}', [AdminInvoiceController::class, 'destroy'])->name('invoices.destroy');
     /*
    |----------------------------------------------------------------------
    | Clientes (admin)
    |----------------------------------------------------------------------
    */
    Route::get('/clients', [AdminClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [AdminClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [AdminClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{client}/edit', [AdminClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{client}', [AdminClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [AdminClientController::class, 'destroy'])->name('clients.destroy');
});