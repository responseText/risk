<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblViolence extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('violence', function (Blueprint $table) {
           $table->increments('id');
           $table->string('code',2)->nullable();
           $table->string('name')->nullable();
           $table->string('violencelevel_id')->nullable();
           $table->string('typerisk_id')->nullable();
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
         Schema::dropIfExists('violence');
     }
}
