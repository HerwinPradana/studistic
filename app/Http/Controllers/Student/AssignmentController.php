<?php

namespace Studistic\Http\Controllers\Student;

use Illuminate\Http\Request;
use Studistic\Http\Controllers\Controller;
use Studistic\User;
use Studistic\Classes;
use Studistic\Assignment;
use Studistic\Question;
use Studistic\Option;
use Studistic\Attempt;
use Studistic\Answer;

class AssignmentController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
        $classes = User::find(\Auth::user()->id)->classes;

	    $data = Assignment::whereHas('classes', function($query) use ($classes){
	    							$query->whereIn('class_subject_id', $classes);
	    						})->orderBy('created_at', 'desc')->get();
	    
        return view('student/assignments/index', ['assignments' => $data]);
    }

    public function show(Assignment $assignment){
	    $attempts = Attempt::where('assignment_id', $assignment->id)
	    			->where('created_by', \Auth::user()->id)
	    			->orderBy('created_at', 'asc')->get();
		
        return view('student/assignments/detail', ['assignment' => $assignment, 'attempts' => $attempts]);
    }
    
    public function edit(Assignment $assignment){
        return view('student/assignments/edit', ['assignment' => $assignment]);
    }

    public function update(Request $request){
    	$id = $request->input('id');

		$score = 0;
		
    	$questions 	= $request->input('questions');
    	$assignment = Assignment::find($id);
    	
    	foreach($assignment->questions as $question){
    		foreach($question->options as $option){
    			if($questions[$question->id] == $option->id && $option->is_correct)
	    			$score++;
	    	}
    	}
    	
    	$n_questions = $assignment->questions->count();
    	$score = ($n_questions > 0)? ($score / $n_questions) * 10 : 0;
    	
		$attempt = new Attempt(array('score' => $score, 'created_by' => \Auth::user()->id));
		$attempt = $assignment->attempts()->save($attempt);
		
		$answers = array();
		foreach($questions as $question_id => $answer){
			$answers[] = new Answer(array('question_id' => $question_id, 'option_id' => $answer));
		}
		
		if(!empty($answers))
			$attempt->answers()->saveMany($answers);
    	
        return redirect('assignments/'.$assignment->id.'/attempts/'.$attempt->id);
    }
    
    public function attempt(Assignment $assignment, Attempt $attempt){
        return view('student/assignments/attempt', ['assignment' => $assignment, 'attempt' => $attempt]);
	}
}
