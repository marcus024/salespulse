document.addEventListener("DOMContentLoaded", () => {
    let calendarLink = ''; // Store the calendar link
    const currentUserId = document.getElementById('currentUser').value; // Fetch the current user ID from the hidden input field

    if (!currentUserId) {
        console.error('Current user ID is not available.');
        return;
    }

    // Fetch calendar information for the current user
    fetch('calendar/outlook/check_calendar.php', {
        method: 'POST', // Send the user ID as a POST request
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ userId: currentUserId })
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Fetched calendar data:', data); // Log fetched data for debugging
            const calendarButton = document.getElementById('calendarButton');

            if (!calendarButton) {
                console.error('Calendar button not found in the DOM.');
                return;
            }

            if (data.hasCalendar) {
                // If calendar exists, set the link and display the button
                calendarLink = data.calendarLink;
                calendarButton.style.display = 'block';
                calendarButton.onclick = () => addCalendar(calendarLink);
            } else {
                // If no calendar link, show modal to input the link
                calendarButton.style.display = 'block';
                calendarButton.onclick = () => {
                    const modal = new bootstrap.Modal(document.getElementById('addCalendarModal'));
                    modal.show();
                };
            }
        })
        .catch(error => {
            console.error('Error fetching calendar data:', error);
            // Optionally show the button for debugging purposes even if fetch fails
            const calendarButton = document.getElementById('calendarButton');
            if (calendarButton) calendarButton.style.display = 'block';
        });

    // Handle calendar form submission to save calendar link
    document.getElementById('calendarForm').addEventListener('submit', (e) => {
        e.preventDefault();
        const calendarLinkInput = document.getElementById('calendarLink').value;

        if (!calendarLinkInput) {
            alert('Please enter a valid calendar link.');
            return;
        }

        fetch('calendar/outlook/save_calendar.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ calendarLink: calendarLinkInput, userId: currentUserId })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Calendar save response:', data); // Log response for debugging
                if (data.success) {
                    alert('Calendar link saved successfully!');
                    location.reload(); // Reload the page to fetch the updated calendar data
                } else {
                    alert(`Failed to save calendar link: ${data.message || 'Unknown error'}`);
                }
            })
            .catch(error => {
                console.error('Error saving calendar data:', error);
                alert('An error occurred while saving the calendar link.');
            });
    });

    // Function to add the calendar dynamically using the provided link
    window.addCalendar = function (link) {
        const calendarContainer = document.getElementById('calendar-container');

        if (!calendarContainer) {
            console.error('Calendar container not found in the DOM.');
            return;
        }

        // Clear previous calendar content before adding a new one
        calendarContainer.innerHTML = '';

        const iframe = document.createElement('iframe');
        iframe.style.width = '100%';
        iframe.style.height = '390px';
        iframe.style.border = '1px solid white';
        iframe.style.borderRadius = '5px';

        if (!link) {
            console.error('Invalid calendar link provided.');
            calendarContainer.innerHTML = '<p>Error: No calendar link available.</p>';
            return;
        }

        iframe.src = link; // Use the dynamically retrieved link
        calendarContainer.appendChild(iframe);
    };
});
