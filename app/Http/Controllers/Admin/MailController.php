<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\WebResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\MailRequest;
use App\Mail\FeedbackMail;
use App\Models\Image;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MailController extends Controller
{

    public function show_form()
    {
        try {
            return WebResponse::success(view('elitvid.site.form'));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

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

            return WebResponse::success(response()->json([
                'success' => true,
                'message' => 'Письмо успешно отправлено!'
            ]));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }
}
