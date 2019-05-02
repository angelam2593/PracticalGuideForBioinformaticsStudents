<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $table = 'exercises';

    public function theme()
	{
	    return $this->belongsTo('App\Theme')->withDefault();
	}
}

