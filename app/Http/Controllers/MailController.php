<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailRequest;
use App\Mail\FeedbackMail;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MailController extends Controller
{

    public function show_form()
    {
        return view('elitvid.site.form');
    }

//    public function send(MailRequest $mailRequest)
//    {
//        $data = $mailRequest->all();
//        if ($mailRequest->hasFile('file')) {
//            $name = $mailRequest->file('file')->getClientOriginalName();
//            $path = Storage::putFileAs('files', $mailRequest->file('file'), $name); // Даем путь к этому файлу
//            $data['file'] = $path;
//            Mail::to('Elitvid.site@yandex.ru')->send(new FeedbackMail($data));
//            Storage::delete($path);
//        } else {
//            Mail::to('Elitvid.site@yandex.ru')->send(new FeedbackMail($data));
//        }
//    }

    public function send(MailRequest $mailRequest)
    {
        try {
            $data = $mailRequest->all();

            if ($mailRequest->hasFile('file')) {
                $name = $mailRequest->file('file')->getClientOriginalName();
                $path = Storage::putFileAs('files', $mailRequest->file('file'), $name);
                $data['file'] = $path;
                Mail::to('el_vid@mail.ru')->send(new FeedbackMail($data));
                Storage::delete($path);
            } else {
                Mail::to('el_vid@mail.ru')->send(new FeedbackMail($data));
            }

            // Успешный ответ
            return response()->json([
                'success' => true,
                'message' => 'Письмо успешно отправлено!'
            ]);

        } catch (\Exception $e) {
            // Ошибка при отправке
            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при отправке письма: ' . $e->getMessage()
            ], 500); // Код 500 для ошибок сервера
        }
    }
}
