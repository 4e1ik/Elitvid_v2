<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\WebResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\MailRequest;
use App\Mail\FeedbackMail;
use App\Models\Mail as ModelMail;
use App\Repositories\Admin\MailRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MailController extends Controller
{

    public function __construct(
        public MailRepository $mailRepository,
    ){}

    public function index()
    {
        $mails = $this->mailRepository->getAll();
        return view('elitvid.admin.mails.index', compact('mails'));
    }
}
