<?php

namespace Studistic\Http\Middleware;

use Closure;

class CheckTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	$user = $request->user();
    	if($user){
			if($user->is_teacher == 1 && !$request->is('teacher/*') && !$request->is('logout')){
    			return redirect('teacher/home');
			}
    	 	if($user->is_teacher == 0 && $request->is('teacher/*')){
    			return redirect('home');
			}
    	}
        return $next($request);
    }
}
