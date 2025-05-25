<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>OPC - Online Plagiarism Checker</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com " rel="preconnect">
  <link href="https://fonts.gstatic.com " rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto :ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css ">

  <!-- Mammoth.js for DOCX + PDF.js for PDF -->
  <script src="https://unpkg.com/mammoth @1.4.13/build/mammoth.browser.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js "></script>

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  @livewireStyles
</head>
<body class="index-page">
      <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/logo.png" alt=""> 
        {{-- <h1 class="sitename">Online Plagiarism Checker</h1> --}}
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('home')}}" class="active">Home</a></li>
          <li><a href="{{ route('about.index')}}">About</a></li>
          <li><a href="{{ route('check-plagiarism') }}">Check Plagiarism</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"> </i>
      </nav>

      <a class="btn-getstarted" href="{{ route('check-plagiarism') }}">Get Started</a>

    </div>
  </header>

    <main class="main">
        

        <!-- Main Content -->
        {{ $slot }}

    </main>
<footer id="footer" class="footer bg-dark text-light pt-5">

  <div class="container footer-top">
    <div class="row gy-4">

      <!-- About Section -->
      <div class="col-lg-4 col-md-6 footer-about">
        <a href="{{ route('home') }}" class="d-flex align-items-center mb-2 text-light text-decoration-none">
          <span class="sitename fs-5 fw-bold">OPC - Online Plagiarism Checker</span>
        </a>
        <p class="small">A fast and accurate online tool to detect copied content. Trusted by students, educators, and writers.</p>
      </div>

      <!-- Useful Links -->
      <div class="col-lg-2 col-md-4 footer-links">
        <h5 class="text-uppercase mb-3">Useful Links</h5>
        <ul class="list-unstyled">
          <li><i class="bi bi-chevron-right me-1"></i> <a href="{{ route('home') }}" class="text-light text-decoration-none">Home</a></li>
          <li><i class="bi bi-chevron-right me-1"></i> <a href="{{ route('about.index') }}" class="text-light text-decoration-none">About</a></li>
          <li><i class="bi bi-chevron-right me-1"></i> <a href="{{ route('check-plagiarism') }}" class="text-light text-decoration-none">Check Plagiarism</a></li>
        </ul>
      </div>

    </div>
  </div>

  <!-- Footer Bottom -->
  <div class="container text-center mt-4 pt-4 border-top border-light">
    <p class="mb-1 small">© <strong>IDRIS SAAD - NDA/13799</strong> | All Rights Reserved</p>
    <div class="credits small text-muted">
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Remove only if you have a pro license -->
    </div>
  </div>

</footer>


  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Main JS File -->
<script src="assets/js/main.js"></script>

<!-- YOUR CUSTOM SCRIPT FOR PLAGIARISM CHECKER GOES HERE -->
<!-- Include this only on check-plagiarism page -->
@stack('scripts')

@livewireScripts
</body>
</html>