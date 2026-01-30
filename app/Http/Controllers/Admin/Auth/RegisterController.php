<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Helpers\WebResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function index(){
        try {
            if (Auth::check()){
                if (Auth::user()['is_admin'] == true){
                    return redirect(route('admin'));
                }
            }
            return WebResponse::success(view('elitvid.admin.auth.registration'));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function registration(UserRequest $request){
        try {
            if (Auth::check()){
                if (Auth::user()['is_admin'] == true) {
                    return redirect(route('admin'));
                }
            }
            if (User::where('email', $request->all()['email'])->exists()){
                return redirect(route('registration'));
            }

            return WebResponse::success(DB::transaction(function () use ($request) {
                $user = User::create($request->all());
                if ($user){
                    if (Auth::user()['is_admin'] == true) {
                        Auth::login($user);
                        return redirect(route('admin'));
                    }
                }
                return redirect(route('login'))->withInput();
            }));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }
}
