<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserManagementController;

// Rotas Públicas
Route::get('/', [ProductController::class, 'index'])->name('index');
Route::get('/feminino', [ProductController::class, 'feminino'])->name('feminino');
Route::get('/masculino', [ProductController::class, 'masculino'])->name('masculino');
Route::get('/produto/{id?}', [ProductController::class, 'show'])->name('produto');

// Rotas de Autenticação
Route::controller(AuthController::class)->middleware('guest')->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.store');
    
    Route::get('/cadastro', 'showRegister')->name('cadastro');
    Route::post('/cadastro', 'register')->name('cadastro.store');
});

# Logout (protegido)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Rotas de Login Administrativo
Route::controller(AdminAuthController::class)->group(function () {
    Route::get('/admin/login', 'showLoginForm')->name('admin.login');
    Route::post('/admin/login', 'login')->name('admin.login.post');
    Route::post('/admin/logout', 'logout')->middleware('auth')->name('admin.logout');
});

// Rotas de Carrinho e Pagamento (Protegidas por autenticação)
Route::middleware('auth')->group(function () {
    Route::get('/pagamento', function () {
        return view('pagamento');
    })->name('pagamento');

    Route::get('/carrinho', function () {
        return view('carrinho');
    })->name('carrinho');
});

// Rotas Admin (Protegidas por autenticação)
Route::prefix('adm')->middleware('auth')->name('adm-')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/search', [AdminController::class, 'search'])->name('search');
    
    // Produtos
    Route::get('/produtos', [AdminController::class, 'products'])->name('produto');
    Route::get('/produtos/criar', [AdminController::class, 'createProduct'])->name('produto-criar');
    Route::post('/produtos', [AdminController::class, 'storeProduct'])->name('produto-store');
    Route::get('/produtos/{id}/editar', [AdminController::class, 'editProduct'])->name('produto-editar');
    Route::put('/produtos/{id}', [AdminController::class, 'updateProduct'])->name('produto-update');
    Route::delete('/produtos/{id}', [AdminController::class, 'deleteProduct'])->name('produto-delete');
    
    // Usuários
    Route::get('/usuarios', [AdminController::class, 'users'])->name('usuarios');
    Route::get('/usuarios/{id}/editar', [AdminController::class, 'editUser'])->name('usuarios-editar');
    Route::put('/usuarios/{id}', [AdminController::class, 'updateUser'])->name('usuarios-update');
    Route::delete('/usuarios/{id}', [AdminController::class, 'deleteUser'])->name('usuarios-delete');
    
    // Criar novo admin (protegido - apenas admins)
    Route::middleware('admin')->group(function () {
        Route::get('/usuarios/criar', [AdminController::class, 'createAdmin'])->name('usuarios-criar');
        Route::post('/usuarios', [AdminController::class, 'storeAdmin'])->name('usuarios-store');
    });
});

// Manter rotas antigas para compatibilidade (nomes de rota antigos)
Route::get('/adm-dashboard', [AdminController::class, 'dashboard'])->middleware('auth')->name('adm-dashboard');
Route::get('/adm-produto', [AdminController::class, 'products'])->middleware('auth')->name('adm-produto');
Route::get('/adm-usuarios', [AdminController::class, 'users'])->middleware('auth')->name('adm-usuarios');
Route::get('/adm-cadastro', [AdminController::class, 'createProduct'])->middleware('auth')->name('adm-cadastro');
Route::get('/adm-produto-editar/{id}', [AdminController::class, 'editProduct'])->middleware('auth')->name('adm-produto-editar');
Route::put('/adm-produto-update/{id}', [AdminController::class, 'updateProduct'])->middleware('auth')->name('adm-produto-update');
Route::get('/adm-usuarios-editar/{id}', [AdminController::class, 'editUser'])->middleware('auth')->name('adm-usuarios-editar');
Route::put('/adm-usuarios-update/{id}', [AdminController::class, 'updateUser'])->middleware('auth')->name('adm-usuarios-update');
Route::get('/adm-usuarios-criar', [AdminController::class, 'createAdmin'])->middleware(['auth', 'admin'])->name('adm-usuarios-criar');
Route::post('/adm-usuarios-store', [AdminController::class, 'storeAdmin'])->middleware(['auth', 'admin'])->name('adm-usuarios-store');
Route::delete('/adm-usuarios-delete/{id}', [AdminController::class, 'deleteUser'])->middleware('auth')->name('adm-usuarios-delete');

// Rotas de Informação
Route::get('/sobre', function () {
    return view('sobre');
})->name('sobre');

Route::get('/suporte', function () {
    return view('suporte');
})->name('suporte');

Route::get('/termos', function () {
    return view('termos');
})->name('termos');

Route::get('/privacidade', function () {
    return view('privacidade');
})->name('privacidade');

// API Routes para produtos
Route::get('/api/products', [ProductController::class, 'getProducts']);
Route::get('/api/products/{category}', [ProductController::class, 'getProducts']);