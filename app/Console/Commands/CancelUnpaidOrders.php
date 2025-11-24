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
    // Command ini akan dipanggil melalui scheduler Laravel.
    // Format pemanggilan: php artisan orders:cancel-unpaid
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membatalkan pembayaran yang belum dibayar selama 24 jam';
    // Deskripsi singkat tentang apa yang dilakukan oleh command ini.

    /**
     * Execute the console command.
     */

    public function handle()
    {
        // Menghitung waktu 24 jam yang lalu dari waktu saat ini.
        // Pesanan yang lebih lama dari waktu ini akan dianggap kadaluarsa.
        $twentyFourHoursAgo = Carbon::now()->subHours(24);

        // Mengambil semua pesanan yang:
        // - status-nya masih "awaiting_payment" (menunggu pembayaran)
        // - dibuat lebih dari 24 jam yang lalu (melewati batas waktu pembayaran)
        $unpaidOrders = Order::where('status', 'awaiting_payment')
            ->where('created_at', '<', $twentyFourHoursAgo)
            ->get();

        // Melakukan iterasi untuk setiap pesanan yang memenuhi kriteria
        foreach ($unpaidOrders as $order) {
            
            // Mengubah status pesanan menjadi "cancelled" karena sudah melewati batas pembayaran.
            $order->update(['status' => 'cancelled']);

            // Menampilkan informasi di terminal bahwa pesanan dengan ID tertentu dibatalkan.
            $this->info("Cancelled order #{$order->id}");
        }

        // Menampilkan total jumlah pesanan yang berhasil dibatalkan.
        $this->info("Cancelled {$unpaidOrders->count()} unpaid orders.");
    }

}
