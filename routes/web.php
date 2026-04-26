<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Auth Routes (Mockups)
Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');

Route::post('/login', function () {
    return redirect()->route('dashboard')->with('toast', ['type' => 'success', 'message' => 'Selamat datang kembali!']);
});

Route::get('/register', function () {
    return view('pages.auth.register');
})->name('register');

Route::post('/register', function () {
    return redirect()->route('login')->with('toast', ['type' => 'success', 'message' => 'Akun berhasil dibuat. Silakan masuk.']);
});

Route::post('/logout', function () {
    return redirect()->route('login');
})->name('logout');

// Main App Routes
Route::middleware([])->group(function () {
    
    Route::get('/', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    Route::get('/katalog', function () {
        return view('pages.katalog');
    })->name('katalog');

    Route::get('/proposal/baru', function () {
        return view('pages.proposal.create');
    })->name('proposal.create');

});
