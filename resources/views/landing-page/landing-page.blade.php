<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Kenali</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ asset('landing-assets/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap"
        rel="stylesheet">

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

    <link rel="icon" type="image/png" href="{{ asset('landing-assets/img/Logo_Kenali_1.png') }}">
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="51">
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
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
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="#home" class="nav-item nav-link active">Home</a>
                        <a href="#about" class="nav-item nav-link">About</a>
                        <a href="#feature" class="nav-item nav-link">Fitur</a>
                        <a href="#bmi-calculator" class="nav-item nav-link">BMI</a>
                        <a href="#artikel" class="nav-item nav-link">Artikel</a>
                    </div>
                    <a href="{{ url('/login') }}"
                        class="btn btn-primary-gradient rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Login</a>
                </div>
            </nav>

            <div class="container-xxl bg-primary hero-header">
                <div class="container px-lg-5">
                    <div class="row g-5"> 
                       <div class="col-lg-8 text-center text-lg-start">
                            <h1 class="text-white mb-4 animated slideInDown">Solusi Cerdas Untuk Apa?</h1>
                            <p class="text-white pb-3 animated slideInDown" style="text-align: justify;">Untuk mengatasi deteksi dini risiko stroke menjadi sangat penting untuk menekan angka kejadian dan mencegah komplikasi serius. Saat ini, skrining risiko stroke umumnya masih mengandalkan pemeriksaan klinis manual dan kuesioner sederhana yang rentan subjektivitas. Selain itu, sumber daya medis di banyak wilayah masih terbatas, sehingga akses ke screening yang komprehensif tidak merata.</p>
                            <a href="#contact" class="btn btn-secondary-gradient py-sm-3 px-4 px-sm-5 rounded-pill animated slideInRight">Download Disini</a>
                        </div>
                        <div class="owl-carousel screenshot-carousel">
                                <img class="img-fluid" src="{{ asset('landing-assets/img/gambar1.png') }}"
                                    alt="">
                                <img class="img-fluid" src="{{ asset('landing-assets/img/gambar2.png') }}"
                                    alt="">
                                <img class="img-fluid" src="{{ asset('landing-assets/img/gambar3.png') }}"
                                    alt="">
                                <img class="img-fluid" src="{{ asset('landing-assets/img/gambar4.png') }}"
                                    alt="">
                                <img class="img-fluid" src="{{ asset('landing-assets/img/gambar5.png') }}"
                                    alt="">
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
                        <p class="mb-4" style="text-align: justify;">Stroke merupakan penyakit tidak menular yang menjadi penyebab utama kematian dan kecacatan, dan sering kali terjadi secara tiba-tiba tanpa gejala awal yang jelas. Sayangnya, masih banyak masyarakat yang belum menyadari risiko mereka terhadap penyakit ini, serta kurangnya akses terhadap layanan deteksi dini yang cepat dan efisien, terutama di wilayah terpencil. Pengembangan sistem ini diharapkan dapat membantu tenaga medis dalam proses skrining, meningkatkan kesadaran masyarakat akan pentingnya pencegahan stroke, dan pada akhirnya menurunkan angka kejadian stroke melalui deteksi dini berbasis data.</p>
                        <div class="row g-4 mb-4"></div>
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
            <h1 class="mb-5">Fitur Keunggulan</h1>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="feature-item bg-light rounded p-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary-gradient rounded-circle mb-4" style="width: 60px; height: 60px;">
                        <i class="fa fa-eye text-white fs-4"></i>
                    </div>
                    <h5 class="mb-3">Login & Autentikasi</h5>
                    <p class="m-0" style="text-align: justify;">Gerbang utama yang aman untuk masuk ke dalam aplikasi. Ini memastikan bahwa hanya pengguna yang terdaftar dan terverifikasi (melalui nama pengguna dan kata sandi) yang dapat mengakses dan menggunakan fitur-fitur serta data pribadi mereka di dalam sistem, menjaga keamanan dan integritas informasi. Pada platform web, pengguna juga memiliki kemampuan untuk melakukan proses pendaftaran (register), memungkinkan mereka untuk membuat akun baru sebelum dapat login dan memulai penggunaan aplikasi.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="feature-item bg-light rounded p-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-secondary-gradient rounded-circle mb-4" style="width: 60px; height: 60px;">
                        <i class="fa fa-layer-group text-white fs-4"></i>
                    </div>
                    <h5 class="mb-3">Dashboard Web & Mobile (Ringkasan Data)</h5>
                    <p class="m-0" style="text-align: justify;">"Kenali" adalah ekosistem terintegrasi yang memungkinkan deteksi dini risiko stroke yang mudah diakses pengguna melalui aplikasi mobile (lengkap dengan dashboard personal), sekaligus menyediakan alat manajemen dan pemantauan data yang kuat bagi administrator melalui platform web.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="feature-item bg-light rounded p-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary-gradient rounded-circle mb-4" style="width: 60px; height: 60px;">
                        <i class="fa fa-edit text-white fs-4"></i>
                    </div>
                    <h5 class="mb-3">Riwayat Deteksi</h5>
                    <p class="m-0" style="text-align: justify;">Riwayat deteksi ini terdapat sebuah akses yaitu admin dan user. Untuk admin, terdapat fitur riwayat deteksi user yang menampilkan daftar hasil skrining risiko stroke dari berbagai pengguna. Sementara itu, untuk user, terdapat fitur riwayat deteksi di mana mereka akan memiliki akses ke subset fungsionalitas yang sama, namun terfokus pada riwayat deteksi pribadi mereka sendiri, memastikan privasi dan relevansi informasi.</p>
                </div>
            </div>
            </div>
    </div>
</div>
        <!-- Features End -->

       <!-- BMI Calculator Start -->
<div class="container-xxl py-5" id="bmi-calculator">
    <div class="container py-5 px-lg-5">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h5 class="text-primary-gradient fw-medium">Kalkulator BMI</h5>
            <h1 class="mb-5">Hitung Indeks Massa Tubuh Anda</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="wow fadeInUp" data-wow-delay="0.3s">
                    <form id="bmiForm">
                        <div class="row g-3">

                            <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-select" id="gender" required>
                                        <option value="" disabled selected>Pilih Gender</option>
                                        <option value="laki-laki">Laki-laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                    <label for="gender">Gender</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="weight" placeholder="Berat Badan (kg)" min="0" step="0.1" required>
                                    <label for="weight">Berat Badan (kg)</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="height" placeholder="Tinggi Badan (cm)" min="0" step="1" required>
                                    <label for="height">Tinggi Badan (cm)</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="age" placeholder="Usia (tahun)" min="0" required>
                                    <label for="age">Usia (tahun)</label>
                                </div>
                            </div>

                            <div class="col-12 text-center mt-4">
                                <div id="bmiResultContainer" class="p-3 border rounded" style="background-color: #f0f8ff;">
                                    <p class="mb-0 text-muted">Isi data di atas untuk menghitung BMI Anda.</p>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function calculateBMI() {
        const gender = document.getElementById("gender").value;
        const weight = parseFloat(document.getElementById("weight").value);
        const height = parseFloat(document.getElementById("height").value);
        const age = parseInt(document.getElementById("age").value);

        const bmiResultContainer = document.getElementById("bmiResultContainer");

        // Validasi input
        if (!gender || isNaN(weight) || isNaN(height) || isNaN(age) || weight <= 0 || height <= 0 || age <= 0) {
            bmiResultContainer.innerHTML = '<p class="text-danger mb-0">Mohon isi semua field dengan benar dan pastikan nilainya positif.</p>';
            return;
        }

        // Konversi tinggi badan dari cm ke meter
        const heightInMeter = height / 100;

        // Hitung BMI
        const bmi = weight / (heightInMeter * heightInMeter);
        const bmiRounded = bmi.toFixed(2); // Bulatkan 2 angka di belakang koma

        // Tentukan kategori BMI
        let category = "";
        if (bmi < 18.5) {
            category = "Kekurangan Berat Badan";
        } else if (bmi >= 18.5 && bmi <= 24.9) {
            category = "Normal";
        } else if (bmi >= 25 && bmi <= 29.9) {
            category = "Kelebihan Berat Badan";
        } else { // bmi >= 30
            category = "Obesitas";
        }

        // Penentuan teks gender dengan emoji
        let genderText = "";
        if (gender === "laki-laki") {
            genderText = "Laki-laki ♂️";
        } else if (gender === "perempuan") {
            genderText = "Perempuan ♀️";
        }

        // Tampilkan hasil di satu elemen output
        bmiResultContainer.innerHTML = `
            <h4 class="mb-2">Hasil BMI Anda:</h4>
            <p class="fs-4 fw-bold mb-1">BMI: ${bmiRounded} (${category})</p>
            <p class="mb-1">Usia: ${age} tahun</p>
            <p class="mb-0">Gender: ${genderText}</p>
        `;
    }

    // Pemicu perhitungan saat input berubah (selain tombol klik)
    document.getElementById('gender').addEventListener('change', calculateBMI);
    document.getElementById('weight').addEventListener('input', calculateBMI);
    document.getElementById('height').addEventListener('input', calculateBMI);
    document.getElementById('age').addEventListener('input', calculateBMI);

    // Panggil sekali saat halaman dimuat untuk menampilkan placeholder awal
    document.addEventListener('DOMContentLoaded', calculateBMI);
</script>

        <!-- Artikel Terbaru Start -->
        <div class="container-xxl py-5" id="artikel">
            <div class="container py-5 px-lg-5">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="text-primary-gradient fw-medium">Artikel Terbaru</h5>
                    <h1 class="mb-5">Informasi & Tips</h1>
                </div>
                <div class="row g-4">
                    @foreach($artikels as $artikel)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="bg-light rounded p-4">
                                <h5>{{ $artikel->judul }}</h5>
                                <p class="mb-2"><small>Oleh {{ $artikel->penulis }}</small></p>
                                <p class="mb-2" style="text-align: justify;">{{ Str::limit(strip_tags($artikel->deskripsi), 120) }}</p>
                                <a href="{{ $artikel->sumber }}" target="_blank" class="btn btn-primary-gradient btn-sm">Baca Selengkapnya</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Artikel Terbaru End -->



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
            <a href="#" class="btn btn-lg btn-lg-square back-to-top pt-2"><i
                    class="bi bi-arrow-up text-white"></i></a>
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
    <script>

