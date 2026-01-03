<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Cache;

class MasterController extends Controller
{
    public function setMasterClientId(Request $request)
    {
        Cache::put('master-client-id', $request->clientId);
        Broadcast::on('master')
            ->as('MasterClientChanged')
            ->with($request->all())
            ->send();
    }
}
