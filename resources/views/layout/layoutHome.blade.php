<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Toko</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="utf-8">
    <title>Toko - Free Nonprofit Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="toko jual beli bahan pangan area dawarblandong, jatirowo" name="keywords">
    <meta content="toko jual kebutuhan pokok area dawarblandong, jatirowo" name="keywords">
    <meta content="toko jual beli bahan pangan area dawarblandong, jatirowo" name="description">

    <!-- Favicon -->
    <link rel="shortcut icon" href="#">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Saira:wght@500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('assetLandingPage/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href=" {{ asset('assetLandingPage/lib/owlcarousel/assets/owl.carousel.min.css') }} " rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('assetLandingPage/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('assetLandingPage/css/style.css') }}" rel="stylesheet">

    <!-- sweet alert-->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    {{-- <link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css" > --}}
</head>

<body>
    <style>
        html {
            scroll-behavior: smooth;
        }

        .img-fluid {
            width: 730px;
            height: 270px;
        }
    </style>
    
    @yield('home')

    @stack('script')  
    <!-- JavaScript Libraries -->
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assetLandingPage/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assetLandingPage/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assetLandingPage/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assetLandingPage/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assetLandingPage/lib/parallax/parallax.min.js') }}"></script>
    <!--sweet alert-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('assetLandingPage/js/main.js') }}"></script>
    
</body>

</html>
