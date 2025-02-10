
    function toggleMenu() {
        const menu = document.querySelector('.nav-menu'); // Select the navigation menu
        const overlay = document.querySelector('.menu-overlay'); // Select the overlay

        // Toggle the 'active' class for both the menu and overlay
        menu.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    // Close the menu when clicking on any menu item
    document.querySelectorAll('.nav-menu li a').forEach(link => {
        link.addEventListener('click', () => {
            const menu = document.querySelector('.nav-menu');
            const overlay = document.querySelector('.menu-overlay');

            // Remove the 'active' class to close both menu and overlay
            menu.classList.remove('active');
            overlay.classList.remove('active');
        });
    });






    document.addEventListener("DOMContentLoaded", () => {
        const wrapper = document.querySelector(".images-wrapper");
        const scrollLeftBtn = document.querySelector(".scroll-left");
        const scrollRightBtn = document.querySelector(".scroll-right");
        const images = Array.from(wrapper.querySelectorAll("img")); // Convert NodeList to Array
    
        const imageWidth = images[0].offsetWidth; // Width of one image
        const imageGap = parseInt(getComputedStyle(wrapper).gap) || 0; // Gap between images
        const scrollStep = imageWidth + imageGap; // Scroll exactly one image at a time
    
        // Clone images for circular scrolling
        images.forEach((img) => wrapper.appendChild(img.cloneNode(true))); // Clone at the end
        images.forEach((img) => wrapper.insertBefore(img.cloneNode(true), wrapper.firstChild)); // Clone at the start
    
        const totalImages = wrapper.querySelectorAll("img").length;
        const maxScroll = scrollStep * images.length; // Scroll distance for one full loop
    
        // Initialize scroll position to the center of the clones
        let scrollAmount = maxScroll;
        wrapper.style.transform = `translateX(-${scrollAmount}px)`;
    
        // Auto-scroll functionality
        let autoScrollInterval = null;
    
        const startAutoScroll = () => {
            if (autoScrollInterval) clearInterval(autoScrollInterval); // Clear any existing interval
            autoScrollInterval = setInterval(() => {
                scrollRight(false); // Don't stop auto-scroll when triggered by the interval
            }, 2000); // Auto-scroll every 2 seconds
        };
    
        const stopAutoScroll = () => {
            if (autoScrollInterval) {
                clearInterval(autoScrollInterval);
                autoScrollInterval = null;
            }
        };
    
        const scrollLeft = (restartAuto = true) => {
            if (restartAuto) stopAutoScroll();
            scrollAmount -= scrollStep;
            wrapper.style.transition = "transform 0.5s ease-in-out";
            wrapper.style.transform = `translateX(-${scrollAmount}px)`;
    
            // Check for seamless jump to end
            if (scrollAmount <= 0) {
                setTimeout(() => {
                    wrapper.style.transition = "none";
                    scrollAmount = maxScroll;
                    wrapper.style.transform = `translateX(-${scrollAmount}px)`;
                }, 500); // Match the transition duration
            }
    
            if (restartAuto) startAutoScroll();
        };
    
        const scrollRight = (restartAuto = true) => {
            if (restartAuto) stopAutoScroll();
            scrollAmount += scrollStep;
            wrapper.style.transition = "transform 0.5s ease-in-out";
            wrapper.style.transform = `translateX(-${scrollAmount}px)`;
    
            // Check for seamless jump to start
            if (scrollAmount >= maxScroll * 2) {
                setTimeout(() => {
                    wrapper.style.transition = "none";
                    scrollAmount = maxScroll;
                    wrapper.style.transform = `translateX(-${scrollAmount}px)`;
                }, 500); // Match the transition duration
            }
    
            if (restartAuto) startAutoScroll();
        };
    
        // Attach event listeners for buttons
        scrollLeftBtn.addEventListener("click", () => scrollLeft());
        scrollRightBtn.addEventListener("click", () => scrollRight());
    
        // Start auto-scroll initially
        startAutoScroll();
    });
    
