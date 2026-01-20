<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('consignment_accounts', function (Blueprint $table) {
      $table->id();
      $table->string('code', 190)->unique();     // mã tài khoản
      $table->unsignedInteger('price_k')->default(0); // giá theo nghìn (1000 => 1,000,000)
      $table->string('segment', 50)->nullable(); // phân khúc (tự do)
      $table->text('note')->nullable();
      $table->timestamps();

      $table->index(['segment', 'price_k']);
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('consignment_accounts');
  }
};
