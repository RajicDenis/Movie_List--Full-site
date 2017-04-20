<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;

class LoginController extends Controller
{

    public function index() {

        return view('login-page');

    }

    public function login(Request $request) {

		try{

            $rememberMe = false;

            if(isset($request->rememberMe)) {
                $rememberMe = true;
            }

            if(Sentinel::authenticate($request->all(), $rememberMe)) {

                return redirect('news');

            } else {

                return redirect()->back()->with(['error' => 'E-mail or password incorrect']);

            }   

        } catch (ThrottlingException $e) {

            $delay = $e->getDelay();

            return redirect()->back()->with(['error' => "Suspicious activity detected. You have been banned for $delay seconds"]);
    		
        }

    }

    public function logout() {

    	Sentinel::logout();

    	return redirect('/');
    }
        
}
