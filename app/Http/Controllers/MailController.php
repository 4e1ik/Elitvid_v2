<?php

namespace App\Http\Controllers;

use App\Helpers\WebResponse;
use App\Http\Requests\MailRequest;
use App\Mail\FeedbackMail;
use App\Models\Mail as ModelMail;
use App\Repositories\Admin\MailRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MailController extends Controller
{
    public function send(MailRequest $mailRequest)
    {
        try {
            $data = $mailRequest->all();
            $mail = 'el_vid@mail.ru';

            if ($mailRequest->hasFile('file')) {
                $name = $mailRequest->file('file')->getClientOriginalName();
                $path = Storage::putFileAs('files', $mailRequest->file('file'), $name);
                $data['file'] = $path;
                Mail::to($mail)->send(new FeedbackMail($data));
            } else {
                Mail::to($mail)->send(new FeedbackMail($data));
            }

            DB::transaction(function () use ($data) {
                ModelMail::create( [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['country'].$data['phone'],
                    'corporation_name' => $data['name_corp'] ?? '',
                    'message' => $data['textarea'] ?? '',
                    'file' => $data['file'] ?? '',
                ]);
            });

            return WebResponse::success(response()->json([
                'success' => true,
                'message' => 'Письмо успешно отправлено!'
            ]));
        } catch (\Exception $e) {
            return WebResponse::error($e, false);
        }
    }
}
