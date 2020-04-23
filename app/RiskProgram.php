<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RiskProgram extends Model
{
  use SoftDeletes;
  protected $table ='risk_program';
  protected $dates = ['deleted_at'];
  public function incident_group()
  {
      return $this->belongsTo('App\IncidentGroup','risk_program_id');
  }
}
