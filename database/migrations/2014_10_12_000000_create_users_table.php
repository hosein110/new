<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname');
            $table->string('image_path');
            $table->string('username')->unique();
            $table->string('mobile')->unique();
            $table->text('bio');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('api_token');
            $table->string('sms_verify');


            $table->tinyInteger('is_public')->default(1);
            $table->tinyInteger('is_administrator')->default(0);
            $table->enum('register_type',['application','google','site']);
            $table->enum('language',['fa','en','fr'])->default('fa');

            $table->rememberToken();

            $table->string('version_app');
            $table->timestamps();
            $table->index([DB::raw('email(191)')]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
