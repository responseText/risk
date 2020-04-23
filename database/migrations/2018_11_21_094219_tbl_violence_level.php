<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblViolenceLevel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('violence_level', function (Blueprint $table) {
           $table->increments('id');
           $table->string('code',2)->nullable();
           $table->string('name')->nullable();
           $table->string('color',7)->nullable();
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
         Schema::dropIfExists('violence_level');
     }
}
