<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use App\ProductCat;
use Illuminate\Http\Request;
use App\Components\Recusive;
use App\Feature_image;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }
    function show(Request $request)
    {
        $list_act = ['select' => 'Chọn tác vụ', 'delete' => 'Xóa'];
        // $category = ProductCat::where('parent_id','id')->get();
        // return $category;
        $status = $request->input('status');
        if ($status == 'out_of_stock') {
            //nhớ phải có phân trang kèm theo
            $products = Product::where('status', 1)->orderBy('created_at', 'DESC')->paginate(10);
        } else if ($status == 'trash') {
            $list_act = ['select' => 'Chọn tác vụ', 'restore' => 'Khôi phục', 'forceDelete' => 'Xóa'];
            $products = Product::onlyTrashed()->orderBy('deleted_at', 'DESC')->paginate(10);
        } else if ($status == 'stocking') {
            $products = Product::where('status', 0)->orderBy('created_at', 'DESC')->paginate(10);
        } else if ($status == 'comming_soon') {
            $products = Product::where('status', 2)->orderBy('created_at', 'DESC')->paginate(10);
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            //Muốn tìm kiếm ta để duy nhất 1 câu truy vấn kèm theo where
            $products = Product::where('name', 'like', "%{$keyword}%")->orderBy('created_at', 'DESC')->paginate(10);
        }
        $count_product_active = Product::count();
        $count_product_trash = Product::onlyTrashed()->count();
        $stocking_count = Product::where('status', 0)->count();
        $out_of_stock_count = Product::where('status', 1)->count();
        $comming_soon_count = Product::where('status', 2)->count();
        $count = [$count_product_active, $count_product_trash, $stocking_count, $out_of_stock_count, $comming_soon_count];
        return view('admin.product.list', compact('products', 'list_act', 'count', 'status'));
    }
    function add()
    {
        $data = ProductCat::all();
        $recusive = new Recusive($data);
        $cats = $recusive->showCat();
        $brands = Brand::all();
        // return $brands;
        return view('admin.product.add', compact('cats', 'data', 'brands'));
    }
    function restore($id)
    {
        $restore = Product::where('id', $id);
        $restore->restore();
        return redirect('admin/product/list')->with('status', 'Khôi phục thành công');
    }
    function force_delete($id){
        $product = Product::withTrashed()->find($id);
        $product->forceDelete();
        return redirect('admin/product/list')->with('status','Đã xóa thành công');
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'price' => 'integer',
                'slug'=>['required','unique:products']

            ],
            [
                'required' => ':attribute không được để trống',
                'integer' => ':attribute phải là số nguyên',
                'unique' => ':attribute đã tồn tại'
            ],
            [
                'name' => 'Tên sản phẩm',
                'price' => 'Giá',


            ]
        );
        if ($request->input('cats') == 0 || $request->input('brands') == 0) {
            return back()->with('danger', 'Vui lòng chọn danh mục và thương hiệu');
        } else {
            $product = Product::create(
                [
                    'name' => $request->input('name'),
                    'thumbnail' => $request->input('thumbnail'),
                    'price' => $request->input('price'),
                    'intro' => $request->input('intro'),
                    'content' => $request->input('content'),
                    'cat_id' => $request->input('cats'),
                    'status' => $request->input('exampleRadios'),
                    'brand_id' => $request->input('brands'),
                    'slug' => $request->input('slug'),
                ]
            );
            // return $product->id;
            $img = $request->input('feature_img');
            // return $img;
            foreach($img as $item){
                Feature_image::create(
                    [
                        'product_id'=>$product->id,
                        'img_url'=>$item,

                    ]
                );
            }
            return redirect('admin/product/list')->with('status', 'Thêm sản phẩm thành công');
        }
    }

function edit(Request $request, $id)
{
    $products = Product::find($id);
    // $data = ProductCat::all();
    $brands = Brand::all();
    $cate = ProductCat::all();
    return view('admin.product.edit', compact('products', 'brands', 'cate'));
}
function update(Request $request, $id)
{
    $request->validate(
        [
            'name' => 'required',
            'price' => 'integer',
            // 'thumbnail'=>'required',

        ],
        [
            'required' => ':attribute không được để trống',
            'integer' => ':attribute phải là số nguyên',
        ],
        [
            'name' => 'Tên sản phẩm',
            'price' => 'Giá',


        ]
    );
    $thumbnail = $request->input('thumbnail');

    if($thumbnail){
        // $thumb = Product::find($id)->thumbnail;
        Product::where('id', $id)->update(
            [
                'name' => $request->input('name'),
                'thumbnail' => $request->input('thumbnail'),
                'price' => $request->input('price'),
                'intro' => $request->input('intro'),
                'content' => $request->input('content'),
                'cat_id' => $request->input('cats'),
                'status' => $request->input('exampleRadios'),
                'slug' => $request->input('slug'),
                'brand_id' => $request->input('brands'),
            ]
        );
    }else{
        Product::where('id', $id)->update(
            [
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'intro' => $request->input('intro'),
                'content' => $request->input('content'),
                'cat_id' => $request->input('cats'),
                'status' => $request->input('exampleRadios'),
                'slug' => $request->input('slug'),
                'brand_id' => $request->input('brands'),
            ]
        );
    }
    $img = $request->input('feature_img');
    if($img == ['']){
        return redirect('admin/product/list')->with('status', 'Cập nhật thành công');
    }else{

        $product = Product::find($id);
        Feature_image::where('product_id',$id)->delete();
        foreach($img as $item){
            Feature_image::create(
                [
                    'img_url'=>$item,
                    'product_id'=>$product->id,
                ]
            );
        }
    }
    return redirect('admin/product/list')->with('status', 'Cập nhật thành công');
}
function delete($id)
{
    $delete = Product::find($id);
    $delete->delete();
    return redirect('admin/product/list')->with('status', 'Đã xóa thành công');
}
function action(Request $request)
{
    $act = $request->input('act');
    $list_check = $request->input('list_check');
    if (!empty($list_check)) {
        if ($act == 'select') {
            return redirect('admin/product/list')->with('danger', 'Vui lòng chọn tác vụ xử lý');
        }
        if ($act == 'delete') {
            Product::destroy($list_check);
            return redirect('admin/product/list')->with('status', 'Đã xóa thành công');
        }
        if ($act == 'restore') {
            Product::withTrashed()->whereIn('id', $list_check)->restore();
            return redirect('admin/product/list')->with('status', 'Khôi phục thành công');
        }
        if ($act == 'forceDelete') {
            Product::withTrashed()->whereIn('id', $list_check)->forceDelete();
            return redirect('admin/product/list')->with('status', 'Đã xóa thành công');
        }
    }
    return redirect('admin/product/list')->with('danger', 'Bạn cần chọn phần tử thực thi');
}
function show_brand()
{
    $data = ProductCat::all();
    $recusive = new Recusive($data);
    $cats = $recusive->showCat();
    $brands = Brand::orderBy('Created_at','DESC')->paginate(10)->groupBy('cat_id');
    $links = Brand::paginate(10);
    // foreach($brands as $k){
    //     foreach($k as $v){
    //         return $v->id;
    //     }
    // }
    return view('admin.product.brand', compact('brands','cats','links'));
}
function add_brand(Request $request)
{

    $request->validate(
        [
            'name' => 'required',
            'slug'=>'required||unique:brands'
        ],
        [
            'required' => ':attribute không được để trống',
            'unique'=>':attribute đã tồn tại'
        ],
        [
            'name' => 'Tên thương hiệu',
        ]
    );
    if($request->input('category') == 0){
        return back()->with('danger','Vui lòng chọn danh mục');
    }else{
        Brand::create(
            [
                'name' => $request->input('name'),
                'cat_id'=>$request->input('category'),
                'slug'=>$request->input('slug'),
            ]
        );
        return redirect('admin/product/brand/list')->with('status', 'Thêm mới thành công');
    }

}
}
