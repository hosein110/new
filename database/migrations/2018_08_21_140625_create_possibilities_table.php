<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePossibilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('possibilities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('image_path');
            $table->tinyInteger('type');
            $table->tinyInteger('status');
            $table->timestamps();
        });


        Schema::create('location_possibility', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('possibility_id')->unsigned()->index();

            $table->integer('location_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('possibility_id')->references('id')->on('possibilities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('possibilities');
    }
}
