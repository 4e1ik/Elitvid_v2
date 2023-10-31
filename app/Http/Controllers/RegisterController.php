<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index(){
        if (Auth::check()){
            return redirect(route('admin'));
        }
        return view('includes.elitvid.admin.registration');
    }

    public function registration(UserRequest $request){
//        dd($request);
        if (Auth::check()){
            return redirect(route('admin'));
        }
//        dd($request->all());
//        dd(User::where('email', $request->all()['email'])->exists());
        if (User::where('email', $request->all()['email'])->exists()){
            return redirect(route('registration'));
        }
        $user = User::create($request->all());
//        dd($user);
        if ($user){
            Auth::login($user);
            return redirect(route('admin'));
        }
        return redirect(route('login'))->withInput();
    }
}
