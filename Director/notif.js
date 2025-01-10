document.addEventListener('DOMContentLoaded', function() {
    const bellButton = document.getElementById('notification-button');
    const dropdown = document.getElementById('notification-dropdown');

    // Click on the bell button toggles the dropdown
    bellButton.addEventListener('click', function(event) {
        event.stopPropagation();  // Prevent the event from bubbling up to document
        const isVisible = dropdown.style.display === 'block';
        dropdown.style.display = isVisible ? 'none' : 'block';
    });

    // Close dropdown if user clicks outside
    document.addEventListener('click', function(event) {
        // If click is NOT inside the dropdown or on the bell button, hide it
        if (!dropdown.contains(event.target) && event.target !== bellButton) {
            dropdown.style.display = 'none';
        }
    });
});
