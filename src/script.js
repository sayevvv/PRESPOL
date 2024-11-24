document.addEventListener('DOMContentLoaded', function() {
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

    const tooltipButton = document.getElementById('tooltipButton');
    const tooltip = document.getElementById('tooltip');
    let isTooltipVisible = false;

    // Toggle tooltip on button click
    tooltipButton.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent form submission
        isTooltipVisible = !isTooltipVisible;
        tooltip.classList.toggle('hidden');
    });

    // Close tooltip when clicking outside
    document.addEventListener('click', function(e) {
        if (isTooltipVisible && !tooltipButton.contains(e.target) && !tooltip.contains(e.target)) {
            tooltip.classList.add('hidden');
            isTooltipVisible = false;
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
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
});

// Include the transition script from the layout
function navigateToPage(url) {
    const overlay = document.querySelector('.transition-overlay');
    
    const tl = gsap.timeline({
        onComplete: () => {
            sessionStorage.setItem('isTransitioning', 'true');
            window.location.href = url;
        }
    });
    
    tl.to(overlay, {
        left: 0,
        duration: 0.6,
        ease: 'power2.inOut'
    });
}

window.addEventListener('load', () => {
    const overlay = document.querySelector('.transition-overlay');
    const isTransitioning = sessionStorage.getItem('isTransitioning');
    
    if (isTransitioning) {
        gsap.set(overlay, { left: 0 });
        
        gsap.to(overlay, {
            left: '100%',
            duration: 0.6,
            ease: 'power2.inOut',
            onComplete: () => {
                gsap.set(overlay, { left: '-100%' });
                sessionStorage.removeItem('isTransitioning');
            }
        });
    }
});