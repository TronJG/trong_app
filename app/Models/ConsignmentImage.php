<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsignmentImage extends Model
{
    protected $fillable = ['consignment_account_id','path'];

    public function account()
    {
        return $this->belongsTo(ConsignmentAccount::class, 'consignment_account_id');
    }
}
