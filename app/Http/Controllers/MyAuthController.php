<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Auth;

class MyAuthController extends Controller{
    public function login(Request $req){
        $user_id = $req->input('user_id');
        $password=$req->input('password');

        $staff=DB::table('stafftbl')->where ('username',$user_id)
                                    ->where('password',$password)
                                    ->first();

        if ($staff){
            session(['username'=>$user_id]);
            return redirect()->route('dashboard');
        }
        return redirect()->route('welcome')->with('error','Invalid Credentials!');
    }
    public function dashboard(){
        $username = session('username');
        if ($username === 'receptionist12plk') {
            return view('customerForm');
    }
        return view('loanofficerdashboard');

    }

    //function for logging out:
    public function logout(Request $request){
       Auth::logout();
       $request->session()->invalidate(); // Invalidate the session
       $request->session()->regenerateToken(); // Regenerate CSRF token
       return redirect()->route('welcome')->with('success','you logged out!'); 
    }
}
?>