<?php

namespace App\Http\Controllers;

use App\Models\Tpemasukan;
use App\Models\Tpesanan;
use App\Models\Tpelanggan;
use App\Models\Tharga;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Controller_Dashboard extends Controller
{
    // 

    

    public function index(): View
    {
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
       
        
       
       
        return view('folder_dashboard.page_dashboard', 
            compact('namauserlogin','akunuserlogin','roleuserlogin'));
    }

    

    
}
