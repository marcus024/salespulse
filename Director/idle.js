
    const idleTimeLimit = 60000; // 1 minute = 60000 milliseconds
    const timeoutLimit = 10000; // 10 seconds to respond to the popup

    let idleTime = 0; // Track the idle time
    let timeoutPopup; // Reference to timeout for popup
    let logoutTimer; // Timer for automatic logout after 10 seconds

    // Function to log out the user
    function logout() {
        // Perform the logout action, this could be a redirect to a logout page or an AJAX request to log out
        window.location.href = '../auth/logout.php'; // Replace with your logout page URL or function
    }

    // Function to show the popup and ask if the user wants to continue or logout
    function showPopup() {
        const popup = document.createElement('div');
        popup.id = 'idlePopup';
        popup.style.position = 'fixed';
        popup.style.top = '50%';
        popup.style.left = '50%';
        popup.style.transform = 'translate(-50%, -50%)';
        popup.style.backgroundColor = '#fff';
        popup.style.padding = '20px';
        popup.style.borderRadius = '10px';
        popup.style.boxShadow = '0px 4px 10px rgba(0, 0, 0, 0.2)';
        popup.style.zIndex = '9999';
        popup.style.textAlign = 'center';

        popup.innerHTML = `
            <h3>Your session is about to expire due to inactivity.</h3>
            <p>Do you want to continue or log out?</p>
            <button id="continueButton">Continue</button>
            <button id="logoutButton">Log Out</button>
        `;

        document.body.appendChild(popup);

        // Set a timer to log out after 10 seconds if no action
        logoutTimer = setTimeout(logout, timeoutLimit);

        // If the user clicks "Continue", reset the timers and close the popup
        document.getElementById('continueButton').addEventListener('click', function() {
            clearTimeout(logoutTimer); // Stop the logout timer
            closePopup();
            resetIdleTimer(); // Reset the idle timer
        });

        // If the user clicks "Log Out", log them out immediately
        document.getElementById('logoutButton').addEventListener('click', function() {
            clearTimeout(logoutTimer); // Stop the logout timer
            closePopup();
            logout(); // Log out the user
        });
    }

    // Function to close the popup
    function closePopup() {
        const popup = document.getElementById('idlePopup');
        if (popup) {
            popup.remove();
        }
    }

    // Function to reset the idle timer
    function resetIdleTimer() {
        idleTime = 0; // Reset idle time to 0
    }

    // Monitor user activity (mouse movements, key presses, and clicks)
    function monitorActivity() {
        setInterval(function() {
            idleTime += 1000; // Increase idle time by 1 second

            if (idleTime >= idleTimeLimit) {
                showPopup(); // Show the inactivity popup if idle time exceeds limit
            }
        }, 1000);

        document.onmousemove = resetIdleTimer;
        document.onkeypress = resetIdleTimer;
        document.onclick = resetIdleTimer;
    }

    // Start monitoring user activity when the page loads
    window.onload = function() {
        monitorActivity(); // Start tracking user activity
    };
