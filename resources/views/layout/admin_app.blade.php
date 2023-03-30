<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('css/style_table.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('css/pagination_custom.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('css/modal.css') }}" rel="stylesheet" type="text/css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0-2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
  
    <div class="container">
        <div class="sidebar">
            <ul>
                <li>
                    <a href="#">
                        <i class="fas fa-sharp fa-solid fa-hippo"></i>
                        <div class="title">48 Shop</div>
                    </a>
                </li>
                <li>
                    <a href="{{route('dashboard')}}">
                        <i class="fas fa-wallet"></i>
                        <div class="title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="{{route('view-kategori')}}">
                        <i class="fas fa-bars"></i>
                        <div class="title">Kategori</div>
                    </a>
                </li>
                <li>
                    <a href="{{route('view-product')}}">
                        <i class="fas fa-puzzle-piece"></i>
                        <div class="title">Product</div>
                    </a>
                </li>
                {{-- <li>
                    <a href="#">
                        <i class="fas fa-balance-scale-right"></i>
                        <div class="title">Keuntungan</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-money-bill-alt"></i>
                        <div class="title">Transaction</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-hand-holding-usd"></i>
                        <div class="title">Payments</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-cog"></i>
                        <div class="title">Setting</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-question"></i>
                        <div class="title">Brand name</div>
                    </a>
                </li> --}}
            </ul>
        </div>
        <!-- content --->
        <div class="main">
            <div class="top-bar">
                <div class="search">
                    <input type="text" name="search" placeholder="search here">
                    <label for="search"><i class="fas fa-search"></i></label>
                </div>
                <i class="fas fa-bell"></i>
                <div class="user" id="open-modal">
                    <img src="{{asset('css/img/user2.png')}}" alt="">
                </div>
            </div>
            @yield('dashboard')
            <div style="margin-bottom: 90px;"></div>
            @yield('table_content')
        </div>
        <!-- content --->
        <!--modal start-->
        <div class="modal_cus modal_container" style="z-index:500000" style="width:1000px;height:899px">
            <button class="modal_button" id="">
                open modal
            </button>
        </div>
        
        <div class="modal_container_open" id="modal-container-open">
            <div class="modal_content">
                <div class="modal__close" id="modal_close">
                    <i class="fas fa-window-close"></i>
                </div>
                {{-- <img src="{{asset('css/img/setting2.png')}}" class="modal__img"> --}}
                {{-- <h1 class="modal__title">Good Boy</h1> --}}
                {{-- <p class="modal__description">Click to the button for close</p> --}}
                <button class="modal_button modal__button-width">
                   Logout
                </button>
                {{-- <a href="" style="text-decoration:none;" class="modal_button modal__button-width">Logout</a> --}}
                {{-- <button class="modal__button-link">
                    Close
                </button> --}}
            </div>
        </div>
        <!--modal end-->
    </div>

@stack('scripts')   
<script src="{{ asset('css/js/modal_custom.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
</script>
</body>
</html>