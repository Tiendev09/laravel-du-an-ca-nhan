<?php

namespace App\Http\Controllers;

use App\detailOrder;
use App\Order;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;


use Illuminate\Support\Str;

class AdminSellController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function($request,$next){
            session(['module_active' => 'order']);
            return $next($request);
        });
    }
    function delete($id){
        $order = Order::find($id);
        $order->delete();
        return redirect('admin/order/list')->with('status','Đã xóa thành công');
    }
    function show(Request $request){
        // return Str::random(10);
        $orders = Order::orderBy('updated_at','DESC')->paginate(10);
        // return $orders;
        // $cart = Cart::content();
        // return $cart;
        $status = $request->input('status');
        if($status == 'Processing'){
            $orders = Order::where('status','0')->orderBy('updated_at','DESC')->paginate(10);
        }
        else if($status == 'Success'){
            $orders = Order::where('status','1')->orderBy('updated_at','DESC')->paginate(10);
        }
        else if($status == 'Shipped'){
            $orders = Order::where('status','2')->orderBy('updated_at','DESC')->paginate(10);
        }
        else if($status == 'Cancel'){
            $orders = Order::where('status','3')->orderBy('updated_at','DESC')->paginate(10);
        }else{
            $keyword = "" ;
            if($request->input('keyword')){
                $keyword = $request->input('keyword');
            }
            $orders = Order::where('fullname','like',"%{$keyword}%")->orderBy('updated_at','DESC')->paginate(10);
        }
        $pro_count = Order::where('status','0')->count();
        $suc_count = Order::where('status','1')->count();
        $ship_count = Order::where('status','2')->count();
        $can_count = Order::where('status','3')->count();
        $count = [$pro_count,$suc_count,$ship_count,$can_count];
        return view('admin.sell.order',compact('orders','status','count'));
    }
    function detail($id){
        // $detail = Order::find(183)->products;
        // $detail = Order::find($id)->products;
        // return $detail;
        $detail = detailOrder::where('order_id',$id)->get();
        // return $a;
        $detail_order = Order::find($id);
        // $detail = detailOrder::where('order_id',$id)->get();
        // return $detail;
        // return $a;
        return view('admin.sell.detail_order',compact('detail','detail_order'));
    }
    function update(Request $request,$id){
        $value = $request->input('act');
        Order::where('id',$id)->update(
            [
                'status'=>$value,
            ]
        );
        return redirect('admin/order/list')->with('status','Cập nhật thông tin đơn hàng thành công');
    }
}
