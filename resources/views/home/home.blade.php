@extends('layout.layoutHome')

@section('home')
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="top-bar text-white-50 row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <small><i class="fa fa-map-marker-alt me-2"></i>123 Street, New York, USA</small>
                <small class="ms-4"><i class="fa fa-envelope me-2"></i>info@example.com</small>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <a class="text-white-50 ms-3" href="#"><i class="fab fa-qq"></i></a>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-dark py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
            <a href="#" class="navbar-brand ms-4 ms-lg-0" id="onlogin">
                <h1 class="fw-bold text-primary m-0">Chari<span class="text-white">Team</span></h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="#" id="hrefhome" class="nav-item nav-link active">Home</a>
                    <a href="#" id="hrefabout" class="nav-item nav-link">About</a>
                    <a href="#" id="hrefproduct" class="nav-item nav-link">Product</a>
                    <!-- <div class="nav-item dropdown">
                              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                              <div class="dropdown-menu m-0">
                                  <a href="service.html" class="dropdown-item">Service</a>
                                  <a href="donate.html" class="dropdown-item">Donate</a>
                                  <a href="team.html" class="dropdown-item">Our Team</a>
                                  <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                                  <a href="404.html" class="dropdown-item">404 Page</a>
                              </div>
                          </div> -->
                    <a href="#" id="hrefcontact" class="nav-item nav-link">Contact</a>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5" id="sectionhome">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('assetLandingPage/img/carousel-1.webp') }}" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-7 pt-5">
                                    <h1 class="display-4 text-white mb-3 animated slideInDown">Let's Change The World
                                        With Humanity</h1>
                                    <p class="fs-5 text-white-50 mb-5 animated slideInDown">Aliqu diam amet diam et
                                        eos. Clita erat ipsum et lorem sed stet lorem sit clita duo justo erat amet</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="{{ asset('assetLandingPage/img/carousel-2.webp') }}" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-7 pt-5">
                                    <h1 class="display-4 text-white mb-3 animated slideInDown">Let's Save More Lifes
                                        With Our Helping Hand</h1>
                                    <p class="fs-5 text-white-50 mb-5 animated slideInDown">Aliqu diam amet diam et
                                        eos. Clita erat ipsum et lorem sed stet lorem sit clita duo justo erat amet</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- About Start -->
    <div class="container-xxl py-5" id="sectionabout">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="position-relative overflow-hidden h-100" style="min-height: 400px;">
                        <img class="position-absolute w-100 h-100 pt-5 pe-5"
                            src="{{ asset('assetLandingPage/img/about-1.webp') }}" alt=""
                            style="object-fit: cover;">
                        <img class="position-absolute top-0 end-0 bg-white ps-2 pb-2"
                            src="{{ asset('assetLandingPage/img/about-2.webp') }}" alt=""
                            style="width: 200px; height: 200px;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="h-100">
                        <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">About Us
                        </div>
                        <h1 class="display-6 mb-5">Toko kami menjual berbagai macam barang</h1>
                        <div class="bg-light border-bottom border-5 border-primary rounded p-4 mb-4">
                            <p class="text-dark mb-2">Aliqu diam amet diam et eos. Clita erat ipsum et lorem sed stet
                                lorem sit clita duo justo erat amet</p>
                            <span class="text-primary">Jhon Doe, Founder</span>
                        </div>
                        <p class="mb-5">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet
                            diam et eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna
                            dolore erat amet</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Causes Start -->
    <div class="container-xxl bg-light my-5 py-5" id="sectionproduct">
        <div class="container py-5">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">Product</div>
                <h1 class="display-6 mb-5">The Products We Sell</h1>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div
                        class="causes-item d-flex flex-column bg-white border-top border-5 border-primary rounded-top overflow-hidden h-100">
                        <div class="text-center p-4 pt-0">
                            <div class="d-inline-block bg-primary text-white rounded-bottom fs-5 pb-1 px-3 mb-4">
                                <small>Minyak goreng</small>
                            </div>
                            <h5 class="mb-3">Minyak goreng</h5>
                        </div>
                        <div class="position-relative mt-auto">
                            <img class="img-fluid" src="{{ asset('assetLandingPage/img/p1.webp') }}" alt="">
                            <div class="causes-overlay">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div
                        class="causes-item d-flex flex-column bg-white border-top border-5 border-primary rounded-top overflow-hidden h-100">
                        <div class="text-center p-4 pt-0">
                            <div class="d-inline-block bg-primary text-white rounded-bottom fs-5 pb-1 px-3 mb-4">
                                <small>Rempah rempah</small>
                            </div>
                            <h5 class="mb-3">Bawang</h5>
                        </div>
                        <div class="position-relative mt-auto">
                            <img class="img-fluid" src="{{ asset('assetLandingPage/img/p2.webp') }}" alt="">
                            <div class="causes-overlay">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div
                        class="causes-item d-flex flex-column bg-white border-top border-5 border-primary rounded-top overflow-hidden h-100">
                        <div class="text-center p-4 pt-0">
                            <div class="d-inline-block bg-primary text-white rounded-bottom fs-5 pb-1 px-3 mb-4">
                                <small>Kebutuhan pokok</small>
                            </div>
                            <h5 class="mb-3">Beras</h5>

                        </div>
                        <div class="position-relative mt-auto">
                            <img class="img-fluid" src="{{ asset('assetLandingPage/img/p3.webp') }}" alt="">
                            <div class="causes-overlay">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Causes End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s"
        id="sectioncontact">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h1 class="fw-bold text-primary mb-4">Chari<span class="text-white">Team</span></h1>
                    <p>Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit, sed
                        stet lorem sit clita</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Address</h5>
                    <p><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p><i class="fa fa-envelope me-3"></i>info@example.com</p>
                </div>
            </div>
        </div>
        <div class="container-fluid copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a href="#">Your Site Name</a>, All Right Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $("#hrefabout").on('click', function(event) {
                $("#hrefhome").removeClass("active");
                $("#hrefproduct").removeClass("active");
                $("#hrefcontact").removeClass("active")
                $("#hrefabout").addClass('active')
                $('html, body').animate({
                    scrollTop: $("#sectionabout").offset().top - 80,
                })
            });

            $("#hrefproduct").on('click', function() {
                $("#hrefhome").removeClass("active");
                $("#hrefcontact").removeClass("active");
                $("#hrefabout").removeClass("active")
                $("#hrefproduct").addClass('active')
                $('html, body').animate({
                    scrollTop: $("#sectionproduct").offset().top - 30,
                })
            })

            $("#hrefcontact").on('click', function() {
                $("#hrefhome").removeClass("active");
                $("#hrefproduct").removeClass("active");
                $("#hrefabout").removeClass("active")
                $("#hrefcontact").addClass('active')
                $('html, body').animate({
                    scrollTop: $("#sectioncontact").offset().top - 80,
                })
            })

            $("#hrefhome").on('click', function() {
                $("#hrefcontact").removeClass("active");
                $("#hrefproduct").removeClass("active");
                $("#hrefabout").removeClass("active")
                $("#hrefhome").addClass('active')
                $('html, body').animate({
                    scrollTop: $("#sectionhome").offset().top - 80,
                })
            })
        });

        $("#onlogin").on('click', function() {
            console.log('modal login');
            Swal.fire({
                title: 'Login',
                html: `<input type="text" id="email" class="swal2-input" placeholder="Username">
                <input type="password" id="password" class="swal2-input" placeholder="Password">`,
                confirmButtonText: 'Login',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                focusConfirm: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    let email = $("#email").val();
                    let pass = $("#password").val();
                    $.ajax({
                        url: `{{route('login')}}`,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        type: 'post',
                        data:{'email':email, 'password' : pass},
                        success: function(response){
                            if (response.hasOwnProperty('error')) {
                               if (response.error.hasOwnProperty('email')) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: response.error.email[0],
                                    })
                               }
                            }
                            if (response.hasOwnProperty('message') && response.message == 'success login') {
                                localStorage.setItem("userId",response.id_user)
                                localStorage.setItem("token", response.jwt_token);
                                localStorage.setItem("name_login",`${response.role.name_role}-${response.toko.nama_toko}`)
                                window.location.href = '{{route("kategori-url")}}'
                            }
                            const save_param_log_activity = {
                                'user_id': response.id_user,
                                'tipe': 'post',
                                'lat': localStorage.getItem('lat'),
                                'long': localStorage.getItem('long'),
                                'desc' : `user ${response.role.name_role}-${response.toko.nama_toko} telah melakukan login`
                            };
                            saveAjax(save_param_log_activity)
                            .then(res=>res)
                            .catch(err=> err)
                            
                        },
                        error: function(xhr,status,res){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'password salah',
                            })
                        }
                    })
                }
            })
               
        })

       const saveAjax = (req_data) =>{
            return new Promise((resolve,reject)=>{
                $.ajax({
                    url: `{{route('save-logActivity')}}`,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    type: 'post',
                    data:req_data,
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

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successFunction);
        } else {
            alert('It seems like Geolocation, which is required for this page, is not enabled in your browser. Please use a browser which supports it.');
        }

        function successFunction(position) {
            var lat = position.coords.latitude;
            var long = position.coords.longitude;
            localStorage.setItem("lat",lat)
            localStorage.setItem("long", long);
        }
        
    </script>
@endpush
