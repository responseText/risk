<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncidentCaseInput extends Model
{
  protected $softDelete = false;
  public $timestamps = false;
  protected $table ='incident_case_input';
}
