<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Localization
{
    /**    
     * @var array
     **/
    protected $locales = [];

    public function __construct(Repository $config)
    {
        $this->locales = collect($config->get('laravellocalization.supportedLocales'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!session()->has('locale')) {
            $iso_code = geoip()->getLocation(geoip()->getClientIP())->iso_code;
            $lang = "en";

            $this->locales->each(function ($item, $key) use($iso_code, &$lang) {
                if (isset($item['iso_code']) && strtolower($iso_code) === strtolower($item['iso_code'])) {
                    $lang = $key;
                    return false;        
                }
            });

            $getLocale = explode('-', $lang)[0];        

            if(LaravelLocalization::getCurrentLocale() !== $getLocale) {
                session(['locale' => $getLocale]);
                LaravelLocalization::setLocale($getLocale);
            }
        }

        return $next($request);
    }
}
