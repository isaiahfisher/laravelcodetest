<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sweetwater_test;
use DB;

class IndexController extends Controller
{
    function __invoke()
    {
        $OrderInfo = DB::table('Sweetwater_test')->selectRaw("orderid, comments, shipdate_expected AS date, 
        IF((comments LIKE '%candy%' OR comments LIKE '%smarties%'), 'candy', IF((comments LIKE '%call%' OR comments LIKE '%contact%'), 'contact preferences', 
        IF((comments LIKE '%signature%' OR comments LIKE '%sign%'), 'Delivery Signature', IF(comments LIKE '%referred%', 'referrals', 'Miscellaneous')))) AS classification"
        )->orderBy('classification')->get();

        return view('index')->with('OrderInfo', $OrderInfo);
    }
}
