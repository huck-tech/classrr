<?php

namespace App\Http\Controllers;

use App\Classroom;
use Illuminate\Http\Request;
use App\Country;

class StaticController extends Controller
{
    public function index()
    {
        return view('static.homepage');
    }
	public function diversity()
    {
        return view('static.diversity');
    }
	public function referralterms()
    {
        return view('static.referralterms');
    }
    public function blank()
    {
        return view('static.blank');
    }
    public function about()
    {
        return view('static.about');
    }
    public function partners()
    {
        return view('static.partners');
    }
    public function press()
    {
        return view('static.press');
    }
    public function story()
    {
        return view('static.story');
    }
	/*
    public function team()
    {
        return view('static.team');
    }
	*/
    public function terms()
    {
        return view('static.terms');
    }
	public function privacy()
    {
        return view('static.privacy');
    }
    public function testimonials()
    {
        return view('static.testimonials');
    }
    public function movement()
    {
        return view('static.movement');
    }
    public function get()
    {
        return view('static.get');
    }
    public function tips()
    {
        return view('static.tips');
    }
    public function coverage()
    {
        // United States

        $state = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'District Of Columbia', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Missouri', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'];
        $teacher = array();
        $mag = sizeof ($state);
    
        for ($a = 0; $a < $mag; $a++)
        {
            $teacher[$a] = Classroom::where(['state' => $state[$a], 'country_id' => '230'])->count();
    
        }

        $sho = sizeof ($teacher);

        // The rest of the world
        
        $country = ['10', '12', '13', '14', '16', '18' ,'21', '24', '30', '33', '36', '38', '43', '44', '47', '51', '54', '55', '56', '59', '62', '63', '66', '67', '71', '72', '80', '84', '96', '97', '99', '101', '104', '105', '106', '109', '110', '111', '113', '116', '127', '133', '142', '149', '155', '159', '165', '167', '170', '171', '173', '174', '176', '177', '178', '182', '195', '197', '200', '202', '210', '211', '212', '216', '222', '227', '228', '229', '232', '237'];
        $teacher2 = array();
        $mag2 = sizeof ($country);

        for ($a = 0; $a < $mag2; $a++)
        {
            $teacher2[$a] = Classroom::where(['country_id' => $country[$a]])->count();
            $country[$a] = Country::select('name')->where(['id' => $country[$a]])->value('name');
    
        }

        $sho2 = sizeof ($teacher2);
    
        return view('static.coverage', ['states' => $state, 'teacher' => $teacher, 'sho' => $sho, 'country' => $country, 'teacher2' => $teacher2, 'sho2' => $sho2, 'country' => $country]);
    }

/*
Route::get('/about', 'StaticController@about')->name('about');
Route::get('/contact', 'StaticController@contact')->name('contact');
Route::get('/partners', 'StaticController@partners')->name('partners');
Route::get('/press', 'StaticController@press')->name('press');
Route::get('/story', 'StaticController@story')->name('story');
Route::get('/team', 'StaticController@team')->name('team');
Route::get('/terms', 'StaticController@terms')->name('terms');
Route::get('/testimonials', 'StaticController@testimonials')->name('testimonials');
*/

}
