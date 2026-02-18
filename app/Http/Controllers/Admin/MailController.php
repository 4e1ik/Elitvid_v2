<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\MailRepository;

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
