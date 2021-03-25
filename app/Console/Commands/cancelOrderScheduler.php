<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class cancelOrderScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel_order:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $current_date = date('Y-m-d H:i:s');
        return Order::where('invalid_at', '<', $current_date)->update(['status' => 4]);
    }
}
