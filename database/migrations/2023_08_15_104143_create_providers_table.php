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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('image',100)->nullable();
            $table->string('phone',15)->unique();
            $table->string('country_code',5);
            $table->string('email',100)->nullable()->unique();
            $table->string('password',100);
            $table->text('description')->nullable();
            $table->string('bank_account',100)->unique();
            $table->string('bank_name',100)->nullable();
            $table->string('bank_username',100)->nullable();
            $table->string('bank_iban',100)->nullable();
            $table->string('lat',60)->nullable();
            $table->string('lng',60)->nullable();
            $table->string('map_desc',255)->nullable();
            $table->string('city')->nullable();
            $table->string('code',10)->nullable();
            $table->timestamp('code_expire')->nullable();
            $table->string('level_experience')->nullable();
            $table->boolean('active')->default(0);
            $table->boolean('is_notify')->default(1);
            $table->boolean('is_approved')->default(0);
            $table->boolean('is_blocked')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
