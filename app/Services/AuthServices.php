<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class AuthServices
{
    // function login
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

    // function phân quyền
    public function isAdmin($user)
    {

        return in_array($user->role, [1,2]);
    }

    // function login
    public function logout()
    {
        Auth::logout();
    }

    // function change password
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

    //
    /**
     * Send password reset email_address to the given user.
     *
     * @param  string  $email_address
     * @return void
     */
    public function sendResetLinkEmail($email_address)
    {
        $user = User::where('email_address', $email_address)->first();

        if (!$user) {
            return false;
        }

        $token = Str::random(10);
        DB::table('password_resets')->insert([
            'email_address' => $email_address,
            'token' => $token,
            'created_at' => now()
        ]);

        Mail::send('auth.email', ['token' => $token], function ($message) use ($user) {
            $message->to($user->email_address);
            $message->subject('Reset your password');
        });

        return true;
    }
    /**
     * Reset the given user's password.
     *
     * @param  string  $email_address
     * @param  string  $password
     * @param  string  $token
     * @return bool
     */
    public function resetPassword($email_address, $password, $token)
    {
        $reset = DB::table('password_resets')
            ->where('email_address', $email_address)
            ->where('token', $token)
            ->first();

        if (!$reset) {
            return false;
        }

        $user = User::where('email_address', $email_address)->first();

        if (!$user) {
            return false;
        }

        $user->password = Hash::make($password);
        $user->save();

        DB::table('password_resets')
            ->where('email_address', $email_address)
            ->delete();

        return true;
    }
}
