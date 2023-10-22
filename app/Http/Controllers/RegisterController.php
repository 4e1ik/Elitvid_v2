<?php

namespace App\Http\Controllers;

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

    public function registration(Request $request){
//        dd($request);
        if (Auth::check()){
            return redirect(route('admin'));
        }
//        dd($request->all()['email']);
        if (User::where('email', $request->all()['email'])){
            return redirect(route('registration'));
        }
        $user = User::create($request->all());
//        dd($user);
        if ($user){
            Auth::login($user);
            return redirect(route('admin'));
        }
        return redirect(route('login'));
    }
}
