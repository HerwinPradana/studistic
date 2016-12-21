<?php

namespace Studistic;

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model{

	protected $table	= 'assignment_attempts';
	public $timestamps	= true;

    protected $fillable = ['score', 'created_by'];
    
    public function assignment(){
    	return $this->belongsTo('Studistic\Assignment', 'assignment_id');
    }
    
    public function answers(){
    	return $this->hasMany('Studistic\Answer');
    }
    
    public function correctAnswers(){
    	return $this->hasMany('Studistic\Answer');
    }
}
