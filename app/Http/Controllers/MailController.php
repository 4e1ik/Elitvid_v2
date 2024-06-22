<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailCallRequest;
use App\Http\Requests\MailRequest;
use App\Mail\FeedbackMail;
use App\Mail\FeedbackCall;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MailController extends Controller
{

    public function show_form()
    {
        return view('elitvid.site.form');
    }

    public function send(MailRequest $mailRequest)
    {
        $data = $mailRequest->all();
        $data['country'] = mb_substr($data['country'], 3);

        if ($mailRequest->hasFile('file')) {
            $name = $mailRequest->file('file')->getClientOriginalName();
            $path = Storage::putFileAs('files', $mailRequest->file('file'), $name); // Даем путь к этому файлу
            $data['file'] = $path;
            Mail::to('Elitvid.site@yandex.ru')->send(new FeedbackMail($data));
            Storage::delete($path);
        } else {
            Mail::to('Elitvid.site@yandex.ru')->send(new FeedbackMail($data));
        }

//        dd($data);
//        return redirect(route('home'));
    }

    public function order_call(MailCallRequest $mailRequest)
    {
        $data = $mailRequest->all();

        dd($data);

        Mail::to('Elitvid.site@yandex.ru')->send(new FeedbackMail($data));

    }
}
