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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->unsignedBigInteger('hub_id')->nullable();
            $table->foreign('hub_id')->references('id')->on('hubs')->onDelete('cascade');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('title');
            $table->string('img');
            $table->string('thumbImg');
            $table->string('coordinates')->nullable();
            $table->string('author');
            $table->string('data');
            $table->integer('order')->default(500);
            $table->string('signature');
            $table->boolean('views');
            $table->boolean('likes');
            $table->boolean('comments');
            $table->enum('type', ['0', '1', '2'])->default('0');
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
        Schema::dropIfExists('news');
    }
};
