<?php

namespace Studistic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model{

	use SoftDeletes;

	protected $table	= 'classes';
	public $timestamps	= true;

	protected $dates	= ['deleted_at'];
    protected $fillable = ['name', 'subject', 'semester', 'year'];
    
    public function students(){
    	return $this->belongsToMany('Studistic\User', 'user_classes', 'class_id', 'user_id');
	}
    
    public function subjects(){
    	return $this->hasMany('Studistic\Subject', 'class_subjects', 'class_id', 'subject_id');
	}
    
    public function assignments(){
    	return $this->hasMany('Studistic\Assignment', 'class_subject_id');
	}
}
