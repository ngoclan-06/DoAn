<?php

namespace App\Http\Controllers;

use App\Services\UserServices;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userServices;
    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }
    public function index()
    {
        $users = $this->userServices->getAllUsers();
        return view('backend.users.index', compact('users'));
    }
    public function create()
    {
        return view('backend.users.create');
    }
    public function store(CreateUserRequest $request)
    {
        try {
            $result = $this->userServices->store($request);
            if ($result) {
                return redirect()->route('users')->with('success', 'Thêm mới người dùng thành công.');
            } else {
                return back()->with('error', 'Thêm mới người dùng không thành công.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('backend.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $result = $this->userServices->update($request, $id);
            if ($result) {
                return redirect()->route('users')->with('success', 'Sửa thông tin tài khoản người dùng thành công.');
            } else {
                return back()->with('error', 'Sửa thông tin tài khoản người dùng không thành công.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->userServices->delete($id);
            if ($result) {
                return redirect()->route('users')->with('success', 'Xóa tài khoản người dùng thành công.');
            } else {
                return redirect()->back()->with('error', 'Xóa thông tin tài khoản người dùng không thành công.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function forceDelete($id)
    {
        try {
            $result = $this->userServices->delete($id);
            if ($result) {
                return redirect()->route('users')->with('success', 'Xóa tài khoản người dùng thành công.');
            } else {
                return redirect()->back()->with('error', 'Xóa thông tin tài khoản người dùng không thành công.');
            }
        } catch (Exception $exception) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function getAllUserDelete()
    {
        $users = $this->userServices->getAllUserDelete();
        return view('backend.users.index', compact('users'));
    }
    public function restore($id)
    {
        $result = $this->userServices->restoreUser($id);

        if($result){
            return redirect()->route('users')->with('success', 'Khôi phục tài khoản người dùng thành công.');
        } else {
            return redirect()->back()->with('error', 'Khôi phục thông tin tài khoản người dùng không thành công.');
        }
    }
}
