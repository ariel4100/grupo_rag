<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->json('title')->nullable();
            $table->json('description')->nullable();
            $table->json('text')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('order')->default('zz');
            $table->boolean('featured')->default(0);
            $table->boolean('published')->default(1);
            $table->json('slug')->nullable();
            $table->unsignedBigInteger('padre_id')->nullable();
            $table->foreign('padre_id')->references('id')->on('families')->onDelete('cascade');
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
        Schema::dropIfExists('families');
    }
}
