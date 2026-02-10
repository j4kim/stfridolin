<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function get(Voucher $voucher)
    {
        $voucher->load('article');
        return $voucher;
    }

    public function use(Voucher $voucher)
    {
        if ($voucher->guest_id) {
            abort(400, "La carte a déjà été utilisée");
        }
        $voucher->load('article');
        $voucher->guest_id = Guest::fromRequest()->id;
        $voucher->save();
        return $voucher;
    }
}
