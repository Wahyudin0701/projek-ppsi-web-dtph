<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Route
Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/katalog', function () {
    return view('pages.katalog');
})->name('katalog');

Route::get('/program', function () {
    return view('pages.program');
})->name('program');

Route::get('/kontak', function () {
    return view('pages.kontak');
})->name('kontak');

Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/overview', function () {
        return view('pages.profil.overview');
    })->name('overview');
    Route::get('/visi-misi', function () {
        return view('pages.profil.visi-misi');
    })->name('visi-misi');
    Route::get('/struktur-organisasi', function () {
        return view('pages.profil.struktur-organisasi');
    })->name('struktur-organisasi');
    Route::get('/tugas-fungsi', function () {
        return view('pages.profil.tugas-fungsi');
    })->name('tugas-fungsi');
    Route::get('/satuan-kerja', function () {
        return view('pages.profil.satuan-kerja');
    })->name('satuan-kerja');
});

Route::prefix('informasi')->name('informasi.')->group(function () {
    Route::get('/berita-artikel', function () {
        return view('pages.informasi.berita-artikel');
    })->name('berita-artikel');
    Route::get('/berita-artikel/{slug}', function ($slug) {
        return view('pages.informasi.berita-artikel-detail', compact('slug'));
    })->name('berita-artikel.detail');
    Route::get('/unduh-dokumen', function () {
        return view('pages.informasi.unduh-dokumen');
    })->name('unduh-dokumen');
    Route::get('/faq', function () {
        return view('pages.informasi.faq');
    })->name('faq');
});

// Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [App\Http\Controllers\AdminController::class, 'index'])->name('users.index');
        Route::get('/users-list', [App\Http\Controllers\AdminController::class, 'list'])->name('users.list');
        Route::get('/users/{user}', [App\Http\Controllers\AdminController::class, 'show'])->name('users.show');
        Route::post('/users/{user}/reviewed', [App\Http\Controllers\AdminController::class, 'markAsReviewed'])->name('users.reviewed');
        Route::patch('/users/{user}/approve', [App\Http\Controllers\AdminController::class, 'approve'])->name('users.approve');
        Route::delete('/users/{user}/reject', [App\Http\Controllers\AdminController::class, 'reject'])->name('users.reject');
        
        Route::resource('programs', App\Http\Controllers\Admin\ProgramController::class);
        Route::post('/programs/{program}/toggle', [App\Http\Controllers\Admin\ProgramController::class, 'toggleStatus'])->name('programs.toggle');
    });

    // Farmer Routes
    Route::middleware(['approved'])->prefix('farmer')->name('farmer.')->group(function () {
        Route::get('/proposals', [App\Http\Controllers\ProposalController::class, 'index'])->name('proposals.index');
        Route::get('/proposals/create/{program}', [App\Http\Controllers\ProposalController::class, 'create'])->name('proposals.create');
        Route::post('/proposals/{program}', [App\Http\Controllers\ProposalController::class, 'store'])->name('proposals.store');
        
        Route::get('/messages', function () {
            return view('pages.farmer.messages');
        })->name('messages');
    });

});

require __DIR__.'/auth.php';
