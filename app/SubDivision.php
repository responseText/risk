<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SubDivision extends Model
{
  use SoftDeletes;
  protected $table ='subdivision';
  protected $dates = ['deleted_at'];
  public function division()
  {
      return $this->hasOne('App\Division','id','division_id')->withTrashed();
  }
}
