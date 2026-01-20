<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('money_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('trans_date'); // ngày phát sinh
            $table->enum('type', ['income', 'expense']); // thu/chi
            $table->unsignedBigInteger('amount'); // số tiền (VND) không âm
            $table->string('note', 255)->nullable(); // ghi chú
            $table->timestamps();

            $table->index(['trans_date', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('money_transactions');
    }
};
