<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrController extends Controller
{
    public function redirect(Request $request)
    {
        return $request->rawValue;
    }
}
