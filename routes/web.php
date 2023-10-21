<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Transaction;
use App\Http\Controllers\FirebasePushController;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/config-clear', function () {
    $status = Artisan::call('optimize:clear');
    return '<h1>Configurations cleared</h1>';
});

//Generate Key:
Route::get('/gen-key', function () {
    $status = Artisan::call('key:generate');
    return '<h1>Key Generated</h1>';
});

Route::get('/migrate', function () {
    $status = Artisan::call('migrate');
    return '<h1>Migrated</h1>';
});

Route::get('/seed', function () {
    $status = Artisan::call('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
    return '<h1>Seeded</h1>';
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });
    Route::get('/dashboard', function () {
        dd(Role::findByName("Manager"));
        return view('dashboard');
    })->name('dashboard');
    Route::get('/create-price-offer', function () {
        return view('transactions.create-price-offer');
    })->name('transactions.create-price-offer');
    Route::get('/update-price-offer', function () {
        return view('transactions.update-price-offer');
    })->name('transactions.update-price-offer');
    Route::get('/create-buying-order', function (Request $request) {
        $id = null;
        if ($request->has('id'))
            $id = $request->id;
        return view('transactions.create-buying-order', compact('id'));
    })->name('transactions.create-buying-order');

    Route::get('/index-transactions/{status}', function ($status) {
        return view('transactions.index', compact('status'));
    })->name('transactions.index');

    Route::get('/print-price-offer/{transaction}', function (Transaction $transaction) {
        return view('transactions.print-price-offer', compact('transaction'));
    })->name('transactions.printOffer');
    Route::get('/print-buying-order/{transaction}', function (Transaction $transaction) {
        return view('transactions.print-buying-order', compact('transaction'));
    })->name('transactions.printOrder');

    Route::post('setToken', [FirebasePushController::class, 'setToken'])->name('firebase.token');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:Super Admin'
])->group(function () {
    Route::get('/users', function () {
        return view('dashboard.users');
    })->name('users');

    Route::get('/banks', function () {
        return view('dashboard.banks');
    })->name('banks');

    Route::get('/branches', function () {
        return view('dashboard.branches');
    })->name('branches');

    Route::get('/materials', function () {
        return view('dashboard.materials');
    })->name('materials');
});
