<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FrontendServices
{
    public function login($email_address, $password, $remember)
    {
        $credentials = ['email_address' => $email_address, 'password' => $password];

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            return $user;
        } else {
            return false;
        }
    }

    public function logout()
    {
        Auth::logout();
    }

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email_address' => $request->email_address,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 0,
        ]);

        return $user;
    }
    public function updateProfile(Request $request, $id)
    {
        if ($request->image != null) {
            $image = $request->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();

                if (strcasecmp($extension, 'jpg') || strcasecmp($extension, 'png') || strcasecmp($extension, 'jepg')) {
                    $image = Str::random(5) . "_" . $filename;
                    while (file_exists("image/user/" . $image)) {
                        $image = Str::random(5) . "_" . $filename;
                    }
                    $file->move('image/user', $image);
                }
            }
        }else{
            $profile = User::find($id);
            $image = $profile->image;
        }
        try {
            DB::beginTransaction();
            $profile = User::find($id)->update([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'image' => $image,
            ]);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return $profile;
    }
    public function changePassword($currentPassword, $newPassword)
    {
        $user = Auth::user();
        $currentPasswordHash = $user->password;
        if (!Hash::check($currentPassword, $currentPasswordHash)) {

            return false;
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        return true;
    }
}
