<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleController extends Controller
{
    // public function loginWithGoogle() {
    //     return Socialite::driver('google')->redirect();
    // }

    // public function callbackFromGoogle() {
    //     try {
    //         $user = Socialite::driver('google')->user();
    //         dd($user);
    //     }catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) 
        {
            return redirect('/login');
        }

        if (explode('@', $user->email_address)[1] !== 'company.com')
        {
            return redirect()->to('/');
        }

        $existUser = User::where('email_address', $user->email)->first();

        if ($existUser) {
            auth()->login($existUser, true);
        } else {
            $newUser = new User;
            $newUser->name = $user->name;
            $newUser->email_address = $user->email;
            $newUser->google_id = $user->id;
            $newUser->image = $user->avatar;
            $newUser->save();

            auth()->login($newUser, true);
        }
        return redirect()->to('/home');
    }
}
