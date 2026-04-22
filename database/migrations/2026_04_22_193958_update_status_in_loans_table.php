<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menghapus status 'approved'.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM('pending', 'borrowed', 'returned', 'cancelled') DEFAULT 'pending'");
    }

    /**
     * Kembalikan status 'approved' jika migrasi di-rollback.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM('pending', 'approved', 'borrowed', 'returned', 'cancelled') DEFAULT 'pending'");
    }
};