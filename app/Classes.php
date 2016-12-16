<?php

namespace Studistic;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
	protected $table	= 'classes';
	public $timestamps	= true;

    protected $fillable = ['name', 'subject', 'semester', 'year'];
    
    public function students(){
    	return $this->belongsToMany('Studistic\User', 'user_classes', 'class_id', 'user_id');
	}
    
    public function subjects(){
    	return $this->hasMany('Studistic\Subject', 'class_subjects', 'class_id', 'subject_id');
	}
}
