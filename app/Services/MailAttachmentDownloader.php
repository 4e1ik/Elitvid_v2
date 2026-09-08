<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MailAttachmentDownloader
{
    /**
     * @param  list<string>  $disks
     */
    public function download(string $filename, array $disks = ['public', 'local']): StreamedResponse
    {
        $filename = basename(rawurldecode($filename));

        if ($filename === '' || $filename === '.' || $filename === '..') {
            abort(404);
        }

        $path = 'files/'.$filename;

        foreach ($disks as $diskName) {
            $disk = Storage::disk($diskName);
            if ($disk->exists($path)) {
                return $disk->download($path, $filename);
            }
        }

        abort(404);
    }
}
