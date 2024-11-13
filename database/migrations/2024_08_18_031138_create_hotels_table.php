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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->unsignedBigInteger('hub_id')->nullable();
            $table->foreign('hub_id')->references('id')->on('hubs')->onDelete('cascade');
            $table->string('name');
            $table->string('title');
            $table->string('address');
            $table->text('contact_description')->nullable();
            $table->integer('price');
            $table->integer('link_click')->default(0);
            $table->integer('phone_click')->default(0);
            $table->string('number')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('reservation');
            $table->longText('description')->nullable();
            $table->string('coordinates');
            $table->integer('order')->default(500);
            $table->boolean('views');
            $table->boolean('likes');
            $table->boolean('comments');
            $table->bigInteger('viewsCount')->nullable();
            $table->bigInteger('likesCount')->nullable();
            $table->bigInteger('commentsCount')->nullable();
            $table->timestamp('end_date')->nullable();
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
        Schema::dropIfExists('hotels');
    }
};
