<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function customLogin(Request $request) {
        $request->valudate([
            'email' => 'required'
        ]);

        $credentials = $request->only('email');

    }

    public function registration() {
        return view('auth.register');
    }

    public function customRegistration(Request $request) {
        $request -> validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'code' => 'required|min:6'
        ]);
        $data = $request->all();
        $check = $this->create($data);
        return redirect("dashboard")->withSuccess('You have signed-in');
    }

    public function create(array $data) {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email']
        ]);
    }

    public function dashboard() {
        if (Auth::check()) {
            return view('auth.dashboard');
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function signOut() {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
}
