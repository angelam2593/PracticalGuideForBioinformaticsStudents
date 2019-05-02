<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $table = 'year';

    public function students()
    {
    	return $this->hasMany('App\User');
    }

    public function themes()
    {
    	return $this->hasMany('App\Theme', 'id', 'theme_id');
    }

}
