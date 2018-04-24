<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		//experimental geoip may need to expect errors on homepage
		
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
		
		// geoip ends here
		
		
		//classes showcase with owl carousel! thanks to Kristian
		
		$featured = ['3122','2526','1991','2932','2722','2404','992','26'];
		$freebies = Classroom::where([
            ['base_price', 0]
        ])->inRandomOrder()->take(8)->get(); 
		
		$nearby = [];
		$nearby = Classroom::where([
            ['city', $showloc]
        ])->inRandomOrder()->take(8)->get();
		
		//ends here
		
        if(Auth::check()) {
            $current_user = Auth::user();
            $user         = User::where('id', $current_user->id)->with('skills')->first();
            $user_skills  = $user->getRelation('skills')->toArray();      
            $formated_skills = [];        
      
            if(count($user_skills) > 0) {
                foreach($user_skills as $skill) {
                    $origin_point = $skill['pivot']['amount_point'];
                    $max_level     = $skill['max_level'];
                    $is_max       = $origin_point >= $max_level? true: false;

                    $formated_skills[] = [
                        'id'           => $skill['id'], 
                        'name'         => $skill['name'],
                        'origin_point' => $origin_point,
                        'gain_point'   => 0,
                        'is_max'       => $is_max,
                        'max_level'    => $max_level,
                    ];
                }
            }    

            $data_default = [
                'remaining_point'     => $current_user->skill_points, 
                'search_url'          => route('api.search-suggestion-skills.index'),
                'suggestion_save_url' => route('api.search-suggestion-skills.store'),
                'formated_skills'      => $formated_skills,  
                'skill_suggestion_url' => route('api.skill-suggestions.store'),         
            ];
        }

        $view_data = [
			'freebies' => $freebies,
			'featured' => Classroom::find($featured),
			'city' => $showloc,
			'country' => $country,
			'nearby' => $nearby,
			'newest' => Classroom::all()->take(8),
            'total' => Classroom::count(),
            'data_default' => isset($data_default)? $data_default: [], 
        ];
        
        return view('homepage', $view_data);
    }

    public function tester()
    {
        $result = Carbon::now()->toDateTimeString();
        var_dump($result);
        //return view('home');
    }
}
