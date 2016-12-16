<?php

namespace Studistic;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model{

	protected $table	= 'assignments';
	public $timestamps	= true;

    protected $fillable = ['name', 'description'];
    
    public function classes(){
    	return $this->belongsTo('Studistic\Classes', 'class_id');
    }
    
    public function questions(){
    	return $this->hasMany('Studistic\Question', 'assignment_id');
	}
}
