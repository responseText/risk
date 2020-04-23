<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class IncidentGroup extends Model
{
  use SoftDeletes;
  protected $table ='incident_group';
  protected $dates = ['deleted_at'];
  public function risk_program()
  {
      return $this->hasOne('App\RiskProgram','id','risk_program_id')->withTrashed();
  }
  public function incident_list()
    {

       $this->hasMany('App\IncidentGroup')->withTrashed();
       //$this->hasMany('App\IncidentGroup');
    }
}
