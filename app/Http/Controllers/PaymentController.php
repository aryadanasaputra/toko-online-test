<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller {
    public function upload(Request $r, $orderId){
        $order = Order::findOrFail($orderId);
        if($order->user_id !== auth()->id()) abort(403);
        $r->validate(['file'=>'required|image|max:2048']);
        $path = $r->file('file')->store('payments','public');
        $payment = Payment::create(['order_id'=>$order->id,'file_path'=>$path,'status'=>'uploaded']);
        $order->update(['status'=>'awaiting_verification']);
        return back()->with('success','Bukti pembayaran berhasil diunggah.');
    }
}
