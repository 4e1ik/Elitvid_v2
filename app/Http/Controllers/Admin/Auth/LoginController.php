<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        if (Auth::check()){
            if (Auth::user()['is_admin'] == true) {
                return redirect(route('admin'));
            }
        }
        return view('elitvid.admin.auth.login');
    }

    public function logout(){
        Auth::logout();
        return redirect(route('login'));
    }

    public function login(Request $request){
        if (Auth::check()){
            if (Auth::user()['is_admin'] == true) {
                return redirect(route('admin'));
            }
        }

        $arr_data = [
          'email' => $request->all()['email'],
          'password' => $request->all()['password'],
        ];

        if (Auth::attempt($arr_data)){
            if (Auth::user()['is_admin'] == true){
                return redirect(route('admin'));
            }
        }

        return redirect(route('login'))->withInput();
    }
}
