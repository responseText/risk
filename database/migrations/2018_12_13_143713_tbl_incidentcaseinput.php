<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblIncidentcaseinput extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('incident_case_input', function (Blueprint $table) {
           $table->increments('id');
           $table->integer('incident_id')->nullable();
           $table->integer('incident_case_id')->nullable();
       });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('incident_case_input');
     }
}
