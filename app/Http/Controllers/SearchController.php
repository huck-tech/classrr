<?php

namespace App\Http\Controllers;

use App\Category;
use App\Classroom;
use App\ClassroomLevel;
use App\SkillDistribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
		$showloc = "";
		$gloc = @file_get_contents('http://freegeoip.net/json/'.$_SERVER['REMOTE_ADDR']);
		if($gloc === false){
			$showloc = "";
		}else{
		$estloc = json_decode($gloc);
		$country = $estloc->country_name;
		$region = $estloc->region_name;
		$city = $estloc->city;
		if(!empty($city)){
			$showloc = $city;
		}elseif(!empty($region)){
			$showloc = $region;
		}elseif(!empty($country)){
			$showloc = $country;
		}else{
			$showloc = "";
		}
		}

        $view_data = [
            'query' => $query,
            'where' => $request->get('where'),
            'when' => $request->get('when'),
            'duration' => $request->get('duration'),
            'items' => Classroom::search($query)->paginate(10),
            'categories' => Category::all(),
            'levels' => ClassroomLevel::all(),
			'city' => $showloc,
            'weekdays' => [
                'mon' => 'Monday',
                'tue' => 'Tuesday',
                'wed' => 'Wednesday',
                'thu' => 'Thursday',
                'fri' => 'Friday',
                'sat' => 'Saturday',
                'sun' => 'Sunday'],
            'class_time' => ['Morning', 'Afternoon', 'Evening'],
            'price_from' => 4,
            'price_to' => 60,

        ];

        return view('search.search', $view_data);
    }
    
}
