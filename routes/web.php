<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/create-price-offer', function () {
        return view('transactions.create-price-offer');
    })->name('transactions.create-price-offer');
    Route::get('/create-buying-order', function () {
        return view('transactions.create-buying-order');
    })->name('transactions.create-buying-order');
    Route::get('/index-transactions/{status}', function ($status) {
        return view('transactions.index', compact('status'));
    })->name('transactions.index');
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
