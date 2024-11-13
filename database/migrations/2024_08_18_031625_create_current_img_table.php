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
        Schema::create('current_img', function (Blueprint $table) {
            $table->id();
//            $table->unsignedBigInteger('hotel_id');
//            $table->foreign('hotel_id')->references('id')->on('hotel')->onDelete('cascade');
            $table->string('img');
            $table->string('thumb_img')->nullable();
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
        Schema::dropIfExists('current_img');
    }
};
