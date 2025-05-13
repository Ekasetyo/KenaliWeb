(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $('.navbar').addClass('sticky-top shadow-sm');
        } else {
            $('.navbar').removeClass('sticky-top shadow-sm');
        }
    });


    // Smooth scrolling on the navbar links
    $(".navbar-nav a").on('click', function (event) {
        if (this.hash !== "") {
            event.preventDefault();
            
            $('html, body').animate({
                scrollTop: $(this.hash).offset().top - 45
            }, 1500, 'easeInOutExpo');
            
            if ($(this).parents('.navbar-nav').length) {
                $('.navbar-nav .active').removeClass('active');
                $(this).closest('a').addClass('active');
            }
        }
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Facts counter
    $('[data-toggle="counter-up"]').counterUp({
        delay: 10,
        time: 2000
    });


    // Screenshot carousel
    $(".screenshot-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        loop: true,
        dots: true,
        items: 1
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        loop: true,
        center: true,
        dots: false,
        nav: true,
        navText : [
            '<i class="bi bi-chevron-left"></i>',
            '<i class="bi bi-chevron-right"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });
    
})(jQuery);

let selectedGender = '';

function selectGender(gender) {
    selectedGender = gender;
    document.getElementById('gender').value = gender;

    // Ubah tampilan tombol berdasarkan gender yang dipilih
    document.getElementById('male').classList.remove('btn-primary');
    document.getElementById('female').classList.remove('btn-danger');
    document.getElementById('male').classList.add('btn-outline-primary');
    document.getElementById('female').classList.add('btn-outline-danger');

    if (gender === 'male') {
        document.getElementById('male').classList.add('btn-primary');
        document.getElementById('male').classList.remove('btn-outline-primary');
    } else if (gender === 'female') {
        document.getElementById('female').classList.add('btn-danger');
        document.getElementById('female').classList.remove('btn-outline-danger');
    }
}

function calculateBMI() {
     const weight = parseFloat(document.getElementById('weight').value);
    const height = parseFloat(document.getElementById('height').value);
    const age = parseInt(document.getElementById('age').value);

    if (weight < 0 || height < 0 || age < 0) {
        e.preventDefault(); // Mencegah pengiriman formulir
        alert('Nilai berat badan, tinggi badan, dan usia tidak boleh negatif!');
    }
    const gender = document.getElementById('gender').value;

    if (isNaN(weight) || isNaN(height) || isNaN(age) || !gender || weight <= 0 || height <= 0 || age <= 0) {
        document.getElementById('bmiResult').innerHTML = '<span class="text-danger">Masukkan semua data dengan benar!</span>';
        return;
    }

    const bmi = (weight / (height * height)).toFixed(2);
    let category = '';

    if (bmi < 18.5) {
        category = 'Kekurangan Berat Badan';
    } else if (bmi >= 18.5 && bmi < 24.9) {
        category = 'Normal';
    } else if (bmi >= 25 && bmi < 29.9) {
        category = 'Kelebihan Berat Badan';
    } else {
        category = 'Obesitas';
    }

    const genderIcon = gender === 'male' ? '♂️' : '♀️';

    document.getElementById('bmiResult').innerHTML = `
        <strong>Hasil BMI Anda:</strong><br>
        BMI: <strong>${bmi}</strong> (${category})<br>
        Usia: <strong>${age} tahun</strong><br>
        Gender: <strong>${gender === 'male' ? 'Laki-Laki' : 'Perempuan'} ${genderIcon}</strong>
    `;
}

