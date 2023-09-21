<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style_table.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/pagination_custom.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/modal.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style_modal_global.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0-2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous"></script>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <style>
        .danger-div {
            width: 80%;
            color: white;
            background: red;
            border-radius: 5px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            /*-- center vertical --*/
            height: 30px;
            line-height: 30px;
        }

        .blue-div {
            font-weight: bold;
            color: white;
            background: rgb(29, 17, 202);
            border-radius: 5px;
        }
    </style>

    <div class="container">
        <div class="sidebar" id="sidebar">
            <ul>
                <li>
                    <a href="#">
                        <i class="fas fa-sharp fa-solid fa-hippo"></i>
                        <div class="title">48 Shop</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-wallet"></i>
                        <div class="title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('view-toko') }}">
                        <i class="fa fa-home"></i>
                        <div class="title">Toko</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('view-role') }}">
                        <i class="fa fa-info-circle"></i>
                        <div class="title">Role</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('view-user') }}">
                        <i class="fa fa-users"></i>
                        <div class="title">User</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('view-kategori') }}">
                        <i class="fas fa-bars"></i>
                        <div class="title">Kategori</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('view-product') }}">
                        <i class="fa fa-desktop"></i>
                        <div class="title">Product</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('view-product-upload') }}">
                        <i class="fa fa-file-alt"></i>
                        <div class="title">Product Upload</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('view-laporan') }}">
                        <i class="fas fa-money-bill-alt"></i>
                        <div class="title">Transaction</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('view-kasir') }}">
                        <i class="fa fa-cart-plus" aria-hidden="true"></i>
                        <div class="title">Kasir</div>
                    </a>
                </li>
                <li>
                    <a href="{{route('view-log-activity')}}">
                        <i class="fas fa-balance-scale-right"></i>
                        <div class="title">Log Activity</div>
                    </a>
                </li>
                <!--tes-->

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
            <div class="top-bar" id="top-bar">
                <div class="search">
                    <input type="text" name="search" placeholder="search here">
                    <label for="search"><i class="fas fa-search"></i></label>
                </div>
                <i class="fas fa-bell"></i>
                <div class="user" id="open-modal">
                    <img src="{{ asset('css/img/user2.png') }}" alt="">
                </div>
            </div>
            @yield('dashboard')
            <div style="margin-bottom: 90px;"></div>
            @yield('table_content')
            @yield('content-no-table')
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
                <h3 class="modal__title" id="dom-user" style="margin-bottom: 10px"></h3>
                {{-- <p class="modal__description">Click to the button for close</p> --}}
                <button class="modal_button modal__button-width" id="btn-logout-aj">
                    Logout
                </button>
                {{-- <a href="" style="text-decoration:none;" class="modal_button modal__button-width">Logout</a> --}}
                {{-- <button class="modal__button-link">
                    Close
                </button> --}}
            </div>
        </div>
        @yield('modal_global');
        <!--modal end-->
    </div>

    @stack('scripts')
    <script src="{{ asset('css/js/modal_custom.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
        const saveAjaxLogActivity = (req_data) => {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `{{ route('save-logActivity') }}`,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    type: 'post',
                    data: req_data,
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization',
                            `Bearer ${localStorage.getItem("token")}`);
                    },
                    success: function(resStruck) {
                        resolve(resStruck)
                    },
                    error: function(xhr, status, error) {
                        if (status == 'error') {
                            let msg_error = JSON.parse(xhr.responseText);
                            reject(msg_error);
                        }
                    }
                })
            })
        }
        let elm = $("#dom-user")
        elm.text(`Hallo ${localStorage.getItem("name_login")}`)
        $("#btn-logout-aj").on('click', function() {
            const log_act = {
                        'user_id': localStorage.getItem('userId'),
                        'tipe': 'post',
                        'lat': localStorage.getItem('lat'),
                        'long': localStorage.getItem('long'),
                        'desc': `user ${localStorage.getItem('name_login')} telah melakukan logout`
                    }

            saveAjaxLogActivity(log_act)
                .then((resLog) => {
                    resLog
                })
                .catch((errLog) => {
                    errLog
                })
            
            $.ajax({
                type: 'post',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem("token")}`);
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: `{{ route('logout-api') }}`,
                success: function(res) {

                    localStorage.removeItem("userId");
                    localStorage.removeItem("token");
                    localStorage.removeItem("name_login");
                    if (res.message == 'Logout Berhasil!') {
                        Swal.fire(
                            'Saved',
                            'Berhasil logut',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                modal.classList.remove('show-modal')
                                navbar_atas_id.style.position = "fixed";
                                navbar_samping_id.style.position = "fixed";
                            }
                        })
                        window.location.href = '{{ route('home') }}'
                    }
                }
            })
        })

        function sweetAlertError(msg) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: msg,
            })
        }
    </script>
</body>

</html>
