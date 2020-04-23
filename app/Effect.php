<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Effect extends Model
{
  use SoftDeletes;
  protected $table ='effect';
  protected $dates = ['deleted_at'];
}
