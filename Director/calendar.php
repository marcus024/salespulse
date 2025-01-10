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

    <title>SALES PULSE</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .sidebar {
            transition: width 0.3s;
        }
        .sidebar.collapsed {
            width: 80px;
        }
        .sidebar.collapsed .nav-item span {
            display: none;
        }
        .sidebar.collapsed .sidebar-brand-text {
            display: none;
        }
        .sidebar.collapsed .sidebar-brand-icon {
            margin: 0 auto;
        }
    </style>
    <style>
        /* Floating sidebar styles */
       .floating-sidebar {
            position: fixed;
            top: 10px;
            left: 10px;
            height: 95vh; /* Adjust the height to be 90% of the viewport height */
            z-index: 1000;
            box-shadow: 2px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 10px; /* Combined padding */
            overflow-y: auto; /* Allow scrolling inside the sidebar */
            display: flex;
        }
        body{
            padding-left:200px;
            padding-bottom:30px;
            padding-top:100px;
            color:white;
        }
    </style>
    <style>
        .nav-item{
            color: white; /* Optional: Adjust text color when the item is active */
            font-weight: bold; /* Optional: Make the active menu text bold */
            border-radius:10px;
            margin-bottom:5px;
        }
        /* Active Nav Item Background Color */
        .nav-item.active .nav-link {
            /* padding-left:10px; */
            background-color: white; /* Change this color to your preferred background color */
            color: #36b9cc; /* Optional: Adjust text color when the item is active */
            font-weight: bold; /* Optional: Make the active menu text bold */
            border-radius:10px;
            margin-bottom:5px;
        }
        /* Hover Effect for Nav Items */
        .nav-item .nav-link:hover {
            /* padding-left:10px; */
            background-color: white; /* Same color for hover effect */
            color: #36b9cc; /* Text color for hover */
            border-radius:10px;
            margin-bottom:5px;
        }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav floating-sidebar" id="accordionSidebar" style="background-color:#36b9cc; width: 200px; transition: all 0.3s; padding-left: 20px;">
            <!-- Sidebar - Brand -->
            <i 
                id="sidebarToggleIcon" 
                class="fas fa-bars" 
                onclick="toggleSidebar()" 
                style="cursor: pointer; font-size: 20px; color: white; margin: 10px;"
            ></i>
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div style="color:white; font-weight:bold; font-family:'Poppins'; font-size:20px">
                    SALES PULSE
                </div>
            </a>
            <div style="height: 0.5px;"></div>
            <!-- Divider -->
            <hr class="sidebar-divider my-2">
            <!-- Nav Items -->
            <li class="nav-item" >
                <a class="nav-link selected" href="director.php" style="border-radius:10px;padding-left:10px;">
                    <i class="fas fa-fw fa-home"></i>
                    <span style="font-size:13px; font-family:'Poppins'; ">Home</span>
                </a>
            </li>
            <li class="nav-item active" >
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
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content" style="background-color:white;">

                <!-- Topbar -->
                <!-- Fixed Topbar -->
                <div id="topbartoggle" class="d-flex justify-content-between align-items-center fixed-top" style="background-color:white; padding-right:30px; padding-left:220px; z-index: 300;">
                    <!-- Left Section: Home and Welcome Message -->
                    <div class="d-flex align-items-center" style="margin-top: 10px;"> <!-- Added margin-top to lower the left section -->
                        <div>
                            <h1 style="color:#36b9cc; font-family:'Poppins'; font-weight:bold; margin-bottom: 1px;">Calendar</h1> <!-- Reduced spacing -->
                            <!-- <p style="font-size:15px; color: #555; font-family:'Poppins'; margin: 0px;">Welcome Back <?php echo $_SESSION['user_name']; ?>!</p> -->
                        </div>
                    </div>

                    <!-- Right Section: Notification and Profile -->
                    <div class="d-flex align-items-center">
                        <!-- Notification Button -->
                        <div class="mr-2">
                            <button class="btn" style="color:#36b9cc;" id="notification-button">
                                <i class="fas fa-bell"></i>
                                <span id="notification-count" class="badge badge-danger">3</span>
                            </button>
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
                        <style>
                            /* Hover effect for profile image */
                            .profile-img:hover {
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                                transform: scale(1.1);
                                transition: all 0.2s ease-in-out;
                            }

                            /* Hover effect for popup links */
                            .popup-link {
                                padding: 8px 0;
                                text-decoration: none;
                                color: #555;
                                margin-bottom: 5px;
                                transition: color 0.2s ease-in-out, background-color 0.2s ease-in-out;
                            }

                            .popup-link:hover {
                                color: #36b9cc;
                                border-radius: 4px;
                                text-decoration:none;
                            }

                            /* Special hover for logout link */
                            .logout-link:hover {
                                color: #36b9cc;
                                text-decoration:none;
                            }
                        </style>
                    </div>
                </div>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <!-- Narrow Container for Add Calendar -->
                        <div class="col-md-3 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <p style="font-family:'Poppins'; font-size:15px; font-weight:700; color:#555">Calendar</p>
                                    <!-- Button for Outlook Calendar -->
                                    <a href="#" class="btn calendar-button w-90" onclick="addCalendar('Outlook')">
                                        <span class="icon">
                                            <img src="../images/outlookcalendar.png" alt="Outlook Calendar Icon" style="width: 30px; height: 30px;">
                                        </span>
                                        <p style="font-size:13px; font-family:'Poppins'; font-weight:bold; padding-left:5px; padding-top:10px">Outlook Calendar</p>
                                    </a>
                                    <hr class="my-2">
                                    <!-- Button for Google Calendar -->
                                    <a href="#" class="btn calendar-button w-90" onclick="addCalendar('Google')">
                                        <span class="icon">
                                            <img src="../images/gcalendar.png" alt="Google Calendar Icon" style="width: 30px; height: 30px;">
                                        </span>
                                        <p style="font-size:13px; font-family:'Poppins'; font-weight:bold; padding-left:5px; padding-top:10px;">Google Calendar</p>
                                    </a>
                                    <!-- Styling remains the same -->
                                    <style>
                                        .calendar-button {
                                            background: #36b9cc;
                                            border: none;
                                            padding: 10px 20px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            border-radius: 10px;
                                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                            transition: all 0.3s ease;
                                            text-decoration: none;
                                            color:white;
                                        }

                                        .calendar-button:hover {
                                            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
                                            transform: translateY(-2px);
                                        }

                                        .calendar-button .icon img {
                                            width: 30px;
                                            height: 30px;
                                        }

                                        .calendar-button:active,
                                        .calendar-button:focus {
                                            outline: none;
                                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                        }

                                        .calendar-button {
                                            text-decoration: none;
                                        }

                                        hr.my-2 {
                                            margin: 10px 0;
                                            border: none;
                                            border-top: 1px solid #ddd;
                                        }
                                    </style>
                                </div>



                            </div>
                        </div>

                        <!-- Wide Container for Calendar Content -->
                        <div class="col-md-9 mb-4">
                            <div class="card shadow-sm" style="background: #36b9cc">
                                <div class="card-body" id="calendar-container" style="min-height: 400px; color: white;">
                                    <h1 class="h5 mb-4">Calendar Content</h1>
                                    <!-- Calendars will be dynamically added here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

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
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Bootstrap and Popper.js (Use the CDN for the latest version) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <!-- Calendar script (if needed in the future) -->
    <!-- <script src="path_to_calendar_script.js"></script> -->
   <script>
    function addCalendar(type) {
    const calendarContainer = document.getElementById('calendar-container');

    // Clear previous calendar content before adding a new one
    calendarContainer.innerHTML = '';

    if (type === 'Outlook') {
        const iframe = document.createElement('iframe');
        iframe.style.width = '100%';
        iframe.style.height = '390px';
        iframe.style.border = '1px solid white';
        iframe.style.borderRadius = '5px';
        iframe.src = "https://outlook.office365.com/owa/calendar/d02aec1836114286a7fad6531c48851c@uas.com.ph/7a3b2b761fab4055a30f896a80c358aa14889519084045600576/calendar.html";
        calendarContainer.appendChild(iframe);
    } else if (type === 'Google') {
        const iframe = document.createElement('iframe');
        iframe.style.width = '100%';
        iframe.style.height = '390px';
        iframe.style.border = '1px solid white';
        iframe.style.borderRadius = '5px';
        iframe.src = "https://calendar.google.com/calendar/embed?src=markantony.calipayan%40ssu.edu.ph&ctz=Asia%2FManila";
        calendarContainer.appendChild(iframe);
    }
}

   </script>
    <script>
        // Toggle sidebar collapse
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            const sidebar = document.getElementById('accordionSidebar');
            sidebar.classList.toggle('collapsed');
        });
    </script>
     <script>
        function togglePopup() {
            const popup = document.getElementById('popup-container');
            popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
        }
        function showProfile() {
            // Redirect or perform action to show the profile
            alert('Navigating to Profile Page');
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
    <script src="toogleNav.js"></script>
</body>
</html>