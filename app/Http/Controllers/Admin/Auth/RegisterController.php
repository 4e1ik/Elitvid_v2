<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index(){
        if (Auth::check()){
            if (Auth::user()['is_admin'] == true){
                return redirect(route('admin'));
            }
        }
        return view('elitvid.admin.auth.registration');
    }

    public function registration(UserRequest $request){
        if (Auth::check()){
            if (Auth::user()['is_admin'] == true) {
                return redirect(route('admin'));
            }
        }
        if (User::where('email', $request->all()['email'])->exists()){
            return redirect(route('registration'));
        }
        $user = User::create($request->all());
        if ($user){
            if (Auth::user()['is_admin'] == true) {
                Auth::login($user);
                return redirect(route('admin'));
            }
        }
        return redirect(route('login'))->withInput();
    }
}
