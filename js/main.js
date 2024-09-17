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
        if ($(this).scrollTop() > 300) {
            $('.sticky-top').css('top', '0px');
        } else {
            $('.sticky-top').css('top', '-100px');
        }
    });
    
    
    // Dropdown on mouse hover
    const $dropdown = $(".dropdown");
    const $dropdownToggle = $(".dropdown-toggle");
    const $dropdownMenu = $(".dropdown-menu");
    const showClass = "show";
    
    $(window).on("load resize", function() {
        if (this.matchMedia("(min-width: 992px)").matches) {
            $dropdown.hover(
            function() {
                const $this = $(this);
                $this.addClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "true");
                $this.find($dropdownMenu).addClass(showClass);
            },
            function() {
                const $this = $(this);
                $this.removeClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "false");
                $this.find($dropdownMenu).removeClass(showClass);
            }
            );
        } else {
            $dropdown.off("mouseenter mouseleave");
        }
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
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


    // Header carousel
    $(".header-carousel").owlCarousel({
        autoplay: false,
        smartSpeed: 1500,
        items: 1,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="bi bi-chevron-left"></i>',
            '<i class="bi bi-chevron-right"></i>'
        ]
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: false,
        smartSpeed: 1000,
        center: true,
        dots: true,
        loop: true,
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

// Show Forgot Password Modal
function showForgotPasswordModal() {
    $('#connexionModal').modal('hide');
    $('#forgotPasswordModal').modal('show');
}

// Show Register Modal
function showRegisterModal() {
    $('#connexionModal').modal('hide');
    $('#registerModal').modal('show');
}

// Function to show additional fields based on the selected user type
function showAdditionalFields() {
    const selectedUserType = document.getElementById("userType").value;

    // Hide all fields initially
    const allFields = document.querySelectorAll('.additional-field');
    allFields.forEach(field => field.classList.add('hidden'));

    // Show relevant fields based on user type
    if (selectedUserType === "independent_driver") {
        document.querySelector('.independent_driver_fields').classList.remove('hidden');
    } else if (selectedUserType === "customer") {
        document.querySelector('.customer_fields').classList.remove('hidden');
    } else if (selectedUserType === "company") {
        document.querySelector('.company_fields').classList.remove('hidden');
    }
}

// Form validation for login
document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const email = document.getElementById("loginEmail").value;
    const password = document.getElementById("loginPassword").value;

    // Reset previous error messages
    document.getElementById("loginEmailError").style.display = "none";
    document.getElementById("loginPasswordError").style.display = "none";
    document.getElementById("loginError").style.display = "none";

    // Basic validation for demonstration
    if (!email || !password) {
        if (!email) {
            document.getElementById("loginEmailError").textContent = "Please enter a valid email.";
            document.getElementById("loginEmailError").style.display = "block";
        }
        if (!password) {
            document.getElementById("loginPasswordError").textContent = "Please enter your password.";
            document.getElementById("loginPasswordError").style.display = "block";
        }
    } else {
        // Perform login (AJAX or form submission could be done here)
        alert("Login successful!");
    }
});

// Form validation for registration
document.getElementById("registerForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const email = document.getElementById("registerEmail").value;
    const password = document.getElementById("registerPassword").value;
    const repassword = document.getElementById("registerRepassword").value;

    // Reset previous error messages
    document.getElementById("registerEmailError").style.display = "none";
    document.getElementById("registerPasswordError").style.display = "none";
    document.getElementById("registerRepasswordError").style.display = "none";
    document.getElementById("registerError").style.display = "none";

    // Validation
    if (!email || !password || !repassword) {
        if (!email) {
            document.getElementById("registerEmailError").textContent = "Please enter a valid email.";
            document.getElementById("registerEmailError").style.display = "block";
        }
        if (!password) {
            document.getElementById("registerPasswordError").textContent = "Please enter a password.";
            document.getElementById("registerPasswordError").style.display = "block";
        }
        if (password !== repassword) {
            document.getElementById("registerRepasswordError").textContent = "Passwords do not match.";
            document.getElementById("registerRepasswordError").style.display = "block";
        }
    } else {
        // Perform registration (AJAX or form submission)
        alert("Registration successful!");
    }
});

// Forgot password form submission
document.getElementById("forgotPasswordForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const email = document.getElementById("forgotEmail").value;

    // Reset previous error messages
    document.getElementById("forgotEmailError").style.display = "none";
    document.getElementById("forgotError").style.display = "none";

    if (!email) {
        document.getElementById("forgotEmailError").textContent = "Please enter a valid email.";
        document.getElementById("forgotEmailError").style.display = "block";
    } else {
        // Perform password recovery (AJAX or form submission)
        alert("Password recovery instructions sent!");
    }
});
