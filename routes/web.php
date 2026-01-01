<?php

use Illuminate\Support\Facades\Route;

// Controladores Públicos y de Cliente
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WhatsAppController;


// Controladores Admin
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\ServerController as AdminServerController;
use App\Http\Controllers\Admin\RegistrarController as AdminRegistrarController;
use App\Http\Controllers\Admin\AddonController as AdminAddonController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;

// Modelos (si se usan en closures)
use App\Models\Product;

// -----------------------------------------------------------------------------
// 1. RUTAS PÚBLICAS (Landing, Ventas, Buscador, Webhooks)
// -----------------------------------------------------------------------------

// Página principal
Route::get('/', function () {
    $products = Product::where('is_active', 1)
        ->where('type', 'hosting')
        ->orderBy('price_monthly', 'asc')
        ->get();

    return view('frontend.home', compact('products'));
})->name('home');

Route::view('/paginas-web', 'frontend.websites')->name('paginas-web');
// Páginas públicas adicionales (placeholders)
Route::view('/hosting', 'frontend.hosting')->name('hosting');
Route::view('/dominios', 'frontend.domains')->name('dominios');
Route::view('/vps', 'frontend.vps')->name('vps');

Route::view('/contacto', 'frontend.contact')->name('contacto');
Route::view('/promociones', 'frontend.promotions')->name('promociones');
Route::view('/portafolio', 'frontend.portfolio')->name('portafolio');

// Legales
Route::view('/terminos', 'frontend.terms')->name('terminos');
Route::view('/privacidad', 'frontend.privacy')->name('privacidad');
Route::view('/cookies', 'frontend.cookies')->name('cookies');


// API Buscador de Dominios y Carrito (ACCESIBLES PARA INVITADOS)
Route::post('/api/domain-check', [OrderController::class, 'checkDomain'])->name('domain.check');
Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
Route::get('/checkout', [OrderController::class, 'checkout'])->name('cart.checkout');

// Configuración de producto antes de comprar
Route::get('/cart/configure/{id}', [OrderController::class, 'configure'])->name('cart.configure');
Route::get('/cart/remove/{type}', [OrderController::class, 'removeItem'])->name('cart.remove');

// Webhook de Pagos (PayU/PayPal)
Route::post('/payment/webhook/{gateway}', [PaymentController::class, 'webhook'])->name('payment.webhook');


// -----------------------------------------------------------------------------
// 2. AUTENTICACIÓN
// -----------------------------------------------------------------------------
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::any('/logout', [AuthController::class, 'logout'])->name('logout');


// -----------------------------------------------------------------------------
// 3. ÁREA DE CLIENTES (Requiere Login)
// -----------------------------------------------------------------------------
Route::middleware('auth')->group(function () {

    // Panel Principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tienda / Contratar
    Route::get('/store', [OrderController::class, 'index'])->name('store.index');
    
    // Procesar Orden (Checkout final)
    Route::post('/cart/place-order', [OrderController::class, 'placeOrder'])->name('cart.placeOrder');

    // Facturas
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');

    // Servicios
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
    
    // Tickets
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
// Ruta para responder tickets (Cliente)
Route::post('/tickets/{ticket}/reply', [TicketController::class, 'reply'])->name('tickets.reply');

Route::get('/tickets/{ticket}/messages', [TicketController::class, 'fetchMessages'])->name('tickets.messages');

    // Dominios
    Route::get('/domains', [DomainController::class, 'index'])->name('domains.index');
    Route::get('/domains/{domain}', [DomainController::class, 'show'])->name('domains.show');
    
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Sistema de Pagos
    Route::get('/payment/{id}', [PaymentController::class, 'show'])->name('payment.show');     
    Route::post('/payment/{id}', [PaymentController::class, 'process'])->name('payment.process'); 
    Route::any('/payment/callback/{gateway}', [PaymentController::class, 'callback'])->name('payment.callback');
});


// -----------------------------------------------------------------------------
// 4. ÁREA ADMINISTRATIVA (Requiere Login + Rol Admin)
// -----------------------------------------------------------------------------
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Infraestructura
    Route::resource('servers', AdminServerController::class);
    Route::resource('registrars', AdminRegistrarController::class);
    Route::resource('addons', AdminAddonController::class);

    // Ajustes Generales
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Gestión de Pasarelas de Pago
    Route::resource('gateways', PaymentGatewayController::class);

    // Productos
    Route::resource('products', ProductController::class);

    // Servicios (Gestión Admin)
    Route::resource('services', AdminServiceController::class);
    Route::post('/services/{service}/provision', [AdminServiceController::class, 'provision'])->name('services.provision');
    Route::post('/services/{service}/register-domain', [AdminServiceController::class, 'registerDomain'])->name('services.register_domain');

    // Facturas y Clientes
    Route::resource('invoices', AdminInvoiceController::class);
    Route::resource('clients', AdminClientController::class);

    // Tickets Admin
    Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/reply', [AdminTicketController::class, 'reply'])->name('tickets.reply');
    Route::delete('/tickets/{ticket}', [AdminTicketController::class, 'destroy'])->name('tickets.destroy');
    
    
    
});


// Grupo de rutas para el Administrador de WhatsApp
Route::prefix('admin/whatsapp')->middleware(['auth'])->group(function () {
    
    // Ver panel y QR
    Route::get('/', [WhatsAppController::class, 'index'])->name('admin.whatsapp.index');
    
    // Cerrar Sesión
    Route::post('/logout', [WhatsAppController::class, 'logout'])->name('admin.whatsapp.logout');
    
    // Enviar prueba
    Route::post('/test', [WhatsAppController::class, 'testMessage'])->name('admin.whatsapp.test');
});