<?php

namespace App\Http\Controllers;

use App\Components\Recusive;
use App\Post;
use App\PostCats;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPostController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function($request,$next){
            session(['module_active' => 'post']);
            return $next($request);
        });
    }
    function show(Request $request){
        $status = $request->input('status');
        $posts = Post::paginate(10);
        // $a = Post::where('status','=','0')->paginate(10);
        // return $posts;
        $list_act = ['select'=>'Chọn tác vụ','delete'=>'Xóa bài viết'];

        if($status == 'active'){
            $list_act = ['select'=>'Chọn tác vụ','delete'=>'Xóa bài viết'];
        }
        if($status =='trash'){
            $list_act = ['select' => 'Chọn Tác vụ','restore'=>'Khôi phục','forceDelete'=>'Xóa vĩnh viễn'];
            $posts = Post::onlyTrashed()->paginate(10);
        }
        if($status == 'pending'){
            $posts = Post::where('status','=','0')->paginate(10);
        }
        if($status == 'public'){
            $posts = Post::where('status','=','1')->paginate(10);
        }
        $count_pending = Post::where('status','=','0')->count();
        $count_public = Post::where('status','=','1')->count();
        $count_post_active = Post::where('status','=','1')->count();
        $count_post_delete = Post::onlyTrashed()->count();
        $count = [$count_post_active,$count_post_delete,$count_pending,$count_public];
        return view('admin.post.list',compact('posts','list_act','count','status'));
    }
    function action(Request $request){
        $list_check = $request->input('list_check');
        if(!empty($list_check)){
            $act = $request->input('act');
            if($act == 'select'){
                return redirect('admin/post/list')->with('danger','Vui lòng chọn quyền xử lý');
            }
            if($act == 'forceDelete'){
                Post::withTrashed()->whereIn('id',$list_check)->forceDelete();
                return redirect('admin/post/list')->with('status','Đã xóa thành công');
            }
            if($act == 'delete'){
                Post::destroy($list_check);
                return redirect('admin/post/list')->with('status','Đã xóa thành công');
            }
        }else{
            return redirect('admin/post/list');
        }
    }
    function add(Request $request){
        $act = $request->input('act');
        $post_cats = PostCats::all();
        $cats = new Recusive($post_cats);
        $list_post_cats = $cats->showCat();
        return view('admin.post.add',compact('post_cats','list_post_cats'));
    }
    function store(Request $request){
        // $post_cats = PostCats::all();
        $id = Auth::id();
        $request ->validate(
            [
                'title' => ['required', 'string', 'max:255'],
                'content'=>['required'],
            ],
            [
                'required' =>':attribute không được để trống'
            ],
            [
                'title' =>'Tiêu đề ',
                'content'=>'nội dung',
            ]
            );
            Post::create(
                [
                    'title' => $request->input('title'),
                    'content' => $request->input('content'),
                    'cat_id' => $request->input('act'),
                    'user_id' => $id,
                    'status' =>$request->input('exampleRadios'),
                    'thumbnail'=>$request->input('thumbnail')
                ]
            );
            return redirect('admin/post/list')->with('status','Thêm bài viết thành công');
    }
    function delete(Request $request, $id){
        $post = Post::find($id);
        $post->delete();
        return redirect('admin/post/list')->with('status','Xóa bài viết thành công');
    }
    function force_delete($id){
        $post = Post::withTrashed()->find($id);
        $post->forceDelete();
        return redirect('admin/post/list')->with('status','Đã xóa thành công');
    }
    function restore(Request $request,$id){
        $post = Post::where('id',$id);
        $post->restore();
        return redirect('admin/post/list')->with('status','Khôi phục thành công');
    }
    function edit($id){
        $post_cats = PostCats::all();
        $post = Post::find($id);
        $recusive = new Recusive($post_cats);
        $cats = $recusive->showCat();
        return view('admin.post.edit',compact('post_cats','post','cats'));
    }
    function update(Request $request,$id){
        $request ->validate(
            [
                'title' => ['required', 'string', 'max:255'],
                'content'=>['required'],
            ],
            [
                'required' =>':attribute không được để trống'
            ],
            [
                'title' =>'Tiêu đề ',
                'content'=>'nội dung',
            ]
            );
            $thumbnail = $request->input('thumbnail');
            if($thumbnail){
                Post::where('id',$id)->update(
                    [
                        'title' => $request->input('title'),
                        'content'=>$request->input('content'),
                        'cat_id'=>$request->input('act'),
                        'status' =>$request->input('exampleRadios'),
                        'thumbnail'=>$request->input('thumbnail')
                    ]
                );
            }else{
                Post::where('id',$id)->update(
                    [
                        'title' => $request->input('title'),
                        'content'=>$request->input('content'),
                        'cat_id'=>$request->input('act'),
                        'status' =>$request->input('exampleRadios'),
                    ]
                );
            }
            return redirect('admin/post/list')->with('status','Cập nhật thành công');
    }
}
