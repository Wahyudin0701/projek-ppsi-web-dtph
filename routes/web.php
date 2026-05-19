<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Route
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        // Redirect internal staff to their dashboards
        if ($user->isAdmin() || $user->isPimpinan() || $user->isKabid()) {
            return redirect()->route('dashboard');
        }
    }
    return view('public.home');
})->name('home');

Route::get('/katalog', function () {
    $alsintans = App\Models\Alsintan::all();
    return view('public.katalog', compact('alsintans'));
})->name('katalog');

Route::get('/program', function () {
    $programs = App\Models\Program::orderBy('open_date', 'desc')->get();
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
        
        // Surat Tugas & Verifikasi CPCL Offline
        Route::get('/proposals/{proposal}/surat-tugas/cetak', [App\Http\Controllers\Admin\ProposalController::class, 'cetakSuratTugas'])->name('proposals.cetak-surat-tugas');
        Route::get('/proposals/{proposal}/cpcl/create', [App\Http\Controllers\Admin\ProposalController::class, 'createCpcl'])->name('proposals.cpcl.create');
        Route::post('/proposals/{proposal}/cpcl', [App\Http\Controllers\Admin\ProposalController::class, 'storeCpcl'])->name('proposals.cpcl.store');
    });

    // Pimpinan Routes
    Route::middleware(['pimpinan'])->prefix('pimpinan')->name('pimpinan.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Pimpinan\ProposalController::class, 'dashboard'])->name('dashboard');
        Route::get('/proposals', [App\Http\Controllers\Pimpinan\ProposalController::class, 'index'])->name('proposals.index');
        Route::get('/proposals/{proposal}', [App\Http\Controllers\Pimpinan\ProposalController::class, 'show'])->name('proposals.show');
        Route::post('/proposals/{proposal}/dispose', [App\Http\Controllers\Pimpinan\ProposalController::class, 'dispose'])->name('proposals.dispose');
        Route::patch('/proposals/{proposal}/approve', [App\Http\Controllers\Pimpinan\ProposalController::class, 'approve'])->name('proposals.approve');
        Route::delete('/proposals/{proposal}/reject', [App\Http\Controllers\Pimpinan\ProposalController::class, 'reject'])->name('proposals.reject');
    });

    // Kabid Routes
    Route::middleware(['kabid'])->prefix('kabid')->name('kabid.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Kabid\ProposalController::class, 'dashboard'])->name('dashboard');
        Route::get('/proposals', [App\Http\Controllers\Kabid\ProposalController::class, 'index'])->name('proposals.index');
        Route::get('/proposals/{proposal}', [App\Http\Controllers\Kabid\ProposalController::class, 'show'])->name('proposals.show');
        Route::post('/proposals/{proposal}/assign-team', [App\Http\Controllers\Kabid\ProposalController::class, 'assignTeam'])->name('proposals.assign-team');

        Route::get('/proposals/{proposal}/berita-acara/create', [App\Http\Controllers\Kabid\BeritaAcaraController::class, 'create'])->name('berita-acara.create');
        Route::post('/proposals/{proposal}/berita-acara', [App\Http\Controllers\Kabid\BeritaAcaraController::class, 'store'])->name('berita-acara.store');
        Route::get('/proposals/{proposal}/berita-acara', [App\Http\Controllers\Kabid\BeritaAcaraController::class, 'show'])->name('berita-acara.show');

        Route::get('/tim-survei', [App\Http\Controllers\Kabid\TimSurveiController::class, 'index'])->name('tim-survei.index');
        Route::get('/tim-survei/create', [App\Http\Controllers\Kabid\TimSurveiController::class, 'create'])->name('tim-survei.create');
        Route::post('/tim-survei', [App\Http\Controllers\Kabid\TimSurveiController::class, 'store'])->name('tim-survei.store');
        Route::delete('/tim-survei/{user}', [App\Http\Controllers\Kabid\TimSurveiController::class, 'destroy'])->name('tim-survei.destroy');
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

        // Legacy routes (tetap ada agar tidak error jika masih dipakai)
        Route::get('/programs', [App\Http\Controllers\Farmer\ProposalController::class, 'listByCategory'])->name('programs');
        Route::get('/form', [App\Http\Controllers\Farmer\ProposalController::class, 'form'])->name('form');
        Route::post('/store-unified', [App\Http\Controllers\Farmer\ProposalController::class, 'storeUnified'])->name('store-unified');

        // Sukses & Download (shared, bebas waktu)
        Route::get('/{proposal}/success', [App\Http\Controllers\Farmer\ProposalController::class, 'success'])->name('success');
        Route::get('/{proposal}/download-receipt', [App\Http\Controllers\Farmer\ProposalController::class, 'downloadReceipt'])->name('download-receipt');
    });
});

// Shared Document Routes (Bisa diakses asal terotentikasi & authorized di Controller)
Route::middleware('auth')->prefix('documents')->name('documents.')->group(function () {
    Route::get('/berita-acara/{proposal}', [\App\Http\Controllers\DocumentController::class, 'printBeritaAcara'])->name('berita-acara');
    Route::get('/sk-bantuan/{proposal}', [\App\Http\Controllers\DocumentController::class, 'printSKBantuan'])->name('sk-bantuan');
    Route::get('/surat-perjanjian/{proposal}', [\App\Http\Controllers\DocumentController::class, 'printSuratPerjanjian'])->name('surat-perjanjian');
});

require __DIR__.'/auth.php';
