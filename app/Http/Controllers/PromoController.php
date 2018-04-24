<?php

namespace App\Http\Controllers;

use App\Promo;
use App\User;
// use App\Classroom;
use App\Http\Requests\StorePromo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
	public function travel()
    {
        return view('landing.traveldeals');
    }
	
	public function rental()
    {
        return view('landing.rentals');
    }
	
	public function mystery()
    {
        return view('landing.mystery');
    }
	
	public function compass()
    {
        return view('landing.compass');
    }
	
	public function bootcamp()
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
		
		$view_data = [
			'city' => $showloc,
			'country' => $country,
        ];
		
		// geoip ends here
		
        return view('landing.bootcamp', $view_data);
    }
	
	public function referralprogram()
    {
        return view('landing.referralprogram');
    }
	
	public function freelearning()
    {
        return view('landing.learning');
    }
	
	public function teachersbonus()
    {
        return view('landing.teaching');
    }
	
    public function create()
    {
        return view('landing.promo');
    }

    public function contest()
    {
        return view('landing.contest');
    }

    public function store(StorePromo $request)
    {
        // $current_user = Auth::user();

        // $promo->user_email = $current_user->id;

        $user_email = $request->get('user_email');
        // $listing = User::find($user_email);

        $emailcheck = User::where([
            ['email', $user_email]
        ])->first();

        if (!$emailcheck) return redirect()->route('promo')->with('status', 'Your entered email address is not registered.');

    	$promo = new Promo;

    	$promo->fill($request->all());
        $promo->save();

        return redirect()->route('promo')->with('status', 'Thank you for your participation. Please sit back &amp; enjoy while we review your submission.');;
    }

    public function contestStore(StorePromo $request)
    {
        // $current_user = Auth::user();

        // $promo->user_email = $current_user->id;

        $user_email = $request->get('user_email');
        // $listing = User::find($user_email);

        $emailcheck = User::where([
            ['email', $user_email]
        ])->first();

        if (!$emailcheck) return redirect()->route('contest')->with('status', 'Your entered email address is not registered.');

        $promo = new Promo;

        $promo->fill($request->all());
        $promo->save();

        return redirect()->route('contest')->with('status', 'Thank you for your participation. Please stay tune for the winner announcement.');;
    }
}
