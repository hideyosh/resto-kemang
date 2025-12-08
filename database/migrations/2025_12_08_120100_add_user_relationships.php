<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add user relationship to orders
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
                }
            });
        }

        // Add user relationship to table_reservations
        if (Schema::hasTable('table_reservations')) {
            Schema::table('table_reservations', function (Blueprint $table) {
                if (!Schema::hasColumn('table_reservations', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (Schema::hasColumn('orders', 'user_id')) {
                    $table->dropForeign(['user_id']);
                    $table->dropColumn('user_id');
                }
            });
        }

        if (Schema::hasTable('table_reservations')) {
            Schema::table('table_reservations', function (Blueprint $table) {
                if (Schema::hasColumn('table_reservations', 'user_id')) {
                    $table->dropForeign(['user_id']);
                    $table->dropColumn('user_id');
                }
            });
        }
    }
};
