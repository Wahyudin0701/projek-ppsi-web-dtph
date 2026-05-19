<?php

use App\Models\User;
use App\Models\Proposal;

$farmerId = User::where('role', 'user')->first()->id;
$kabidId = User::where('role', 'kabid_psp')->first()->id;

$proposal = Proposal::create([
    'user_id' => $farmerId,
    'program_id' => 1,
    'status' => 'disposisi_kabid',
    'submission_date' => now()->subDays(2),
    'lokasi_lahan' => 'Desa Sukamaju, Blok C (Tunggu Survei)',
    'admin_notes' => 'Berkas administrasi awal lengkap. Lanjut ke Pimpinan.',
    'reviewed_at' => now()->subDays(1),
    'pimpinan_notes' => 'Tolong segera survei lahan ini untuk memastikan kelayakan.',
    'decided_at' => now()->subDays(1),
    'kabid_id' => $kabidId,
    'disposition_notes' => 'Silakan segera bentuk tim dan agendakan survei.',
]);

echo "Proposal ID {$proposal->id} berhasil dibuat dengan status disposisi_kabid untuk Kabid PSP.\n";
