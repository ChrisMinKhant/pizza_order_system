<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //direct regsiter page
    public function registerPage()
    {
        return view('register');
    }

    //direct login page
    public function loginPage()
    {
        return view('login');
    }

    //checking user role
    public function checkCondition()
    {
        if (Auth::user()->role != 'admin') {
            return redirect()->route('user#homepage');
        }

        return redirect()->route('category#listPage');
    }
}
