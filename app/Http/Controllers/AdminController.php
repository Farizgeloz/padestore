<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function index(){
        echo "Halo Selamat datang";
        echo "<h1>". Auth::user()->name ."</h1>";
        echo "<a href='/logout'>logout</a>";
    }
    function ambilsuperadmin(){
        echo "Halo Selamat datang adminku";
        echo "<h1>". Auth::user()->name ."</h1>";
        echo "<a href='/logout'>logout</a>";
    }
    function ambiladmin(){
        echo "Halo Selamat datang adminku";
        echo "<h1>". Auth::user()->name ."</h1>";
        echo "<a href='/logout'>logout</a>";
    }
    function ambiluser(){
        echo "Halo Selamat datang user";
        echo "<h1>". Auth::user()->name ."</h1>";
        echo "<a href='/logout'>logout</a>";
    }
}
