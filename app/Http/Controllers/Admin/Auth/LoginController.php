<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Helpers\WebResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        try {
            if (Auth::check()){
                if (Auth::user()['is_admin'] == true) {
                    return redirect(route('admin'));
                }
            }
            return WebResponse::success(view('elitvid.admin.auth.login'));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function logout(){
        try {
            Auth::logout();
            return WebResponse::success(redirect(route('login')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function login(Request $request){
        try {
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
                    return WebResponse::success(redirect(route('admin')));
                }
            }

            return WebResponse::success(redirect(route('login'))->withInput());
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }
}
