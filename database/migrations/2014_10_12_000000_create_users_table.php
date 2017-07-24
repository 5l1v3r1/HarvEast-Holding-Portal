<?php

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
            $table->string('name');
            $table->timestamp('birthday');
            $table->integer('city_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->integer('position_id')->unsigned();
            $table->integer('boss_id')->unsigned();
            $table->string('photo');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('phones', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->string('phone');
            $table->primary(['user_id','phone']);
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('phones');
    }
}
