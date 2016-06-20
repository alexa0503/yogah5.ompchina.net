<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infos', function (Blueprint $table) {
            $table->integer('id')->unsigned()->primary();
            $table->foreign('id')->references('id')->on('wechat_users');
            $table->string('name',60)->nullable();
            $table->string('gender',60)->nullable();
            $table->string('district',60)->nullable();
            $table->string('mobile',60)->nullable();
            $table->string('address',120)->nullable();
            $table->string('pregnancy',60);
            $table->integer('action');
            $table->dateTime('created_time')->index();
            $table->string('created_ip',120)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('infos');
    }
}
