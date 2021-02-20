<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
Route::patch('/profile', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('profile.update');

//Rutas para admin-----------------------------------------------------------------------------------------------------------------------------------|
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin')->middleware('can:main_admin');
//usuarios
Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users')->middleware('can:main_admin');
Route::get('/admin/users/create', [App\Http\Controllers\AdminController::class, 'createUser'])->name('admin.users.create');
Route::get('/admin/users/{user}/edit', [App\Http\Controllers\AdminController::class, 'editUser'])->name('admin.users.edit');
Route::post('/admin/users', [App\Http\Controllers\AdminController::class, 'storeUser'])->name('admin.users.store');
Route::patch('/admin/users/{user}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.users.update');
Route::delete('/admin/users', [App\Http\Controllers\AdminController::class, 'destroyUser'])->name('admin.users.destroy');
//categorias
Route::get('/admin/categories', [App\Http\Controllers\AdminController::class, 'categories'])->name('admin.categories');
Route::get('/admin/categories/create', [App\Http\Controllers\AdminController::class, 'createCategory'])->name('admin.categories.create');
Route::get('/admin/categories/{category}/edit', [App\Http\Controllers\AdminController::class, 'editCategory'])->name('admin.categories.edit');
Route::post('/admin/categories', [App\Http\Controllers\AdminController::class, 'storeCategory'])->name('admin.categories.store');
Route::patch('/admin/categories/{category}', [App\Http\Controllers\AdminController::class, 'updateCategory'])->name('admin.categories.update');
Route::delete('/admin/categories/{category}', [App\Http\Controllers\AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');
//variables
Route::get('/admin/variables', [App\Http\Controllers\AdminController::class, 'variables'])->name('admin.variables');
Route::get('/admin/variables/create', [App\Http\Controllers\AdminController::class, 'createVariable'])->name('admin.variables.create');
Route::get('/admin/variables/{variable}/edit', [App\Http\Controllers\AdminController::class, 'editVariable'])->name('admin.variables.edit');
Route::post('/admin/variables', [App\Http\Controllers\AdminController::class, 'storeVariable'])->name('admin.variables.store');
Route::patch('/admin/variables/{variable}', [App\Http\Controllers\AdminController::class, 'updateVariable'])->name('admin.variables.update');
Route::delete('/admin/variables', [App\Http\Controllers\AdminController::class, 'destroyVariable'])->name('admin.variables.destroy');
//rols
Route::get('/admin/rols', [App\Http\Controllers\AdminController::class, 'rols'])->name('admin.rols');
Route::get('/admin/rols/create', [App\Http\Controllers\AdminController::class, 'createRol'])->name('admin.rols.create');
Route::get('/admin/rols/{rol}/edit', [App\Http\Controllers\AdminController::class, 'editRol'])->name('admin.rols.edit');
Route::post('/admin/rols', [App\Http\Controllers\AdminController::class, 'storeRol'])->name('admin.rols.store');
Route::patch('/admin/rols/{rol}', [App\Http\Controllers\AdminController::class, 'updateRol'])->name('admin.rols.update');
Route::delete('/admin/rols', [App\Http\Controllers\AdminController::class, 'destroyRol'])->name('admin.rols.destroy');

//providers
Route::get('/admin/providers', [App\Http\Controllers\AdminController::class, 'providers'])->name('admin.providers');
Route::get('/admin/providers/create', [App\Http\Controllers\AdminController::class, 'createProvider'])->name('admin.providers.create');
Route::get('/admin/providers/{provider}/edit', [App\Http\Controllers\AdminController::class, 'editProvider'])->name('admin.providers.edit');
Route::post('/admin/providers', [App\Http\Controllers\AdminController::class, 'storeProvider'])->name('admin.providers.store');
Route::patch('/admin/providers/{provider}', [App\Http\Controllers\AdminController::class, 'updateProvider'])->name('admin.providers.update');
Route::delete('/admin/providers', [App\Http\Controllers\AdminController::class, 'destroyProvider'])->name('admin.providers.destroy');

//offices
Route::get('/admin/offices', [App\Http\Controllers\AdminController::class, 'offices'])->name('admin.offices');
Route::get('/admin/offices/create', [App\Http\Controllers\AdminController::class, 'createOffice'])->name('admin.offices.create');
Route::get('/admin/offices/{office}/edit', [App\Http\Controllers\AdminController::class, 'editOffice'])->name('admin.offices.edit');
Route::post('/admin/offices', [App\Http\Controllers\AdminController::class, 'storeOffice'])->name('admin.offices.store');
Route::patch('/admin/offices/{office}', [App\Http\Controllers\AdminController::class, 'updateOffice'])->name('admin.offices.update');
Route::delete('/admin/offices', [App\Http\Controllers\AdminController::class, 'destroyOffice'])->name('admin.offices.destroy');

//Tutas para modulo inventarios------------------------------------------------------------------------------------------------------------------------|
Route::get('/inventory', [App\Http\Controllers\InventoryController::class, 'index'])->name('inventory');
//Catalogo
//Filtros en catalogo
Route::post('/inventory/filter-catalog', [App\Http\Controllers\InventoryController::class, 'filtersCatalog'])->name('inventory.catalog.filter');

Route::get('/inventory/catalog', [App\Http\Controllers\InventoryController::class, 'catalog'])->name('inventory.catalog');
Route::get('/inventory/catalog/create', [App\Http\Controllers\InventoryController::class, 'createCatalog'])->name('inventory.catalog.create');
Route::post('/inventory/catalog', [App\Http\Controllers\InventoryController::class, 'storeCatalog'])->name('inventory.catalog.store');
Route::get('/inventory/catalog/{catalog}', [App\Http\Controllers\InventoryController::class, 'detailCatalog'])->name('inventory.catalog.detail');
Route::get('/inventory/catalog/{catalog}/edit', [App\Http\Controllers\InventoryController::class, 'editCatalog'])->name('inventory.catalog.edit');
Route::patch('/inventory/catalog/{catalog}', [App\Http\Controllers\InventoryController::class, 'updateCatalog'])->name('inventory.catalog.update');
Route::delete('/inventory/catalog', [App\Http\Controllers\InventoryController::class, 'destroyCatalog'])->name('inventory.catalog.destroy');

//Historial de movimientos
Route::get('/inventory/history', [App\Http\Controllers\InventoryController::class, 'history'])->name('inventory.history');

// Ingresos---------------------------------------------------------------------------------------------------------------------------------------------|
//datos en el ingreso
Route::post('/inventory/get-catalog', [App\Http\Controllers\EntryController::class, 'getCatalog'])->name('getcatalog');
Route::post('/inventory/get-item', [App\Http\Controllers\ItemController::class, 'getItem'])->name('getitem');

//ITEMS
Route::get('/inventory/items', [App\Http\Controllers\ItemController::class, 'index'])->name('items');
Route::get('/inventory/items/create', [App\Http\Controllers\ItemController::class, 'create'])->name('item.create');
Route::post('/inventory/items', [App\Http\Controllers\ItemController::class, 'store'])->name('item.store');
Route::get('/inventory/items/{item}', [App\Http\Controllers\ItemController::class, 'details'])->name('item.details');
Route::get('/inventory/items/{item}/edit', [App\Http\Controllers\ItemController::class, 'edit'])->name('item.edit');
Route::patch('/inventory/items/{item}', [App\Http\Controllers\ItemController::class, 'update'])->name('item.update');
Route::delete('/inventory/items', [App\Http\Controllers\ItemController::class, 'destroy'])->name('item.destroy');

//INGRESOS
Route::get('/inventory/entries', [App\Http\Controllers\EntryController::class, 'index'])->name('entries');
Route::get('/inventory/entries/create', [App\Http\Controllers\EntryController::class, 'create'])->name('entry.create');
Route::post('/inventory/entries', [App\Http\Controllers\EntryController::class, 'store'])->name('entry.store');
Route::get('/inventory/entries/{entry}', [App\Http\Controllers\EntryController::class, 'detail'])->name('entry.detail');
Route::get('/inventory/entries/{entry}/edit', [App\Http\Controllers\EntryController::class, 'edit'])->name('entry.edit');
Route::patch('/inventory/entries/{entry}', [App\Http\Controllers\EntryController::class, 'update'])->name('entry.update');
Route::delete('/inventory/entries', [App\Http\Controllers\EntryController::class, 'destroy'])->name('entry.destroy');

//SALIDAS
Route::get('/inventory/outlets', [App\Http\Controllers\OutletController::class, 'index'])->name('outlet');
Route::get('/inventory/outlets/create', [App\Http\Controllers\OutletController::class, 'create'])->name('outlet.create');
Route::post('/inventory/outlets', [App\Http\Controllers\OutletController::class, 'store'])->name('outlet.store');
Route::get('/inventory/outlets/{outlet}', [App\Http\Controllers\OutletController::class, 'detail'])->name('outlet.detail');

//Traspasos
Route::get('/inventory/transfers', [App\Http\Controllers\TransferController::class, 'index'])->name('transfer');
Route::get('/inventory/transfers/create', [App\Http\Controllers\TransferController::class, 'create'])->name('transfer.create');
Route::get('/inventory/transfers/{transfer}', [App\Http\Controllers\TransferController::class, 'detail'])->name('transfer.detail');
Route::get('/inventory/transfers/{transfer}/edit', [App\Http\Controllers\TransferController::class, 'edit'])->name('transfer.edit');
Route::post('/inventory/transfers', [App\Http\Controllers\TransferController::class, 'store'])->name('transfer.store');
Route::patch('/inventory/transfers/{transfer}', [App\Http\Controllers\TransferController::class, 'update'])->name('transfer.update');
Route::post('/inventory/transfers/authorize', [App\Http\Controllers\TransferController::class, 'authorizeTransfer'])->name('transfer.authorize');
Route::post('/inventory/transfers/entry', [App\Http\Controllers\TransferController::class, 'entryTransfer'])->name('transfer.entry');
Route::delete('/inventory/transfers', [App\Http\Controllers\TransferController::class, 'destroy'])->name('transfer.delete');

//Exportar datos =9
Route::get('/inventory/export',[App\Http\Controllers\InventoryController::class, 'exportView'])->name('export');
Route::post('/inventory/export',[App\Http\Controllers\InventoryController::class, 'export'])->name('export.data');