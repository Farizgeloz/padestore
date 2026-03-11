//resources/views/layouts/app.blade.php
<!DOCTYPE html>
<html>
 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Organisasi DPC PKB Kab. Probolinggo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.umd.js"></script>
   <link href="{{ url('css/styleku.css') }}" rel="stylesheet"> 
   <link href="{{ url('css/style_background.css') }}" rel="stylesheet"> 
   <link href="{{ url('css/style_border.css') }}" rel="stylesheet"> 
   <link href="{{ url('css/style_font.css') }}" rel="stylesheet"> 
</head>
 
<body>
  <div class="fixed-top">
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed ">
      <div class="container-fluid bg-success text-light">
        <a class="navbar-brand min_width_40 text-light" href="#" style="">Navbar</a>
        <button class="navbar-toggler  text-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon  text-light" style="color:#ffffff"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0  d-flex justify-content-end text-light mx-3" style="width: 100%;">
            <li class="nav-item back_border_input_green">
              <a class="nav-link active text-light " aria-current="page" href="#">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="#">Link</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Salman Al Farisi
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
              </ul>
            </li>
           
          </ul>
        
        </div>
      </div>
    </nav>
  </div>

  <div class="wrapper">
      <!-- Sidebar -->
      <aside id="sidebar">
          <div class="h-100">
              <div class="sidebar-logo">
                  <a href="#">CodzSword</a>
              </div>
              <!-- Sidebar Navigation -->
              <ul class="sidebar-nav">
                  <li class="sidebar-header">
                      Tools & Components
                  </li>
                  <li class="sidebar-item">
                      <a href="#" class="sidebar-link">
                          <i class="fa-solid fa-list pe-2"></i>
                          Profile
                      </a>
                  </li>
                  <li class="sidebar-item">
                      <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#pages"
                          aria-expanded="false" aria-controls="pages">
                          <i class="fa-regular fa-file-lines pe-2"></i>
                          Pages
                      </a>
                      <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                          <li class="sidebar-item">
                              <a href="#" class="sidebar-link">Analytics</a>
                          </li>
                          <li class="sidebar-item">
                              <a href="#" class="sidebar-link">Ecommerce</a>
                          </li>
                          <li class="sidebar-item">
                              <a href="#" class="sidebar-link">Crypto</a>
                          </li>
                      </ul>
                  </li>
                  <li class="sidebar-item">
                      <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard"
                          aria-expanded="false" aria-controls="dashboard">
                          <i class="fa-solid fa-sliders pe-2"></i>
                          Dashboard
                      </a>
                      <ul id="dashboard" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                          <li class="sidebar-item">
                              <a href="#" class="sidebar-link">Dashboard Analytics</a>
                          </li>
                          <li class="sidebar-item">
                              <a href="#" class="sidebar-link">Dashboard Ecommerce</a>
                          </li>
                      </ul>
                  </li>
                  <li class="sidebar-item">
                      <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#auth"
                          aria-expanded="false" aria-controls="auth">
                          <i class="fa-regular fa-user pe-2"></i>
                          Auth
                      </a>
                      <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                          <li class="sidebar-item">
                              <a href="#" class="sidebar-link">Login</a>
                          </li>
                          <li class="sidebar-item">
                              <a href="#" class="sidebar-link">Register</a>
                          </li>
                      </ul>
                  </li>
                  <li class="sidebar-header">
                      Multi Level Nav
                  </li>
                  <li class="sidebar-item">
                      <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#multi"
                          aria-expanded="false" aria-controls="multi">
                          <i class="fa-solid fa-share-nodes pe-2"></i>
                          Multi Level
                      </a>
                      <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                          <li class="sidebar-item">
                              <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                                  data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                                  Two Links
                              </a>
                              <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                                  <li class="sidebar-item">
                                      <a href="#" class="sidebar-link">Link 1</a>
                                  </li>
                                  <li class="sidebar-item">
                                      <a href="#" class="sidebar-link">Link 2</a>
                                  </li>
                              </ul>
                          </li>
                      </ul>
                  </li>
              </ul>
          </div>
      </aside>
      <!-- Main Component -->
      <div class="main">
          <nav class="navbar navbar-expand px-3 border-bottom">
              <!-- Button for sidebar toggle -->
              <button class="btn" type="button" data-bs-theme="dark">
                  <span class="navbar-toggler-icon"></span>
              </button>
          </nav>
          <main class="content px-3 py-2">
              <div class="container">
                  @yield("content")
              </div>
          </main>
      </div>
  </div>
 
  
 
</body>

<script src="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.umd.js"></script>
<script>
    const {
        ClassicEditor,
        Essentials,
        Paragraph,
        Bold,
        Italic,
        Font
    } = CKEDITOR;
    // Create a free account and get <YOUR_LICENSE_KEY>
    // https://portal.ckeditor.com/checkout?plan=free
    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            licenseKey: '<YOUR_LICENSE_KEY>',
            plugins: [ Essentials, Paragraph, Bold, Italic, Font ],
            toolbar: [
                'undo', 'redo', '|', 'bold', 'italic', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ]
        } )
        .then( editor => {
            window.editor = editor;
        } )
        .catch( error => {
            console.error( error );
        } );
</script>
 
</html>