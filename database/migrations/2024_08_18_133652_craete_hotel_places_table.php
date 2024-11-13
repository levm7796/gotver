<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
//        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::create('hotel_places', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotels_id');
            $table->foreign('hotels_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->string('icon');
            $table->string('text');
            $table->timestamps();
        });
//        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_places');
    }
};
