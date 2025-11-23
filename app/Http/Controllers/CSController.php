<?php

namespace App\Http\Controllers;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CSController extends Controller {
    // CS layer1
    public function listPaymentsForVerification(){
        $payments = Payment::where('status','uploaded')->with('order.user')->get();
        $hasPendingPayments = $payments->count() > 0;
        return view('cs1.index', compact('payments', 'hasPendingPayments'));
    }

    public function verifyPayment(Request $r, $id){
        $payment = Payment::findOrFail($id);
        DB::transaction(function() use($payment){
            $payment->update(['status'=>'verified','verified_by'=>auth()->id()]);
            $order = $payment->order;
            foreach($order->items as $item){
                $product = $item->product;
                $product->decrement('stock', $item->quantity);
            }
            $order->update(['status'=>'confirmed']);
        });
        return back()->with('success','Pembayaran diverifikasi.');
    }

    public function rejectPayment(Request $r,$id){
        $payment = Payment::findOrFail($id);
        $payment->update(['status'=>'rejected','note'=>$r->input('note')]);
        $payment->order->update(['status'=>'cancelled']);
        return back()->with('success','Pembayaran ditolak dan order dibatalkan.');
    }

    // CS Layer 2
    public function listForShipment(){
        $orders = Order::where('status','confirmed')->with('items')->get();
        $hasPendingShipments = $orders->count() > 0;
        return view('cs2.index', compact('orders', 'hasPendingShipments'));
    }

    public function markShipped(Request $r, $id){
        $order = Order::findOrFail($id);
        $order->update(['status'=>'shipped']);
        return back()->with('success','Order dimark shipped.');
    }
}
