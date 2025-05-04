<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Kenali</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ asset('landing-assets/img/favicon.ico')}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('landing-assets/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing-assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('landing-assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('landing-assets/css/style.css') }}" rel="stylesheet">
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="51">
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0" id="home">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <h1 class="m-0">Kenali</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="#home" class="nav-item nav-link active">Home</a>
                        <a href="#about" class="nav-item nav-link">About</a>
                        <a href="#feature" class="nav-item nav-link">Fitur</a>
                        <a href="#review" class="nav-item nav-link">Review</a>
                        <a href="#contact" class="nav-item nav-link">Contact</a>
                    </div>
                    <a href="{{ url('/login') }}" class="btn btn-primary-gradient rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Login</a>
                </div>
            </nav>

            <div class="container-xxl bg-primary hero-header">
                <div class="container px-lg-5">
                    <div class="row g-5"> 
                        <div class="col-lg-8 text-center text-lg-start">
                            <h1 class="text-white mb-4 animated slideInDown">Solusi Cerdas Untuk Apa?</h1>
                            <p class="text-white pb-3 animated slideInDown">Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt at amet, ut architecto harum laboriosam cum praesentium repudiandae quisquam atque quaerat dolorem voluptate blanditiis doloribus saepe vero fuga, cumque soluta?</p>
                            <!-- <a href="" class="btn btn-primary-gradient py-sm-3 px-4 px-sm-5 rounded-pill me-3 animated slideInLeft">Read More</a> -->
                            <a href="#contact" class="btn btn-secondary-gradient py-sm-3 px-4 px-sm-5 rounded-pill animated slideInRight">Hubungi Kami</a>
                        </div>
                        <div class="col-lg-4 d-flex justify-content-center justify-content-lg-end wow fadeInUp" data-wow-delay="0.3s">
                            <div class="owl-carousel screenshot-carousel">
                                <img class="img-fluid" src="{{ asset('landing-assets/img/finomali_depan.png') }}" alt="">
                                <img class="img-fluid" src="{{ asset('landing-assets/img/finomali_depan2.png') }}" alt="">
                                <img class="img-fluid" src="{{ asset('landing-assets/img/finomali_login.png') }}" alt="">
                                <img class="img-fluid" src="{{ asset('landing-assets/img/finomali_register.png') }}" alt="">
                                <img class="img-fluid" src="{{ asset('landing-assets/img/finomali_dashboard.png') }}" alt="">
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        <!-- About Start -->
        <div class="container-xxl py-5" id="about">
            <div class="container py-5 px-lg-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <h5 class="text-primary-gradient fw-medium">Tentang Kenali</h5>
                        <h1 class="mb-4">#1 </h1>
                        <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto voluptates corporis delectus qui quasi! Animi totam perspiciatis labore nam at hic eius alias omnis, veritatis excepturi minus quibusdam rerum iste.</p>
                        <div class="row g-4 mb-4">
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                                <div class="d-flex">
                                    <i class="fa fa-cogs fa-2x text-primary-gradient flex-shrink-0 mt-1"></i>
                                    <div class="ms-3">
                                        <h2 class="mb-0" data-toggle="counter-up">1234</h2>
                                        <p class="text-primary-gradient mb-0">Pengunduh</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                                <div class="d-flex">
                                    <i class="fa fa-comments fa-2x text-secondary-gradient flex-shrink-0 mt-1"></i>
                                    <div class="ms-3">
                                        <h2 class="mb-0" data-toggle="counter-up">1234</h2>
                                        <p class="text-secondary-gradient mb-0">Reviews</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

        <!-- Features Start -->
        <div class="container-xxl py-5" id="feature">
            <div class="container py-5 px-lg-5">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="text-primary-gradient fw-medium">Fitur Aplikasi</h5>
                    <h1 class="mb-5">Fitur Unggulan</h1>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="feature-item bg-light rounded p-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary-gradient rounded-circle mb-4" style="width: 60px; height: 60px;">
                                <i class="fa fa-eye text-white fs-4"></i>
                            </div>
                            <h5 class="mb-3">Login & Autentikasi</h5>
                            <p class="m-0">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Enim veniam esse consequatur vel animi nemo, tempora deserunt sapiente, nostrum dignissimos recusandae consectetur amet incidunt quae at. Tempore voluptate doloremque quia.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="feature-item bg-light rounded p-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-secondary-gradient rounded-circle mb-4" style="width: 60px; height: 60px;">
                                <i class="fa fa-layer-group text-white fs-4"></i>
                            </div>
                            <h5 class="mb-3">Dashboard Mobile ( Ringkasan Data )</h5>
                            <p class="m-0">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sequi rerum iusto fugit rem ipsum labore, doloribus a sunt repellat, voluptates suscipit sed delectus voluptas hic, quae dicta consectetur quaerat? Alias?</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="feature-item bg-light rounded p-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary-gradient rounded-circle mb-4" style="width: 60px; height: 60px;">
                                <i class="fa fa-edit text-white fs-4"></i>
                            </div>
                            <h5 class="mb-3">List & Detail Transaksi</h5>
                            <p class="m-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque deserunt optio sapiente dolore enim amet numquam odio provident voluptatem inventore culpa, incidunt qui soluta nisi consequuntur, distinctio necessitatibus voluptate ipsa?</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="feature-item bg-light rounded p-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary-gradient rounded-circle mb-4" style="width: 60px; height: 60px;">
                                <i class="fa fa-cloud text-white fs-4"></i>
                            </div>
                            <h5 class="mb-3">Dashboard Web</h5>
                            <p class="m-0"> sit amet consectetur adipisicing elit. Perferendis esse aperiam libero magni qui enim ullam, ex ipsam nesciunt ut, modi et itaque mollitia sint unde officiis ipsa earum accusamus!</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="feature-item bg-light rounded p-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-secondary-gradient rounded-circle mb-4" style="width: 60px; height: 60px;">
                                <i class="fa fa-mobile-alt text-white fs-4"></i>
                            </div>
                            <h5 class="mb-3">Laporan & Notifikasi</h5>
                            <p class="m-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Modi alias expedita natus atque voluptates vero placeat illo officia at totam ducimus eum autem et, tenetur iste! Aliquid quas molestias quae.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Features End -->


        <!-- Process Start -->
        <div class="container-xxl py-5">
            <div class="container py-5 px-lg-5">
                <div class="text-center pb-4 wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="text-primary-gradient fw-medium">Cara Kerja</h5>
                    <h1 class="mb-5">3 Langkah Mudah</h1>
                </div>
                <div class="row gy-5 gx-4 justify-content-center">
                    <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="position-relative bg-light rounded pt-5 pb-4 px-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary-gradient rounded-circle position-absolute top-0 start-50 translate-middle shadow" style="width: 100px; height: 100px;">
                                <i class="fa fa-cog fa-3x text-white"></i>
                            </div>
                            <h5 class="mt-4 mb-3">Instal Aplikasi</h5>
                            <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio quidem fuga nemo dolore molestiae incidunt ut, sed minima ab quasi nobis sapiente maxime dolorum perspiciatis eaque. Culpa cupiditate qui quod?</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="position-relative bg-light rounded pt-5 pb-4 px-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-secondary-gradient rounded-circle position-absolute top-0 start-50 translate-middle shadow" style="width: 100px; height: 100px;">
                                <i class="fa fa-address-card fa-3x text-white"></i>
                            </div>
                            <h5 class="mt-4 mb-3">Login & Setup Akun</h5>
                            <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt necessitatibus vero cumque consequatur fugiat perspiciatis dicta asperiores, dolore quia doloribus eaque sed accusantium, est, error enim. Maiores eligendi magni labore?</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="position-relative bg-light rounded pt-5 pb-4 px-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary-gradient rounded-circle position-absolute top-0 start-50 translate-middle shadow" style="width: 100px; height: 100px;">
                                <i class="fa fa-check fa-3x text-white"></i>
                            </div>
                            <h5 class="mt-4 mb-3">Nikmati Fitur-Fiturnya</h5>
                            <p class="mb-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Incidunt maxime natus assumenda voluptates? Ratione dolores similique voluptatem vitae doloremque quo saepe facilis, commodi ea maxime modi? Atque pariatur debitis ea.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Process Start -->

        <!-- Testimonial Start -->
        <div class="container-xxl py-5" id="review">
            <div class="container py-5 px-lg-5">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="text-primary-gradient fw-medium">Developer</h5>
                    <h1 class="mb-5">Team Pengembang Aplikasi</h1>
                </div>
                <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                    <div class="testimonial-item rounded p-4">
                        <div class="d-flex align-items-center mb-4">
                            <img class="img-fluid bg-white rounded flex-shrink-0 p-1" src="{{ asset('landing-assets/img/testimonial-2.jpg') }}" style="width: 85px; height: 85px;">
                            <div class="ms-4">
                                <h5 class="mb-1">Divisi AI</h5>
                                <p class="mb-1">Eka Setyo Saputra</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item rounded p-4">
                        <div class="d-flex align-items-center mb-4">
                            <img class="img-fluid bg-white rounded flex-shrink-0 p-1" src="{{ asset('landing-assets/img/testimonial-3.jpg') }}" style="width: 85px; height: 85px;">
                            <div class="ms-4">
                                <h5 class="mb-1">Divisi Website</h5>
                                <p class="mb-1">Abd. A Rama & Farrel Ezza</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item rounded p-4">
                        <div class="d-flex align-items-center mb-4">
                            <img class="img-fluid bg-white rounded flex-shrink-0 p-1" src="{{ asset('landing-assets/img/testimonial-4.jpg') }}" style="width: 85px; height: 85px;">
                            <div class="ms-4">
                                <h5 class="mb-1">Divisi Mobile</h5>
                                <p class="mb-1">Ahmad Rizal & Moch. Rizki</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->


        <!-- Contact Start -->
        <div class="container-xxl py-5" id="contact">
            <div class="container py-5 px-lg-5">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="text-primary-gradient fw-medium">Contact</h5>
                    <h1 class="mb-5">Hubungi Kami</h1>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <div class="wow fadeInUp" data-wow-delay="0.3s">
                            <!-- <p class="text-center mb-4">The contact form is currently inactive. Get a functional and working contact form with Ajax & PHP in a few minutes. Just copy and paste the files, add a little code and you're done. <a href="https://htmlcodex.com/contact-form">Download Now</a>.</p> -->
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="name" placeholder="Your Name">
                                            <label for="name">Nama Anda</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="email" placeholder="Your Email">
                                            <label for="email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="subject" placeholder="Subject">
                                            <label for="subject">Subjek</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Leave a message here" id="message" style="height: 150px"></textarea>
                                            <label for="message">Pesan</label>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button class="btn btn-primary-gradient rounded-pill py-3 px-5" type="submit">Kirim Pesan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->
        

        <!-- Footer Start -->
        <div class="container-fluid bg-primary text-light footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-3">
                        <h4 class="text-white mb-4">Alamat</h4>
                        <p><i class="fa fa-map-marker-alt me-3"></i>Politeknik Negeri Jember, Jember</p>
                        <p><i class="fa fa-phone-alt me-3"></i>+00000000</p>
                        <p><i class="fa fa-envelope me-3"></i>ini@email.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h4 class="text-white mb-4" style="text-align: justify;">Quick Link</h4>
                        <a class="btn btn-link" href="" style="text-align: justify; display: block;">Tentang Kami</a>
                        <a class="btn btn-link" href="" style="text-align: justify; display: block;">Hubungi Kami</a>
                        <a class="btn btn-link" href="" style="text-align: justify; display: block;">Kebijakan Privasi</a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h4 class="text-white mb-4" style="text-align: justify;">Popular Link</h4>
                        <a class="btn btn-link" href="" style="text-align: justify; display: block;">About Us</a>
                        <a class="btn btn-link" href="" style="text-align: justify; display: block;">Contact Us</a>
                    </div>
                </div>
            </div>
            <div class="container px-lg-5">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">Kenali</a>, All Right Reserved. 
							
							<!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
							Designed By Team SIGAP
                            </br>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="">Home</a>
                                <a href="">Help</a>
                                <a href="">FQAs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-lg-square back-to-top pt-2"><i class="bi bi-arrow-up text-white"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('landing-assets/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('landing-assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('landing-assets/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('landing-assets/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('landing-assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('landing-assets/js/main.js') }}"></script>
</body>

</html>