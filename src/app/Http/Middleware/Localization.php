<?php

namespace App\Http\Middleware;

use Closure;
use App;
Use Session;

class Localization
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

        //https://laravel.com/docs/5.8/session

        $availableLangs  = array('en', 'fr');
        $userLangs = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

//        $request->session()->put('locale', 'en');


//        if (\Session::has('locale'))
//        {
//            \App::setlocale(\Session::get('locale') );
//        }
        if ($request->session()->has('locale')  ) {
            $locale = $request->session()->get('locale');
            App::setLocale($locale);
        }
        else if (in_array($userLangs, $availableLangs))
        {
            \App::setLocale($userLangs);
            Session::put('locale', $userLangs);
        }
        else {
            \App::setLocale('en');
            Session::put('locale', 'en');
        }

//        dump( $request );
//        dump(\Session::get('locale')  );
//        dump ( env('SESSION_DOMAIN')  );
//        dump ( $request->session()->all()  );
//        dump ( session('locale')  );

        return $next($request);

    }
}
