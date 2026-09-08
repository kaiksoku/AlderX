<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\Admin\UsuariosController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\RestaurantesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\ChassisController;
use App\Http\Controllers\SalidasController;
use App\Http\Controllers\GensetController;
use App\Http\Controllers\DepartamentosController;

// Principal---------------------------------------------------------------------------------------------------------------------------------
Route::get('/', function () { return view('welcome'); })->name('welcome');  // Asigna el nombre 'welcome' a la ruta
Auth::routes(['register' => false]);
// Principal---------------------------------------------------------------------------------------------------------------------------------


//Administrador------------------------------------------------------------------------------------------------------------------------------
Route::get('usuarios/create', [RegisterController::class, 'create'])->middleware('auth')->middleware('can:Crear Usuarios')->name('usuarios.create');
Route::get('usuarios', [UsuariosController::class, 'index'])->middleware(['auth', 'can:Ver Usuarios'])->name('usuarios.index');
Route::get('usuarios/{usuario}/edit', [UsuariosController::class, 'edit'])->middleware(['auth', 'can:Editar Usuarios'])->name('usuarios.edit');
Route::put('usuarios/{usuario}', [UsuariosController::class, 'update'])->middleware(['auth', 'can:Editar Usuarios'])->name('usuarios.update');
Route::get('usuarios/{usuario}', [UsuariosController::class, 'show'])->middleware(['auth', 'can:Ver Usuarios'])->name('usuarios.show');
Route::get('usuarios/eliminar/{id}', [UsuariosController::class, 'destroy'])->middleware(['auth', 'can:Eliminar Usuarios'])->name('usuarios.destroy');
Route::post('usuarios/guardar', [RegisterController::class, 'register'])->middleware('auth')->middleware('can:Crear Usuarios')->name('register.guardar');

Route::get('roles', [RolesController::class, 'show'])->middleware(['auth', 'can:Ver Roles'])->name('roles');
Route::get('roles/create', [RolesController::class, 'create'])->middleware(['auth', 'can:Crear Roles'])->name('roles.create');
Route::post('roles/guardar', [RolesController::class, 'store'])->middleware(['auth', 'can:Crear Roles'])->name('roles.guardar');
Route::get('roles/{role}/edit', [RolesController::class, 'edit'])->middleware(['auth', 'can:Editar Roles'])->name('roles.editar');
Route::put('roles/{role}', [RolesController::class, 'update'])->middleware(['auth', 'can:Editar Roles'])->name('roles.actualizar');
Route::get('roles/eliminar/{id}', [RolesController::class, 'destroy'])->middleware(['auth', 'can:Eliminar Roles'])->name('roles.eliminar');


// Inicia Rutas generales---------------------------------------------------------------------------------------------------------------------

// Módulo inicio de sesión
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('home', [HomeController::class, 'index'])->middleware(['auth', 'can:Ver Dashboard'])->name('home');

// Módulo Chassis 
Route::get('chassis', [ChassisController::class, 'show'])->middleware(['auth', 'can:Ver Chassis'])->name('chassis');
Route::get('chassis/create', [ChassisController::class, 'create'])->middleware(['auth', 'can:Crear Chassis'])->name('chassis.create');
Route::post('chassis/guardar', [ChassisController::class, 'store'])->middleware(['auth', 'can:Crear Chassis'])->name('chassis.guardar');
Route::get('chassis/edit/{id}', [ChassisController::class, 'edit'])->middleware(['auth', 'can:Editar Chassis'])->name('chassis.editar');
Route::post('chassis/update', [ChassisController::class, 'update'])->middleware(['auth', 'can:Editar Chassis'])->name('chassis.actualizar');
Route::get('chassis/destroy/{id}', [ChassisController::class, 'destroy'])->middleware(['auth', 'can:Eliminar Chassis'])->name('chassis.destroy');

// Módulo Genset
Route::get('genset', [GensetController::class, 'show'])->middleware(['auth', 'can:Ver Genset'])->name('genset');

// Módulo Salidas 
Route::get('salidas', [SalidasController::class, 'show'])->middleware(['auth', 'can:Ver Salidas'])->name('salidas');
Route::get('ajax/validar-chassis', [SalidasController::class, 'validarChassis'])->middleware(['auth', 'can:Ver Salidas'])->name('validarchassis');
Route::get('ajax/validar-genset', [SalidasController::class, 'validarGenset'])->middleware(['auth', 'can:Ver Salidas'])->name('validargenset');

//Modulo Historial de Registros
Route::get('historial', [HistorialController::class, 'index'])->middleware(['auth', 'can:Ver Reportes'])->name('historial');
Route::get('consultas', [ConsultasController::class, 'index'])->middleware(['auth', 'can:Ver Reportes'])->name('consultas');


// Módulo Departamentos
Route::get('departamentos', [DepartamentosController::class, 'show'])->middleware(['auth', 'can:Ver Departamentos'])->name('departamentos');
Route::get('departamentos/create', [DepartamentosController::class, 'create'])->middleware(['auth', 'can:Crear Departamentos'])->name('departamentos.create');
Route::post('departamentos/guardar', [DepartamentosController::class, 'store'])->middleware(['auth', 'can:Crear Departamentos'])->name('departamentos.guardar');
Route::get('departamentos/eliminar/{id}', [DepartamentosController::class, 'destroy'])->middleware(['auth', 'can:Eliminar Departamentos'])->name('departamentos.eliminar');

// Módulo Empleados
Route::get('empleados', [EmpleadosController::class, 'show'])->middleware(['auth', 'can:Ver Empleados'])->name('empleados');
Route::get('empleados/create', [EmpleadosController::class, 'create'])->middleware(['auth', 'can:Crear Empleados'])->name('empleados.create');
Route::get('empleados/edit/{id}', [EmpleadosController::class, 'edit'])->middleware(['auth', 'can:Editar Empleados'])->name('empleados.edit');
Route::put('empleados/update/{id}', [EmpleadosController::class, 'update'])->middleware(['auth', 'can:Editar Empleados'])->name('empleados.update');
Route::post('empleados/store', [EmpleadosController::class, 'store'])->middleware(['auth', 'can:Crear Empleados'])->name('empleados.guardar');









