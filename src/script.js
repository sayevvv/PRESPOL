// Transition div
function transitionToPage(pageNumber) {
    const page1 = document.getElementById('page1');
    const page2 = document.getElementById('page2');

    // Determine which pages to animate
    const exitPage = pageNumber === 2 ? page1 : page2;
    const enterPage = pageNumber === 2 ? page2 : page1;

    // Ensure the enter page is visible
    enterPage.classList.remove('hidden');

    // GSAP Timeline for transition
    const tl = gsap.timeline();

    tl.to(exitPage, {
        duration: 0.5,
        x: pageNumber === 2 ? '-100%' : '100%',
        ease: 'power2.inOut'
    })
    .fromTo(enterPage, 
        { x: pageNumber === 2 ? '100%' : '-100%' }, 
        {
            duration: 0.5,
            x: '0%',
            ease: 'power2.inOut'
        }, 
        0 // Start this animation at the same time as the exit animation
    )
    .then(() => {
        // Hide the exit page after transition
        exitPage.classList.add('hidden');
    });
}

// --
document.addEventListener('DOMContentLoaded', function() {
    // Select all tab buttons
    const tabButtons = document.querySelectorAll('[data-tab]');
    
    // Select all tab content sections
    const tabContents = document.querySelectorAll('.tab-content');

    // Add click event listener to each tab button
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Get the tab name from the data-tab attribute
            const tabName = button.getAttribute('data-tab');

            // Reset all buttons to default state
            tabButtons.forEach(btn => {
                btn.classList.remove('text-orange-600', 'border-orange-500');
                btn.classList.add('text-gray-700', 'border-gray-200');
            });

            // Activate current button
            button.classList.remove('text-gray-700', 'border-gray-200');
            button.classList.add('text-orange-600', 'border-orange-500');

            // Hide all tab contents
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Show the selected tab content
            const selectedContent = document.getElementById(`${tabName}-content`);
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
            }
        });
    });

    // AOS
    const sections = document.querySelectorAll('.animate-fadeIn');

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('opacity-100');
          }
        });
      },
      { threshold: 0.5 }
    );

    sections.forEach((section) => {
      section.classList.add('opacity-0'); // Hide initially
      observer.observe(section);
    });

    // Pagination --
    const signupForm = document.getElementById('signupForm');
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');

    // Step 1 Next Button
    const step1NextBtn = step1.querySelector('button');
    step1NextBtn.addEventListener('click', () => {
        // Validate Step 1 inputs
        const username = document.getElementById('username');
        const password = document.getElementById('password');
        const confirmPw = document.getElementById('confirmPw');

        // Basic validation
        let isValid = true;

        // Username validation
        if (username.value.trim() === '') {
            isValid = false;
            username.classList.add('border-red-500');
        } else {
            username.classList.remove('border-red-500');
        }

        // Password validation
        if (password.value.trim() === '') {
            isValid = false;
            password.classList.add('border-red-500');
        } else {
            password.classList.remove('border-red-500');
        }

        // Confirm password validation
        if (confirmPw.value.trim() === '') {
            isValid = false;
            confirmPw.classList.add('border-red-500');
        } else if (password.value !== confirmPw.value) {
            isValid = false;
            confirmPw.classList.add('border-red-500');
            // Optional: Show error message
            alert('Passwords do not match');
        } else {
            confirmPw.classList.remove('border-red-500');
        }

        // If all validations pass, move to step 2
        if (isValid) {
            step1.classList.add('hidden');
            step2.classList.remove('hidden');
        }
    });

    // Step 2 Buttons
    const step2BackBtn = step2.querySelector('button:first-child');
    const step2SubmitBtn = step2.querySelector('button[type="submit"]');

    // Back Button Functionality
    step2BackBtn.addEventListener('click', () => {
        step2.classList.add('hidden');
        step1.classList.remove('hidden');
    });

    // Tooltip functionality
    const tooltipButton = document.getElementById('tooltipButton');
    const tooltip = document.getElementById('tooltip');

    tooltipButton.addEventListener('mouseenter', () => {
        tooltip.classList.remove('hidden');
    });

    tooltipButton.addEventListener('mouseleave', () => {
        tooltip.classList.add('hidden');
    });

    // Form Submission
    signupForm.addEventListener('submit', (event) => {
        event.preventDefault();

        // Validate all inputs in step 2
        const additionalInfoInputs = step2.querySelectorAll('input:not([type="file"]), select');
        const fileInput = document.getElementById('dropzone-file');
        let isValid = true;

        // Validate additional info inputs
        additionalInfoInputs.forEach(input => {
            if (input.value.trim() === '') {
                isValid = false;
                input.classList.add('border-red-500');
            } else {
                input.classList.remove('border-red-500');
            }
        });

        // File upload validation
        if (!fileInput.files.length) {
            isValid = false;
            fileInput.closest('label').classList.add('border-red-500');
        } else {
            fileInput.closest('label').classList.remove('border-red-500');

            // Additional file validation
            const file = fileInput.files[0];
            const validTypes = ['image/jpeg', 'image/png', 'image/svg+xml'];
            const maxSize = 2 * 1024 * 1024; // 2MB

            if (!validTypes.includes(file.type)) {
                isValid = false;
                alert('Invalid file type. Please upload .jpg, .jpeg, .png, or .svg');
                fileInput.value = ''; // Clear the file input
            }

            if (file.size > maxSize) {
                isValid = false;
                alert('File is too large. Maximum size is 2MB');
                fileInput.value = ''; // Clear the file input
            }
        }

        // If all validations pass, submit form
        if (isValid) {
            // Here you would typically handle form submission
            // For now, just show a success message
            alert('Form submitted successfully!');
            // You can replace this with actual form submission logic
            // signupForm.submit(); // Uncomment for actual submission
        }
    });

    // File input change event
    const dropzoneFile = document.getElementById('dropzone-file');
    dropzoneFile.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            // Optional: Add visual feedback for file selection
            const fileLabel = event.target.closest('label');
            fileLabel.querySelector('h2').textContent = file.name;
        }
    });

    // Define the program study options for each major
    const prodiOptions = {
        'an': ['D-III Administrasi Bisnis', 'D-IV Bahasa Inggris Untuk Industri Pariwisata', 'D-IV Bahasa Inggris untuk Komunikasi Bisnis dan Profesional', 'D-IV Manajemen Pemasaran', 'D-IV Pengelolaan Arsip dan Rekaman Informasi', 'D-IV Usaha Perjalanan Wisata'],
        'ak': ['D-III Akuntansi', 'D-IV Akuntansi Manajeman', 'D-IV Keuangan', 'S-2 Sistem Informasi Akuntansi'],
        'elektro': ['D-III Teknik Elektronika', 'D-III Teknik Listrik', 'D-III Teknik Telekomunikasi', 'D-IV Jaringan Telekomunikasi Digital', 'D-IV Sistem Kelistrikan', 'D-IV Teknik Elektronika', 'S-2 Teknik Elektro'],
        'tekkim': ['D-III Teknik Kimia', 'D-IV Teknik Kimia'],
        'mesin': ['D-III Teknik Mesin', 'D-III Teknologi Pemeliharaan Pesawat Udara', 'D-IV Teknik Mesin Produksi dan Perawatan', 'D-IV Teknik Otomotif Elektronik', 'S-2 Rekayasa Teknologi Manufaktur'],
        'sipil': ['D-III Teknik Sipil', 'D-III Teknologi Konstruksi Jalan, Jembatan, dan Bangunan Air', 'D-III Teknologi Pertambangan', 'D-IV Manajemen Rekayasa Konstruksi', 'D-IV Teknologi Rekayasa Konstruksi Jalan dan Jembatan'],
        'ti': ['D-II Pengembangan Piranti Lunak Situs', 'D-IV Sistem Informasi Bisnis', 'D-IV Teknik Informatika', 'S-2 Rekayasa Teknologi Informasi']
    };

    // Get references to the dropdowns
    const jurusanDropdown = document.getElementById('jurusan');
    const prodiDropdown = document.getElementById('prodi');

    // Add event listener to jurusan dropdown
    jurusanDropdown.addEventListener('change', function() {
        // Clear existing options
        prodiDropdown.innerHTML = '<option value="">Pilih Program Studi</option>';
        
        // Get the selected jurusan
        const selectedJurusan = this.value;

        // If a jurusan is selected, populate the prodi dropdown
        if (selectedJurusan && prodiOptions[selectedJurusan]) {
            prodiOptions[selectedJurusan].forEach(prodi => {
                const option = document.createElement('option');
                option.value = prodi.toLowerCase().replace(/\s+/g, '-');
                option.textContent = prodi;
                prodiDropdown.appendChild(option);
            });
            prodiDropdown.disabled = false;
        } else {
            prodiDropdown.disabled = true;
        }
    });
    
    // Function to create password toggle functionality
    function setupPasswordToggle(toggleSelector, passwordSelector) {
        const togglePassword = document.querySelector(toggleSelector);
        const password = document.querySelector(passwordSelector);

        if (togglePassword && password) {
            togglePassword.addEventListener('click', function () {
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