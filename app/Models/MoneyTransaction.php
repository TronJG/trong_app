<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoneyTransaction extends Model
{
    protected $table = 'money_transactions';

    protected $fillable = [
        'trans_date',
        'type',
        'amount',
        'note',
    ];

    protected $casts = [
        'trans_date' => 'date',
        'amount' => 'integer',
    ];
}
