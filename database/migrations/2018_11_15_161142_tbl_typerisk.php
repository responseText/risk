<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblTyperisk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('typerisk', function (Blueprint $table) {
           $table->increments('id');
           $table->string('name')->nullable();
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
         Schema::dropIfExists('typerisk');
     }
}
