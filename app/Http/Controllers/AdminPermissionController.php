<?php

namespace App\Http\Controllers;

use App\Components\Recusive;
use App\Permission;
use Illuminate\Http\Request;

class AdminPermissionController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function($request,$next){
            session(['module_active' => 'permission']);
            return $next($request);
        });
    }
    function list(){
        $data = Permission::all();
        $recusive = new Recusive($data);
        $permissions = $recusive->showCat();
        $showCatTable = $recusive->showCatTable();
        $permissionParent = Permission::where('parent_id',0)->get();
        return view('admin.permission.add',compact('permissions','showCatTable','data','permissionParent'));
    }
    function store(Request $request){
        $request->validate(
            [
                'name'=>'required',

            ],
            [
                'required'=>':attribute không được để trống'
            ],
            [
                'name'=>'Tên quyền'
            ]
        );
        Permission::create(
            [
                'name'=>$request->input('name'),
                'desc'=>$request->input('desc'),
                'parent_id'=>$request->input('category'),
            ]
        );
        return redirect('admin/permission/list')->with('status','Thêm mới thành công');
    }
}
