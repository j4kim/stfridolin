<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function get(Voucher $voucher)
    {
        $voucher->load('article');
        return $voucher;
    }
}
