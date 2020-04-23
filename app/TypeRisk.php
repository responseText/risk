<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TypeRisk extends Model
{
  use SoftDeletes;
  protected $table ='typerisk';
  protected $dates = ['deleted_at'];
}
