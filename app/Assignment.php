<?php

namespace Studistic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model{

	use SoftDeletes;
	
	protected $table	= 'assignments';
	public $timestamps	= true;

	protected $dates	= ['deleted_at'];
    protected $fillable = ['name', 'description'];
    
    public function classes(){
    	return $this->belongsTo('Studistic\Classes', 'class_subject_id');
    }
    
    public function questions(){
    	return $this->hasMany('Studistic\Question', 'assignment_id');
	}
    
    public function attempts(){
    	return $this->hasMany('Studistic\Attempt', 'assignment_id');
	}
    
    public function scores(){
    	return $this->hasMany('Studistic\Score', 'assignment_id');
	}
}
