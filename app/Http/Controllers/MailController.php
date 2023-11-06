<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailRequest;
use App\Mail\FeedbackMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send(MailRequest $mailRequest)
    {
//        dd($mailRequest);
        $data = $mailRequest->all();
        $name = $data['name'];
        $email = $data['email'];
        $name_corp = $data['name_corp'];
        $phone = $data['phone'];
        $file = $data['file'];
        $textarea = $data['textarea'];
//        dd($data);
        Mail::to('Elitvid.site@yandex.ru')->send(new FeedbackMail($name, $email, $name_corp, $phone, $file, $textarea));
//        redirect(route(''));
    }
}
