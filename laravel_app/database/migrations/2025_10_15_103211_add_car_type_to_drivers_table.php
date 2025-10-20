<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('drivers', function (Blueprint $table) {
            $table->enum('car_type', ['economy', 'comfort', 'luxe'])->default('economy')->after('status');
        });
    }

    public function down(): void {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn('car_type');
        });
    }
};
