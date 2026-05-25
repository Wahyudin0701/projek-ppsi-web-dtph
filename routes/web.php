<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public API Routes
Route::get('/api/villages', [LocationController::class, 'getVillages'])->name('api.villages');

// Public Route
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        // Redirect internal staff to their dashboards
        if ($user->isAdmin() || $user->isPimpinan() || $user->isKabid()) {
            return redirect()->route('dashboard');
        }
    }
    $employees = \App\Models\Employee::all();
    return view('public.home', compact('employees'));
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
        $employees = \App\Models\Employee::all();
        return view('public.profil.struktur-organisasi', compact('employees'));
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
Route::get('/verify/{uuid}', [\App\Http\Controllers\VerificationController::class, 'verifySignature'])->name('verify.signature');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Farmer Profile Request Change
    Route::post('/farmer/profile/request-change', [App\Http\Controllers\FarmerProfileController::class, 'requestChange'])->name('farmer.profile.request-change');

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('users.index');
        Route::get('/users-list', [App\Http\Controllers\Admin\AdminController::class, 'list'])->name('users.list');
        Route::get('/users/{user}', [App\Http\Controllers\Admin\AdminController::class, 'show'])->name('users.show');
        Route::post('/users/{user}/reviewed', [App\Http\Controllers\Admin\AdminController::class, 'markAsReviewed'])->name('users.reviewed');
        Route::patch('/users/{user}/approve', [App\Http\Controllers\Admin\AdminController::class, 'approve'])->name('users.approve');
        Route::patch('/users/{user}/revisi', [App\Http\Controllers\Admin\AdminController::class, 'revise'])->name('users.revisi');
        Route::delete('/users/{user}/reject', [App\Http\Controllers\Admin\AdminController::class, 'reject'])->name('users.reject');
        Route::patch('/users/{user}/respond-change', [App\Http\Controllers\Admin\AdminController::class, 'respondChangeRequest'])->name('users.respond-change');
        
        Route::resource('programs', App\Http\Controllers\Admin\ProgramController::class);
        
        Route::resource('alsintan', App\Http\Controllers\Admin\AlsintanController::class);

        // Proposal Management
        Route::get('/proposals', [App\Http\Controllers\Admin\ProposalController::class, 'index'])->name('proposals.index');
        Route::get('/proposals/{proposal}', [App\Http\Controllers\Admin\ProposalController::class, 'show'])->name('proposals.show');
        Route::patch('/proposals/{proposal}/approve', [App\Http\Controllers\Admin\ProposalController::class, 'approve'])->name('proposals.approve');
        Route::delete('/proposals/{proposal}/reject', [App\Http\Controllers\Admin\ProposalController::class, 'reject'])->name('proposals.reject');
        
        // Surat Tugas & Verifikasi CPCL Offline
        Route::get('/proposals/{proposal}/surat-tugas/cetak', [App\Http\Controllers\Admin\ProposalController::class, 'cetakSuratTugas'])->name('proposals.cetak-surat-tugas');
        Route::get('/proposals/{proposal}/form-cpcl/cetak', [App\Http\Controllers\Admin\ProposalController::class, 'cetakFormCpcl'])->name('proposals.cetak-form-cpcl');
        Route::get('/proposals/{proposal}/cpcl/create', [App\Http\Controllers\Admin\ProposalController::class, 'createCpcl'])->name('proposals.cpcl.create');
        Route::post('/proposals/{proposal}/cpcl', [App\Http\Controllers\Admin\ProposalController::class, 'storeCpcl'])->name('proposals.cpcl.store');
        Route::get('/proposals/{proposal}/cpcl/edit', [App\Http\Controllers\Admin\ProposalController::class, 'editCpcl'])->name('proposals.cpcl.edit');
        Route::patch('/proposals/{proposal}/cpcl', [App\Http\Controllers\Admin\ProposalController::class, 'updateCpcl'])->name('proposals.cpcl.update');
        // Manajemen Struktur Organisasi (Pegawai)
        Route::resource('employees', App\Http\Controllers\Admin\EmployeeController::class)->except(['show']);
    });

    // Pimpinan Routes
    Route::middleware(['pimpinan'])->prefix('pimpinan')->name('pimpinan.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Pimpinan\ProposalController::class, 'dashboard'])->name('dashboard');
        Route::get('/proposals', [App\Http\Controllers\Pimpinan\ProposalController::class, 'index'])->name('proposals.index');
        Route::get('/proposals/archives', [App\Http\Controllers\Pimpinan\ProposalController::class, 'archives'])->name('proposals.archives');
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
        Route::get('/proposals/{proposal}/assign-team', [App\Http\Controllers\Kabid\ProposalController::class, 'showAssignTeamForm'])->name('proposals.assign-team.form');
        Route::post('/proposals/{proposal}/assign-team', [App\Http\Controllers\Kabid\ProposalController::class, 'assignTeam'])->name('proposals.assign-team');
        Route::get('/proposals/{proposal}/survey-assignments/{assignment}/edit', [App\Http\Controllers\Kabid\ProposalController::class, 'editAssignment'])->name('proposals.assignment.edit');
        Route::patch('/proposals/{proposal}/survey-assignments/{assignment}', [App\Http\Controllers\Kabid\ProposalController::class, 'updateAssignment'])->name('proposals.assignment.update');

        Route::get('/proposals/{proposal}/berita-acara', [App\Http\Controllers\Kabid\BeritaAcaraController::class, 'show'])->name('berita-acara.show');
        Route::post('/proposals/{proposal}/berita-acara/approve', [App\Http\Controllers\Kabid\BeritaAcaraController::class, 'approve'])->name('berita-acara.approve');

        Route::get('/tim-survei', [App\Http\Controllers\Kabid\TimSurveiController::class, 'index'])->name('tim-survei.index');
        Route::get('/tim-survei/create', [App\Http\Controllers\Kabid\TimSurveiController::class, 'create'])->name('tim-survei.create');
        Route::post('/tim-survei', [App\Http\Controllers\Kabid\TimSurveiController::class, 'store'])->name('tim-survei.store');
        Route::delete('/tim-survei/{user}', [App\Http\Controllers\Kabid\TimSurveiController::class, 'destroy'])->name('tim-survei.destroy');
    });


    // Farmer Profile Edit (For Revision)
    Route::prefix('farmer/profile')->name('farmer.profile.')->group(function () {
        Route::get('/edit', [App\Http\Controllers\FarmerProfileController::class, 'edit'])->name('edit');
        Route::patch('/update', [App\Http\Controllers\FarmerProfileController::class, 'update'])->name('update');
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
        Route::get('/alsintan/{alsintan}/detail', [App\Http\Controllers\Farmer\ProposalController::class, 'alsintanShow'])->name('alsintan.show');
        Route::get('/alsintan/{alsintan}', [App\Http\Controllers\Farmer\ProposalController::class, 'alsintanCreate'])->name('alsintan.create');
        Route::post('/alsintan/{alsintan}', [App\Http\Controllers\Farmer\ProposalController::class, 'alsintanStore'])->name('alsintan.store');

        // --- PROGRAM BANTUAN ---
        Route::get('/bantuan', [App\Http\Controllers\Farmer\ProposalController::class, 'bantuanList'])->name('bantuan');
        Route::get('/bantuan/{program}/detail', [App\Http\Controllers\Farmer\ProposalController::class, 'bantuanShow'])->name('bantuan.show');
        Route::get('/bantuan/{program}', [App\Http\Controllers\Farmer\ProposalController::class, 'create'])->name('create');
        Route::post('/bantuan/{program}', [App\Http\Controllers\Farmer\ProposalController::class, 'store'])->name('store');


        Route::get('/form', [App\Http\Controllers\Farmer\ProposalController::class, 'form'])->name('form');
        Route::post('/store-unified', [App\Http\Controllers\Farmer\ProposalController::class, 'storeUnified'])->name('store-unified');

        // Sukses & Download (shared, bebas waktu)
        Route::get('/{proposal}/success', [App\Http\Controllers\Farmer\ProposalController::class, 'success'])->name('success');
        Route::get('/{proposal}/download-receipt', [App\Http\Controllers\Farmer\ProposalController::class, 'downloadReceipt'])->name('download-receipt');
    });
});

Route::middleware('auth')->prefix('documents')->name('documents.')->group(function () {
    Route::get('/surat-tugas/{proposal}', [\App\Http\Controllers\DocumentController::class, 'printSuratTugas'])->name('surat-tugas');
    Route::get('/form-cpcl-blank/{proposal}', [\App\Http\Controllers\DocumentController::class, 'printFormCpcl'])->name('form-cpcl-blank');
    Route::get('/cpcl/{proposal}', [\App\Http\Controllers\DocumentController::class, 'printCpcl'])->name('cpcl');
    Route::get('/berita-acara/{proposal}', [\App\Http\Controllers\DocumentController::class, 'printBeritaAcara'])->name('berita-acara');
    Route::get('/sk-bantuan/{proposal}', [\App\Http\Controllers\DocumentController::class, 'printSKBantuan'])->name('sk-bantuan');
    Route::get('/surat-perjanjian/{proposal}', [\App\Http\Controllers\DocumentController::class, 'printSuratPerjanjian'])->name('surat-perjanjian');
});

require __DIR__.'/auth.php';
