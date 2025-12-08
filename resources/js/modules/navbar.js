/**
 * Navbar Mobile Menu Toggle
 */
export function initNavbar() {
    const navbarBtn = document.getElementById('navbar-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (navbarBtn && mobileMenu) {
        navbarBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
}
