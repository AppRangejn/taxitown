<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('order_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->enum('status', ['new','in_progress','completed','cancelled']);
            $table->timestamp('changed_at')->useCurrent();
        });
    }

    public function down(): void {
        Schema::dropIfExists('order_histories');
    }
};
