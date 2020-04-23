<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblIncident extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('incident', function (Blueprint $table) {
          $table->increments('id');
          $table->string('incident_no')->nullable();
          $table->date('incident_date')->nullable();
          $table->time('incident_time')->nullable();
          $table->string('division_id')->nullable();
          $table->string('sub_division_id')->nullable();
          $table->string('effect_id')->nullable();
          $table->string('incident_group_id')->nullable();
          $table->string('incident_list_id')->nullable();
          $table->string('type_risk_id')->nullable();
          $table->string('violence_id')->nullable();
          $table->string('incident_case_id')->nullable();
          $table->string('incident_title')->nullable();
          $table->string('incident_place')->nullable();
          $table->string('incident_event')->nullable();
          $table->string('incident_edit')->nullable();
          $table->string('incident_propersal')->nullable();
          $table->string('discover_employee_id')->nullable();
          $table->string('incident_solve')->nullable();
          $table->string('incident_headpropersal')->nullable();
          $table->string('conclusion')->nullable();
          $table->string('status')->nullable();
          $table->string('by_user_id')->nullable();
          $table->string('tran')->nullable();

          $table->string('headrm_sendto_headdivision_status')->nullable();
          $table->string('headrm_sendto_headdivision_date')->nullable();
          $table->string('headrm_sendto_headdivision_by_id')->nullable();
          $table->string('headdivision_receive_status')->nullable();
          $table->string('headdivision_receive_date')->nullable();
          $table->string('headdivision_edit')->nullable();
          $table->string('headdivision_propersal')->nullable();
          $table->string('headdivision_receive_by_id')->nullable();
          $table->string('by_user_id')->nullable();
          $table->string('incident_division')->nullable();
          $table->string('incident_subdivision')->nullable();


          $table->string('hearm_review_edit')->nullable();
          $table->string('hearm_review_propersal')->nullable();
          $table->string('hearm_review_status')->nullable();
          $table->string('hearm_review_by_id')->nullable();
          $table->string('hearm_review_date')->nullable();
          $table->string('incident_status_id')->nullable();

          $table->timestamps();
          $table->softDeletes();

      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incident');
    }
}
