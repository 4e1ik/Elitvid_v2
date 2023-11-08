<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailRequest;
use App\Mail\FeedbackMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{

    public function show_form()
    {
        return view('elitvid.site.form');
    }

    public function send(MailRequest $mailRequest)
    {
//        dd($mailRequest);
//        $route = \Illuminate\Support\Facades\Route::currentRouteName();
        $data = $mailRequest->all();
        Mail::to('Elitvid.site@yandex.ru')->send(new FeedbackMail($data));
        return redirect(route('home'));
    }
}
