<?php

namespace Studistic;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model{

	protected $table	= 'subjects';
	public $timestamps	= true;

    protected $fillable = ['name'];
    
    public function classes(){
    	return $this->hasMany('Studistic\Classes', 'class_subjects', 'subject_id', 'class_id');
	}
}
