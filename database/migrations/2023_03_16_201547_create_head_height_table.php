<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeadHeightTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('head_height', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('head_id');
            $table->integer('height');
            $table->timestamps();
            $table->unsignedBigInteger('admin_created_id');
            $table->unsignedBigInteger('admin_updated_id');

            $table->foreign('head_id')->references('id')->on('employees');
            $table->foreign('admin_created_id')->references('id')->on('users');
            $table->foreign('admin_updated_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('head_hight');
    }
}
