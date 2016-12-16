<?php

namespace Studistic;

use Illuminate\Database\Eloquent\Model;

class Option extends Model{

	protected $table	= 'assignment_options';
	public $timestamps	= true;

    protected $fillable = ['order', 'text', 'is_correct'];
    
    public function question(){
    	return $this->belongsTo('Studistic\Question', 'question_id');
    }
}
