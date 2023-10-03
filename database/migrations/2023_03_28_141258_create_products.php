<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->tinyInteger('status');
            $table->string('image');
            $table->double('price');
            $table->date('date_of_manufacture');
            $table->date('expiry');
            $table->integer('quantity');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('sub_categories_id')->nullable()
                ->constrained('sub_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
