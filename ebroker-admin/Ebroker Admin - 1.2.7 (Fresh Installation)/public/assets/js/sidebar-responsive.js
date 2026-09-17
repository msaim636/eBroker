/**
 * Responsive Sidebar Toggle Functionality
 * Handles mobile sidebar open/close with overlay
 */

(function() {
    'use strict';

    // Wait for DOM to be ready and ensure other scripts have loaded
    function initSidebar() {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarCloseBtn = document.querySelector('.sidebar-close-btn');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        // Check if elements exist
        if (!sidebar || !sidebarToggle) {
            return;
        }

        // Toggle sidebar function
        function toggleSidebar() {
            const isActive = sidebar.classList.contains('active');
            
            if (isActive) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }

        // Open sidebar function
        function openSidebar() {
            sidebar.classList.add('active');
            if (sidebarOverlay) {
                sidebarOverlay.classList.add('active');
            }
            
            // Prevent body scroll on mobile
            if (window.innerWidth <= 767.98) {
                document.body.style.overflow = 'hidden';
            }
        }

        // Close sidebar function
        function closeSidebar() {
            sidebar.classList.remove('active');
            if (sidebarOverlay) {
                sidebarOverlay.classList.remove('active');
            }
            
            // Restore body scroll
            document.body.style.overflow = '';
        }

        // Event listeners - use event delegation to avoid conflicts
        document.addEventListener('click', function(e) {
            // Handle burger button click
            if (e.target.closest('#sidebarToggle')) {
                e.preventDefault();
                e.stopPropagation();
                toggleSidebar();
            }
            
            // Handle close button click
            if (e.target.closest('.sidebar-close-btn')) {
                e.preventDefault();
                e.stopPropagation();
                closeSidebar();
            }
            
            // Handle overlay click
            if (e.target === sidebarOverlay) {
                closeSidebar();
            }
        });

        // Close sidebar when clicking on menu items (mobile only)
        document.addEventListener('click', function(e) {
            if (e.target.closest('#sidebarMenu a') && window.innerWidth <= 767.98) {
                closeSidebar();
            }
        });

        // Handle window resize
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                // On desktop, ensure sidebar is open and remove overlay
                if (window.innerWidth >= 768) {
                    sidebar.classList.add('active');
                    if (sidebarOverlay) {
                        sidebarOverlay.classList.remove('active');
                    }
                    document.body.style.overflow = '';
                }
            }, 100);
        });

        // Handle escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('active')) {
                closeSidebar();
            }
        });

        // Initialize sidebar state based on screen size
        function initializeSidebar() {
            if (window.innerWidth >= 768) {
                // Desktop: sidebar should be open by default
                sidebar.classList.add('active');
            } else {
                // Mobile: sidebar should be closed by default
                sidebar.classList.remove('active');
            }
        }

        // Initialize on load
        initializeSidebar();
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSidebar);
    } else {
        // DOM is already ready
        initSidebar();
    }

    // Also initialize after a short delay to ensure other scripts have loaded
    setTimeout(initSidebar, 100);

})();
