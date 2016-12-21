<?php

namespace Studistic;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model{

	protected $table	= 'assignment_answers';

    protected $fillable = ['question_id', 'option_id'];
    
    public function attempt(){
    	return $this->belongsTo('Studistic\Attempt', 'attempt_id');
    }
    
    public function question(){
    	return $this->belongsTo('Studistic\Option', 'question_id');
	}
    
    public function option(){
    	return $this->belongsTo('Studistic\Option', 'option_id');
	}
}
