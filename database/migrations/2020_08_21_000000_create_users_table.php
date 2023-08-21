<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
  public function up() {
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name',100);
        $table->string('country_code',5)->default('966');
        $table->string('phone',15)->unique();
        $table->string('email',100)->unique()->nullable();
        $table->string('image', 100)->default('default.png');
        $table->string('lang', 2)->default('ar');
        $table->string('code', 10)->nullable();
        $table->timestamp('code_expire')->nullable();
        $table->decimal('wallet_balance', 9,2)->default(0);
        $table->boolean('active')->default(0);
        $table->boolean('is_blocked')->default(0);
        $table->boolean('is_notify')->default(true);
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        $table->softDeletes();
    });
  }

  public function down() {
    Schema::dropIfExists('users');
  }
}
