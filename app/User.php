<?php

namespace Studistic;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_num', 'name', 'email', 'password', 'is_teacher'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function classes(){
    	return $this->belongsToMany('Studistic\Classes', 'user_classes', 'user_id', 'class_id');
    }
}
