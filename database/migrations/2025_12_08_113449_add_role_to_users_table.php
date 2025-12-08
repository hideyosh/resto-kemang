<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom role sebagai enum dengan default 'customer'
            // nilai: customer = pelanggan biasa, admin = admin sistem
            $table->enum('role', ['customer', 'admin'])->default('customer')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom role ketika migration di-rollback
            $table->dropColumn('role');
        });
    }
};
