<?php 
session_start();
include("../auth/db.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sales Pulse</title>
    <link rel="icon" href="../images/logo_blue.ico" type="image/x-icon">
    <!-- Font Awesome -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap (use only one version) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/spcomfloat.css" rel="stylesheet">
    <link href="css/spcomnav.css" rel="stylesheet">
    <link href="css/spcomsidebar.css" rel="stylesheet">
    <link href="css/spcomfooter.css" rel="stylesheet">
    <link href="css/spcomnotif.css" rel="stylesheet">
    <link href="css/spcomprofile.css" rel="stylesheet">
    <link href="css/spcommodal.css" rel="stylesheet">
    <link href="css/spcomtable.css" rel="stylesheet">
    <link href="css/spcomcard.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #15151a;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        .container-fluid {
            max-width: 100%;
            padding: 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .tracker-container {
            background: #1e1e26;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(255, 255, 255, 0.1);
        }

        .input-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: none;
            font-size: 14px;
        }

        .timer {
            text-align: center;
            font-size: 40px; /* Larger than previous */
            font-weight: bold;
            margin-bottom: 15px;
        }

        .btn {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .start-btn {
            background-color: yellow;
            color: black;
        }

        .stop-btn {
            background-color: red;
            color: white;
        }

        .task-details-widget {
            background-color: #2c2c2c;
            padding: 20px;
            color: white;
            border-radius: 8px;
        }

        .task-details-widget h3 {
            margin-bottom: 15px;
        }

        .task-container {
            background-color: #333;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 8px;
            color: white;
        }

        .task-container .task-title {
            font-weight: bold;
            font-size: 18px;
        }

        .task-container .task-details {
            font-size: 16px;
            margin-top: 5px;
        }

        /* Make task containers bigger */
        .task-container .task-title, .task-container .task-details p {
            font-size: 18px;
        }

        .task-container .task-details p strong {
            font-size: 16px;
        }
        .task-list {
            margin-top: 20px;
            max-height: 400px; /* Adjust the height as needed */
            overflow-y: auto; /* Enables vertical scrolling */
            padding-right: 10px; /* Adds some padding for the scrollbar */
        }
    </style>
    
</head>
<body id="page-top" style="background-color:#15151a;">
    <!-- Page Wrapper -->
    <div id="wrapper" style="background-color:#15151a;">
        <!-- Sidebar -->
        <ul class="navbar-nav floating-sidebar" id="accordionSidebar" style="background-color:#1f2024; width: 200px; transition: all 0.3s; padding-left: 20px;">
            <!-- Sidebar - Brand -->
            <div 
                class="d-flex align-items-center mx-1" 
                id="salespulse" 
                style="font-weight: bold; font-family: 'Poppins';"
                >
                <!-- The image outside the text element -->
                <img
                    id="sidebarToggleIcon"
                    src="../images/logo_white.png"
                    alt="Toggle Sidebar"
                    onclick="toggleSidebar()"
                    style="cursor: pointer; width: 24px; height: 24px; margin-right: 10px;"
                />
                <!-- The text -->
                <span>SALES PULSE</span>
            </div>
            <div style="height: 0.5px;"></div>
            <!-- Divider -->
            <hr class="sidebar-divider my-2">
            <!-- Nav Items -->
            <li class="nav-item" >
                <a class="nav-link selected" href="director.php" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-home"></i>
                    <span style="font-size:13px; font-family:'Poppins'; ">Home</span>
                </a>
            </li>
            <li class="nav-item" >
                <a class="nav-link" href="calendar.php" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-calendar-alt" style="white"></i>
                    <span style="font-size:13px; font-family:'Poppins';">Calendar</span>
                </a>
            </li>
            <li class="nav-item" >
                <a class="nav-link" href="contacts.php" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-address-book"></i>
                    <span style="font-size:13px; font-family:'Poppins';">Contacts</span>
                </a>
            </li>
            <li class="nav-item" >
                <a class="nav-link" href="team.php" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-users"></i>
                    <span style="font-size:13px; font-family:'Poppins'; ">Team Members</span>
                </a>
            </li>
            <li class="nav-item" >
                <a class="nav-link" href="spcom.php" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-money-bill-wave"></i>
                    <span style="font-size:13px; font-family:'Poppins'; ">Commissions</span>
                </a>
            </li>
            <li class="nav-item active" >
                <a class="nav-link" href="spclock.php" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-money-bill-wave"></i>
                    <span style="font-size:13px; font-family:'Poppins'; ">WorkPulse</span>
                </a>
            </li>
            <!-- Spacer to Push Footer to Bottom -->
            <li style="flex-grow: 1;"></li>
            <li class="nav-item footer">
                <span class="powered-by">Powered by</span>
                <span class="company-name">WORKFORCE NEXTGEN</span><br>
                <span>&copy; <span id="current-year"></span></span>
            </li>
        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content" style="background-color:white;">
                <!-- Topbar -->
                <div id="topbartoggle" class="d-flex justify-content-between align-items-center fixed-top" style="background-color:#15151a; padding-right:30px; padding-left:220px; z-index: 300;">
                    <!-- Left Section: Home and Welcome Message -->
                    <div class="d-flex align-items-center" style="margin-top: 30px;"> <!-- Added margin-top to lower the left section -->
                        <div>
                            <h1 style="color:#73726e; font-family:'Poppins'; font-weight:bold; margin-bottom: 1px;">WorkPulse</h1> <!-- Reduced spacing -->
                            <!-- <p style="font-size:15px; color: #555; font-family:'Poppins'; margin: 0px;">Welcome Back <?php echo $_SESSION['user_name']; ?>!</p> -->
                        </div>
                    </div>
                    <!-- Right Section: Notification and Profile -->
                    <div class="d-flex align-items-center">
                        <!-- Notification Button -->
                        <div class="mr-2" style="position: relative;">
                            <!-- Notification Button -->
                            <button id="notification-button" style="color: #f9ce45; padding-right: 50px; position: relative; background: none; border: none; cursor: pointer;">
                                <img src="../images/notif_yellow.png" alt="Notification" style="height: 20px; width: 20px;">
                                <span id="notification-count" style="
                                    font-family: 'Poppins', sans-serif; 
                                    font-weight: bold; 
                                    font-size: 10px; 
                                    color: white; 
                                    background: red; 
                                    border-radius: 10px; 
                                    padding: 2px 6px; 
                                    position: absolute; 
                                    top: -5px; 
                                    right: 35px;">
                                </span>
                            </button>
                            <!-- Dropdown Container (Initially hidden) -->
                            <div id="notification-dropdown" 
                                style="
                                    display: none; 
                                    position: absolute; 
                                    top: 40px; 
                                    right: 0; 
                                    width: 220px; 
                                    background-color: #fff; 
                                    border: 1px solid #ccc; 
                                    border-radius: 5px; 
                                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                                ">
                                <h6 style=" color: black; padding: 8px; margin: 0; border-bottom: 1px solid #ccc; font-size: 14px;">Notifications</h6>

                                <!-- Notification Items -->
                                <div class="notify" id="notifs" style="padding: 8px; font-size: 13px; color: #555; max-height: 200px; overflow-y: auto;"></div>
                                <div style="text-align: center; border-top: 1px solid #ccc; padding: 8px;">
                                    <a href="#" id="toggleNotifications"  style="font-size: 12px; color: #36b9cc; text-decoration: none;">Show All Alerts</a>
                                </div>
                            </div>
                        </div>
                        <!-- Profile Name and Picture -->
                        <div class="d-flex align-items-center">
                            <div>
                                <!-- User Name -->
                                <p style="margin: 0; font-size:15px; font-family:'Poppins'; color:#555;">
                                    <?php echo $_SESSION['user_name']; ?>
                                </p>
                                <!-- User Position -->
                                <p style="margin: 0; font-size:10px; font-family:'Poppins'; color:lightgray;">
                                    <?php echo $_SESSION['position']; ?>
                                </p>
                            </div>
                            <img src="<?php echo $_SESSION['image']; ?>" alt="Profile Picture" class="rounded-circle" style="width: 40px; height: 40px; margin-left: 10px; cursor: pointer;" onclick="togglePopup()">
                        </div>
                        <!-- Popup Container -->
                        <div id="popup-container" 
                            class="popup" 
                            style="position: absolute; top: 50px; right: 0; width: 200px; background-color: #fff; border: 1px solid #ccc; border-radius: 8px; padding: 10px; display: none; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                            <nav style="display: flex; flex-direction: column; font-family: 'Poppins'; font-size: 14px;">
                                <a href="#" class="popup-link" onclick="showProfile()">Profile</a>
                                <a href="#" class="popup-link" >Settings</a>
                                <a href="#" class="popup-link logout-link" data-bs-toggle="modal" data-bs-target="#outLog">Logout</a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="container-fluid" style="background-color:#15151a;">
                    <div class="row">
                        <!-- Left Side: Time Tracker -->
                        <div class="col-md-4">
                            <div class="tracker-container">
                                <!-- Project Selection -->
                                <div class="input-group">
                                    <label>Auxiliaries</label>
                                    <select id="projectSelect">
                                        <option value="Auxiliary 1">Auxiliary 1</option>
                                        <option value="Auxiliary 2">Auxiliary 2</option>
                                        <option value="Auxiliary 3">Auxiliary 3</option>
                                    </select>
                                </div>

                                <!-- Timer -->
                                <div class="timer" id="timer">00:00:00</div>

                                <!-- Start/Stop Button -->
                                <button id="startStopBtn" class="btn start-btn" onclick="toggleTimer()">Start</button>
                            </div>
                        </div>

                        <!-- Right Side: Task Details Widget -->
                        <div class="col-md-8">
                            <div class="task-details-widget" style="width:400px;">
                                <p style="font-size:15px; font-weight:bold;">Task Details</p>
                                <div style="max-height: 400px; overflow-y: auto;">
                                    <div id="taskDetailsContainer" class="p-2 rounded-md shadow-md" style="height:100px">
                                        <!-- Task containers will be appended here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="outLog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="font-size: 15px; font-family:'Poppins'; color:#36b9cc">Ready to Leave?</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style=" font-size:13px; color:#555; font-family:'Poppins'">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" style="font-size:15px; font-family:'Poppins';">Cancel</button>
                    <a class="btn " style="font-size:15px; font-family:'Poppins'; color: white; background: #36b9cc" href="../auth/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Results Modal -->
    <!-- Modal Structure -->
    <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel">Calculation Results</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background:#1f2024;">
                <p><strong>Total Commission Rate:</strong> <span id="totalComRate"></span></p>
                <p><strong>Individual Commission Rate:</strong> <span id="individualComRate"></span></p>
                <p><strong>Commission Value:</strong> <span id="commissionValue"></span></p>
                <p><strong>Actual Commission:</strong> <span id="actualCommission"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveBtn">Save</button>
            </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript -->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages -->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Bootstrap and Popper.js (Use the CDN for the latest version) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script> -->
    <script src="toogleNav.js"></script>
    <script src="alerts/notif.js"></script>
    <script src="alerts/notifCount.js"></script>
    <script src="current_year.js"></script>
    <script src="fetchprojects/fetch_com_table.js"></script>
    <script src="fetchprojects/fetch_charts.js"></script>
    <script>
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
    </script>
    <script>
       let timerInterval;
let seconds = 0;
let isRunning = false;
let startTime;

// Fetch task data from the backend and display it
function fetchTaskData() {
    fetch('dirback/fetch_task_time.php') // Adjust the path if necessary
        .then(response => response.json())
        .then(data => {
            data.forEach(task => {
                displayTask(task.project, new Date(task.start), new Date(task.end));
            });
        })
        .catch(error => console.error('Error fetching task data:', error));
}

function displayTask(projectName, start, stop) {
    const taskDetailsContainer = document.getElementById('taskDetailsContainer');
    const startTimeFormatted = formatDateTime(start);
    const stopTimeFormatted = formatDateTime(stop);
    const duration = calculateDuration(start, stop);

    const taskContainer = document.createElement('div');
    taskContainer.classList.add('task-container');
    taskContainer.style.borderBottom = "1px solid #ddd";
    taskContainer.style.padding = "5px";

    taskContainer.innerHTML = `
        <div class="task-title" style="font-size:12px; font-weight:bold">${projectName}</div>
        <div class="task-details">
            <p style="font-size:10px;"><strong style="font-size:10px;">Start:</strong> ${startTimeFormatted}</p>
            <p style="font-size:10px;"><strong style="font-size:10px;">End:</strong> ${stopTimeFormatted}</p>
            <p style="font-size:10px;"><strong style="font-size:10px;">Duration:</strong> ${duration}</p>
        </div>
    `;

    taskDetailsContainer.prepend(taskContainer); // Add to the top

    // Auto-scroll to the latest task
    const scrollContainer = taskDetailsContainer.parentElement;
    scrollContainer.scrollTop = 0;
}


function calculateDuration(start, stop) {
    const durationInSeconds = Math.floor((stop - start) / 1000); // Difference in seconds
    const hrs = String(Math.floor(durationInSeconds / 3600)).padStart(2, '0');
    const mins = String(Math.floor((durationInSeconds % 3600) / 60)).padStart(2, '0');
    const secs = String(durationInSeconds % 60).padStart(2, '0');
    return `${hrs}:${mins}:${secs}`;
}

function toggleTimer() {
    const button = document.getElementById('startStopBtn');
    const projectName = document.getElementById('projectSelect').value;

    if (isRunning) {
        clearInterval(timerInterval);
        button.textContent = "Start";
        button.classList.remove('stop-btn');
        button.classList.add('start-btn');

        const stopTime = new Date();
        recordTask(projectName, startTime, stopTime);

    } else {
        seconds = 0;
        updateTimerDisplay();

        timerInterval = setInterval(updateTimer, 1000);
        button.textContent = "Stop";
        button.classList.remove('start-btn');
        button.classList.add('stop-btn');

        startTime = new Date();
    }
    isRunning = !isRunning;
}

function updateTimer() {
    seconds++;
    updateTimerDisplay();
}

function updateTimerDisplay() {
    const hrs = String(Math.floor(seconds / 3600)).padStart(2, '0');
    const mins = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
    const secs = String(seconds % 60).padStart(2, '0');
    document.getElementById('timer').textContent = `${hrs}:${mins}:${secs}`;
}

function recordTask(projectName, start, stop) {
    const startTimeFormatted = formatDateTime(start);
    const stopTimeFormatted = formatDateTime(stop);

    // Send task data to backend
    fetch('dirback/save_task_time.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            project: projectName,
            startTime: startTimeFormatted,
            endTime: stopTimeFormatted
        })
    })
    .then(response => response.text())
    .then(data => console.log(data))
    .catch(error => console.error('Error:', error));

    // Display task data in containers
    displayTask(projectName, start, stop);
}

function formatDateTime(date) {
    return date.toLocaleDateString() + " " + date.toLocaleTimeString();
}

// Fetch task data when page loads
window.onload = fetchTaskData;

    </script>

   
</body>
</html>