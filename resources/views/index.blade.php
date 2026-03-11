<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PADEPOKANN STORE</title>
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
    <div class="fixed-top">
        <nav class="fixed py-0 navbar navbar-expand-lg bg-body-tertiary " style="padding-y:0px">
            <div class="container-fluid bg-success text-light">
                <a class="navbar-brand min_width_40 text-light" href="#" style="">Padepokan Store</a>
                <button class="navbar-toggler text-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-light" style="color:#ffffff"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="mx-3 mb-2 navbar-nav me-auto mb-lg-0 d-flex justify-content-end text-light show-gadget" style="width: 100%;">
                        <li class="nav-item button_navbar">
                        <a class="nav-link active text-light " aria-current="page" href="#">Beranda</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link text-light" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                           Guest
                        </a>
                        <ul class="dropdown-menu">
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/Login">Masuk</a></li>
                        </ul>
                        </li>

                    </ul>
                    <ul class="mx-3 mb-2 navbar-nav me-auto mb-lg-0 d-flex justify-content-end text-light hidden-gadget" style="width: 100%;">

                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Guest
                        </a>
                        <ul class="dropdown-menu">
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/Login">Masuk</a></li>
                        </ul>
                        </li>

                    </ul>


                </div>
            </div>
        </nav>

    </div>
    <div class="wrapper max-height">
        <div class="p-1 main margin_t3" >
           <div class="row max-height overflowy_auto back_silver" style="height:100%;overflow-y:scroll;">
                <div class="mt-1 mb-5 card bg-body-tertiary">
                
                    <div class="bg-white card-header">
                        <h4><i class="fa fa-database"></i> Daftar Biodata DPC</h4>
                    </div>
                    
                    <div class="card-body">
                    </div>
                        
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
</html>
