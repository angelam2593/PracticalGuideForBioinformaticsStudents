<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Theme;
use App\Exercise;
use App\Smer;
use App\Year;
use App\SolvedExercises;
use App\User;
use App\File;
use Auth;
use Hash;
use Sentinel;


class UserController extends Controller
{
    public function userProfile()
    {
    	$logged_user = Auth::user();
    	$smers = Smer::all();
        foreach($smers as $smer)
            if(!($logged_user->smer == $smer['ime']))
                $smerovi[$smer['id']] = $smer['ime'];

        $years = Year::all()->toArray();
        $godini = array();
        foreach($years as $year)
            if(!($logged_user->year_id == $year['id']))
                $godini[$year['id']] = $year['name'];

        return view('user.profile', compact('logged_user', 'smerovi', 'godini'));
    }

    public function userGrades()
    {
    	$logged_user = Auth::user();
    	$temi = Theme::all();
    	$reseni_zadaci = SolvedExercises::all();
    	$zadaci = Exercise::all();
        return view('user.grades', compact('temi', 'reseni_zadaci', 'zadaci', 'logged_user'));
    }

    public function userThemes($themeId)
    {
        $zadaci = Exercise::where('theme_id', $themeId)->get();
        return view('user.themes', compact('zadaci'));
    }

    public function userExercise($exerciseId)
    {
        $zadaca = Exercise::find($exerciseId)->get()->first();
        return view('user.exercise', compact('zadaca'));
    }

    public function uploadFile(Request $request)
    {
        $logged_user = Auth::user()->id; 
        $file = $request->file_to_verify;
        $data = explode('.', $file->getClientOriginalName());
        $name = $data[0] . '_' . $logged_user . '_' .time() .'.'.$data[1]; 
        File::store($name);
        $file->move(storage_path('uploads'), $name);

        return redirect()->back()->with('success', 'Решението е успешно прикачено');
    }

    public function editProfile(Request $request)
    {
         try{
            $logged_user = Auth::user()->id;
            $user = User::find($logged_user);
            $user->name = $request->get('ime');
            $user->surename = $request->get('prezime');
            $user->userid = $request->get('idneks');
            if($request->get('year') != null)
                $user->year_id = $request->get('year');
            if($request->get('smer') != null)
                $user->smer_id = $request->get('smer'); 
            $user->email = $request->get('email'); 
            if ($request->has('lozinka')) {
                $user->password = Hash::make($request->get('lozinka'));
            }
            $user->save();
            return redirect()->back()->with('success', 'Новите податоци се сочувани');
        }
        catch(UserNotFoundException $e){
            return redirect()->back()->with('error', 'Има проблем, обидете се повторно');
        }
    }
}
