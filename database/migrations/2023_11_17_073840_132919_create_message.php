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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Cửa hàng HaVy Bakery');
            $table->string('image')->nullable();
            $table->longText('message');
            $table->timestamp('read_at');
            $table->tinyInteger('status');
            $table->timestamps();
            $table->softDeletes();

             // declare foreign key
            $table->foreignId('user_id')->nullable()
            ->constrained('users')
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
        Schema::dropIfExists('messages');
    }
};
