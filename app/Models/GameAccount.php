<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameAccount extends Model
{
    protected $table = 'game_accounts';

    protected $fillable = [
        'account',
        'password',
        'note',
        'change_due_date',
        'is_changed',
        'changed_at',
    ];

    protected $casts = [
        'change_due_date' => 'date',
        'is_changed' => 'boolean',
        'changed_at' => 'datetime',
    ];
}
