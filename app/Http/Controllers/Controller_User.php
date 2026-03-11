<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ttingkat;
use App\Models\Tdivisi;
use App\Models\Tposisi;
use App\Models\Twilayah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Controller_User extends Controller
{
    // 
    public function indexuser(): View
    {
        

        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        if($roleuserlogin=="Super Admin"){
            $userku = User::orderBy('id', 'DESC')->Paginate(10);
        }else{
            if($roleuserlogin=="Admin"){
                $userku = User::where('role','!=' ,'Super Admin')
                                ->orderBy('name', 'DESC')->Paginate(10);
            }
            
        }


        
        if($roleuserlogin=="Super Admin"){
        return view('folder_user.page_user', 
                compact('userku','namauserlogin','akunuserlogin','roleuserlogin'));
        }else{
        return view('folder_user.page_user', 
            compact('userku','namauserlogin','akunuserlogin','roleuserlogin')); 
        }
    }

    public function searchuser(Request $request)
    {
        $superku="Super Admin";
        if (!empty($request)) {
            $namauserlogin = Auth::user()->name;
            $akunuserlogin = Auth::user()->akun;  
            $roleuserlogin = Auth::user()->role;
           
            $search = $request->input('search');
            
            if($roleuserlogin=="Super Admin"){
                $userku = User::where('name','like',"%$search%")
                                ->orWhere('email', 'like', "%$search%")
                                ->orderBy('id', 'DESC')
                                ->paginate(10);
            }else if($roleuserlogin=="Admin"){
                $userku = User::where('role',"not like","%$superku%")
                                ->where(function ($query) use ($request) {
                                    $query->where('name', "like", "%" . $request->search . "%");
                                    $query->orWhere('email', "like", "%" . $request->search . "%");
                                })
                                ->orderBy('id', 'DESC')
                                ->paginate(10);
            }else{
                $userku = "";
            }

 
            return view('folder_user.page_user', 
                compact('userku','namauserlogin','akunuserlogin','roleuserlogin'));
        }else{
            $namauserlogin = Auth::user()->name;
            $akunuserlogin = Auth::user()->akun;  
            $roleuserlogin = Auth::user()->role;
            
            if($roleuserlogin=="Super Admin"){
                $userku = User::select('*')->orderBy('id', 'DESC')->Paginate(10);
            }else{
                $userku = User::where('role',"not like","%$superku%")
                            ->orderBy('id', 'DESC')->Paginate(10);
               
                
            }
            
            return view('folder_user.page_user', 
                compact('userku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
 
        
        
    }

    // buat method create
    public function createuser(): View
    {
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
       

        


        return view('folder_user.create', 
                compact('namauserlogin','akunuserlogin','roleuserlogin'));
    }

    

    public function storeuser(Request $request): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "name" => 'required|min:5',
            "akun" => 'required|min:3',
            'email' => 'required|min:5',
            'role' => 'required|min:1',
            'password' => 'required|min:5',
            'wilayah' => 'required|min:1',
            
            //'image_ktp' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            //'image_kk' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            //'image_sk' => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        
        User::create([
            'name' => $request->name,
            'akun' => $request->akun,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'wilayah' => $request->wilayah
        ]);

        $roleuserlogin = Auth::user()->role;
        if($roleuserlogin=="Super Admin"){
            return redirect('/SuperAdmin/User')->with(['success' => 'Data Berhasil Disimpan']);
        }else{
            return redirect('/Admin/User')->with(['success' => 'Data Berhasil Disimpan']);
        }
    }

    // method untuk detail produk
    public function showuser(string $id): View
    {
        // ambil id produk
        $userku = User::findOrFail($id);
        // render view
        return view('folder_user.show', compact('userku'));
    }

    // buat method untuk view data yang mau diubah
    public function edituser(string $id): View
    {
        
        $userku = User::findOrFail($id);
        
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        


        return view('folder_user.edit', 
            compact('userku','namauserlogin','akunuserlogin','roleuserlogin'));
    }
    // method untuk ubah data di database
    public function updateuser(Request $request, $id): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "name" => 'required|min:5',
            'akun' => 'required|min:3',
            'email' => 'required|min:5',
            'password' => 'required|min:6',
            'role' => 'required|min:1',
            'wilayah' => 'required|min:1'
        ]);

         // get data by id produk
        $userku = User::findOrFail($id);
            // ubah data sesuai inputan
        if($request->role=="Super Admin"){
            $userku->update([
                'name' => $request->name,
                'akun' => $request->akun,
                'email' => $request->email,
                'role' => $request->role,
                'password' => $request->password,
                'wilayah' => ""
            ]);
        }
        else if($request->role=="Admin"){
            $userku->update([
                'name' => $request->name,
                'akun' => $request->akun,
                'email' => $request->email,
                'role' => $request->role,
                'password' => $request->password,
                'wilayah' => ""
            ]);
        }
        else{
            $userku->update([
                'name' => $request->name,
                'akun' => $request->akun,
                'email' => $request->email,
                'role' => $request->role,
                'password' => $request->password,
                'wilayah' => $request->wilayah
            ]); 
        }    
        
        $roleuserlogin = Auth::user()->role;
        if($roleuserlogin=="Super Admin"){
            return redirect('/SuperAdmin/User')->with(['success' => 'Data Berhasil Diubah']);
        }else{
            return redirect('/Admin/User')->with(['success' => 'Data Berhasil Diubah']);
        }
       
    }

    // method hapus data
    public function destroyuser($id): RedirectResponse
    {

        // get data by id produk
        $userku = User::findOrFail($id);

        // hapus data produk
        $userku->delete();

        return redirect()->route('folder_user.page_user')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
