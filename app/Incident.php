<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Incident extends Model
{
  use SoftDeletes;
  protected $table ='incident';
  protected $dates = ['deleted_at'];
  public function incident_group()
  {
      return $this->hasOne('App\IncidentGroup','id','incident_group_id')->withTrashed();
  }
  public function incident_list()
  {
      return $this->hasOne('App\IncidentList','id','incident_list_id')->withTrashed();
  }
  public function incident_case()
  {
      return $this->hasOne('App\IncidentCase','id','incident_case_id')->withTrashed();
  }
  public function division()
  {
      return $this->hasOne('App\Division','id','division_id')->withTrashed();
  }
  public function subdivision()
  {
      return $this->hasOne('App\SubDivision','id','sub_division_id')->withTrashed();
  }
  public function typerisk()
  {
      return $this->hasOne('App\TypeRisk','id','type_risk_id')->withTrashed();
  }
  public function violence()
  {
      return $this->hasOne('App\Violence','id','violence_id')->withTrashed();
  }
  public function effect()
  {
      return $this->hasOne('App\Effect','id','effect_id')->withTrashed();
  }
  public function employee()
  {
      return $this->hasOne('App\Employee','id','discover_employee_id')->withTrashed();
  }
  public function emloyee_discover()
  {
      return $this->hasOne('App\Employee','id','discover_employee_id')->withTrashed();
  }
  public function user()
  {
      return $this->hasOne('App\User','id','user_id')->withTrashed();
  }
  public function evaluation()
  {
      return $this->hasOne('App\Evaluation','id','incident_status_id')->withTrashed();
  }
  public function headrmname()
  {
      return $this->hasOne('App\User','id','headrm_delete_byid')->withTrashed();
  }

  public function writeByID()
  {
      return $this->hasOne('App\User','id','by_user_id')->withTrashed();
  }






}
