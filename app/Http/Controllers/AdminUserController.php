<?php

namespace App\Http\Controllers;

use App\Role;
use App\Role_User;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminUserController extends Controller
{

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);
            return $next($request);
        });
    }
    //
    function list(Request $request)
    {
        $list_act = ['select' => 'Chọn', 'delete' => 'Vô hiệu hóa'];

        $status = $request->input('status');
        if ($status == 'trash') {
            $list_act = ['select' => 'Chọn', 'restore' => 'Khôi phục', 'forceDelete' => 'Xóa vĩnh viễn'];
            $users = User::onlyTrashed()->paginate(10);
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $users = User::where('name', 'like', "%{$keyword}%")->paginate(10);
        }
        $count_user_active = User::count();
        $count_user_trash = User::onlyTrashed()->count();
        $count = [$count_user_active, $count_user_trash];
        return view('admin.user.list', compact('users', 'count', 'list_act', 'status'));
    }
    function add()
    {
        $roles = Role::all();
        return view('admin.user.add', compact('roles'));
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],

            ],
            [
                'required' => ':attribute không được để trống',
                'email' => 'Địa chỉ :attribute không hợp lệ',
                'min' => ':attribute tối thiểu :min ký tự',
                'unique' => 'Đã tồn tại email này vui lòng nhập lại',
                'confirmed' => 'Xác thực mật khẩu không thành công',
                'max' => ':attribute tối đa :max ký tự'
            ],
            [
                'name' => 'Họ và tên',
                'password' => 'Mật khẩu',
                'email' => 'Email'
            ]
        );

        //Thêm user vào cơ sở dữ liệu
        try {
            DB::beginTransaction();
            $users = User::create(
                [
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password'))

                ]
            );
            $users->roles()->attach($request->input('role_id'));
            DB::commit();
            return redirect('admin/user/list')->with('status', 'Thêm thành viên thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("message" . $exception->getMessage() . '---Line: ' . $exception->getLine());
        }
        // return $request;
    }
    function edit_info($id){
        $user = User::find($id);
        if(Auth::id()==$id){
            return view('admin.user.edit-info',compact('user'));
        }else{
            return "Bạn không có quyền thay đổi thông tin của người khác";
        }
    }
    function update_info(Request $request,$id){
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],

            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute tối thiểu :min ký tự',
                'unique' => 'Đã tồn tại email này vui lòng nhập lại',
                'confirmed' => 'Xác thực mật khẩu không thành công',
                'max' => ':attribute tối đa :max ký tự'
            ],
            [
                'name' => 'Họ và tên',
                'password' => 'Mật khẩu',
            ]
        );
        if(Auth::id()==$id){
            User::where('id',$id)->update(
                [
                    'name' => $request->input('name'),
                    'password' => Hash::make($request->input('password'))
                ]
            );
            return redirect('admin')->with('status','Cập nhật thành công');
        }else{
            return "Bạn không có quyền";
        }
    }
    function delete($id)
    {
        if (Auth::id() != $id) {
            $user = User::find($id);
            $user->delete();
            return redirect('admin/user/list')->with('status', 'Vô hiệu hóa thành công');
        } else {
            return redirect('admin/user/list')->with('status', 'Bạn không thể xóa chính mình khỏi hệ thống');
        }
    }
    function force_delete($id){
        $user = User::withTrashed()->find($id);
        $user->forceDelete();
        return redirect('admin/user/list')->with('status','Đã xóa thành công');
    }
    function action(Request $request)
    {
        // $list_check = $request->input('list_check');
        $list_check = $request->input('list_check');
        // $status = $request->input('status');
        if ($list_check) {
            foreach ($list_check as $k => $id) {
                if (Auth::id() == $id) {
                    unset($list_check[$k]);
                }
            }
            if (!empty($list_check)) {
                //name của thẻ select
                $act = $request->input('act');
                if ($act == 'select') {
                    return redirect("admin/user/list")->with('danger', 'Vui lòng chọn quyền xử lý');
                }
                if ($act == 'delete') {
                    // $page = Page::whereIn('user_id',$list_check)->get();
                    // return $page;
                    // $page->delete();
                    User::destroy($list_check);
                    return redirect('admin/user/list')->with('status', 'Vô hiệu hóa thành công');
                }
                if ($act == 'restore') {
                    User::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    return redirect('admin/user/list')->with('status', 'Khôi phục thành công');
                }
                if ($act == 'forceDelete') {
                    User::withTrashed()->whereIn('id', $list_check)->forceDelete();
                    return redirect('admin/user/list')->with('status', 'Xóa thành công');
                }
            }
            return redirect('admin/user/list')->with('danger', 'Bạn không thể xóa chính mình');
        }
        return redirect('admin/user/list')->with('danger', 'Bạn cần chọn phần tử thực thi');
    }
    function edit($id)
    {
        $roles = Role::all();
        $user = User::find($id);
        $roleOfUser = $user->roles;
        // dd($roleOfUser);
        return view('admin.user.edit', compact('user', 'roles', 'roleOfUser'));
    }
    function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],

            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute tối thiểu :min ký tự',
                'unique' => 'Đã tồn tại email này vui lòng nhập lại',
                'confirmed' => 'Xác thực mật khẩu không thành công',
                'max' => ':attribute tối đa :max ký tự'
            ],
            [
                'name' => 'Họ và tên',
                'password' => 'Mật khẩu',
            ]
        );
        try {
            DB::beginTransaction();
            User::find($id)->update(
                [
                    'name' => $request->input('name'),
                    // 'email'=>$request->input('email'),
                    'password' => Hash::make($request->input('password'))

                ]
            );
            DB::commit();
            return redirect('admin/user/list')->with('status', 'Cập nhật thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("message" . $exception->getMessage() . '---Line: ' . $exception->getLine());
            return redirect('admin/user/list')->with('danger', 'Đã xảy ra lỗi');
        }
    }
    function restore($id)
    {
        User::where('id', $id)->restore();
        return redirect('admin/user/list')->with('status', 'Khôi phục thành công');
    }
    function permission($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $roleOfUser = $user->roles;
        return view('admin.user.grantPermission', compact('user', 'roles', 'roleOfUser'));
    }
    function updatePermission(Request $request, $id)
    {
        if (Auth::id() != $id) {
            $user = User::find($id);
            $user->roles()->sync($request->input('role_id'));
            return redirect('admin/user/list')->with('status', 'Cấp quyền thành công');
        }else{
            return redirect('admin/user/list')->with('danger','Bạn không thể tự cấp quyền cho mình');
        }
    }
}
