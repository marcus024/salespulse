document.addEventListener("DOMContentLoaded", () => {
    let gcalendarLink = ''; // Store the calendar link
    const currentUserId = document.getElementById('currentUser').value; // Fetch the current user ID from the hidden input field

    if (!currentUserId) {
        console.error('Current user ID is not available.');
        return;
    }

    // Fetch calendar information for the current user
    fetch('calendar/google/check_gcal.php', {
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
            const gcalendarButton = document.getElementById('gCalButton');

            if (!gcalendarButton) {
                console.error('Calendar button not found in the DOM.');
                return;
            }

            if (data.hasCalendar) {
                // If calendar exists, set the link and display the button
                gcalendarLink = data.calendarLink; // Assign to local variable
                gcalendarButton.style.display = 'block';
                gcalendarButton.onclick = () => addgCalendar(gcalendarLink); // Pass the correct value
            } else {
                // If no calendar link, show modal to input the link
                gcalendarButton.style.display = 'block';
                gcalendarButton.onclick = () => {
                    const modal = new bootstrap.Modal(document.getElementById('addGCal'));
                    modal.show();
                };
            }
        })
        .catch(error => {
            console.error('Error fetching calendar data:', error);
            const calendarButton = document.getElementById('gCalButton');
            if (calendarButton) calendarButton.style.display = 'block';
        });

    // Handle calendar form submission to save calendar link
    document.getElementById('gcalendarForm').addEventListener('submit', (e) => {
        e.preventDefault();
        const calendarLinkInput = document.getElementById('gcalendarLink').value;

        if (!calendarLinkInput) {
            alert('Please enter a valid calendar link.');
            return;
        }

        fetch('calendar/google/save_gcal.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ gcalendarLink: calendarLinkInput, guserId: currentUserId })
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
    window.addgCalendar = function (glink) {
        const calendarContainer = document.getElementById('calendar-container');

        if (!calendarContainer) {
            console.error('Calendar container not found in the DOM.');
            return;
        }

        calendarContainer.innerHTML = ''; // Clear previous calendar content

        if (!glink) {
            console.error('Invalid calendar link provided.');
            calendarContainer.innerHTML = '<p>Error: No calendar link available.</p>';
            return;
        }

        // Validate and ensure the link is in the correct format
        const isValidGoogleLink = glink.includes('https://calendar.google.com/calendar/embed');
        if (!isValidGoogleLink) {
            console.error('Provided link is not a valid Google Calendar embed link.');
            calendarContainer.innerHTML = '<p>Error: Invalid Google Calendar link.</p>';
            return;
        }

        console.log('Embedding Google Calendar with link:', glink);

        const iframe = document.createElement('iframe');
        iframe.style.width = '100%';
        iframe.style.height = '390px';
        iframe.style.border = '1px solid white';
        iframe.style.borderRadius = '5px';
        iframe.src = glink; // Set the validated and formatted link

        calendarContainer.appendChild(iframe);
    };
});
