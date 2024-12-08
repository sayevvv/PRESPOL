<?php
include_once 'classes/CSRFToken.php';

$csrf = new CSRFToken();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#25D366">
    <meta property="og:title" content="Hubungi Kami di WhatsApp">
    <meta property="og:description" content="Klik tombol untuk menghubungi kami melalui WhatsApp.">
    <meta property="og:url" content="https://wa.me/628123456789?text=Halo%20saya%20ingin%20bertanya%20tentang%20produk%20Anda">
    <meta property="og:image" content="img/logoBlack.svg">
    <title>Masuk | PRESPOL</title>
    <link rel="icon" href="img/pres.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <style>
        /* slideshow */
        .bg-slideshow {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .bg-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
        }

        .bg-slide.active {
            opacity: 1;
        }
    </style>
</head>

<body class="overflow-x-hidden m-0 p-0 font-helvetica text-stone-900 
            bg-cover bg-center bg-no-repeat bg-fixed
            max-h-[400px] overflow-y-auto
            [&::-webkit-scrollbar]:w-2
            [&::-webkit-scrollbar-track]:rounded-full
            [&::-webkit-scrollbar-track]:bg-neutral-100
            [&::-webkit-scrollbar-thumb]:rounded-full
            [&::-webkit-scrollbar-thumb]:bg-neutral-300"
    style="background-image: url('img/homepageGradient.png')">

    <div class="font-helvetica">
        <div class="flex justify-center min-h-screen">
            <div class="hidden lg:block lg:w-3/5 relative">
                <div class="bg-slideshow h-full">
                    <div class="bg-slide" style="background-image: url('img/imgLogin7.jpg')"></div>
                    <div class="bg-slide" style="background-image: url('img/imgLogin8.jpg')"></div>
                    <div class="bg-slide" style="background-image: url('img/imgLogin3.jpg')"></div>
                    <div class="bg-slide" style="background-image: url('img/imgLogin4.jpeg')"></div>
                    <div class="bg-slide" style="background-image: url('img/imgLogin5.jpg')"></div>
                    <div class="bg-slide" style="background-image: url('img/imgLogin6.jpg')"></div>
                    <div class="bg-slide" style="background-image: url('img/imgLogin1.jpeg')"></div>
                    <div class="bg-slide" style="background-image: url('img/imgLogin2.jpg')"></div>
                </div>
                <div class="absolute inset-0 bg-gray-900 bg-opacity-60 flex items-end pb-20 px-20">
                    <div>
                        <h2 class="text-8xl font-bold text-gray-300">Catat Prestasimu!</h2>
                        <p class="max-w-xl mt-3 text-gray-200">
                            "Torehkan Prestasi, Wujudkan Eksistensi!"
                        </p>
                    </div>
                </div>
            </div>
            <div id="alert-container"></div>
            <div class="flex items-center w-full max-w-md px-6 mx-auto lg:w-2/6">
                <div class="flex-1">
                    <div class="mt-16 ">
                        <form id="signupForm">
                            <!-- Step 1 - Log in -->
                            <div id="step1" class="signup-step">
                                <div class="text-center">
                                    <div class="flex justify-center mx-auto">
                                        <a href="../indexLead.php"><img class="cursor-pointer h-7 sm:h-10" src="img/logoBlack.svg" alt="logo">
                                        </a>
                                    </div>

                                    <p class="text-l mt-3 text-gray-500">Masuk untuk mengakses akun yang sudah terdaftar</p>
                                </div>

                                <div class="mt-8">
                                    <form action="prosesLogin.php" method="post">

                                        <div class="relative flex items-center mt-8">
                                            <span class="absolute">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </span>

                                            <input type="text" name="username" id="username" required class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 focus:border-orange-400 focus:ring-orange-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Username">
                                        </div>

                                        <div class="relative flex items-center mt-4">
                                            <span class="absolute">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </span>

                                            <input type="password" name="password" id="password" required class="block w-full px-10 py-3 text-gray-700 bg-white border rounded-lg focus:border-orange-400 focus:ring-orange-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Password">
                                            <span
                                                id="togglePassword"
                                                class="absolute right-3 top-4 cursor-pointer text-gray-400 hover:text-orange-600">
                                                <!-- Tambahkan ikon di sini -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M15 12c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z" />
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.522 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7s-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </span>
                                        </div>

                                        <div class="mt-0">
                                            <p class="mt-6 text-sm text-right text-gray-400">Lupa password? <button id="hubungi" class="cursor-pointer text-orange-500 focus:outline-none focus:underline hover:underline">Hubungi Admin!</button></p>
                                        </div>

                                        <div class="mt-6">
                                            <input type="hidden" name="csrf_token" value="<?= $csrf->generateToken(); ?>">

                                            <button type="submit" class="w-full px-4 py-2 tracking-wide text-white transition-colors duration-300 transform bg-orange-500 rounded-lg hover:bg-orange-400 focus:outline-none focus:bg-orange-400 focus:ring focus:ring-orange-300 focus:ring-opacity-50">
                                                Masuk
                                            </button>
                                        </div>
                                    </form>

                                    <p class="mt-6 text-sm text-center text-gray-400">Belum punya akun? <a href="signup.html" class="cursor-pointer text-orange-500 focus:outline-none focus:underline hover:underline">Daftar</a>.</p>
                                </div>
                            </div>
                            <!-- Step 2 -- Hubungi Admin -->
                            <div id="step2" class="signup-step hidden">
                                <div class="text-center">
                                    <div class="flex justify-center mx-auto">
                                        <a href="../indexLead.php"><img class="cursor-pointer h-7 sm:h-10" src="img/logoBlack.svg" alt="logo">
                                        </a>
                                    </div>
                
                                    <p class="text-l mt-3 text-gray-500">Silahkan hubungi Admin untuk menceritakan permasalahan kamu mengenai website PRESPOL</p>
                                </div>
                                
                                <div class="mt-16 ">
                                    <form>
                                        <div class="w-full mb-4 border border-orange-200 rounded-lg bg-orange-50">
                                            <div class="px-4 py-2 bg-white rounded-t-lg">
                                                <textarea id="message" rows="4" class="w-full px-0 text-sm text-orange-900 bg-white " placeholder="p..Atmint!" required ></textarea>
                                            </div>
                                            <div class="flex items-center justify-between px-3 py-2 border-t ">
                                                <button onclick="sendMessage()" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-orange-700 rounded-lg focus:ring-4 focus:ring-orange-200 hover:bg-orange-800">
                                                    Kirim Pesan
                                                </button>
                                                <div class="flex ps-0 space-x-1 rtl:space-x-reverse sm:ps-2">
                                                    <button id="kembali" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-orange-700 rounded-lg focus:ring-4 focus:ring-orange-200 hover:bg-orange-800">
                                                        Kembali ke Halaman Masuk
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-6 text-center ">
                                            <p class="mt-6 text-sm text-center text-gray-400">atau langsung hubungi pada nomor Whatsapp Admin: <i class="cursor-text focus:outline-none focus:underline hover:text-orange-500">+6281216718180</i></p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        //Chat Admin
        function sendMessage() {
            const number = "6281216718180"; // Nomor WhatsApp tujuan
            const message = document.getElementById("message").value;
            const encodedMessage = encodeURIComponent(message);

            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            const waURL = isMobile 
                ? `https://api.whatsapp.com/send/?phone=${number}&text=${encodedMessage}&type=phone_number&app_absent=0`
                : `https://web.whatsapp.com/send?phone=${number}&text=${encodedMessage}`;

            window.open(waURL, "_blank");
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Pagination --
            const signupForm = document.getElementById('signupForm');
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');

            // Step 1 Next Button
            const step1NextBtn = step1.querySelector('#hubungi');
            step1NextBtn.addEventListener('click', () => {
                // If all validations pass, move to step 2
                step1.classList.add('hidden');
                step2.classList.remove('hidden');
            });

            // Step 2 Buttons
            const step2BackBtn = step2.querySelector('#kembali');

            // Back Button Functionality
            step2BackBtn.addEventListener('click', () => {
                step2.classList.add('hidden');
                step1.classList.remove('hidden');
            });

            // Function to create password toggle functionality
            function setupPasswordToggle(toggleSelector, passwordSelector) {
                const togglePassword = document.querySelector(toggleSelector);
                const password = document.querySelector(passwordSelector);

                if (togglePassword && password) {
                    togglePassword.addEventListener('click', function() {
                        // Toggle the type attribute
                        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                        password.setAttribute('type', type);

                        // Toggle the eye icon (optional)
                        this.classList.toggle('text-gray-600');

                        // Optional: Focus back on the password input after toggling
                        password.focus();
                    });
                }
            }

            // Setup toggles for both password fields
            setupPasswordToggle('#togglePassword', '#password');
            setupPasswordToggle('#togglePassword2', '#confirmPw');

            const slides = document.querySelectorAll('.bg-slide');
            let currentSlide = 0;

            // Initially activate the first slide
            slides[0].classList.add('active');

            // Function to change slides
            function changeSlide() {
                // Remove active class from current slide
                slides[currentSlide].classList.remove('active');

                // Move to next slide, wrap around to start if at end
                currentSlide = (currentSlide + 1) % slides.length;

                // Add active class to new slide
                slides[currentSlide].classList.add('active');
            }

            // Change slide every 5 seconds
            setInterval(changeSlide, 5000);
        });
    </script>
    <script>
        function createErrorOverlay() {
            // Create overlay container
            const overlay = document.createElement('div');
            overlay.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4 backdrop-blur-sm';
            overlay.setAttribute('aria-modal', 'true');
            overlay.setAttribute('role', 'dialog');

            // Create alert card
            const card = document.createElement('div');
            card.className = 'w-full max-w-md rounded-2xl bg-white shadow-2xl ring-1 ring-gray-200 transition-all duration-300 ease-in-out transform hover:scale-105';

            // Create alert content
            card.innerHTML = `
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-orange-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Login Gagal</h3>
                        <p class="text-sm text-gray-600">
                            Terdapat kesalahan pada username atau password. 
                            <br>
                            Mohon coba lagi.
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <button id="dismiss-error" class="w-full px-4 py-2 text-sm font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                            Coba lagi
                        </button>
                    </div>
                </div>
            `;

            overlay.appendChild(card);

            // Add to body
            document.body.appendChild(overlay);

            // Function to dismiss overlay
            function dismissOverlay() {
                window.location.href = 'login.php';
            }

            // Add click events to dismiss
            overlay.addEventListener('click', function(event) {
                // Dismiss if clicking outside the card
                if (event.target === overlay) {
                    dismissOverlay();
                }
            });

            // Add click event to the button
            const dismissButton = card.querySelector('#dismiss-error');
            dismissButton.addEventListener('click', dismissOverlay);

            // Prevent card click from closing the overlay
            card.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        }

        // Check for the error query parameter
        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            if (params.has('error')) {
                createErrorOverlay();
            }
        });
    </script>
</body>

</html>