<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function employee()
    {
        return $this->hasOne('App\Employee','id','employee_id')->withTrashed();
    }

    public function level_access()
    {
        return $this->hasMany('App\LevelAccess','id','level_id');
    }
    public function division()
    {
        return $this->hasOne('App\Division','id','division_id')->withTrashed();
    }
    public function subdivision()
    {
        return $this->hasOne('App\SubDivision','id','subdivision_id')->withTrashed();
    }
    public function user_level()
    {
        return $this->hasMany('App\UserLevel','user_id','id');
    }


}
