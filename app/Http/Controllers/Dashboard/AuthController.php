<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('dashboard.login');
    }

    public function login(Request $request)
    {
        $userData = $request->validate([
            'email'     => 'required|email|exists:admins',
            'password'  => 'required|min:8',
        ]);

        if(auth('admin')->attempt($userData ,$request->boolean('remember'))){
            $request->session()->regenerate();
            return to_route('dashboard.home')->with(['success'=>'تم تسجيل الدخول بنجاح !']);
        }
        return back()->withErrors(['error'=>'البريد أإلكتروني أو كلمة المرور غير صحيحة !']);
    }
    public function logout(Request $request)
    {
        auth('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('dashboard.showLoginForm');
    }
}
