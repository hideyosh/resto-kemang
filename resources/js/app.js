import './bootstrap';
import { initNavbar } from './modules/navbar';
import { initMenu } from './modules/menu';
import { initReservation } from './modules/reservation';
import { initOrder } from './modules/order';

/**
 * Initialize page-specific functionality on DOM ready
 */
document.addEventListener('DOMContentLoaded', () => {
    // Initialize navbar for all pages
    initNavbar();

    // Initialize page-specific modules based on current page
    const currentPath = window.location.pathname;

    if (currentPath.includes('/menu')) {
        initMenu();
    } else if (currentPath.includes('/reservation')) {
        initReservation();
    } else if (currentPath.includes('/order')) {
        initOrder();
    }
});
