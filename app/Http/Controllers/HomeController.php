<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Theme;
use App\Exercise;
use App\User;
use App\Smer;
use App\Year;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function loggingUserAdmin()
    {
        if (Auth::user()->admin == 0)
        {
            $temi = Theme::all();
            return view('user.dashboard', compact('temi'));
        }
        else
        {
            $years = Year::all();
            foreach($years as $year)
            {
                if((Carbon::now() >= $year->start_date) && (Carbon::now() <= $year->end_date))
                    $godina = $year;
            }

            $studenti = count(User::where('year_id', $godina->id)->get());
            $temi = Theme::all()->pluck('title')->toArray(); 
            $zadaci = Exercise::all(); 
            $studenti_po_godina = array();
            foreach($years as $year)
            {
                $studenti_po_godina[$year->name] = $year->students()->get();
            }

            $studenti_ovaa_godina = User::students_this_year($godina->id);

            return view('admin.dashboard', compact('godina', 'studenti', 'temi', 'zadaci', 'studenti_po_godina', 'studenti_ovaa_godina'));
        }
    }

    public function index()
    {
        return view('home');
    }
}
