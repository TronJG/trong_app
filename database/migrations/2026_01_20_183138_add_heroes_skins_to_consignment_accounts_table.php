<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('consignment_accounts', function (Blueprint $table) {
      $table->unsignedSmallInteger('heroes')->default(0)->after('segment');
      $table->unsignedSmallInteger('skins')->default(0)->after('heroes');
    });
  }

  public function down(): void
  {
    Schema::table('consignment_accounts', function (Blueprint $table) {
      $table->dropColumn(['heroes','skins']);
    });
  }
};
