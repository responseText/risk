<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('employee', function (Blueprint $table) {
           $table->increments('id');
           $table->string('prefix_id')->nullable();
           $table->string('fname')->nullable();
           $table->string('lname')->nullable();
           $table->string('position_id')->nullable();
           $table->string('division_id')->nullable();
           $table->string('subdivision_id')->nullable();
           $table->timestamps();
           $table->softDeletes();
           $table->string('status')->nullable();
           $table->string('orderby')->nullable();
       });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('employee');
     }
}
