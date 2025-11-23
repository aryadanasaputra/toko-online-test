<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class CancelUnpaidOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel-unpaid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel orders that have not been paid within 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $twentyFourHoursAgo = Carbon::now()->subHours(24);

        $unpaidOrders = Order::where('status', 'awaiting_payment')
            ->where('created_at', '<', $twentyFourHoursAgo)
            ->get();

        foreach ($unpaidOrders as $order) {
            $order->update(['status' => 'cancelled']);
            $this->info("Cancelled order #{$order->id}");
        }

        $this->info("Cancelled {$unpaidOrders->count()} unpaid orders.");
    }
}
