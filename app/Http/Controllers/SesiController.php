<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SesiController extends Controller
{
   function index(){
     return view('index');
   }
   function viewlogin(){
    return view('login');
  }

   function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ],
        [
            'email.required' => 'Email Wajib Diisi',
            'password.required' => 'Password Wajib Diisi'
        ]);

        $infologin=[
            'email' =>$request->email,
            'password' =>$request->password,
        ];

        if(Auth::attempt($infologin)){
            if(Auth::user()->role == 'Super Admin'){
                return redirect('/SuperAdmin/Order');
            }else if(Auth::user()->role == 'Admin'){
                return redirect('/Admin/Order');
            }else if(Auth::user()->role == 'User'){
                return redirect('/Order');
            }else{
                return redirect('/Login');
            }
           
        }else{
            return back()->withErrors('User dan Password yang dimasukkan tidak sesuai');
        }

    }

    function logout(){
        Auth::logout();
        return redirect('');
    }

  
}
