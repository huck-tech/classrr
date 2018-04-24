<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\User;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function sitemap()
	{
		$classrooms = Classroom::all();
		$users = User::all();
		return response()->view('static.sitemap', compact('classrooms','users'))->header('Content-Type', 'text/xml');
	}
}
