<?php

use App\Booking;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use TCG\Voyager\Facades\Voyager;

//
if (App::environment('local', 'development')) {
    Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
}

Route::group(['prefix' => 'control-panel'], function () {
	Voyager::routes(); 
});

//Referral pretty link
Route::get('/{referral_code}', function($referralCode){
	return redirect('/?ref='.$referralCode);
})->where('referral_code', 'BangTutorial|Recruitment');
Route::group([
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => [ 'autoLocalize', 'localeSessionRedirect', 'localizationRedirect' ]
	], function() {
	// Home
	Route::get('/', 'HomeController@index')->name('homepage');

	// Sitemap
	Route::get('/sitemap.xml', 'SitemapController@sitemap');

	// Landing Pages
	Route::get('/invite', 'PromoController@referralprogram')->name('referral_program');
	Route::get('/compass', 'PromoController@compass')->name('compass');
	Route::get('/compass/travel', 'PromoController@travel')->name('travel_deals');
	Route::get('/compass/learning', 'PromoController@freelearning')->name('free_learning');
	Route::get('/compass/teaching', 'PromoController@teachersbonus')->name('teachers_bonus');
	Route::get('/compass/classroom', 'PromoController@rental')->name('rentals');
	Route::get('/compass/bootcamp', 'PromoController@bootcamp')->name('bootcamp');
	//Route::get('/compass/paid-learning', 'PromoController@mystery')->name('mystery');
	/*
	Route::get('/teacher-program', 'PromoController@create')->name('promo');
	Route::post('/entry-submit', 'PromoController@store')->name('promo_store');
	Route::get('/student-contest', 'PromoController@contest')->name('contest');
	Route::post('/student-submit', 'PromoController@contestStore')->name('contest_store');
	*/

	// Auth stuff
	$providers = 'google|linkedin|facebook';
	Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider')->where('provider', $providers)
	    ->name('oauth');
	Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback')->where('provider', $providers);

	Route::get('/logout', 'Auth\LoginController@logout');
	Route::get('/signin', 'StaticController@signin')->name('signin');
	Route::get('/signup', 'StaticController@signup')->name('signup');

	// Static
	Route::get('/blank', 'StaticController@blank')->name('blank');
	Route::get('/about', 'StaticController@about')->name('about');
	//Route::get('/contact', 'StaticController@contact')->name('contact');
	Route::get('/partners', 'StaticController@partners')->name('partners');
	Route::get('/press', 'StaticController@press')->name('press');
	Route::get('/story', 'StaticController@story')->name('story');
	Route::get('/referrals-terms', 'StaticController@referralterms')->name('referral_terms');
	//Route::get('/team', 'StaticController@team')->name('team');
	Route::get('/terms', 'StaticController@terms')->name('terms');
	Route::get('/testimonials', 'StaticController@testimonials')->name('testimonials');
	Route::get('/tips', 'StaticController@tips')->name('tips');
	//Route::get('/faq', 'StaticController@faq')->name('faq');
	Route::get('/privacy', 'StaticController@privacy')->name('privacy');
	Route::get('/global-movement', 'StaticController@movement')->name('movement');
	Route::get('/get-started', 'StaticController@get')->name('get');
	Route::get('/coverage', 'StaticController@coverage')->name('coverage');
	Route::get('/diversity', 'StaticController@diversity')->name('diversity');

});

	// Search
	Route::any('/search', 'SearchController@search')->name('search');
	Route::post('/subscribe', 'SubscriptionController@subscribe')->name('subscribe');

	// Classroom
	Route::post('/classroom', 'ClassroomController@store')->name('classroom_store');
	Route::post('/classroom/review', 'ReviewController@store')->name('classroom_review_store');

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'autoLocalize', 'localeSessionRedirect', 'localizationRedirect' ]], 
	function() {
	Route::get('/classroom/create', 'ClassroomController@create')->name('classroom_create');
	Route::get('/classroom/show/{id}', 'ClassroomController@show')->name('classroom_show');
	Route::get('/classroom/edit/{id}', 'ClassroomController@edit')->name('classroom_edit');
	Route::get('/classroom/list', 'ClassroomController@listAll')->name('classroom_list');
});
	Route::post('/classroom/{id}/contact', 'ClassroomController@contactClassroom')->name('classroom_contact');

	// Booking
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'autoLocalize', 'localeSessionRedirect', 'localizationRedirect' ]], 
	function() {
	Route::get('/booking/calc_total', 'BookingController@calcTotal')->name('booking_calc_total');
	Route::get('/payments/book', 'PaymentController@book')->name('payments_book');
	Route::get('/payments/callback', 'PaymentController@callback')->name('payments_callback');
	Route::get('/payments/capture/{id}', 'PaymentController@capture')->name('payments_capture');
	Route::get('/payments/cancel/{id}', 'PaymentController@cancel')->name('payments_cancel');
	Route::get('/payments/escalate/{id}', 'PaymentController@escalate')->name('payments_escalate');
	Route::post('/payments/void/{id}', 'PaymentController@void')->name('payments_void');
});
	Route::post('/payments/report/{id}', 'PaymentController@report')->name('payments_report');

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'autoLocalize', 'localeSessionRedirect', 'localizationRedirect' ]], 
	function() {
	// User routes
	Route::get('/user/profile', 'UserController@profile')->name('user_profile');
	Route::get('/user/review/{id}', 'UserController@review')->name('user_review');
	Route::get('/user/approve', 'UserController@approve')->name('user_approve');
	Route::get('/user/account', 'UserController@account')->name('user_account');
	Route::get('/user/dashboard', 'UserController@dashboard')->name('user_dashboard');
	Route::get('/user/listing', 'UserController@listing')->name('user_listing');
	Route::get('/user/transactions', 'UserController@transactions')->name('user_transactions');
	Route::get('/user/reviews', 'UserController@reviews')->name('user_reviews');
	Route::get('/user/studyplan', 'UserController@studyplan')->name('user_studyplan');
});
	Route::post('/user/profile', 'UserController@store')->name('user_store');
	Route::post('/user/send_message', 'UserController@sendMessage')->name('user_send_message');
	Route::post('/user/deactivate', 'UserController@deactivate')->name('user_deactivate');

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'autoLocalize', 'localeSessionRedirect', 'localizationRedirect' ]], 
	function() {
	// Verification
	Route::get('/verification/getemail', 'VerificationController@getEmailCode')->name('verification_get_email_code');
	Route::get('/verification/email/{code}', 'VerificationController@verifyEmailCode')->name('verification_verify_email_code');
	Route::get('/verification/getsms', 'VerificationController@getSmsCode')->name('verification_get_sms_code');
	Route::get('/verification/verifycode', 'VerificationController@verifySmsCode')->name('verification_verify_code');
});

	// Files
	Route::post('/files/upload', 'ImageUploadController@store')->name('files_upload');

	/*
	Route::get('/test', 'PaymentController@test');
	Route::get('/test2', 'PaymentController@auth');
	*/

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'autoLocalize', 'localeSessionRedirect', 'localizationRedirect' ]], 
	function() {
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
	Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
});
	
	Route::post('login', 'Auth\LoginController@login');
	Route::post('logout', 'Auth\LoginController@logout')->name('logout');
	Route::post('register', 'Auth\RegisterController@register');	
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'autoLocalize', 'localeSessionRedirect', 'localizationRedirect' ]], 
	function() {	
	Route::get('/user/messages', 'MessagesController@index')->name('user_messages');
	Route::get('/user/messages/{message_id}', 'MessagesController@show')->name('user_message');
	Route::get('/user/messages/{message_id}/archive/{reason}', 'MessagesController@archive')->name('user_message_archive')->where('reason', implode(',', App\Message::$canBeUnarchivedReasons));
	Route::get('/user/messages/{message_id}/unarchive', 'MessagesController@unarchive')->name('user_message_unarchive');
	Route::get('/user/messages/{message_id}/replies', 'MessagesController@repliesIndex')->name('user_message_replies_index');
	Route::get('/user/messages/{message_id}/previous-replies/{reply_id}', 'MessagesController@previousReplies')->name('user_message_previous_replies');
	Route::get('/user/referrals', 'ReferralsController@index')->name('user_referrals');
});
	Route::post('/user/messages/{message_id}/replies', 'MessagesController@repliesStore')->name('user_message_replies_store');
	// Referral
	Route::post('/user/invite-friends', 'ReferralsController@inviteFriends')->name('invite_friends');

	// Travel Goodies
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'autoLocalize', 'localeSessionRedirect', 'localizationRedirect' ]], 
	function() {
	Route::get('/user/hub', 'UserController@hub')->name('user_hub');
});

	// Use in classroom create
	Route::get('/search-skills','SearchSkillController@index')->name('api.search.index');
	Route::post('/search-skills','SearchSkillController@store');

	// Use in user profile
	Route::get('/search-suggestion-skills', 'SearchSuggestionSkillController@index')->name('api.search-suggestion-skills.index');
	Route::post('/search-suggestion-skills', 'SearchSuggestionSkillController@store')->name('api.search-suggestion-skills.store');
	// Use when skill is not found in user profile modal and classroom modal skill
	Route::post('/skill-suggestions', 'SkillSuggestionController@store')->name('api.skill-suggestions.store');

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'autoLocalize', 'localeSessionRedirect', 'localizationRedirect' ]], 
	function() {
	Route::get('profile/{slug}', 'ProfileController@show')->name('show_profile');
});


Route::get('/geoip', function() {
	session()->flush();
	$a = geoip()->getLocation(geoip()->getClientIP());
	dd($a);
});
