<?php

namespace Studistic;

use Illuminate\Database\Eloquent\Model;

class Score extends Model{

	protected $table	= 'assignment_scores';
	public $timestamps	= true;

    protected $fillable = ['user_id', 'score'];
    
    public function assignment(){
    	return $this->belongsTo('Studistic\Assignment', 'assignment_id');
    }
}
