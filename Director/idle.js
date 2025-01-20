
    // Set the idle time threshold (in milliseconds)
    const idleTimeLimit = 30000; // 1 minute = 60000 milliseconds
    let idleTime = 0; // Track the idle time

    // Function to log out the user
    function logout() {
        // Perform the logout action, this could be a redirect to a logout page or an AJAX request to log out
        window.location.href = '../auth/logout.php'; // Replace with your logout page URL or function
    }

    // Function to reset the idle timer
    function resetIdleTimer() {
        idleTime = 0; // Reset idle time to 0
    }

    // Monitor user activity
    window.onload = function() {
        // Increment the idle timer every 1000ms (1 second)
        setInterval(function() {
            idleTime += 1000;
            if (idleTime >= idleTimeLimit) {
                logout(); // Logout after the specified idle time limit
            }
        }, 1000);

        // Monitor mouse movements, clicks, and keypresses to reset the idle timer
        document.onmousemove = resetIdleTimer;
        document.onkeypress = resetIdleTimer;
        document.onclick = resetIdleTimer;
    }
