<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::where('role', 'user')->pluck('id');
        if ($users->isEmpty()) {
            // Create a dummy user if none exists
            $user = \App\Models\User::create([
                'name' => 'Dummy Farmer',
                'email' => 'farmer_dummy_' . time() . '@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
                'is_verified' => true,
            ]);
            $users = collect([$user->id]);
        }

        $programs = \App\Models\Program::pluck('id');
        $alsintans = \App\Models\Alsintan::pluck('id');

        $proposalsToInsert = [];
        $now = now();

        for ($i = 0; $i < 50; $i++) {
            $isAlsintan = rand(0, 1) == 1 && $alsintans->isNotEmpty();
            $isProgram = !$isAlsintan && $programs->isNotEmpty();
            
            // Generate a random date within the last 90 days
            $submissionDate = $now->copy()->subDays(rand(0, 90));
            
            $proposalsToInsert[] = [
                'user_id' => $users->random(),
                'program_id' => $isProgram ? $programs->random() : null,
                'alsintan_id' => $isAlsintan ? $alsintans->random() : null,
                'jumlah_unit' => rand(1, 3),
                'status' => collect(['sedang_diverifikasi_admin', 'sedang_diverifikasi_pimpinan', 'disetujui', 'ditolak'])->random(),
                'submission_date' => $submissionDate,
                'created_at' => $submissionDate,
                'updated_at' => $submissionDate,
            ];
        }

        \App\Models\Proposal::insert($proposalsToInsert);
    }
}
