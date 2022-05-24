<?php

namespace App\Http\Controllers;

use App\Page;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPageController extends Controller
{
    //
        function __construct()
    {
        $this->middleware(function($request,$next){
            session(['module_active' => 'page']);
            return $next($request);
        });
    }
    function show(Request $request){
        $pages = Page::paginate(10);
        // return $pages;
        $status = $request->input('status');
        if($status == 'trash'){
            $pages = Page::onlyTrashed()->paginate(10);
        }else{
            $keyword = "";
            if($request->input('keyword')){
                $keyword = $request->input('keyword');
            }
            $pages = Page::where('name','like',"%{$keyword}%")->orderBy('created_at','DESC')->paginate(10);
        }
        $active_count = Page::count();
        $trash_count = Page::onlyTrashed()->count();
        $count =[$active_count,$trash_count];
        return view('admin.pages.list',compact('pages','status','count'));
    }
    function add(){

        return view('admin.pages.add');
    }
    function force_delete($id){
        $page = Page::withTrashed()->find($id);
        $page->forceDelete();
        return redirect('admin/page/list')->with('status','Đã xóa thành công');
    }
    function store(Request $request){
        $request->validate(
            [
                'name'=>'required',
                'content'=>'required',
                'slug'=>'required||unique:pages'
            ],
            [
                'required' =>':attribute không được để trống',
                'unique'=>':attribute đã tồn tại'
            ],
            [
                'name'=>'Tiêu đề trang',
                'content'=>'Nội dung trang',
            ]
        );
        Page::create(
            [
                'name'=>$request->input('name'),
                'content'=>$request->input('content'),
                'user_id'=>Auth::id(),
                'slug'=>$request->input('slug'),
            ]
        );
        return redirect('admin/page/list')->with('status','Thêm mới thành công');
    }
    function delete($id){
        $delete = Page::find($id);
        $delete->delete();
        return redirect('admin/page/list')->with('status','Đã xóa thành công');
    }
    function restore($id){
        $restore = Page::where('id',$id);
        $restore->restore();
        return redirect('admin/page/list')->with('status','Khôi phục thành công');
    }
    function edit($id){
        $page = Page::find($id);
        return view('admin.pages.edit',compact('page'));
    }
    function update(Request $request,$id){
        $request->validate(
            [
                'name'=>'required',
                'content'=>'required'
            ],
            [
                'required'=>':attribute không được để trống',
            ],
            [
                'name'=>'Tiêu đề trang',
                'content'=>'Nội dung trang',
            ]
        );
        Page::where('id',$id)->update(
            [
                'name'=>$request->input('name'),
                'content'=>$request->input('content'),
                'user_id'=>Auth::id(),
            ]
        );
        return redirect('admin/page/list')->with('status','Cập nhật thành công');
    }
    function detail($id){
        $detail = Page::find($id);
        return view('admin.pages.detail',compact('detail'));
    }
}
