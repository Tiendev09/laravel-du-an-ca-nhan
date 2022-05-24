<?php

namespace App\Http\Controllers;

use App\Order;
use App\Post;
use App\Product;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function($request,$next){
            session(['module_active' => 'dashboard']);
            return $next($request);
        });
    }
    function show(){
        $orders = Order::orderBy('created_at','DESC')->paginate(10);
        $total = 0;
        $subtotal = Order::where('status','1')->get('total');
        foreach($subtotal as $item){
            $total += $item->total;
        }
        $products = Product::where('status','0')->count();
        $users = User::count();
        $posts = Post::where('status','1')->count();
        $success = Order::where('status','1')->count();
        $processing = Order::where('status','0')->count();
        $shipped = Order::where('status','2')->count();
        $cancel = Order::where('status','3')->count();
        $count = [$success,$processing,$shipped,$cancel,$posts,$products,$users];
        return view('admin.dashboard',compact('orders','count','total'));
    }

}
