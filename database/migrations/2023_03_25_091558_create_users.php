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
        Schema::create('users', function(Blueprint $table)
        {
            $table->id();
            $table->string('name');
            $table->string('email_address');
            $table->string('address')->nullable();
            $table->string('password')->default('$2y$10$FoBBT6brPzjximfpWtC7LedZ4vu9hzFlN0xH6pYMn48iagXUdWSoy')->nullable();
            $table->string('google_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('remember_token')->nullable();
            $table->tinyInteger('role')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
