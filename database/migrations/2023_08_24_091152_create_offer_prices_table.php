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
        Schema::create('offer_prices', function (Blueprint $table) {
            $table->id();
            $table->string('process_type')->nullable();
            $table->string('duration')->nullable();
            $table->string('price')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();


            /*
             * foreign keys
             */
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->unsignedBigInteger('request_service_id')->nullable();

            /*
             * relationship on db level
             */
            $table->foreign('provider_id')->references('id')->on('providers');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_prices');
    }
};
