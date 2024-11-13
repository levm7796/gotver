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
        Schema::create('tags_for_news', function (Blueprint $table) {
            $table->id();
            $table->string('name');
//            $table->unsignedBigInteger('new_id');
//            $table->foreign('new_id')->references('id')->on('news')->onDelete('cascade');
            // $table->enum('type', [0, 1, 2]);
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
        Schema::dropIfExists('tags_for_news');
    }
};
