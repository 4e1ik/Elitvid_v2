<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    protected $table = 'mails';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'corporation_name',
        'message',
        'file'
    ];
}
