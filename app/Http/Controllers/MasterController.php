<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MasterController extends Controller
{
    public function getMasterClientId()
    {
        return Cache::get('master-client-id');
    }

    public function setMasterClientId(Request $request)
    {
        return Cache::put('master-client-id', $request->clientId);
    }
}
