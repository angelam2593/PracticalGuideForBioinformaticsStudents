<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exercise;

class SolvedExercises extends Model
{
    protected $table = 'solved_exercises';

    public function ime_zadaca($id)
	{	
	   	$ime_zadaca = Exercise::where('id', $id)->first();
	   	return $ime_zadaca;
	}

	public function student()
	{
		return $this->belongsTo('App\User');
	}
}
