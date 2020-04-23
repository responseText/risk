<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
  protected $softDelete = false;
  public $timestamps = false;
  protected $table ='users_level';

/*
  public function user_id()
  {
      return $this->hasMany('App\User','id','user_id');
  }
  public function level_access()
  {
      return $this->hasOne('App\LevelAccess','id','level_id');
  }
  */
  public function get_level_access()
  {
      return $this->hasMany('App\LevelAccess','id','level_id');
  }
  public function division()
  {
      return $this->hasMany('App\Division','id','division_id')->withTrashed();
  }
  public function subdivision()
  {
      return $this->hasMany('App\SubDivision','id','subdivision_id')->withTrashed();
  }
}
