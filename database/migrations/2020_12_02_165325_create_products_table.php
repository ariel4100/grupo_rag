<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->json('title')->nullable();
            $table->json('short_description')->nullable();
            $table->json('description')->nullable();
            $table->json('text')->nullable();
            $table->json('text_video')->nullable();
            $table->double('price')->nullable();
            $table->string('unit')->nullable();
            $table->string('video')->nullable();
            $table->string('banner')->nullable();
            $table->json('gallery')->nullable();
            $table->json('file')->nullable();
            $table->string('order')->default('zz')->nullable();
            $table->boolean('featured')->default(0);
            $table->boolean('published')->default(1);
            $table->json('slug')->nullable();
            $table->unsignedBigInteger('family_id')->nullable();
            $table->foreign('family_id')->references('id')->on('families')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
