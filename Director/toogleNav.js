function toggleSidebar() {
    const sidebar = document.getElementById('accordionSidebar');
    const body = document.body; // Access the body element
    const topbar = document.getElementById('topbartoggle');
    const tablCard = document.getElementById('table-card-collapse');
    const  logo = document.getElementById('salespulse');

    // Toggle the 'collapsed' class
    if (sidebar.classList.contains('collapsed')) {
        sidebar.classList.remove('collapsed');
        sidebar.style.width = '200px';
        
        body.style.paddingLeft = '200px';
        topbar.style.paddingLeft = '220px';
        sidebar.querySelectorAll('span').forEach(span => {
            span.style.display = 'inline';
        });
        tablCard.style.width = '690px'; 
        logo.style.display ='';
    } else {
        sidebar.classList.add('collapsed');
        sidebar.style.width = '75px';
        
        body.style.paddingLeft = '75px';
        topbar.style.paddingLeft = '100px';
        sidebar.querySelectorAll('span').forEach(span => {
            span.style.display = 'none';
        });
        tablCard.style.width = '900px';
        logo.style.display ='none';
    }
}
