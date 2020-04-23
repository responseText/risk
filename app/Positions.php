<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Positions extends Model
{
  use SoftDeletes;
  protected $table ='positions';
  protected $dates = ['deleted_at'];

}
