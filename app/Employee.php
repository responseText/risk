<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Employee extends Model
{
  use SoftDeletes;
  protected $table ='employee';
  protected $dates = ['deleted_at'];
  public function prefix()
  {
      return $this->hasOne('App\Prefix','id','prefix_id')->withTrashed();
  }
  public function position()
  {
      return $this->hasOne('App\Positions','id','position_id')->withTrashed();
  }
  public function division()
  {
      return $this->hasOne('App\Division','id','division_id')->withTrashed();
  }
  public function subdivision()
  {
      return $this->hasOne('App\SubDivision','id','subdivision_id')->withTrashed();
  }
  public function is_user()
  {
      return $this->hasOne('App\User','employee_id','id')->withTrashed();
  }

}
