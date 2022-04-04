<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   // protected $redirectTo = RouteServiceProvider::HOME;

 protected $redirectTo ;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authencated(Request $request,$user){

         

            if($user->isUser()){
                return redirect(route('home'));
            }

            if($user->isAdmin()){
                return redirect(route('admin_dashborad'));
            }
        

        abort(404);
    }

     protected function redirectTo(){

        if(\Auth::check()){

            if(\Auth::user()->isUser()){
                return $this->redirectTo='/home';
            }

            if(\Auth::user()->isAdmin()){
               return $this->redirectTo='/admin/dashborad';
            }
        }

     }
}
