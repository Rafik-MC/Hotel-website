document.addEventListener("DOMContentLoaded", function () {
    const content = document.querySelector('.entry-content'); // Adjust selector as needed
    if (!content) return;

    const headings = content.querySelectorAll('h2, h3, h4, h5, h6');
    if (headings.length === 0) return;

    const toc = document.createElement('ol');
    toc.classList.add('monawp-toc-list');

    headings.forEach((heading, index) => {
        const id = `monawp-toc-h-${index}`;
        heading.setAttribute('id', id);

        const link = document.createElement('a');
        link.setAttribute('href', `#${id}`);
        link.textContent = heading.textContent;
        link.setAttribute('aria-label', `Table of contents link to ${heading.textContent}`);

        const listItem = document.createElement('li');
        listItem.appendChild(link);
        toc.appendChild(listItem);
    });

    const tocContainer = document.querySelector('.monawp-toc-container');
    if (tocContainer) {
        tocContainer.appendChild(toc);
    }

    // Function to handle smooth scroll with offset
    function scrollWithOffset(event) {
        event.preventDefault();
        const targetId = event.currentTarget.getAttribute('href').substring(1);
        const targetElement = document.getElementById(targetId);
        const offset = calculateOffset(); // Calculate the offset

        if (targetElement) {
            const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
            const offsetPosition = elementPosition - offset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    }

    // Add event listeners to TOC links for custom scroll behavior
    const tocLinks = toc.querySelectorAll('a');
    tocLinks.forEach(link => {
        link.addEventListener('click', scrollWithOffset);
    });

    // Function to calculate the offset
    function calculateOffset() {
        const masthead = document.querySelector('#masthead.site-header');
		const adminBar = document.querySelector('#wpadminbar');
        const isSticky = window.getComputedStyle(masthead).position === 'sticky';
        const mastheadHeight = masthead.offsetHeight;
        const additionalOffset = adminBar ? 42 : 10;
		if (isSticky) {
			return mastheadHeight + additionalOffset;
		} else {
			return additionalOffset;
		}
    }
});
