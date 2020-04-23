<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class IncidentCase extends Model
{
  use SoftDeletes;
  protected $table ='incident_case';
  protected $dates = ['deleted_at'];

}
