<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padepokan Store</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    {{-- CKEditor CDN --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>

    <link rel="stylesheet" href="{{ url('css/fontawesome-free/css/all.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="{{ url('css/styleku.css') }}" rel="stylesheet">
   <link href="{{ url('css/style_background.css') }}" rel="stylesheet">
   <link href="{{ url('css/style_border.css') }}" rel="stylesheet">
   <link href="{{ url('css/style_font.css') }}" rel="stylesheet">
   <style>
        input::placeholder {
        color: red;
        opacity: 0.5;
        }
    </style>
</head>

<body>
    <div class="">
        <nav class="fixed-top fixed py-0 navbar navbar-expand-lg back_blue8 " style="padding-y:0px;background-color:#f94f11">
            <div class="container-fluid text-light">
                <a class="navbar-brand toggle-btn min_width_30 text-light" href="#" style="background-color: #ffffff;;height:60px"><img src="/storage/logo_padepokanstore1.png" style="" class="logo_header"/></a>
                <button class="navbar-toggler text-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
                </button>
                @php
                    $segment1 = request()->segment(1);
                    $segment2 = request()->segment(2);
                    $segment3 = request()->segment(3);

                    $judul = "Dashboard";
                    $judul_link = "Dashboard";

                    if($segment2){
                        $judul .= " / " . ucfirst(str_replace('-', ' ', $segment2));
                    }

                    if($segment3){
                        $judul .= " / " . ucfirst(str_replace('-', ' ', $segment3));
                    }
                @endphp

                <a class="navbar-brand min_width_30 textsize12 text-white" href="#">
                    {{ $judul }}
                </a>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="mx-3 mb-2 navbar-nav me-auto mb-lg-0 d-flex justify-content-end text-light hidden-gadget" style="width: 100%;">

                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                           
                                {{ $roleuserlogin }} {{ $akunuserlogin }}
                            
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#ModalLogout">Logout</a></li>
                        </ul>
                        </li>

                    </ul>
                    
                    <!--GAdget-->
                    <ul class="mx-3 mb-2 navbar-nav me-auto mb-lg-0 d-flex justify-content-end text-light show-gadget" style="width: 100%;">
                        <li class="nav-item">
                            <a class="nav-link text-light " aria-current="page" href="#">Beranda</a>
                        </li>
                        @if ($roleuserlogin == "Super Admin")
                        <li class="nav-item">
                            <a href="/SuperAdmin/User" class="nav-link text-light">
                                <i class="fa fa-user" style="width:15px;"></i>
                                <span>Data Pengguna</span>
                            </a>
                        </li>  
                        <li class="nav-item">
                            <a href="/SuperAdmin/Kotak" class="nav-link text-light">
                                <i class="fas fa-map-marked-alt" style="width:15px;"></i>
                                <span>Data Kotak</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/SuperAdmin/Pelanggan" class="nav-link text-light">
                                <i class="fas fa-map-marked-alt" style="width:15px;"></i>
                                <span>Data Pelanggan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/SuperAdmin/StokBarang" class="nav-link text-light">
                                <i class="fas fa-map-marked-alt" style="width:15px;"></i>
                                <span>Data Stok Barang</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/SuperAdmin/StokProduk" class="nav-link text-light">
                                <i class="fas fa-map-marked-alt" style="width:15px;"></i>
                                <span>Data Stok Produk</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/SuperAdmin/Order" class="nav-link text-light">
                                <i class="fas fa-map-marked-alt" style="width:15px;"></i>
                                <span>Order Pelanggan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/SuperAdmin/DropPesanan" class="nav-link text-light">
                                <i class="fas fa-map-marked-alt" style="width:15px;"></i>
                                <span>Drop Pesanan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/SuperAdmin/Pesanan/Pengiriman" class="nav-link text-light">
                                <i class="fas fa-map-marked-alt" style="width:15px;"></i>
                                <span>Drop Pesanan2</span>
                            </a>
                        </li>
                    
                    @elseif ($roleuserlogin == "Admin" )
                        <li class="nav-item">
                            <a href="/Admin/User" class="nav-link text-light">
                                <i class="fa fa-user" style="width:15px;"></i>
                                <span>Data Pengguna</span>
                            </a>
                        </li>  
                        <li class="nav-item">
                            <a href="/Admin/Kotak" class="nav-link text-light">
                                <i class="fas fa-box" style="width:15px;"></i>
                                <span>Data Kotak</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/Admin/Pelanggan" class="nav-link text-light">
                                <i class="far fa-address-card" style="width:15px;"></i>
                                <span>Data Pelanggan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/Admin/StokBarang" class="nav-link text-light">
                                <i class="fas fa-layer-group" style="width:15px;"></i>
                                <span>Data Stok Barang</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/Admin/Order" class="nav-link text-light">
                                <i class="fas fa-shopping-bag" style="width:15px;"></i>
                                <span>Order Pelanggan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/Admin/DropPesanan" class="nav-link text-light">
                                <i class="fas fa-shopping-bag" style="width:15px;"></i>
                                <span>Drop Pesanan</span>
                            </a>
                        </li>
                    @else
                        <li class="sidebar-item">
                            <a href="/Biodata" class="nav-link text-light">
                                <i class="fas fa-users" style="width:15px;"></i>
                                <span>Data Pengurus</span>
                            </a>
                        </li>
                    @endif
                        
                        <li class="nav-item">
                            <a href="#" class="nav-link text-light">
                                <i class="lni lni-agenda"></i>
                                <span>Task</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                           
                                {{ $roleuserlogin }} {{ $namauserlogin }} 
                           
                           
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"  data-bs-toggle="modal" data-bs-target="#ModalLogout">Logout</a></li>
                        </ul>
                        </li>

                    </ul>
                    


                </div>
            </div>
        </nav>

    </div>
    <div class="wrapper max-height" style="margin-top:5px">
        <aside id="sidebar" class="hidden-gadget top-gadget expand px-2" style="height:100vh">
            {{-- <div class="align-center">
                <button class="toggle-btn" type="button">
                    <img src="/storage/logo_padepokanstore1.png"/>
                </button>
                
            </div> --}}
            <ul class="sidebar-nav  overflow-scroll-y-auto">
                <li class="sidebar-item">
                    <a href="/SuperAdmin/User" class="sidebar-link">
                        <i class="fas fa-home" style="width:15px;"></i>
                        <span>Dashboard</span>
                    </a>
                </li>  
            @if ($roleuserlogin == "Super Admin")
                <p class="font_colgrey2 underline_header" style="margin-left:10px"> Data Pendukung</p>
                <li class="sidebar-item">
                    <a href="/SuperAdmin/User" class="sidebar-link {{ request()->is('SuperAdmin/User') ? 'active' : '' }}">
                        <i class="fa fa-user-plus" style="width:15px;"></i>
                        <span>Data Pengguna</span>
                    </a>
                </li>  
               
                <li class="sidebar-item">
                    <a href="/SuperAdmin/Pelanggan" class="sidebar-link {{ request()->is('SuperAdmin/Pelanggan') ? 'active' : '' }}">
                        <i class="fa fa-user-times" style="width:15px;"></i>
                        <span>Data Pelanggan</span>
                    </a>
                </li>
                <p class="font_colgrey2 underline_header" style="margin-left:10px"> Inventori</p>
                <li class="sidebar-item">
                    <a href="/SuperAdmin/StokBarang" class="sidebar-link {{ request()->is('SuperAdmin/StokBarang') ? 'active' : '' }}">
                        <i class="fa fa-server" style="width:15px;"></i>
                        <span>Data Stok Barang</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/SuperAdmin/Produk" class="sidebar-link {{ request()->is('SuperAdmin/Produk') ? 'active' : '' }}">
                        <i class="fa fa-database" style="width:15px;"></i>
                        <span>Data Produk</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/SuperAdmin/Stok" class="sidebar-link {{ request()->is('SuperAdmin/Stok') ? 'active' : '' }}">
                        <i class="fa fa-database" style="width:15px;"></i>
                        <span>Data Stok</span>
                    </a>
                </li>
                <p class="font_colgrey2 underline_header" style="margin-left:10px"> Proses Pesanan</p>
                
                <li class="sidebar-item">
                    <a href="/SuperAdmin/Order" class="sidebar-link {{ request()->is('SuperAdmin/Order') ? 'active' : '' }}">
                        <i class="fas fa-store" style="width:15px;"></i>
                        <span>Order Pelanggan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/SuperAdmin/DropPesanan" class="sidebar-link {{ request()->is('SuperAdmin/DropPesanan') ? 'active' : '' }}">
                        <i class="fa fa-truck" style="width:15px;"></i>
                        <span>Pesanan Pengiriman</span>
                    </a>
                </li>
               
                <li class="sidebar-item">
                    <a href="/SuperAdmin/Pesanan/Selesai" class="sidebar-link {{ request()->is('SuperAdmin/Pesanan/Selesai') ? 'active' : '' }}">
                        <i class="fas fa-check" style="width:15px;"></i>
                        <span>Pesanan Selesai</span>
                    </a>
                </li>
                <p class="font_colgrey2 underline_header" style="margin-left:10px"> Transaksi</p>
                <li class="sidebar-item">
                    <a href="/SuperAdmin/Pengeluaran" class="sidebar-link  {{ request()->is('SuperAdmin/Pengeluaran') ? 'active' : '' }}">
                        <i class="fas fa-sort-amount-down-alt" style="width:15px;"></i>
                        <span>Pengeluaran</span>
                    </a>
                </li>  
                <li class="sidebar-item">
                    <a href="/SuperAdmin/Pemasukan" class="sidebar-link {{ request()->is('SuperAdmin/Pemasukan') ? 'active' : '' }}">
                        <i class="fas fa-sort-amount-up" style="width:15px;"></i>
                        <span>Pemasukan</span>
                    </a>
                </li>  
                <p class="font_colgrey2 underline_header" style="margin-left:10px"> Laporan</p>
                <li class="sidebar-item">
                    <a href="/SuperAdmin/Rekapitulasi" class="sidebar-link {{ request()->is('SuperAdmin/Rekapitulasi') ? 'active' : '' }}">
                        <i class="fas fa-print" style="width:15px;"></i>
                        <span>Rekapitulasi</span>
                    </a>
                </li>  
            
            @elseif ($roleuserlogin == "Admin" )
                <li class="sidebar-item">
                    <a href="/Admin/User" class="sidebar-link {{ request()->is('Admin/User') ? 'active' : '' }}">
                        <i class="fa fa-user" style="width:15px;"></i>
                        <span>Data Pengguna</span>
                    </a>
                </li>  
                <li class="sidebar-item">
                    <a href="/Admin/Kotak" class="sidebar-link {{ request()->is('Admin/Kotak') ? 'active' : '' }}">
                        <i class="fas fa-box" style="width:15px;"></i>
                        <span>Data Kotak</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/Admin/Pelanggan" class="sidebar-link {{ request()->is('Admin/Pelanggan') ? 'active' : '' }}">
                        <i class="far fa-address-card" style="width:15px;"></i>
                        <span>Data Pelanggan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/Admin/StokBarang" class="sidebar-link {{ request()->is('Admin/StokBarang') ? 'active' : '' }}">
                        <i class="fas fa-layer-group" style="width:15px;"></i>
                        <span>Data Stok Barang</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/Admin/Order" class="sidebar-link {{ request()->is('Admin/Order') ? 'active' : '' }}">
                        <i class="fas fa-shopping-bag" style="width:15px;"></i>
                        <span>Order Pelanggan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/Admin/DropPesanan" class="sidebar-link {{ request()->is('Admin/DropPesanan') ? 'active' : '' }}">
                        <i class="fas fa-shopping-bag" style="width:15px;"></i>
                        <span>Drop Pesanan</span>
                    </a>
                </li>
            @else
                <li class="sidebar-item">
                    <a href="/Driver/Pesanan/Dropsit" class="sidebar-link {{ request()->is('Driver/Pesanan/Dropsit') ? 'active' : '' }}">
                        <i class="fas fa-shopping-bag" style="width:15px;"></i>
                        <span>Pesanan Dropsit</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/PengambilanKotak" class="sidebar-link {{ request()->is('PengambilanKotak') ? 'active' : '' }}">
                        <i class="fas fa-shopping-bag" style="width:15px;"></i>
                        <span>Pengambilan Kotak</span>
                    </a>
                </li>
            @endif
                
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-agenda"></i>
                        <span>Task</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="#" class="sidebar-link" data-bs-toggle="modal" data-bs-target="#ModalLogout">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <div class="p-1 main margin_t3" >
           <div class="row max-height overflowy_auto" style="height:100%;overflow-y:scroll;">
                @yield("content")
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalLogout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-l">
                
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                            <div class="row">
                                <p>Anda Yakin Akan Logout?</p>
                               
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="/logout"><button type="button" class="btn btn-md btn-danger me-3">Logout</button></a>
                    </div>
                </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
<script>
    const hamBurger = document.querySelector(".toggle-btn");

    hamBurger.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("expand");
    });
</script>
<script>
    ClassicEditor.create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    })
</script>



</html>
