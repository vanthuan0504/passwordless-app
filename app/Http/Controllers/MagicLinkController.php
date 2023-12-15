<?php

namespace App\Http\Controllers;

use App\Mail\MagicLinkEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MagicLinkController extends Controller
{
    public function sendMagicLink(Request $request)
    {
        // to prevent attackers from generating large numbers of links
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        $this->incrementLoginAttempts($request);

        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors([
                'email' => 'We could not find a user with that email address.'
            ]);
        }
        $token = sha1(time());
        $user->login_token = $token;
        $user->login_token_created_at = now();
        $user->save();
        $magicLink = url('/login/magic/' . $token);
        
        
        Mail::to($user)->send(new MagicLinkEmail($magicLink));
        return redirect()->back()->with('success', 'We have sent you a magic link. Please check your email.');
    }

    public function loginWithMagicLink($token)
    {
        $user = User::where('login_token', $token)
            ->where('login_token_create_at', '>=', now()->subMinutes(5))
            ->first();

        if (!$user) {
            return redirect('/login')->withErrors(['magic_link' => 'The magic link is invalid or has expired.']);
        }

        Auth::login($user);
        $user->login_token = null;
        $user->login_token_created_at = null;
        $user->save();
        return redirect('/home');
    }

}
