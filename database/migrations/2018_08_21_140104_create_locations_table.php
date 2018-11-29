<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');

            $table->integer('user_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->text('content');
            $table->integer('price');
            $table->string('tel');
            $table->string('name');
            $table->string('	date_time');

            $table->integer('state_id');
            $table->integer('city_id');

            $table->string('lat');
            $table->string('longitude');

            $table->tinyInteger('is_confirm')->default(0);

            $table->string('version_app');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
}
