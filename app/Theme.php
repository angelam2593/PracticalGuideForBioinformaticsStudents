<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Theme extends Model
{
    protected $table = 'themes';

    public function exercises()
    {
        return $this->hasMany('App\Exercise');
    }

    public function year()
    {
        return $this->belongsTo('App\Year');
    }


    public function countExercise($themeId)
    {
    	$count = DB::table('exercises')->where('theme_id', $themeId)->count();
    	return $count;
    }
}
