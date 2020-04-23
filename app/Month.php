<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Month extends Model
{

      protected $softDelete = false;
      public $timestamps = false;

      protected $table ='month';
}
