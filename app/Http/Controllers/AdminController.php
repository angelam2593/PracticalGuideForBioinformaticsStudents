<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Theme;
use App\Exercise;
use App\User;
use App\Year;
use App\Smer;
use App\Grades;
use App\SolvedExercises;
use Auth;
use Hash;
use App\Http\Requests\AdminProfile;
use App\AdminPosition;

class AdminController extends Controller
{

    public function __construct()
    {
    }

    public function userStudent()
    {
        $godini = Year::all(); 
        $studenti = User::where('admin', 0)->get();
        return view('admin.user_student', compact('studenti', 'godini'));
    }

     public function userAdmin()
    {
        $administratori = User::where('admin', 1)->get();
        return view('admin.user_admin', compact('administratori'));
    }

    public function themes()
    {
        $temi = Theme::all();
        $godini = Year::all(); 

        return view('admin.themes', compact('temi', 'godini'));
    }

    public function exercises()
    {
        $zadaci = Exercise::all();
        $temi = Theme::all();

        return view('admin.exercises', compact('zadaci', 'temi'));
    }

    public function adminProfile()
    {
        $logged_user = Auth::user();
        $positions = AdminPosition::all()->toArray();
        $pozicii = array();
        foreach($positions as $position)
            if(!($position['id'] == $logged_user->position_id))
                $pozicii[$position['id']] = $position['title']; 

        return view('admin.profile', compact('pozicii', 'logged_user'));
    }

    public function adminSemesters()
    {
        $semestri = Year::all();

        return view('admin.semesters', compact('semestri'));
    }

    public function showGodini($godinaId)
    {
        // ako e nula togas site studenti od site godini, inaku where godina_id=godinaId
        $godini = Year::all(); 
        $studenti = User::where('admin', 0)->get();
        if($godinaId == 0)
            return view('admin.user_student', compact('studenti', 'godini'));
        else
        {
            $studenti = Year::where('id', $godinaId)->first()->students()->get();
            return view('admin.user_student', compact('studenti', 'godini'));
        }

    }

    public function showGodinaZaTema($id)
    {
        $temi = Theme::where('year_id', $id)->get();
        $godini = Year::all();
        if(count($temi) > 0)
            return view('admin.themes', compact('temi', 'godini'));
        else
           {
             $temi = Theme::all(); 
             $godini = Year::all();
             return view('admin.themes', compact('temi', 'godini'));
           }
    }

    public function adminOverview()
    {
        $temi = Theme::all();
        return view('admin.admin_overview', compact('temi'));
    }

    public function adminThemes($themeId)
    {
        $zadaci = Exercise::where('theme_id', $themeId)->get(); 
        return view('admin.themes_overview', compact('zadaci'));
    }

    public function exercisesOverview($exerciseId)
    {
        $reseni_zadaci = SolvedExercises::where('exercise_id', $exerciseId)->get();
        return view('admin.exercise_solutions', compact('reseni_zadaci'));
    }

    public function addStudent()
    {
        $smers = Smer::all();
        foreach($smers as $smer)
            $smerovi[$smer['id']] = $smer['ime'];

        $years = Year::all()->toArray();
        $godini = array();
        foreach($years as $year)
            $godini[$year['id']] = $year['name'];

        return view('admin.add_student', compact('smerovi', 'godini'));
    }

    public function addNewStudent(Request $request)
    {
        $user = new User;
        $user->name = $request->all()['ime'];
        $user->surename = $request->all()['prezime'];
        $user->smer_id = $request->all()['smer'];
        $user->year_id = $request->all()['year'];
        $user->email = $request->all()['email'];
        $user->password = bcrypt($request->all()['password']);
        $user->admin = 0;
        $user->save();

        return redirect()->back()->with('success', 'Корисникот е успешно креиран.');
    }

    public function addAdmin()
    {
        $positions = AdminPosition::all()->toArray();
        $pozicii = array();
        foreach($positions as $position)
            $pozicii[$position['id']] = $position['title'];

        return view('admin.add_admin', compact('pozicii'));
    }

    public function addNewAdmin(Request $request)
    {
        $user = new User;
        $user->name = $request->all()['ime'];
        $user->surename = $request->all()['prezime'];
        $user->position_id = $request->all()['position'];
        $user->email = $request->all()['email'];
        $user->password = bcrypt($request->all()['password']);
        $user->admin = 1;
        $user->save();

        return redirect()->back()->with('success', 'Администраторот е успешно креиран.');
    }

    public function addTheme()
    {
        $years = Year::all()->toArray();
        $godini = array();
        foreach($years as $year)
            $godini[$year['id']] = $year['name'];

        return view('admin.add_theme', compact('godini'));
    }

    public function addExercise()
    {
        $themes = Theme::all();
        $temi = array();
        foreach($themes as $theme)
            $temi[$theme['id']] = $theme['title'];

        return view('admin.add_exercise', compact('temi'));
    }

    public function addNewExercise(Request $request)
    {
        $zadaca = new Exercise;
        $zadaca->title = $request->all()['ime'];
        $zadaca->theme_id = $request->all()['theme'];
        $zadaca->description = $request->all()['description'];
        $zadaca->test_input = $request->all()['description_input'];
        $zadaca->test_output = $request->all()['description_output'];
        $zadaca->save();

        return redirect()->back()->with('success', 'Задачата е успешно креирана.');
    }

    public function user_info($studentId)
    {
        $student = User::where('id', $studentId)->first();
        $temi = Theme::all();
        $reseni_zadaci = SolvedExercises::where('student_id', $student->id)->get();
        $zadaci = Exercise::all();
        return view('admin.student_info', compact('temi', 'reseni_zadaci', 'zadaci', 'student'));
    }
    
    public function editUserProfile(Request $request)
    {
        try{
            $logged_user = Auth::user()->id;
            $user = User::find($logged_user);
            $user->name = $request->get('ime');
            $user->surename = $request->get('prezime');
            if($request->get('position') != null)
                $user->position_id = $request->get('position'); 
            $user->email = $request->get('email'); 
            if ($request->has('password')) {
                $user->password = Hash::make($request->get('password'));
            }
            $user->save();
            return redirect()->back()->with('success', 'Новите податоци се сочувани');
        }
        catch(UserNotFoundException $e){
            return redirect()->back()->with('error', 'Има проблем, обидете се повторно');
        }
    }


    public function editUser($userId)
    {
        $user = User::find($userId);
        $smers = Smer::all();
        foreach($smers as $smer)
            if(!($user->smer->ime == $smer['ime']))
                $smerovi[$smer['id']] = $smer['ime'];

        $years = Year::all()->toArray();
        $godini = array();
        foreach($years as $year)
            if(!($user->year_id == $year['id']))
                $godini[$year['id']] = $year['name'];

        return view('admin.edit_user', compact('user', 'smerovi', 'godini'));
    }

    public function editCurrentUser(Request $request)
    {
        $user = User::find($request->all()['userId']);
        $user->name = $request->all()['ime'];
        $user->surename = $request->all()['prezime'];
        $user->smer_id = $request->all()['smer'];
        $user->year_id = $request->all()['year'];
        $user->email = $request->all()['email'];
        $user->password = bcrypt($request->all()['password']);
        $user->save();

        return redirect()->back()->with('success', 'Корисникот е успешно ажуриран.');
    }

    public function editTheme($themeId)
    {
        $tema = Theme::find($themeId);
        return view('admin.edit_theme', compact('tema'));
    }

    public function editAdminTheme(Request $request)
    {
        dd("tuka");
    }

    public function showTema($themeId)
    {
        if($themeId == 0)
        {
            $zadaci = Exercise::all();
            $temi = Theme::all();
            return view('admin.exercises', compact('temi', 'zadaci'));
        }
        else
        {
            $zadaci = Exercise::where('theme_id', $themeId)->get();
            $temi = Theme::all();
            return view('admin.exercises', compact('temi', 'zadaci'));
        }
    }

    public function editExercise($exerciseId)
    {
        $zadaca = Exercise::where('id', $exerciseId)->first(); 
        $themes = Theme::all();
        $temi = array();
        foreach($themes as $theme)
            if(!($zadaca->theme_id == $theme['id']))
                $temi[$theme['id']] = $theme['ime'];
        
        return view('admin.edit_exercise', compact('zadaca', 'temi'));
    }

    public function addPoints(Request $request)
    {
        $zadaca_id = $request->all()['zadaca_id'];
        $points = $request->all()['points'];
        SolvedExercises::where('id', $zadaca_id)->update(['points' =>  $points]);

        return redirect()->back()->with('success', 'Поените се ажурирани во база!');
    }

    public function adminGrades()
    {
        $temi = Theme::all();
        $zadaci = Exercise::all();
        $oceni = Grades::all(); 

        return view('admin.grades', compact('temi', 'zadaci', 'oceni'));
    }

    public function userStatus()
    {
        $users = User::all();
        return view('admin.user_status', compact('users'));
    }
} 
