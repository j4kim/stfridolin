<?php

namespace App\Http\Controllers;

use App\Filament\Resources\Guests\Pages\ViewGuest;
use App\Filament\Resources\Vouchers\Pages\ViewVoucher;
use App\Models\Guest;
use Illuminate\Http\Request;

class QrController extends Controller
{
    public function redirect(Request $request)
    {
        $s = str($request->rawValue);
        $appUrl = config('app.url');
        if (!$s->startsWith('http')) {
            return "Not an url:<br>$s";
        }
        if (!$s->startsWith($appUrl)) {
            return "Not an internal link:<br><a href=\"$s\">$s</a>";
        }
        $path = $s->chopStart($appUrl)->chopStart("/")->chopEnd("/");
        $parts = $path->explode("/");
        if ($parts->count() !== 2) {
            return "Redirect not implemented:<br>$s";
        }
        if ($parts[0] === 'guest') {
            $guest = Guest::where('key', $parts[1])->firstOrFail();
            return redirect(ViewGuest::getUrl([$guest]));
        }
        if ($parts[0] === 'voucher') {
            return redirect(ViewVoucher::getUrl([$parts[1]]));
        }
        return "Redirect not implemented:<br>$s";
    }
}
