function togglePopup() {
        const popup = document.getElementById('popup-container');
        popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
    }
    function showProfile() {
        window.location.href = "viewprofile.php";
    }
    // Hide the popup when clicking outside
    document.addEventListener('click', function (event) {
        const popup = document.getElementById('popup-container');
        if (!event.target.closest('#popup-container') && !event.target.closest('img')) {
            popup.style.display = 'none';
        }
    });