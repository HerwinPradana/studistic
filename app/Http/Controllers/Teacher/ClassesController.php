<?php

namespace Studistic\Http\Controllers\Teacher;

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
	    
        return view('teacher/classes/index', ['classes' => $data]);
    }
    
    public function create(){
    	$class = new Classes();
        return view('teacher/classes/edit', ['class' => $class]);
    }
    
    public function store(Request $request){
    	$user  = $request->user();
    	$class = new Classes();
    	
    	$class->name	 = $request->input('name');
    	$class->subject  = $request->input('subject');
    	$class->semester = $request->input('semester');
    	$class->year 	 = $request->input('year');
    	
		$class->created_by = $user->id;
		$class->teacher_id = $user->id;
 		$class->updated_by = $user->id;

		$status	  = $class->save();
		$messages = $status? 'Data berhasil disimpan.' : 'Data gagal disimpan.';
    	
        return redirect('teacher/classes/'.$class->id.'/edit')->with('status', $status)->with('messages', $messages);
    }
    
    public function show(Classes $class){
        return view('teacher/classes/detail', ['class' => $class]);
    }
    
    public function edit(Classes $class){
        return view('teacher/classes/edit', ['class' => $class]);
    }
    
    public function update(Request $request){
    	$user  = $request->user();
    	$id    = $request->input('id');
    	$class = Classes::find($id);
    	
    	$class->name	 = $request->input('name');
    	$class->subject  = $request->input('subject');
    	$class->semester = $request->input('semester');
    	$class->year 	 = $request->input('year');
    	
		$class->updated_by = $user->id;

		$status	  = $class->save();
		$messages = $status? 'Data saved successfully.' : 'Data failed to save.';
    	
        return redirect('teacher/classes/'.$class->id.'/edit')->with('status', $status)->with('messages', $messages);
    }
    
    public function destroy(Classes $class){
    	$status	 = $class->delete();
	    $classes = new Classes();
	    $data	 = $classes->orderBy('created_at', 'desc')->get();

		$messages = $status? 'Data berhasil dihapus.' : 'Data gagal dihapus.';
	    
        return redirect()->route('teacher.classes.index', ['classes' => $data])->with('status', $status)->with('messages', $messages);
    }
}
