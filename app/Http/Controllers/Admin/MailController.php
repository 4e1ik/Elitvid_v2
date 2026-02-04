<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\WebResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\MailRequest;
use App\Models\Mail as ModelMail;
use App\Mail\FeedbackMail;
use App\Repositories\Admin\MailRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MailController extends Controller
{
    public function index(MailRepository $mailRepository)
    {
        $mails = $mailRepository->getAll();
        return view('elitvid.admin.mails.index', compact('mails'));
    }

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
            $mail = 'Artemi324@tut.by';

            if ($mailRequest->hasFile('file')) {
                $name = $mailRequest->file('file')->getClientOriginalName();
                $path = Storage::putFileAs('files', $mailRequest->file('file'), $name);
                $data['file'] = $path;
                Mail::to($mail)->send(new FeedbackMail($data));
            } else {
                Mail::to($mail)->send(new FeedbackMail($data));
            }

            ModelMail::create( [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'corporation_name' => $data['name_corp'] ?? '',
                'message' => $data['textarea'] ?? '',
                'file' => $data['file'] ?? '',
            ]);

            return WebResponse::success(response()->json([
                'success' => true,
                'message' => 'Письмо успешно отправлено!'
            ]));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }
}
