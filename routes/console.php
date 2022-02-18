<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Sweetwater_test;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('fix:dates', function (){

    foreach(Sweetwater_test::where('comments', 'rlike', '[0-9]+/[0-9]+/[0-9]+')->get() as $OrderInfo)
    {
        $comment = $OrderInfo->comments;
        preg_match('#\d{1,2}/\d{1,2}/\d{2,4}+#', $comment, $matches);
        $shipment_date_str = $matches[0];
        $shipment_date = new DateTime($shipment_date_str);
        $shipment_date = $shipment_date->format('Y-m-d');
        $OrderInfo->shipdate_expected = $shipment_date;
        try {
        $OrderInfo->save();
        } catch (\Throwable $e)
        {
            $this->error("An error occurred while trying to fix the dates! Please check orderid: " . $OrderInfo->orderid);
        }
    }
    $this->info("Successfully fixed expected shipping dates");

})->purpose('pull shipping dates from comments and apply the dates to the order info comment field');
