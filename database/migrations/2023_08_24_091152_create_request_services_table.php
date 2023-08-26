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
        Schema::create('request_services', function (Blueprint $table) {
            $table->id();
            $table->text('details');
            $table->string('min_price')->nullable();
            $table->string('max_price')->nullable();
            $table->string('duration')->nullable();
            $table->text('images')->nullable();
            $table->string('price')->nullable();
            $table->string('tax_value')->nullable();
            $table->timestamps();


            /*
             * foreign keys
             */
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->unsignedBigInteger('offer_price_id')->nullable();

            /*
             * relationship on db level
             */
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('offer_price_id')->references('id')->on('offer_prices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_services');
    }
};
