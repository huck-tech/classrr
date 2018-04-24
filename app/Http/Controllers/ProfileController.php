<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show profile of user based on slug
     *
     * @return Illuminate\Support\Facades\View
     * @author 
     **/
    public function show($slug)
    {
    	$user = null;
    	try{
    		$user = User::with(['classrooms.category', 'skills','profile_avatar'])->where('profile_slug', $slug)->firstOrFail();	
    	} catch(Exception $e) {
    		return abort(404);
    	}
    	return view('profile.show')->with('user', $user);
    }
}
