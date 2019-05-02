<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'file';

    public static function store($filename)
    {
    	$file = new File;
    	$file->filename = $filename;
    	$file->save();

    	return redirect()->back();
    }
}
