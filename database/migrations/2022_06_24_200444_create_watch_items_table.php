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
        Schema::create('watch_items', function (Blueprint $table) {
            $table->id('id')->unique();
            $table->uuid('user_id'); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('watchitem_title');
            $table->string('type');
            $table->string('match_rate');
            $table->string('key_tags');
            $table->string('matches_found')->nullable();
            $table->string('dont_recommend')->nullable();
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
        Schema::dropIfExists('watch_items');
    }
};
