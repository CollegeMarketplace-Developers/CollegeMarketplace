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
        Schema::table('messages', function (Blueprint $table) {
            $table->uuid('for_sublease')->nullable();
            $table->foreign('for_sublease')->references('id')->on('subleases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('messages');
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('messages_for_sublease_foreign');
            $table->dropColumn('for_sublease');
        });
    }
};
