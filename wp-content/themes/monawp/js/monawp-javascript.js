(function() {
	function setupNavigation(navClass) {
		const siteNavigations = document.querySelectorAll(navClass);

		// Loop through each horizontal navigation
		siteNavigations.forEach(function(siteNavigation) {
			const button = siteNavigation.querySelector('button');

			// Return early if the button or navigation doesn't exist.
			if (!button || !siteNavigation) {
				return;
			}

			const menu = siteNavigation.querySelector('ul');

			// Hide menu toggle button if menu is empty and return early.
			if (!menu) {
				button.style.display = 'none';
				return;
			}

			if (!menu.classList.contains('nav-menu')) {
				menu.classList.add('nav-menu');
			}

			// Toggle the .toggled class and the aria-expanded value each time the button is clicked.
			button.addEventListener('click', function () {
				siteNavigation.classList.toggle('toggled');

				if (button.getAttribute('aria-expanded') === 'true') {
					button.setAttribute('aria-expanded', 'false');
				} else {
					button.setAttribute('aria-expanded', 'true');
				}
			});

			// Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
			document.addEventListener('click', function (event) {
				const isClickInside = siteNavigation.contains(event.target);

				if (!isClickInside) {
					siteNavigation.classList.remove('toggled');
					button.setAttribute('aria-expanded', 'false');
				}
			});

			// Get all the list items within the menu.
			const listItems = menu.querySelectorAll('li');

			// Add "open-left" or "open-right" class based on position from the left or right side of the screen.
			for (const listItem of listItems) {
				const rect = listItem.getBoundingClientRect();
				const windowWidth = window.innerWidth;
				const distanceFromLeft = rect.left;
				const distanceFromRight = windowWidth - rect.right;
				
				if (distanceFromLeft < distanceFromRight) {
					listItem.classList.add('open-left');
				} else {
					listItem.classList.add('open-right');
				}
				
				// Add caret (^) to list items with submenus
				if (listItem.querySelector('ul')) {
					const caret = document.createElement('span');
					caret.textContent = ' ^';
					caret.classList.add('caret');
					listItem.querySelector('a').appendChild(caret);
				}
			}

			// Get all the link elements within the menu.
			const links = menu.getElementsByTagName('a');

			// Get all the link elements with children within the menu.
			const linksWithChildren = menu.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a');

			// Toggle focus each time a menu link is focused or blurred.
			for (const link of links) {
				link.addEventListener('focus', toggleFocus, true);
				link.addEventListener('blur', toggleFocus, true);
			}

			// Toggle focus each time a menu link with children receive a touch event.
			for (const link of linksWithChildren) {
				link.addEventListener('touchstart', toggleFocus, false);
			}

			/**
			 * Sets or removes .focus class on an element.
			 */
			function toggleFocus(event) {
				if (event.type === 'focus' || event.type === 'blur') {
					let self = this;
					// Move up through the ancestors of the current link until we hit .nav-menu.
					while (!self.classList.contains('nav-menu')) {
						// On li elements toggle the class .focus.
						if ('li' === self.tagName.toLowerCase()) {
							self.classList.toggle('focus');
						}
						self = self.parentNode;
					}
				}

				if (event.type === 'touchstart') {
					const menuItem = this.parentNode;
					event.preventDefault();
					for (const link of menuItem.parentNode.children) {
						if (menuItem !== link) {
							link.classList.remove('focus');
						}
					}
					menuItem.classList.toggle('focus');
				}
			}
		});
	}

	// Call the setupNavigation function with the desired navigation class
	setupNavigation('.horizontal-navigation-desktop');

	function toggleElement(clickedElementCss, elementToShowCss, parentElementCss) {
		const clickedElements = document.querySelectorAll(clickedElementCss);
		const elementsToShow = document.querySelectorAll(elementToShowCss);
		const parentElements = document.querySelectorAll(parentElementCss);

		// Check if any of the queried elements are missing
		if (!clickedElements.length || !elementsToShow.length || !parentElements.length) {
			return;
		}

		// Loop through each matched element
		clickedElements.forEach((clickedElement, index) => {
			const elementToShow = elementsToShow[index];
			const parentElement = parentElements[index];

			clickedElement.addEventListener('click', function() {
				// Toggle the 'show' class on the element
				elementToShow.classList.toggle('show');
			});
		});
	}

	toggleElement('.search-element-button', '.search-wrapper', '.monawp_search_element');
	toggleElement('.search-close-button', '.search-wrapper', '.monawp_search_element');
	toggleElement('.left-sidebar-wrapper-toggle', '.left-sidebar-wrapper', '#page.site');
	// Add a click event listener to all code elements
	var codeElements = document.querySelectorAll('code');
	codeElements.forEach(function(codeElement) {
		codeElement.addEventListener('click', function() {
			// Get the text content of the clicked code element
			var codeContent = codeElement.textContent.trim();

			// Copy the text content to the clipboard
			copyTextToClipboard(codeContent);
		});
	});

	// Function to copy text to clipboard
	function copyTextToClipboard(text) {
		// Create a temporary textarea element
		var tempTextarea = document.createElement('textarea');

		// Set the value of the textarea to the text to be copied
		tempTextarea.value = text;

		// Append the textarea to the document body
		document.body.appendChild(tempTextarea);

		// Select the text within the textarea
		tempTextarea.select();

		// Copy the selected text to the clipboard
		document.execCommand('copy');

		// Remove the textarea from the document body
		document.body.removeChild(tempTextarea);
	}
	
	function setWidgetTop() {
	  let totalTop = 0;

	  // Check if the admin bar exists
	  const adminBar = document.querySelector('#wpadminbar');
	  if (adminBar) {
		totalTop += 32;
	  }

	  // Check if .site-header-wrapper exists
	  const siteHeader = document.querySelector('.site-header.monawp-header');
	  if (siteHeader) {
		const siteHeaderPosition = window.getComputedStyle(siteHeader).position;

		// If position is not sticky, add 20px to the top
		if (siteHeaderPosition !== 'sticky') {
		  totalTop += 0;
		} else {
		  // If position is sticky, add the height of .site-header-wrapper to the top
		  const siteHeaderHeight = siteHeader.offsetHeight;
		  totalTop += siteHeaderHeight;
		}
	  }

	  // Check if #right-sidebar.sticky .widget:last-of-type exists
	  const rightSidebarWidget = document.querySelector('#left_sidebar_widget_one .widget__element > *:last-child');
	  if (rightSidebarWidget) {
		rightSidebarWidget.style.top = `${totalTop}px`;
	  }
	  
	  const leftSidebarWidget = document.querySelector('#monawp-right-sidebar .widget__element > *:last-child');
	  if (leftSidebarWidget) {
		leftSidebarWidget.style.top = `${totalTop}px`;
	  }
	  
	}
	
	// Call the function to set the widget's top value
	setWidgetTop();

})();
