<?php

namespace App\Http\Controllers;

use App\Components\Recusive;
use App\PostCats;
use Illuminate\Http\Request;

class AdminPostCatsController extends Controller
{
    //
    function add(Request $request){
        $request ->validate(
            [
                'name' => ['required', 'string', 'max:255'],
            ],
            [
                'required' =>':attribute không được để trống'
            ],
            [
                'name' =>'Tên danh mục'
            ]
    );
    PostCats::create(
        [
            'name' => $request->input('name'),
            'parent_id'=>$request->input('category')
        ]
    );
    return redirect('admin/post/cat/list')->with('status','Thêm danh mục thành công');
    }
    function list(){
        $postCats = PostCats::all();
        $recusive = new Recusive($postCats);
        $post_cats = $recusive->showCat();
        $show_post_cats = $recusive->showCatTable();
        // return $show_post_cats;
        return view('admin.post.cat',compact('postCats','post_cats','show_post_cats'));
    }

}
