<?php

namespace App\Http\Controllers;


use App\Product;
use App\Brand;
use App\ProductCat;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    function action(Request $request,$slug){
        $act = $request->input('act');
        // return $act;
        $product_cats = ProductCat::where('slug',$slug)->first();
        $cats = ProductCat::all();
        $list_brand = Brand::all();
        $product = Product::where('cat_id',$product_cats->id)->orderBy('id','DESC')->limit(4)->get();
        // return $product_cats;
        // return $act;
        $products = Product::where('cat_id',$product_cats->id)->orderBy('id','DESC')->paginate(8);
        if($act == 0){
            $products = Product::where('cat_id',$product_cats->id)->orderBy('name','ASC')->paginate(8);
        }
        if($act == 1){
            $products = Product::where('cat_id',$product_cats->id)->orderBy('name','ASC')->paginate(8);
        }
        if($act == 2){
            $products = Product::where('cat_id',$product_cats->id)->orderBy('name','DESC')->paginate(8);
        }
        if($act == 3){
            $products = Product::where('cat_id',$product_cats->id)->orderBy('price','DESC')->paginate(8);
        }
        if($act == 4){
            $products = Product::where('cat_id',$product_cats->id)->orderBy('price','ASC')->paginate(8);
            // return $products;
        }
        return view('frontend.filter_products',compact('product','products','product_cats','cats','list_brand','act'));
    }
    function action_brand($cat_slug,$slug,Request $request){
        $act = $request->input('act');
        // return $act;
        $product_cats = ProductCat::where('slug',$cat_slug)->first();
        $brands = Brand::where('slug',$slug)->first();
        // return $brands;
        // return $product_cats;
        $cats = ProductCat::all();
        $list_brand = Brand::all();
        $product = Product::where('brand_id',$brands->id)->orderBy('id','DESC')->limit(4)->get();
        // return $product;
        // return $act;
        $products = Product::where('brand_id',$brands->id)->orderBy('id','DESC')->paginate(8);
        if($act == 0){
            $products = Product::where('brand_id',$brands->id)->orderBy('name','ASC')->paginate(8);
        }
        if($act == 1){
            $products = Product::where('brand_id',$brands->id)->orderBy('name','ASC')->paginate(8);
        }
        if($act == 2){
            $products = Product::where('brand_id',$brands->id)->orderBy('name','DESC')->paginate(8);
        }
        if($act == 3){
            $products = Product::where('brand_id',$brands->id)->orderBy('price','DESC')->paginate(8);
        }
        if($act == 4){
            $products = Product::where('brand_id',$brands->id)->orderBy('price','ASC')->paginate(8);
            // return $products;
        }
        return view('frontend.filter_product_brand',compact('product','products','brands','product_cats','cats','list_brand','act'));
    }
    function action_price(Request $request,$slug){
        $product_cats = ProductCat::where('slug',$slug)->first();
        $act = $request->input('r-price');
        $products = Product::paginate(10);
        $brands = Brand::where('slug',$slug)->first();
        $product = Product::where('cat_id',$product_cats->id)->orderBy('id','DESC')->limit(4)->get();
        $cats = ProductCat::all();
        $list_brand = Brand::all();
        if($act == 0){
            $products = Product::where('price','<',5000000)->paginate(10);
        }
        if($act == 1){
            $products = Product::where('price','>=',5000000)->where('price','<=',10000000)->where('cat_id',$product_cats->id)->paginate(10);
        }
        if($act == 2){
            $products = Product::where('price','>',10000000)->where('price','<=',15000000)->where('cat_id',$product_cats->id)->paginate(10);
        }
        if($act == 3){
            $products = Product::where('price','>',15000000)->where('price','<=',20000000)->where('cat_id',$product_cats->id)->paginate(10);
        }
        if($act == 4){
            $products = Product::where('price','>',20000000)->where('cat_id',$product_cats->id)->paginate(10);
        }
        return view('frontend.Filter_by_price',compact('product_cats','products','cats','list_brand','product','act'));
    }
}
