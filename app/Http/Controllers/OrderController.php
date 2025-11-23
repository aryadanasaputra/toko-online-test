<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller {
    public function addToCart(Request $r, $id){
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $qty = $r->input('qty',1);
        if(isset($cart[$id])) $cart[$id]['quantity'] += $qty;
        else $cart[$id] = ['product_id'=>$id,'name'=>$product->name,'price'=>$product->price,'quantity'=>$qty];
        session(['cart'=>$cart]);
        return back()->with('success','Ditambahkan ke keranjang');
    }

    public function checkout(){ $cart = session()->get('cart',[]); return view('checkout', compact('cart')); }

    public function placeOrder(Request $r){
        $cart = session()->get('cart',[]);
        if(empty($cart)) return redirect()->route('home')->with('error','Keranjang kosong');
        $total = array_sum(array_map(fn($i)=>$i['price']*$i['quantity'],$cart));
        DB::beginTransaction();
        try{
            $order = Order::create(['user_id'=>auth()->id(),'status'=>'awaiting_payment','total'=>$total,'shipping_address'=>$r->input('address')]);
            foreach($cart as $item){
                OrderItem::create(['order_id'=>$order->id,'product_id'=>$item['product_id'],'quantity'=>$item['quantity'],'price'=>$item['price']]);
            }
            DB::commit();
            session()->forget('cart');
            return redirect()->route('orders.show',$order->id)->with('success','Order dibuat. Silakan unggah bukti pembayaran.');
        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error','Gagal membuat order: '.$e->getMessage());
        }
    }

    public function show($id){
        $order = Order::with('items.product','payment')->findOrFail($id);
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        return view('orders.show', compact('order'));
    }

    public function index(){
        $orders = Order::where('user_id', auth()->id())->with('items.product')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function cancel($id){
        $order = Order::findOrFail($id);
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        if (!in_array($order->status, ['pending', 'awaiting_payment'])) {
            return back()->with('error', 'Order cannot be cancelled at this stage.');
        }
        $order->update(['status' => 'cancelled']);
        return back()->with('success', 'Order has been cancelled.');
    }
}
