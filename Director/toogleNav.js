function toggleSidebar() {
    const sidebar = document.getElementById('accordionSidebar');
    const body = document.body; // Access the body element
    const topbar = document.getElementById('topbartoggle');

    // Toggle the 'collapsed' class
    if (sidebar.classList.contains('collapsed')) {
        sidebar.classList.remove('collapsed');
        sidebar.style.width = '200px';
        body.style.paddingLeft = '200px';
        topbar.style.paddingLeft = '220px';
        sidebar.querySelectorAll('span').forEach(span => {
            span.style.display = 'inline';
        });
    } else {
        sidebar.classList.add('collapsed');
        sidebar.style.width = '75px';
        body.style.paddingLeft = '75px';
        topbar.style.paddingLeft = '100px';
        sidebar.querySelectorAll('span').forEach(span => {
            span.style.display = 'none';
        });
    }
}
