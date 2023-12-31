<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->tinyInteger('service')->default(true);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();

            /*
            foreign keys
            */
            $table->unsignedBigInteger('department_id')->nullable();
            $table ->unsignedBigInteger('parent_id')->index()->nullable();

            /*
            relationship on db level
            */
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
