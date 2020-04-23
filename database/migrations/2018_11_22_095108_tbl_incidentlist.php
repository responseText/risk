<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblIncidentlist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('incident_list', function (Blueprint $table) {
           $table->increments('id');
           $table->string('name')->nullable();
           $table->string('incident_group_id')->nullable();
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
         Schema::dropIfExists('incident_list');
     }
}
