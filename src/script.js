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

    
});