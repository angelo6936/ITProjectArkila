<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Feature;
use App\Destination;
class CustomerAuthenticated
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
        if(Auth::check()){

          $mainterminal = (Destination::where('is_main_terminal', true)->select('destination_name')->first() == null ? true : false);

          if(!Auth::user()->isSuperAdmin()){
            if($mainterminal == false){
            $drivermodule = Feature::where('description','Driver Module')->first();
              if(Auth::user()->isSuperAdmin() || $drivermodule->status == 'enable'){
                if(Auth::user()->isDriver()){
                  if(Auth::user()->isEnable()){
                    return redirect(route('drivermodule.index'));
                  }else{
                    Auth::logout();
                    abort(403);
                  }
                }
              }else{
                Auth::logout();
                abort(403);
              }

              $customermodule = Feature::where('description','Customer Module')->first();
              if(Auth::user()->isSuperAdmin() || $customermodule->status == 'enable'){
                if(Auth::user()->isCustomer()){
                  if(Auth::user()->isEnable()){
                    return $next($request);  
                  }else{
                    Auth::logout();
                    abort(403);
                  }
                }
              }else{
                Auth::logout();
                abort(403);
              }
            }else{
              Auth::logout();
              return redirect(route('login'))->withErrors('Your credentials does not match');
            }
          }else if(Auth::user()->isSuperAdmin() && Auth::user()->isEnable()){
            return redirect('home/vanqueue');
          }          
        }

        abort(401);
    }
}
