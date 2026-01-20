<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('consignment_images', function (Blueprint $table) {
      $table->id();
      $table->foreignId('consignment_account_id')->constrained('consignment_accounts')->cascadeOnDelete();
      $table->string('path'); // storage path
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('consignment_images');
  }
};
