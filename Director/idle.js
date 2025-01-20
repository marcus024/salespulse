const idleTimeLimit = 10000; // 1 minute = 60000 milliseconds
const timeoutLimit = 10000; // 10 seconds to respond to the popup

let idleTime = 0; // Track the idle time
let logoutTimer; // Timer for automatic logout after 10 seconds
let idlePopupTimeout; // To track popup timeout

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
    popup.style.boxShadow = '0px 4px 5px rgba(0, 0, 0, 0.2)';
    popup.style.zIndex = '9999';
    popup.style.textAlign = 'center';

    popup.innerHTML = `
        <h3  style="color:black; font-size:20px; font-family:'Poppins';">Your session is about to expire due to inactivity.</h3>
        <p style="color:black; font-size:15px; font-family:'Poppins';">Do you want to continue or log out?</p>
        <button id="continueButton" 
        style="font-family:'Poppins'; font-size:15px; color:#36b9cc; background-color:white; padding:10px 20px; border:2px solid #36b9cc; border-radius:5px; cursor:pointer; transition: all 0.3s ease-in-out;">
            Continue
        </button>
        <button id="logoutButton" 
                style="font-family:'Poppins'; font-size:15px; color:white; background-color:#36b9cc; padding:10px 20px; border:2px solid #36b9cc; border-radius:5px; cursor:pointer; transition: all 0.3s ease-in-out;">
            Log Out
        </button>
        <style>
            #continueButton:hover {
                background-color: #36b9cc;
                color: white;
                transform: scale(1.05); /* Slightly enlarge the button */
            }

            #logoutButton:hover {
                background-color: white;
                color: #36b9cc;
                transform: scale(1.05); /* Slightly enlarge the button */
            }
        </style>


    `;

    document.body.appendChild(popup);

    // Set a timer to log out after 10 seconds if no action
    idlePopupTimeout = setTimeout(logout, timeoutLimit);

    // If the user clicks "Continue", reset the timers and close the popup
    document.getElementById('continueButton').addEventListener('click', function() {
       
        closePopup();

    });

    // If the user clicks "Log Out", log them out immediately
    document.getElementById('logoutButton').addEventListener('click', function() {
        clearTimeout(idlePopupTimeout); // Stop the logout timer
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
