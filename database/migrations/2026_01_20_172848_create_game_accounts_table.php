<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('game_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account', 190)->unique();
            $table->string('password', 255); // để plain hoặc encrypt tùy bạn
            $table->text('note')->nullable();
            $table->date('change_due_date')->nullable(); // ngày đến hạn đổi số
            $table->boolean('is_changed')->default(false); // đã đổi số chưa
            $table->timestamp('changed_at')->nullable(); // thời điểm đổi (tuỳ chọn)
            $table->timestamps();

            $table->index(['is_changed', 'change_due_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_accounts');
    }
};
