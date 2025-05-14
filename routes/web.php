<?php

use App\Http\Controllers\Admin\AdminPedidosController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\ColaboradorController;
use App\Http\Controllers\Admin\LinhaProdutoController;
use App\Http\Controllers\Admin\PriceTableController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductPriceController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserPriceTableController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\FrontendController;
use Illuminate\Routing\Middleware\ValidateSignature;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ColaboradorPedidosController;
use App\Http\Controllers\PedidosController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

// Redirecionamento baseado no perfil
// Linha 18 corrigida
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'colaborador') {
        return redirect()->route('colaborador.dashboard');
    }

    // Se não for nenhum dos dois, redireciona para uma página padrão
    return redirect()->route('login');
})->name('dashboard');

// Rotas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas de Administrador
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::resource('/admin/products', ProductController::class)->names('products');
    Route::resource('/admin/category', CategoryController::class)->names('categories');
    Route::resource('/admin/product-line', LinhaProdutoController::class)->names('product-line');

    // New pricing routes
    Route::resource('/admin/price-tables', PriceTableController::class)->names('price-tables');
    Route::resource('/admin/product-prices', ProductPriceController::class)->names('product-prices');
    Route::resource('/admin/user-price-tables', UserPriceTableController::class)->names('user-price-tables');
    Route::post('/admin/price-tables/{priceTable}/import', [PriceTableController::class, 'import'])
        ->name('price-tables.import');
    Route::post('/admin/price-tables/{priceTable}/duplicate', [PriceTableController::class, 'duplicate'])
        ->name('price-tables.duplicate');
    Route::get('/admin/price-tables/{priceTable}/export', [PriceTableController::class, 'export'])
        ->name('price-tables.export');
    Route::resource('/admin/colaboradores', ColaboradorController::class)
        ->parameters(['colaboradores' => 'colaborador'])->names('colaboradores');

    Route::resource('/admin/clientes', ClienteController::class)->names('clientes');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin/pedidos', [AdminPedidosController::class, 'index'])->name('admin.pedidos.index');
        Route::get('/admin/pedidos/{id}', [AdminPedidosController::class, 'show'])->name('admin.pedidos.show');
    });
});

// Rotas de Colaborador
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/colaborador/dashboard', [FrontendController::class, 'dashboard'])
        ->name('colaborador.dashboard');

    Route::post('/colaborador/set-cliente', [FrontendController::class, 'setCliente'])
        ->name('colaborador.setCliente');
    Route::get('/colaborador/produtos', [FrontendController::class, 'produtos'])
        ->name('colaborador.produtos');

    Route::get('/colaborador/meus-pedidos', [ColaboradorPedidosController::class, 'index'])->name('colaborador.pedidos');
    Route::get('/colaborador/meus-pedidos/{id}', [ColaboradorPedidosController::class, 'show'])->name('colaborador.pedidos.show');


    Route::post('/colaborador/api/pedidos/register', [PedidosController::class, 'register'])->name('api.pedidos.register');
    Route::post('/colaborador/api/pedidos/editname', [PedidosController::class, 'editCheckoutName'])->name('api.pedidos.editCheckoutName');
    Route::get('/colaborador/api/pedidos/remover/{id}', [PedidosController::class, 'delete'])->name('api.pedidos.delete');
});

Route::get('/verify-email-colaborador/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(ValidateSignature::class)
    ->name('verification.verify.colaborador');

// Rotas de autenticação
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
require __DIR__ . '/auth.php';
