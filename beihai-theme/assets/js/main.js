/**
 * Beihai Blog Theme - Main JavaScript
 *
 * @package Beihai_Blog
 */

(function () {
    'use strict';

    /**
     * DOM Ready
     */
    document.addEventListener('DOMContentLoaded', function () {
        initHeaderScroll();
        initMobileMenu();
        initMobileSearch();
        initAuthorFloatWidget();
        initThemeToggle();
        initSmoothScroll();
    });

    /**
     * Header scroll effect
     * Add 'scrolled' class to header when page is scrolled
     */
    function initHeaderScroll() {
        const header = document.querySelector('.site-header');
        if (!header) return;

        const scrollThreshold = 50;

        function updateHeaderState() {
            if (window.scrollY > scrollThreshold) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }

        // Initial check
        updateHeaderState();

        // Listen for scroll events with passive listener for better performance
        window.addEventListener('scroll', updateHeaderState, { passive: true });
    }

    /**
     * Mobile menu toggle
     * Show/hide mobile navigation menu
     */
    function initMobileMenu() {
        const menuToggle = document.querySelector('.menu-toggle');
        const navMenu = document.querySelector('.nav-menu');

        if (!menuToggle || !navMenu) return;

        menuToggle.addEventListener('click', function () {
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            
            menuToggle.setAttribute('aria-expanded', !isExpanded);
            navMenu.classList.toggle('active');
            menuToggle.classList.toggle('active');

            // Toggle menu icon animation
            const spans = menuToggle.querySelectorAll('span');
            if (navMenu.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
            } else {
                spans[0].style.transform = '';
                spans[1].style.opacity = '';
                spans[2].style.transform = '';
            }
        });

        // Close menu when clicking on a link (for anchor links or same-page navigation)
        const menuLinks = navMenu.querySelectorAll('a');
        menuLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                if (navMenu.classList.contains('active')) {
                    menuToggle.click();
                }
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function (event) {
            if (navMenu.classList.contains('active') &&
                !navMenu.contains(event.target) &&
                !menuToggle.contains(event.target)) {
                menuToggle.click();
            }
        });

        // Close menu when pressing Escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && navMenu.classList.contains('active')) {
                menuToggle.click();
            }
        });
    }

    /**
     * Mobile search panel toggle
     * Show/hide mobile search panel
     */
    function initMobileSearch() {
        const searchToggle = document.querySelector('.mobile-search-toggle');
        const searchPanel = document.querySelector('.mobile-search-panel');
        const searchClose = document.querySelector('.mobile-search-close');
        const searchField = document.querySelector('.mobile-search-field');

        if (!searchToggle || !searchPanel) return;

        // Open search panel
        searchToggle.addEventListener('click', function () {
            searchPanel.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Focus on search field after animation
            setTimeout(function () {
                if (searchField) {
                    searchField.focus();
                }
            }, 100);
        });

        // Close search panel function
        function closeSearchPanel() {
            searchPanel.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close button
        if (searchClose) {
            searchClose.addEventListener('click', closeSearchPanel);
        }

        // Close on Escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && searchPanel.classList.contains('active')) {
                closeSearchPanel();
            }
        });

        // Close when clicking outside the search form
        searchPanel.addEventListener('click', function (event) {
            if (event.target === searchPanel) {
                closeSearchPanel();
            }
        });
    }

    /**
     * Author Float Widget
     * Toggle author information floating widget
     */
    function initAuthorFloatWidget() {
        const widget = document.getElementById('authorFloatWidget');
        if (!widget) return;

        const toggle = widget.querySelector('.author-float-toggle');
        const closeBtn = widget.querySelector('.author-float-close');

        if (!toggle) return;

        // Toggle widget on button click
        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            widget.classList.toggle('active');
        });

        // Close on close button click
        if (closeBtn) {
            closeBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                widget.classList.remove('active');
            });
        }

        // Close when clicking outside
        document.addEventListener('click', function (event) {
            if (widget.classList.contains('active') && !widget.contains(event.target)) {
                widget.classList.remove('active');
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && widget.classList.contains('active')) {
                widget.classList.remove('active');
            }
        });

        // Add touch support for mobile devices
        let touchStartY = 0;
        const content = widget.querySelector('.author-float-content');
        
        if (content) {
            content.addEventListener('touchstart', function (e) {
                touchStartY = e.touches[0].clientY;
            }, { passive: true });

            content.addEventListener('touchmove', function (e) {
                const touchY = e.touches[0].clientY;
                const scrollTop = content.scrollTop;
                const scrollHeight = content.scrollHeight;
                const clientHeight = content.clientHeight;

                // Prevent scroll bubbling when at top or bottom
                if ((scrollTop <= 0 && touchY > touchStartY) ||
                    (scrollTop + clientHeight >= scrollHeight && touchY < touchStartY)) {
                    e.preventDefault();
                }
            }, { passive: false });
        }
    }

    /**
     * Theme Toggle (Dark/Light Mode)
     * Toggle between day and night mode with smooth transitions
     */
    function initThemeToggle() {
        const themeToggle = document.getElementById('themeToggle');
        if (!themeToggle) return;

        // Check for saved theme preference or system preference
        const savedTheme = localStorage.getItem('beihai-theme');
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        // Set initial theme
        let isDarkMode = false;
        if (savedTheme) {
            isDarkMode = savedTheme === 'dark';
        } else if (systemPrefersDark) {
            isDarkMode = true;
        }
        
        // Apply initial theme
        applyTheme(isDarkMode);
        
        // Toggle theme on button click
        themeToggle.addEventListener('click', function () {
            isDarkMode = !isDarkMode;
            applyTheme(isDarkMode);
            
            // Save preference
            localStorage.setItem('beihai-theme', isDarkMode ? 'dark' : 'light');
            
            // Announce theme change for screen readers
            const announcement = document.createElement('div');
            announcement.setAttribute('role', 'status');
            announcement.setAttribute('aria-live', 'polite');
            announcement.className = 'sr-only';
            announcement.textContent = isDarkMode ? '已切换到夜间模式' : '已切换到日间模式';
            document.body.appendChild(announcement);
            
            setTimeout(function () {
                document.body.removeChild(announcement);
            }, 1000);
        });
        
        /**
         * Apply theme to document
         * @param {boolean} dark - Whether to apply dark theme
         */
        function applyTheme(dark) {
            if (dark) {
                document.documentElement.setAttribute('data-theme', 'dark');
                themeToggle.setAttribute('aria-pressed', 'true');
            } else {
                document.documentElement.removeAttribute('data-theme');
                themeToggle.setAttribute('aria-pressed', 'false');
            }
        }
        
        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
            // Only apply system preference if user hasn't manually set a preference
            if (!localStorage.getItem('beihai-theme')) {
                isDarkMode = e.matches;
                applyTheme(isDarkMode);
            }
        });
    }

    /**
     * Smooth scroll for anchor links
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
            anchor.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    
                    const headerOffset = 80; // Account for fixed header
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerOffset;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

})();
