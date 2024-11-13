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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->text('btn_text')->nullable();
            $table->string('name');
            $table->string('putevoditel_po');
            $table->string('icon')->nullable();
            $table->text('seo_text')->nullable();

            $table->text('description1')->nullable();
            $table->text('description2')->nullable();
            $table->string('title1')->nullable();
            $table->string('title2')->nullable();

            $table->integer('order')->default(500);
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
        Schema::dropIfExists('locations');
    }
};
