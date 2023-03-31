<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name', 256);
            $table->string('img');
            $table->unsignedBigInteger('position');
            $table->date('employment_date');
            $table->string('email')->unique();
            $table->string('phone');
            $table->unsignedDecimal('salary', $precision = 6, $scale = 3);
            $table->unsignedBigInteger('head')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('admin_created_id');
            $table->unsignedBigInteger('admin_updated_id');

            $table->foreign('position')->references('id')->on('positions');
            $table->foreign('head')->references('id')->on('employees');
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
        Schema::dropIfExists('employees');
    }
}
