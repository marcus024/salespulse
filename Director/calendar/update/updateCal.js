async function saveCalendarLinks() {
    const fieldOneValue = document.getElementById('fieldOne').value; // Outlook
    const fieldTwoValue = document.getElementById('fieldTwo').value; // Google

    // In a real app, you'd get the current userId from session or context
    const userId = document.getElementById('currentUser').value; // Example placeholder

    try {
        const response = await fetch('calendar/update/updateCal.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                userId,
                outlookLink: fieldOneValue,
                googleLink: fieldTwoValue
            })
        });
        const data = await response.json();

        if (response.ok) {
            // Success Alert
            alert('Calendar links updated successfully!');
            console.log(data.message); // For debugging
        } else {
            // Error Alert
            alert(`Failed to update calendar links: ${data.message}`);
            console.error(data.message);
        }
    } catch (error) {
        // Network or unexpected errors
        console.error('Fetch error:', error);
        alert('An error occurred while updating calendar links. Please try again later.');
    }
}

// Attach this to your buttons
document.getElementById('saveButton1').addEventListener('click', saveCalendarLinks);
document.getElementById('saveButton2').addEventListener('click', saveCalendarLinks);
