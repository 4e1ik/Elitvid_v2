<?php

namespace App\Repositories\Admin;

use App\Models\Mail;

class MailRepository
{
    /**
     * Список всех писем (последние сверху).
     */
    public function getAll()
    {
        return Mail::all();
    }
}
