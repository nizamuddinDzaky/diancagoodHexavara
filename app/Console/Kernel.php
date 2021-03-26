<?php

namespace App\Console;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductVariant;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function (){

            $current_date = date('Y-m-d');
            $orders = Order::with('details.variant.product.images', 'payment', 'address')->where('invalid_at', '<',$current_date)->get();
            foreach ($orders as $keyOrder => $order) {
                foreach ($order->details as $keyDetails => $detail) {
                    $variant = ProductVariant::where('id', $detail->product_variant_id)->first();
                    $variant->stock += $detail->qty;
                    $variant->save();
                }
                
                $order->status = 4;
                $order->save();
            }
        })->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
