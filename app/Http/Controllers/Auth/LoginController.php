<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('/admin/home');
        }else{
            return view('auth/login');
        }
    }

    public function actionlogin(Request $request)
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Auth::Attempt($data)) {
            if (Auth::user()->role == 1) {    
                // misal di suatu saat, ada yang tanya ini buat apa?
                // jawab : ini untuk pengecekan role user, jika role nya adalah 1 maka akan ke halaman admin
                // begitupun sebalik e, jika role bernilai 0 maka akan ke halaman depan
                return redirect('/admin/home');
            }

            if (Auth::user()->role == 0) {
                return redirect('/');
            }
        }else{
            Session::flash('error', 'Email atau Password Salah');
            return redirect()->back();
        }
    }

    public function actionlogout()
    {
        $role = Auth::user()->role == 0 ? 0 : 1;
        Auth::logout();
        return ($role == 0) ? redirect('/') : redirect('/admin/login');
    }
}
