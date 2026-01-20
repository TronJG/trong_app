<?php

namespace App\Modules\Accounts\Controllers;

use App\Http\Controllers\Controller;

class AccountAppController extends Controller
{
    public function index()
    {
        return view('modules.accounts.index');
    }
}
