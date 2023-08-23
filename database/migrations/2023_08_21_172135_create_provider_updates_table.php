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
        Schema::create('provider_updates', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['password','phone','email']);
            $table->string('phone');
            $table->string('email',100)->nullable();
            $table->string('country_code')->nullable();
            $table->string('code')->nullable();
            $table->timestamp('code_expire')->nullable();
            $table->enum('status',['pending','completed'])->default('pending');
            $table->timestamps();

            /*
             * foreign keys
             */
            $table->unsignedBigInteger('provider_id');

            /*
             * relationship on db level
             */
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_updates');
    }
};
