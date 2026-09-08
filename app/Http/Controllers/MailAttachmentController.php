<?php

namespace App\Http\Controllers;

use App\Services\MailAttachmentDownloader;

class MailAttachmentController extends Controller
{
    public function show(string $filename, MailAttachmentDownloader $downloader)
    {
        return $downloader->download($filename);
    }
}
