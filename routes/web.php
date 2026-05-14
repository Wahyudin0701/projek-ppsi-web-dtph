<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Route
Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::get('/katalog', function () {
    $alsintans = App\Models\Alsintan::all();
    return view('public.katalog', compact('alsintans'));
})->name('katalog');

Route::get('/program', function () {
    $programs = App\Models\Program::orderByRaw("is_open DESC, open_date DESC")->get();
    return view('public.program', compact('programs'));
})->name('program');

Route::get('/kontak', function () {
    return view('public.kontak');
})->name('kontak');

Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/overview', function () {
        return view('public.profil.overview');
    })->name('overview');
    Route::get('/visi-misi', function () {
        return view('public.profil.visi-misi');
    })->name('visi-misi');
    Route::get('/struktur-organisasi', function () {
        return view('public.profil.struktur-organisasi');
    })->name('struktur-organisasi');
    Route::get('/tugas-fungsi', function () {
        return view('public.profil.tugas-fungsi');
    })->name('tugas-fungsi');
    Route::get('/satuan-kerja', function () {
        return view('public.profil.satuan-kerja');
    })->name('satuan-kerja');
});

Route::prefix('informasi')->name('informasi.')->group(function () {
    Route::get('/berita-artikel', function () {
        return view('public.informasi.berita-artikel');
    })->name('berita-artikel');
    Route::get('/berita-artikel/{slug}', function ($slug) {
        return view('public.informasi.berita-artikel-detail', compact('slug'));
    })->name('berita-artikel.detail');
    Route::get('/unduh-dokumen', function () {
        return view('public.informasi.unduh-dokumen');
    })->name('unduh-dokumen');
    Route::get('/faq', function () {
        return view('public.informasi.faq');
    })->name('faq');
});

// Verification Route
Route::get('/verifikasi/proposal/{id}/{hash}', [\App\Http\Controllers\VerificationController::class, 'verifyProposal'])->name('verification.proposal');

// Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('users.index');
        Route::get('/users-list', [App\Http\Controllers\Admin\AdminController::class, 'list'])->name('users.list');
        Route::get('/users/{user}', [App\Http\Controllers\Admin\AdminController::class, 'show'])->name('users.show');
        Route::post('/users/{user}/reviewed', [App\Http\Controllers\Admin\AdminController::class, 'markAsReviewed'])->name('users.reviewed');
        Route::patch('/users/{user}/approve', [App\Http\Controllers\Admin\AdminController::class, 'approve'])->name('users.approve');
        Route::delete('/users/{user}/reject', [App\Http\Controllers\Admin\AdminController::class, 'reject'])->name('users.reject');
        
        Route::resource('programs', App\Http\Controllers\Admin\ProgramController::class);
        
        Route::resource('alsintan', App\Http\Controllers\Admin\AlsintanController::class);

        // Proposal Management
        Route::get('/proposals', [App\Http\Controllers\Admin\ProposalController::class, 'index'])->name('proposals.index');
        Route::get('/proposals/{proposal}', [App\Http\Controllers\Admin\ProposalController::class, 'show'])->name('proposals.show');
        Route::patch('/proposals/{proposal}/approve', [App\Http\Controllers\Admin\ProposalController::class, 'approve'])->name('proposals.approve');
        Route::delete('/proposals/{proposal}/reject', [App\Http\Controllers\Admin\ProposalController::class, 'reject'])->name('proposals.reject');
    });

    // Farmer Routes
    Route::middleware(['approved'])->prefix('farmer/proposals')->name('farmer.proposals.')->group(function () {
        // Riwayat
        Route::get('/', [App\Http\Controllers\Farmer\ProposalController::class, 'index'])->name('index');
        Route::get('/{proposal}/detail', [App\Http\Controllers\Farmer\ProposalController::class, 'show'])->name('show');

        // Halaman Pilih Jenis Proposal
        Route::get('/pilih', [App\Http\Controllers\Farmer\ProposalController::class, 'selectType'])->name('pilih');

        // --- ALSINTAN --- 
        Route::get('/alsintan', [App\Http\Controllers\Farmer\ProposalController::class, 'alsintanList'])->name('alsintan');
        Route::get('/alsintan/{alsintan}', [App\Http\Controllers\Farmer\ProposalController::class, 'alsintanCreate'])->name('alsintan.create');
        Route::post('/alsintan/{alsintan}', [App\Http\Controllers\Farmer\ProposalController::class, 'alsintanStore'])->name('alsintan.store');

        // --- PROGRAM BANTUAN ---
        Route::get('/bantuan', [App\Http\Controllers\Farmer\ProposalController::class, 'bantuanList'])->name('bantuan');
        Route::get('/bantuan/{program}', [App\Http\Controllers\Farmer\ProposalController::class, 'create'])->name('create');
        Route::post('/bantuan/{program}', [App\Http\Controllers\Farmer\ProposalController::class, 'store'])->name('store');

        // Sukses & Download (shared)
        Route::get('/{proposal}/success', [App\Http\Controllers\Farmer\ProposalController::class, 'success'])->name('success');
        Route::get('/{proposal}/download-receipt', [App\Http\Controllers\Farmer\ProposalController::class, 'downloadReceipt'])->name('download-receipt');

        // Legacy routes (tetap ada agar tidak error jika masih dipakai)
        Route::get('/programs', [App\Http\Controllers\Farmer\ProposalController::class, 'listByCategory'])->name('programs');
        Route::get('/form', [App\Http\Controllers\Farmer\ProposalController::class, 'form'])->name('form');
        Route::post('/store-unified', [App\Http\Controllers\Farmer\ProposalController::class, 'storeUnified'])->name('store-unified');
    });

});

require __DIR__.'/auth.php';
