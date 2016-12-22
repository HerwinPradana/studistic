<?php

namespace Studistic\Http\Controllers\Student;

use Illuminate\Http\Request;
use Studistic\Http\Controllers\Controller;
use Studistic\Classes;

class HomeController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
	    $classes = new Classes();
	    $data	 = $classes->with(['assignments', 'assignments.scores' => function($query){
	    	$query->where('user_id', \Auth::user()->id);
	    }])->whereHas('students', function($query){
	    	$query->where('users.id', \Auth::user()->id);
	    })->orderBy('created_at', 'desc')->get();
	    
	    //echo "<pre>";var_dump($data);echo"</pre>";exit();
	    
        return view('student/home', ['classes' => $data]);
    }
}
