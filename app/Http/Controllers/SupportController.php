<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    public static function formatPath(Request $request): string
    {
        return substr($request->path(),0, 7);
    }
}
