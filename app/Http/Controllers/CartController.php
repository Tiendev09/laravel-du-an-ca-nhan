<?php

namespace App\Http\Controllers;

use App\Brand;
use App\detailOrder;
use App\Mail\orderConfirmation;
use App\Mail\mailBuyNow;
use App\Order;
use App\Product;
use App\ProductCat;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
session_start();
// use Gloudemans\ShoppingCart
class CartController extends Controller
{
    //
    function show(){
        $cats = ProductCat::all();
        $list_brand = Brand::all();
        return view('frontend.cart',compact('cats','list_brand'));
    }
    function add(Request $request,$slug){
        // Cart::destroy();
        $product = Product::where('slug','like',$slug)->get();
        // return $product;
        // return $product;
        foreach($product as $item){
            Cart::add(
                [
                    'id' => $item->id,
                    'name' => $item->name,
                    'qty' => $request->input('qty'),
                    'price' => $item->price,
                    'options' => ['thumbnail'=>$item->thumbnail,'slug'=>$item->slug],
                ]
            );
        }
        // return Cart::content();
        return redirect('chi-tiet-gio-hang')->with('status','Thêm vào giỏ hàng thành công');
    }
    function delete($rowId){
        Cart::remove($rowId);
        return redirect('chi-tiet-gio-hang')->with('status','Đã xóa thành công');
    }
    function destroy(){
        Cart::destroy();
        return redirect('chi-tiet-gio-hang')->with('status','Xóa giỏ hàng thành công');
    }
    function update(Request $request){
        $data = $request->get('qty');
        // return $data;
        foreach($data as $k=>$v){
            // return $v;
            Cart::update($k,$v);
        }
        // foreach($data as $v){
        //     Cart::update($v['rowId'],$v->qty);
        // }
        return redirect('cart/show')->with('status','Cập nhật thành công');
    }
    function cart_ajax(Request $request){
        Cart::update($request->rowId,$request->qty);
    }
    function checkout(){
        $content = Cart::content();
        $cats = ProductCat::all();
        $list_brand = Brand::all();
        // return $content;
        return view('frontend.checkout',compact('content','cats','list_brand'));
    }
    function store(Request $request){
            $data['info'] = $request->all();
            $data['infoCart'] = Cart::content();
            $infoCart = Cart::content();
            $email = $request->input('email');
            $request ->validate(
                [
                    'fullname' => ['required', 'string', 'max:255'],
                    'address'=>['required'],
                ],
                [
                    'required' =>':attribute không được để trống',
                    'min'=>':attribute phải bao gồm các chữ số và ít nhất 10 ký tự'
                ],
                [
                    'fullname' =>'Họ và tên ',
                    'address'=>'Địa chỉ',
                ]
                );
                $order = Order::create(
                    [
                        'fullname'=>$request->input('fullname'),
                        'email'=>$request->input('email'),
                        'address'=>$request->input('address'),
                        'phone_number'=>$request->input('phone'),
                        'note'=>$request->input('note'),
                        'pay'=>$request->input('payment_method'),
                        'total'=>Cart::total(),
                        'code'=>Str::random(6),
                    ]
                );
                // return $order;
            // Mail::to($email)->send(new orderConfirmation($data));
            // return $infoCart;
            // return view('frontend.detail_order',compact('data'));
            return redirect('/checkout/last');
    }
    function add_detail_order(Request $request){
        // $data['info'] = $request->all();
        $data['info'] = Order::orderBy('created_at','DESC')->first();
        $id = Order::orderBy('created_at','DESC')->first();
        // return $id->id;
        // return $data;
        // foreach(Cart::content())
       foreach(Cart::content() as $item){
        //    return $item;
        detailOrder::create(
            [
                'order_id'=>$id->id,
                'product_id'=>$item->id,
                'quantity'=>$item->qty,
            ]
        );
       }
        return view('frontend.detail_order',compact('data'));
    }
    function add_cart_ajax($slug){
        $product = Product::where('slug','like',$slug)->get();
        // return $product;
        foreach($product as $item)
        $cart = array();
        if(isset($cart[$slug])){
            Cart::update($item->qty);
        }else{
            Cart::add(
                [
                    'id' => $item->id,
                    'name' => $item->name,
                    'qty' => 1,
                    'price' => $item->price,
                    'options' => ['thumbnail'=>$item->thumbnail,'slug'=>$item->slug],
                ]
            );
        }
        return response()->json(['code'=>200,'message'=>'Success'], 200);
    }
    function buy_now($slug){
        $content = Product::where('slug','like',$slug)->get();
        $cats = ProductCat::all();
        $list_brand = Brand::all();
        return view('frontend.buy_now',compact('content','cats','list_brand'));
    }
    function store_buy_now(Request $request,$slug){
            $data['info'] = $request->all();
            // return Cart::total();
            // $data['infoCart'] = Cart::content();
            // $infoCart = Cart::content();
            $email = $request->input('email');
            $content = Product::where('slug','like',$slug)->get();
            $request ->validate(
                [
                    'fullname' => ['required', 'string', 'max:255'],
                    'address'=>['required'],
                ],
                [
                    'required' =>':attribute không được để trống',
                    'min'=>':attribute phải bao gồm các chữ số và ít nhất 10 ký tự'
                ],
                [
                    'fullname' =>'Họ và tên ',
                    'address'=>'Địa chỉ',
                ]
                );
                foreach($content as $item){
                    Order::create(
                        [
                            'fullname'=>$request->input('fullname'),
                            'email'=>$request->input('email'),
                            'address'=>$request->input('address'),
                            'phone_number'=>$request->input('phone'),
                            'note'=>$request->input('note'),
                            'pay'=>$request->input('payment_method'),
                            'total'=>$item->price,
                            'code'=>Str::random(6),
                        ]
                    );
                }
            Mail::to($email)->send(new mailBuyNow($data,$content));
            // return view('frontend.detail_order',compact('data'));
            return redirect("/buy_now/last/{$item->slug}");
    }
    function add_buy_now_detail_order($slug){
        $id = Order::orderBy('created_at','DESC')->first();
        $data['info'] = Order::orderBy('created_at','DESC')->first();
        $content = Product::where('slug','like',$slug)->get();
        foreach($content as $item){
            //    return $item;
            detailOrder::create(
                [
                    'order_id'=>$id->id,
                    'product_id'=>$item->id,
                    'quantity'=>1,
                ]
            );
        }
        return view('frontend.detail_order_buy_now',compact('data','content'));
    }
}
