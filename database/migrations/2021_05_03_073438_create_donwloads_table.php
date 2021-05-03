<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonwloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donwloads', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('text')->nullable();
            $table->string('date')->nullable();
            $table->boolean('status')->default(0)->nullable();
            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->string('order')->default('zz')->nullable();
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
        Schema::dropIfExists('donwloads');
    }
}
