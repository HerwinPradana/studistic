<?php

namespace Studistic\Http\Controllers\Student;

use Illuminate\Http\Request;
use Studistic\Http\Controllers\Controller;
use Studistic\Classes;

class ClassesController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
	    $classes = new Classes();
	    $data	 = $classes->orderBy('created_at', 'desc')->get();
	    
        return view('student/classes/index', ['classes' => $data]);
    }
    
    public function show(Classes $class){
        return view('student/classes/detail', ['class' => $class]);
    }
    
    public function join(Classes $class){
        return view('student/classes/detail', ['class' => $class]);
    }
}
