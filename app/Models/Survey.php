<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'username',
        'chat_id',
        'name',
        'work',
        'phone_number',
        'location',
        'food',
        'drink',
        'line_up',
        'partner_activations',
        'create_events',
        'role',
        'comment',
    ];
}
