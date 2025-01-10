

    // Wait for the DOM to fully load
    document.addEventListener('DOMContentLoaded', (event) => {
        const yearSpan = document.getElementById('current-year');
        const currentYear = new Date().getFullYear();
        yearSpan.textContent = currentYear;
    });