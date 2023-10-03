<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserServices
{
    public function getAllUsers()
    {

        $users = User::orderBy('id', 'ASC')->where('role', '!=', 2)->paginate(25);
        return $users;
    }
    public function getAllUserDelete()
    {
        $users = User::orderBy('id', 'ASC')->onlyTrashed()->paginate(25);
        return $users;
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            if ($request->role == 'Nhân viên') {
                $role = 1;
            } else {
                $role = 0;
            }
            $users = User::create([
                'name' => $request->name,
                'email_address' => $request->email_address,
                'password' => Hash::make('12345678'),
                'address' => $request->address,
                'phone' => $request->phone,
                'role' => $role,
            ]);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }

        return $users;
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            if ($request->role == 'Nhân viên') {
                $role = 1;
            } else if ($request->role == 'Khách hàng') {
                $role = 0;
            } else {
                $role = 2;
            }
            $users = User::find($id)->update([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'role' => $role,
            ]);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return $users;
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $user = User::find($id)->delete();

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return $user;
    }

    public function forceDelete($id)
    {
        try {
            DB::beginTransaction();

            $user = User::find($id)->forceDelete();

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return $user;
    }

    public function restoreUser($id)
    {
        $user = User::withTrashed()->find($id);
        if (!$user) {
            throw new Exception("User not found");
        }
        $user->restore();
        return $user;
    }
}
