<?php

namespace App\Http\Controllers;

use App\Slide;
use Illuminate\Http\Request;

class AdminSlideController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function($request,$next){
            session(['module_active' => 'slide']);
            return $next($request);
        });
    }
    function force_delete($id){
        $slide = Slide::withTrashed()->find($id);
        $slide->forceDelete();
        return redirect('admin/slide/list')->with('status','Đã xóa thành công');
    }
    function show(Request $request){
        $slides = Slide::orderBy('created_at','DESC')->paginate(10);
        $status = $request->input('status');
        $list_act = ['select'=>'Chọn tác vụ','delete'=>'Xóa'];
        if($status == 'active'){
            $slides = Slide::orderBy('created_at','DESC')->paginate(10);
            $list_act = ['select'=>'Chọn tác vụ','delete'=>'Xóa'];
        }
        if($status == 'trash'){
            $slides = Slide::orderBy('created_at','DESC')->onlyTrashed()->paginate(10);
            $list_act = ['select'=>'Chọn tác vụ','restore'=>'Khôi phục','forceDelete'=>'Xóa vĩnh viễn'];
        }
        $count_active = Slide::count();
        $count_trash = Slide::onlyTrashed()->count();
        $count = [$count_active,$count_trash];
        return view('admin.slide.list',compact('slides','count','slides','status','list_act'));
    }
    function add(){
        return view('admin.slide.add');
    }
    function edit($id){
        $slides = Slide::find($id);
        // return $slides;
        return view('admin.slide.edit',compact('slides'));
    }
    function store(Request $request){
        $request->validate(
            [
                'thumbnail'=>'required'
            ],
            [
                'required'=>':attribute không được rỗng'
            ],
            [
                'thumbnail'=>'Ảnh slide'
            ]
        );
        Slide::create(
            [
                'thumbnail'=>$request->input('thumbnail'),
            ]
        );
        return redirect('admin/slide/list')->with('status','Thêm mới thành công');
    }
    function update(Request $request,$id){
        $request->validate(
            [
                'thumbnail'=>'required',
            ],
            [
                'required'=>':attribute không được để trống'
            ],
            [
                'thumbnail'=>'Ảnh slide'
            ]
        );
        Slide::where('id',$id)->update(
            [
                'thumbnail'=>$request->input('thumbnail'),
            ]
        );
        return redirect('admin/slide/list')->with('status','Cập nhật thành công');
    }
    function delete($id){
        Slide::find($id)->delete();
        return redirect('admin/slide/list')->with('status','Đã xóa thành công');
    }
    function restore($id){
        Slide::where('id',$id)->restore();
        return redirect('admin/slide/list')->with('status','Khôi phục thành công');
    }
    function action(Request $request){
        $list_check = $request->input('list_check');
        $act = $request->input('act');
        if(!empty($list_check)){
            if($act == 'select'){
                return redirect()->back()->with('danger','Vui lòng chọn tác vụ');
            }
            if($act == 'delete'){
                Slide::destroy($list_check);
                return redirect('admin/slide/list')->with('status','Đã xóa thành công');
            }
            if($act == 'restore'){
                Slide::withTrashed()->whereIn('id',$list_check)->restore();
                return redirect('admin/slide/list')->with('status','Khôi phục thành công');
            }
            if($act == 'forceDelete'){
                Slide::withTrashed()->whereIn('id',$list_check)->forceDelete();
                return redirect('admin/slide/list')->with('status','Đã xóa thành công');
            }
        }else{
            return redirect()->back()->with('danger','Vui lòng chọn phần tử thực thi');
        }
    }
}
