<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;

class AdminRoleController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function($request,$next){
            session(['module_active' => 'role']);
            return $next($request);
        });
    }
    function add(){
        $permissionParent = Permission::where('parent_id',0)->get();
        // return $permissionParent->permissionChild;
        return view('admin.role.add',compact('permissionParent'));
    }
    function store(Request $request){
        $request->validate(
            [
                'name'=>'required',
                'desc'=>'required'
            ],
            [
                'required'=>':attribute không được để trống',

            ],
            [
                'name'=>'Tên quyền',
                'desc'=>'Mô tả quyền'
            ]
        );
        $role = Role::create(
            [
                'name'=>$request->input('name'),
                'desc'=>$request->input('desc')
            ]
        );
        $role->permissions()->attach($request->input('permission_id'));
        return redirect('admin/role/list')->with('status','Thêm quyền thành công');
    }
    function show(){
        $roles = Role::paginate(10);
        return view('admin.role.list',compact('roles'));
    }
    function edit($id){
        $permissionParent = Permission::where('parent_id',0)->get();
        $role = Role::find($id);
        $permissionsChecked = $role->permissions;
        return view('admin.role.edit',compact('permissionParent','role','permissionsChecked'));
    }
    function update(Request $request,$id){
        $request->validate(
            [
                'name'=>'required',
                'desc'=>'required'
            ],
            [
                'required'=>':attribute không được để trống',

            ],
            [
                'name'=>'Tên quyền',
                'desc'=>'Mô tả quyền'
            ]
        );
        Role::where('id',$id)->update(
            [
                'name'=>$request->input('name'),
                'desc'=>$request->input('desc')
            ]
        );
        $role = Role::find($id);
        $role->permissions()->sync($request->input('permission_id'));
        return redirect('admin/role/list')->with('status','Cập nhật thành công');
    }
    function delete($id){
        $role = Role::find($id);
        $role->delete();
        return redirect('admin/role/list')->with('status','Đã xóa thành công');
    }
}
