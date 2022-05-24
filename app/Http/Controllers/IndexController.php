<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Feature_image;
use App\Page;
use App\Post;
use App\Product;
use App\ProductCat;
use App\Slide;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    //
    function show(){
        $slides = Slide::orderBy('id','DESC')->limit(3)->get();
        $product_cats = ProductCat::all();
        $pages = Page::orderBy('id','DESC')->get();
        // return $pages;
        $new_products = Product::latest()->where('cat_id',1)->limit(8)->get();
        // $id = ProductCat::all('id','name','parent_id');
        $mobilePhones = Product::latest()->where('cat_id',1)->limit(8)->get();
        $phones = Product::where('cat_id',1)->get();
        $laptops = Product::where('cat_id',2)->orderBy('id','DESC')->limit(8)->get();
        // ->limit(8)->get()
        // $data = Product::latest()->where('cat_id',36)->orWhere('cat_id',38)->orWhere('cat_id',50)->orWhere('cat_id',51)->orWhere('cat_id',55)->limit(8)->get();
        // return $data;
        $total_laptops = Product::where('cat_id',2)->get();
        // return $total_laptops->count();
        $brands = Brand::all();
        return view('frontend.home',compact('product_cats','slides','new_products','mobilePhones','phones','laptops','total_laptops','brands','pages'));
    }
    // function show_menu(){
    //     $product_cats = ProductCat::all();
    //     return $product_cats;
    //     return view('layouts.home', compact('product_cats'));
    // }
    // function page($slug){
    //     $page = Page::where('slug',$slug)->first();
    //     $pages = Page::orderBy('id','DESC')->get();
    //     $products = Product::orderBy('id','DESC')->limit(8)->get();
    //     $posts = Post::where('status','=','1')->paginate(7);
    //     // return $page;
    //     return view('frontend.about',compact('page','pages','products','posts'));
    // }
    function about(){
        $about = Page::where('id',5)->first();
        // return $about;
        $products = Product::orderBy('id','DESC')->limit(8)->get();
        // return $about;
        return view('frontend.about',compact('about','products'));
    }
    function contact(){
        $contact = Page::where('id',3)->get();
        $products = Product::orderBy('id','DESC')->limit(8)->get();
        // return $about;
        return view('frontend.contact',compact('contact','products'));
    }
    function blog(){
        $posts = Post::where('status','=','1')->paginate(7);
        $products = Product::orderBy('id','DESC')->limit(8)->get();
        // return $posts;
        return view('frontend.blog',compact('posts','products'));
    }
    function detail($id){
        $detail = Post::find($id);
        $products = Product::orderBy('id','DESC')->limit(8)->get();
        // $product = Product::orderBy('id','DESC')->limit(4)->get();
        return view('frontend.detail_blog',compact('detail','products'));
    }
    // function product($slug,$id){
    //     $products_count = Product::where('cat_id',$id)->count();
    //     $total_laptops = Product::where('cat_id',2)->get();
    //     // $product = Product::orderBy('id','DESC')->limit(4)->get();
    //     $list_brand = Brand::all();
    //     $product = Product::where('cat_id',$id)->orderBy('id','DESC')->limit(4)->get();
    //     $cats = ProductCat::all();
    //     $product_cats = ProductCat::where('slug',$slug)->first();
    //     // $products = Product::where('cat_id',$id)->paginate(8);
    //     $products = Product::where('cat_id',$id)->orderBy('id','Desc')->paginate(8);
    //     return view('frontend.products',compact('products','products_count','product','product_cats','cats','list_brand'));
    //     // return $products;
    //     // $products_count = Product::where('cat_id',$id)->count();
    //     // $total_laptops = Product::where('cat_id',2)->get();
    //     // // $product = Product::orderBy('id','DESC')->limit(4)->get();
    //     // $list_brand = Brand::all();
    //     // $product = Product::orderBy('id','DESC')->limit(8)->get();
    //     // // return $products;
    //     // $product = Product::where('cat_id',$id)->orderBy('id','DESC')->limit(4)->get();

    // }
    function product($slug){
        $cats = ProductCat::all();
        $product_cats = ProductCat::where('slug','like',$slug)->first();
        // return $product_cats;
        $list_brand = Brand::all();
        // return $product_cats;
        // $cat_id = ProductCat::where('slug','like',$slug)->get();
        // return $cat_id;
        $products = Product::where('cat_id',$product_cats->id)->orderBy('id','DESC')->paginate(8);
        $product = Product::where('cat_id',$product_cats->id)->orderBy('id','DESC')->limit(4)->get();
        // $products_count = Product::where('cat_id',$v->id)->count();
        // return $products;
        // $cat = ProductCat::find($id);
        // $total_laptops = Product::where('cat_id',2)->get();
        // $product = Product::where('cat_id',1)->orderBy('id','DESC')->limit(4)->get();
        // return $products;
        return view('frontend.products',compact('product_cats','cats','list_brand','product','products'));
    }
    function brand($cat_slug,$slug){
        $cats = ProductCat::all();
        $product_cats = ProductCat::where('slug','like',$cat_slug)->first();
        // return $product_cats;
        // return $product_cats->brand;
        // return $cats->brand;
        $brand = Brand::where('slug',$slug)->first();
        // return $brand;
        // $cat = ProductCat::find($id);
        // return $cat;
        // $pro_brand = Brand::where('id',$id)->get();
        $list_brand = Brand::all();
        // return $brands;
        // $products = Product::where('brand_id',$id)->paginate(8);
        // return $products;
        // $count = Product::where('brand_id',$id)->count();
        return view('frontend.product_brand',compact('cats','list_brand','product_cats','brand'));
    }
    function detail_product(Request $request,$slug){
        $detail_product = Product::where('slug','like',$slug)->first();
        // return $detail_product->img;
        // $product_cats = ProductCat::where('slug','like',$slug)->first();
        // return $detail_product;
        // return $item->cat_id;

        $cats = ProductCat::all();
        $list_brand = Brand::all();
        // $img = Feature_image::where('product_id','=',$id)->get();
        // foreach($detail_product as $item)
        // $category = ProductCat::where('id',$item->cat_id)->get();
        // return $category;
        $same_category = Product::where('cat_id','=',$detail_product->cat_id)->orderBy('created_at','DESC')->limit(8)->get();
        // return $same_category;
        return view('frontend.detail_product',compact('detail_product','cats','same_category','list_brand'));
    }
    function search(Request $request){
        // $products = Product::where('cat_id',$product_cats->id)->orderBy('id','DESC')->paginate(8);
        $cats = ProductCat::all();
        $list_brand = Brand::all();
        // $product_cats = ProductCat::where('slug','like',$slug)->first();
        $keyword = "";
        if($request->input('keyword')){
            $keyword = $request->input('keyword');
        }
        $total = Product::all();
        $products = Product::where('name','like',"%{$keyword}%")
        ->orWhere('slug','like',"%{$keyword}%")
        ->paginate(9);
        // return $products;
        return view('frontend.search',compact('products','keyword','cats','list_brand','total','keyword'));
    }

}
