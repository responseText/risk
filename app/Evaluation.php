<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Evaluation extends Model
{
  use SoftDeletes;
  protected $table ='evaluation';
  protected $dates = ['deleted_at'];
}
