<?php

namespace Studistic;

use Illuminate\Database\Eloquent\Model;

class Question extends Model{

	protected $table	= 'assignment_questions';
	public $timestamps	= true;

    protected $fillable = ['order', 'text', 'multiplier'];
    
    public function assignment(){
    	return $this->belongsTo('Studistic\Assignment', 'assignment_id');
    }
    
    public function options(){
    	return $this->hasMany('Studistic\Option', 'question_id');
	}
}
