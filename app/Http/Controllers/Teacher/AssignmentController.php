<?php

namespace Studistic\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Studistic\Http\Controllers\Controller;
use Studistic\Classes;
use Studistic\Assignment;
use Studistic\Question;
use Studistic\Option;

class AssignmentController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
	    $data	 	= Assignment::orderBy('created_at', 'desc')->get();
	    
        return view('teacher/assignments/index', ['assignments' => $data]);
    }
    
    public function create(){
    	$classes = Classes::orderBy('year', 'desc')->orderBy('semester', 'desc')->get();
    	
    	$class_options = array();
    	foreach($classes as $class){
    		$class_options[$class->id] = $class->name;
    	}
    	
    	$assignment = new Assignment();
        return view('teacher/assignments/edit', ['assignment' => $assignment, 'classes' => $class_options]);
    }

    public function store(Request $request){
    	$assignment = new Assignment();
    	
    	$assignment->class_subject_id	= $request->input('class_id');
    	$assignment->name			 	= $request->input('name');
    	$assignment->description	 	= $request->input('description');

		$status = $assignment->save();
    	
    	$new_questions	= $request->input('new_questions');
    	
    	// Insert new questions.
    	if($status && $new_questions){
			foreach($new_questions as $question_id => $question){
				$options  = array();
				foreach($question['new_options'] as $new_option){
					$options[] = new Option($new_option);
				}
				
				$question = new Question($question);
				$assignment->questions()->save($question);
				
				// Insert options.
				if(!empty($options))
					$question->options()->saveMany($options);
			}
    	}

		$messages = $status? 'Data berhasil disimpan.' : 'Data gagal disimpan.';
    	
        return redirect('teacher/assignments/'.$assignment->id.'/edit')->with('status', $status)->with('messages', $messages);
    }

    public function show(Assignment $assignment){
        return view('teacher/assignments/detail', ['assignment' => $assignment]);
    }
    
    public function edit(Assignment $assignment){
    	$classes = Classes::orderBy('year', 'desc')->orderBy('semester', 'desc')->get();
    	
    	$class_options = array();
    	foreach($classes as $class){
    		$class_options[$class->id] = $class->name;
    	}
    	
        return view('teacher/assignments/edit', ['assignment' => $assignment, 'classes' => $class_options]);
    }

    public function update(Request $request){
    	$id = $request->input('id');
    	
    	$assignment = Assignment::find($id);
    	
    	$assignment->class_subject_id	= $request->input('class_id');
    	$assignment->name		 		= $request->input('name');
    	$assignment->description 		= $request->input('description');

		$status = $assignment->save();
    	
    	$questions		= $request->input('questions');
    	$new_questions	= $request->input('new_questions');
    	
    	// Update existing questions.
    	if($status && $questions){
			foreach($questions as $question_id => $question){
				$options = array();
				if(!empty($question['options'])){
					foreach($question['options'] as $option){
						$row = Option::find($option['id']);

						$row->order	= $option['order'];
						$row->text	= $option['text'];
						$row->is_correct = (isset($option['is_correct']) && $option['is_correct'] == 1)? 1 : 0;
						
						$options[] = $row;
					}
				}

				if(!empty($question['new_options'])){
					foreach($question['new_options'] as $new_option){
						$options[] = new Option($new_option);
					}
				}
				
				$row = Question::find($question_id);
		
				$row->order	 = $question['order'];
				$row->text	 = $question['text'];

				$assignment->questions()->save($row);

				// Insert options.
				if(!empty($options))
					$row->options()->saveMany($options);
			}
    	}
    	
    	// Insert new questions.
    	if($status && $new_questions){
			foreach($new_questions as $question_id => $question){
				$options  = array();
				foreach($question['new_options'] as $new_option){
					$options[] = new Option($new_option);
				}
				
				$question = new Question($question);
				$assignment->questions()->save($question);

				// Insert options.
				if(!empty($options))
					$question->options()->saveMany($options);
			}
    	}

		$messages = $status? 'Data berhasil disimpan.' : 'Data gagal disimpan.';
    	
        return redirect('teacher/assignments/'.$assignment->id.'/edit')->with('status', $status)->with('messages', $messages);
    }
    
    public function destroy(Assignment $assignment){
    	$status	 	 = $assignment->delete();
	    $assignments = new Assignment();
	    $data	 	 = $assignments->orderBy('created_at', 'desc')->get();

		$messages = $status? 'Data berhasil dihapus.' : 'Data gagal dihapus.';
	    
        return redirect()->route('teacher.assignments.index', ['assignments' => $data])->with('status', $status)->with('messages', $messages);
    }
}
