<?php
use App\Http\Controllers\PageController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\InventarioDecantController;
use App\Http\Controllers\DecantController;
use App\Http\Controllers\RegistrarAbonoController;
use App\Http\Controllers\DeudaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProovedorController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PerfumeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::post('decant/generar', [DecantController::class, 'generarDecant'])
    ->middleware(['auth', 'verified'])
    ->name('decant.generar');

Route::post('decant/rellenar', [DecantController::class, 'rellenar'])
    ->middleware(['auth', 'verified'])
    ->name('decant.rellenar');

Route::get('/ventas/historial', [VentaController::class, 'historial'])
    ->middleware(['auth', 'verified'])
    ->name('venta.historial');

Route::get('/pedidos/detallePedidos', [PedidosController::class, 'detallePedidos'])
    ->middleware(['auth', 'verified'])
    ->name('pedidos.detallePedidos');

Route::put('/pedidos/estado/{id}', [PedidosController::class, 'estado'])->name('pedidos.estado')->middleware(['auth', 'verified']);


Route::get('/pedidos/edit/{id}', [PedidosController::class, 'edit'])->name('pedidos.edit');

Route::resource('dashboard', dashboardController::class)->middleware(['auth', 'verified']);
Route::resource('pedidos', PedidosController::class)->middleware(['auth', 'verified']);
Route::resource('inventario_decants', InventarioDecantController::class)->middleware(['auth', 'verified']);
Route::resource('decant', DecantController::class)->middleware(['auth', 'verified']);
Route::resource('abonos', RegistrarAbonoController::class)->middleware(['auth', 'verified']);
Route::resource('marca', MarcaController::class)->middleware(['auth', 'verified']);
Route::resource('usuario', UsuarioController::class)->middleware(['auth', 'verified']);
Route::resource('perfume', PerfumeController::class)->middleware(['auth', 'verified']);
Route::resource('proovedor', ProovedorController::class)->middleware(['auth', 'verified']);
Route::resource('cliente', ClienteController::class)->middleware(['auth', 'verified']);
Route::resource('inventario', InventarioController::class)->middleware(['auth', 'verified']);
Route::resource('venta', VentaController::class)->middleware(['auth', 'verified']);
Route::resource('deuda', DeudaController::class)->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::post('/usuarios', [UsuarioController::class, 'store'])
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('usuarios.store');


Route::get('/venta/{id}/pdf', [VentaController::class, 'pdf'])->name('venta.pdf');
Route::get('/venta/{id}/ticket', [VentaController::class, 'ticket'])
    ->name('venta.pdf2');

Route::get('/pedidos/{id}/pdf', [PedidosController::class, 'pdf'])->name('pedidos.pdf');

//ruta para Landing page
Route::resource('index', PageController::class);



require __DIR__.'/auth.php';
