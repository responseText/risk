<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ViolenceLevel extends Model
{
  use SoftDeletes;
  protected $table ='violence_level';
  protected $dates = ['deleted_at'];
}
