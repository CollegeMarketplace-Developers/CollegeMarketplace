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

            //$table->bigInteger('from');
            $table->uuid('from');

            //$table->bigInteger('to');
            $table->uuid('to'); 
            //$table->unsignedBigInteger('for_listing')->nullable();
            $table->uuid('for_listing'); 
            $table->foreign('for_listing')->references('id')->on('listings')->onDelete('cascade');
            //$table->unsignedBigInteger('for_rentals')->nullable();
            $table->uuid('for_rentals')->nullable(); 
            $table->text('message');
            $table->tinyInteger('is_read');
            $table->timestamps();
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
