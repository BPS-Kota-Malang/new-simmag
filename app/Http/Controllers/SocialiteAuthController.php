<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialiteAuthController extends Controller
{
    /**
     * Function For Redirect
     */

     function redirect ($provider)
     {
        return Socialite::driver($provider)->redirect();
     }

     /**
      * Function to handle callback
      */
      function callback($provider)
      {

        try {
            $googleUser = Socialite::driver($provider)->user();
        } catch (Throwable $th) {
            return redirect('/login');
        }

        // $googleUser = Socialite::driver('github')->user();
 
        $user = User::updateOrCreate([
            'google_id' => $googleUser->id,
        ], [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'password' => Hash::make('googleaccount'),
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
        ]);

        $user->assignRole("User");

        Auth::login($user);
    
        return redirect('/dashboard');
        
      }

}
