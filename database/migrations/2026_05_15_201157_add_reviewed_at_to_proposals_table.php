<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            // Timestamps for audit trail
            $table->timestamp('reviewed_at')->nullable()->after('submission_date');
            $table->timestamp('decided_at')->nullable()->after('reviewed_at');
            $table->text('admin_notes')->nullable()->after('decided_at');
            $table->text('pimpinan_notes')->nullable()->after('admin_notes');
        });

        // Update existing 'disetujui' records: they were directly approved by admin,
        // so we treat them as already decided.
        // No data migration needed for the new status; new proposals will follow the new flow.
    }

    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn(['reviewed_at', 'decided_at', 'admin_notes', 'pimpinan_notes']);
        });
    }
};
