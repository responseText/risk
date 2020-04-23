<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class IncidentList extends Model
{
  use SoftDeletes;
  protected $table ='incident_list';
  protected $dates = ['deleted_at'];
  public function incident_group()
  {
      return $this->hasOne('App\IncidentGroup','id','incident_group_id')->withTrashed();
      //return $this->hasOne('App\IncidentGroup','id','incident_group_id');
  }

}
