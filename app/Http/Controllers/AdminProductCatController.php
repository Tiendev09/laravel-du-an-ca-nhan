<?php

namespace App\Http\Controllers;

use App\ProductCat;
use Illuminate\Http\Request;
use App\Components\Recusive;
use App\Product;
use Illuminate\Validation\Rules\Exists;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;

class AdminProductCatController extends Controller
{
    // private $productCat;
    function __construct(ProductCat $productCat)
    {
        $this->productCat = $productCat;
    }
    function show(){
        $data = ProductCat::all();
        // $category = ProductCat::where('id',36)->orWhere('parent_id',36)->get();
        // $product = Product::where('cat_id',36)->get();
        // return $product;
        // return $data;
        $recusive = new Recusive($data);
        $cats = $recusive->showCat();
        $showCatTable = $recusive->showCatTable();
        // return $showCatTable;
        // echo "<pre>";
        // print_r($showCatTable);
        // echo "</pre>";
        return view('admin.product.cat',compact('cats','showCatTable','data'));
    }

    function add(Request $request){
        $request->validate(
            [
                'name'=>'required',
                'slug'=>'required||unique:product_cats',
            ],
            [
                'required'=>':attribute không được để trống',
                'unique'=>':attribute đã tồn tại',
            ],
            [
                'name' =>'Tên danh mục'
            ]
        );
        ProductCat::create(
            [
                'name'=>$request->input('name'),
                'slug'=>$request->input('slug'),
                // 'parent_id'=>$request->input('category'),
            ]
        );
        return redirect('admin/product/cat/list')->with('status','Thêm mới thành công');
    }
    function delete($id){
        //Lấy id của danh mục cần xóa
        $product = ProductCat::find($id);
        $product->delete();
        return redirect('admin/product/cat/list')->with('status','Đã xóa thành công');
    }

}

