<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Violence extends Model
{
  use SoftDeletes;
  protected $table ='violence';
  protected $dates = ['deleted_at'];
  public function violence_level()
  {
      return $this->hasOne('App\ViolenceLevel','id','violencelevel_id')->withTrashed();
  }
  public function type_risk()
  {
      return $this->hasOne('App\TypeRisk','id','typerisk_id');
  }
}
