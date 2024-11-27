<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page | PRESPOL</title>
    <link rel="icon" href="img/pres.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body class="overflow-x-hidden m-0 p-0">
    <!-- Transition Overlay         -->
    <div class="transition-overlay"></div>

    <div class="bg-gradient-to-b from-white to-orange-100 font-helvetica">
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
    
            <div class="flex items-center w-full max-w-md px-6 mx-auto lg:w-2/6">
                <div class="flex-1">
                    <div class="text-center">
                        <div class="flex justify-center mx-auto">
                            <img onclick="navigateToPage('../index.html')" class="cursor-pointer h-7 sm:h-10" src="img/logoBlack.svg" alt="logo">
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
                                            d="M15 12c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.522 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7s-8.268-2.943-9.542-7z"
                                        />
                                    </svg>
                                </span>
                            </div>
    
                            <div class="mt-6">
                                <button type="submit" class="w-full px-4 py-2 tracking-wide text-white transition-colors duration-300 transform bg-orange-500 rounded-lg hover:bg-orange-400 focus:outline-none focus:bg-orange-400 focus:ring focus:ring-orange-300 focus:ring-opacity-50">
                                    Masuk
                                </button>
                            </div>
                        </form>
                        <p class="mt-6 text-sm text-center text-gray-400">Belum punya akun? <a onclick="navigateToPage('signup.html')" class="cursor-pointer text-orange-500 focus:outline-none focus:underline hover:underline">Daftar</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>