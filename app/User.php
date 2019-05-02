<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'admin', 'year_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function position()
    {
        return $this->hasOne('App\AdminPosition', 'id', 'position_id');
    }

    public function smer()
    {
        return $this->hasOne('App\Smer', 'id', 'smer_id');
    }

    public function year()
    {
        return $this->hasOne('App\Year', 'id', 'year_id');
    }

      public static function students_this_year($yearId)
    {
        return User::where('year_id', $yearId)->get();
    }
}
