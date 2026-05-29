<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First ensure any existing 'pinjam_alat' records are handled (none exist based on previous check)
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE programs MODIFY COLUMN type ENUM('bantuan_permanen', 'usulan_pendanaan') NOT NULL");
        } elseif (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE programs DROP CONSTRAINT IF EXISTS programs_type_check");
            DB::statement("ALTER TABLE programs ADD CONSTRAINT programs_type_check CHECK (type::text = ANY (ARRAY['bantuan_permanen'::character varying, 'usulan_pendanaan'::character varying]::text[]))");
        } else {
            Schema::table('programs', function (Blueprint $table) {
                // sqlite or others
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE programs MODIFY COLUMN type ENUM('bantuan_permanen', 'pinjam_alat', 'usulan_pendanaan') NOT NULL");
        } elseif (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE programs DROP CONSTRAINT IF EXISTS programs_type_check");
            DB::statement("ALTER TABLE programs ADD CONSTRAINT programs_type_check CHECK (type::text = ANY (ARRAY['bantuan_permanen'::character varying, 'pinjam_alat'::character varying, 'usulan_pendanaan'::character varying]::text[]))");
        }
    }
};
