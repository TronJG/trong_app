<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureInstalled
{
    public function handle(Request $request, Closure $next)
    {
        // luôn cho phép vào trang setup
        if ($request->is('setup') || $request->is('setup/*')) {
            return $next($request);
        }

        // nếu chưa có cờ installed => đá ra setup
        if (!file_exists(storage_path('app/installed.flag'))) {
            return redirect()->route('setup.show');
        }

        return $next($request);
    }
}
