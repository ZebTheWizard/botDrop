<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\LoginController;
use App\User;
use Hash;
use Auth;

class AuthController extends Controller
{

    public function checkLogin(Request $r){
      $u = User::firstOrCreate([
        'email' => $r->email,
      ]);
      if ($u->wasRecentlyCreated){
        $u->password = Hash::make($r->password);
        $u->save();
        return view('auth.register')->with('user', $u);
      }else if ($u->disabled == TRUE){
        if (Auth::attempt(['email' => $r->email, 'password' => $r->password])) {
          return view('auth.register')->with('user', $u);
        }
          return back();

      }else{
        if (Auth::attempt(['email' => $r->email, 'password' => $r->password])) {
          Auth::login($u);
          return redirect()->route('dashboard');
        }
          return back();
      }
    }


    public function checkRegister(Request $r){
      $u = User::where('email', $r->email)->first();
      if (Auth::attempt(['email' => $r->email, 'password' => $r->password])) {
        $u->name = $r->name;
        $u->disabled = FALSE;
        $u->save();
        return redirect()->route('dashboard');
      }
        return view('auth.register')->withErrors(['password', 'Password does not match'])->with('user', $u);
    }
}
