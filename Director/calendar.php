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
        :root {
            --accent-color: #f9ce45; /* Accent color */
        }

        .nav-item{
            color: #76777a; /* Optional: Adjust text color when the item is active */
            font-weight: bold; /* Optional: Make the active menu text bold */
            border-radius:10px;
            margin-bottom:5px;
        }
        /* Active Nav Item Background Color */
        .nav-item.active .nav-link {
            padding-left:10px;
             background-color: #2a2925; 
            color: white; 
            font-weight: bold; /* Optional: Make the active menu text bold */
            border-radius:10px;
            margin-bottom:5px;
            border-left: 5px solid var(--accent-color);
        }
        /* Hover Effect for Nav Items */
        .nav-item .nav-link:hover {
            padding-left:10px;
            background-color: #2a2925; 
            color: white;
            border-left: 5px solid var(--accent-color);
            border-radius:10px;
            margin-bottom:5px;
            
        }
    </style>
    <style>
        /* Footer Styles */
        .footer {
            padding-bottom: 10px;
            color: #fff;
            font-size: 12px;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center align all footer content */
        }

        .footer .powered-by {
            font-weight: lighter;
        }

        .footer .company-name {
            font-weight: bold;
        }

        .footer .copyright {
            margin-top: 5px; /* Space between company name and copyright */
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
                <!-- Fixed Topbar -->
                <div id="topbartoggle" class="d-flex justify-content-between align-items-center fixed-top" style="background-color:#15151a; padding-right:30px; padding-left:220px; z-index: 300;">
                    <!-- Left Section: Home and Welcome Message -->
                    <div class="d-flex align-items-center" style="margin-top: 30px;"> <!-- Added margin-top to lower the left section -->
                        <div>
                            <h1 style="color:#73726e; font-family:'Poppins'; font-weight:bold; margin-bottom: 1px;">Calendar</h1> <!-- Reduced spacing -->
                            <!-- <p style="font-size:15px; color: #555; font-family:'Poppins'; margin: 0px;">Welcome Back <?php echo $_SESSION['user_name']; ?>!</p> -->
                        </div>
                    </div>

                    <!-- Right Section: Notification and Profile -->
                    <div class="d-flex align-items-center">
                        <div class="mr-2" style="position: relative;">
                            <!-- Notification Button -->
                            <button id="notification-button" style="color: #36b9cc; padding-right: 50px; position: relative; background: none; border: none; cursor: pointer;">
                                <img src="../images/notif.png" alt="Notification" style="height: 20px; width: 20px;">
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
                                <style>
                                /* Optional: Add a border or styling for the scrollable area */
                                    .notify::-webkit-scrollbar {
                                        width: 4px; /* Width of the vertical scrollbar */
                                        height: 4px; /* Height of the horizontal scrollbar */
                                    }

                                    .notify::-webkit-scrollbar-thumb {
                                        background-color: #36b9cc;
                                        border-radius: 10px;
                                        height: 5px; /* Minimum height for the scrollbar thumb */
                                    }

                                    .notify::-webkit-scrollbar-thumb:hover {
                                        background-color: #555;
                                    }
                                </style>
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
                                <input  hidden id="currentUser" value="<?php echo $_SESSION['user_id_c']; ?>">
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
                <div class="container-fluid" style=" background-color:#15151a;">
                    <div class="row">
                        <!-- Narrow Container for Add Calendar -->
                        <div class="col-md-3 mb-4">
                            <div class="card shadow-sm" style="background-color:#1f2024; border:none;">
                                <div class="card-body">
                                    <div class="col align-items-center" style="display: flex; justify-content: space-between;">
                                        <!-- Calendar Text -->
                                        <p style="font-family:'Poppins'; font-size:15px; font-weight:700; color:white; margin: 0;">Calendar</p>
                                        <!-- Edit Button -->
                                        <i class="fas fa-edit edit-icon"
                                        style="font-size: 10px; color: white; cursor: pointer;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"></i>
                                    </div>
                                    <!-- Calendar Button -->
                                    <a href="#" class="btn calendar-button w-90" id="calendarButton" style="background-color:#f9ce45;">
                                        <span class="icon">
                                            <img src="../images/outlookcalendar.png" alt="Outlook Calendar Icon" style="width: 30px; height: 30px;">
                                        </span>
                                        <p style="font-size:13px; font-family:'Poppins';color:#1f2024; font-weight:bold; padding-left:5px; padding-top:10px">Outlook Calendar</p>
                                    </a>
                                    <style>                   
                                        i {
                                            transition: color 0.3s ease, transform 0.3s ease;
                                            cursor: pointer;
                                        }
                                        i:hover {
                                            color: #009394; /* Hover color for edit icon */
                                            transform: scale(1.2); /* Slightly enlarge */
                                        }
                                    </style>
                                    <!-- Edit Calendar Modal -->
                                     <!-- Modal Structure -->
                                    <div
                                        class="modal fade"
                                        id="exampleModal"
                                        tabindex="-1"
                                        aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog" style="width: 420px;">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header" style="background-color:#f9ce45; border:none">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color:#1f2024; font-family:'Poppins'; font-size:15px;">Edit Item</h5>
                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"
                                                ></button>
                                                </div>
                                                <!-- Modal Body with two fields + aligned save buttons -->
                                                <div class="modal-body" style="background-color:#1f2024;">
                                                    <form id="modalForm">
                                                        <!-- Field One + Save -->
                                                        <div class="row mb-3">
                                                            <div class="col-md-8">
                                                                <label for="fieldOne" class="form-label" style="color:#555; font-family:'Poppins'; font-size:12px; font-weight:bold;">Outlook Calendar Link</label>
                                                                <input
                                                                type="text"
                                                                class="form-control"
                                                                id="fieldOne"
                                                                placeholder="Enter first value" style="color:white; background-color:#1f2024; font-family:'Poppins'; font-size:12px;"
                                                                />
                                                            </div>
                                                            <div class="col-md-4 d-flex align-items-end">
                                                                <button
                                                                type="button"
                                                                class="btn btn-primary w-100 mt-4 mt-md-0 button-cal"
                                                                id="saveButton1"
                                                                data-bs-dismiss="modal" 
                                                                >
                                                                Save
                                                                </button>
                                                            </div>
                                                            </div>
                                                            <!-- Field Two + Save -->
                                                            <div class="row mb-3">
                                                            <div class="col-md-8">
                                                                <label for="fieldTwo" class="form-label" style="color:#555; font-family:'Poppins'; font-size:12px; font-weight:bold;">Google Calendar Link</label>
                                                                <input
                                                                type="text" style="color:white; background-color:#1f2024; font-family:'Poppins'; font-size:12px;"
                                                                class="form-control"
                                                                id="fieldTwo"
                                                                placeholder="Enter second value"
                                                                />
                                                            </div>
                                                            <div class="col-md-4 d-flex align-items-end">
                                                                <button
                                                                type="button"
                                                                class="btn btn-success w-100 mt-4 mt-md-0 button-cal"
                                                                id="saveButton2"
                                                                data-bs-dismiss="modal" 
                                                                >
                                                                Save
                                                                </button>
                                                            <style>
                                                                .button-cal{
                                                                border: none; 
                                                                color:#1f2024; 
                                                                background-color: #f9ce45; 
                                                                font-family:'Poppins'; 
                                                                font-size:12px;
                                                                }
                                                                .button-cal:hover{
                                                                    background:#006272;
                                                                }
                                                                
                                                            </style>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal for Inputting Calendar Link -->
                                    <div class="modal fade" id="addCalendarModal" tabindex="-1" aria-labelledby="addCalendarModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background:#f9ce45; border:none;">
                                                    <h5 class="modal-title" style="font-weight:bold; font-size:12px; font-family:'Poppins'; color:#1f2024;" id="addCalendarModalLabel">Add Calendar Link</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style=" background:#1f2024;">
                                                    <form id="calendarForm">
                                                        <div class="mb-3">
                                                            <label for="calendarLink" style="font-size:12px; color:#555; font-weight:bold; font-family:'Poppins';" class="form-label">Calendar Link</label>
                                                            <input type="url" class="form-control" style="background:#1f2024; color:white; " id="calendarLink" required>
                                                        </div>
                                                        <button type="submit" class="btn" style="background:#f9ce45; color:#1f2024; font-family:'Poppins'; font-size:15px;">Save</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-2">
                                    <!-- Button for Google Calendar -->
                                    <a href="#" class="btn calendar-button w-90" id="gCalButton" style=" background-color:#f9ce45;">
                                        <span class="icon">
                                            <img src="../images/gcalendar.png" alt="Google Calendar Icon" style="width: 30px; height: 30px;">
                                        </span>
                                        <p style="font-size:13px; font-family:'Poppins'; color:#1f2024;  font-weight:bold; padding-left:5px; padding-top:10px;">Google Calendar</p>
                                    </a>
                                    <!-- Modal for Inputting Calendar Link -->
                                    <div class="modal fade" id="addGCal" tabindex="-1" aria-labelledby="addCalendarModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background:#f9ce45; border:none;">
                                                    <p class="modal-title" style="font-weight:bold; font-size:12px; font-family:'Poppins'; color:#1f2024;" id="addCalendarModalLabel">Add Calendar Link</p>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style=" background:#1f2024;">
                                                    <form id="gcalendarForm">
                                                        <div class="mb-3">
                                                            <label for="calendarLink" style="font-size:12px; color:#555; font-weight:bold; font-family:'Poppins';" class="form-label">Calendar Link</label>
                                                            <input type="url" class="form-control" style="background:#1f2024; color:white;" id="gcalendarLink" required>
                                                        </div>
                                                        <button type="submit" class="btn" style="background:#f9ce45; color:#1f2024; font-family:'Poppins'; font-size:15px;">Save</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-2">
                                   <!-- Trigger Button -->
                                    <!-- Trigger Button -->
                                    <a href="#" class="btn calendar-button w-90 text-center" data-bs-toggle="modal" data-bs-target="#calendarGuideModal" 
                                    style="font-size: 13px; font-family: 'Poppins'; background-color:#f9ce45; color:#1f2024;  font-weight: bold; text-decoration: none;">
                                        Guide to Add Calendar
                                    </a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="calendarGuideModal" tabindex="-1" aria-labelledby="calendarGuideModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="calendarGuideModalLabel" style="font-family:'Poppins'; color:#555; font-size:15px">User Guide to Add a Calendar</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <!-- Modal Body -->
                                                <div class="modal-body">
                                                    <!-- Tab Navigation -->
                                                    <ul class="nav nav-tabs" id="calendarGuideTabs" role="tablist">
                                                        <li class="nav-item">
                                                            <button style ="font-size:12px; font-family:'Poppins'" class="nav-link active" id="google-tab" data-bs-toggle="tab" data-bs-target="#google" type="button" role="tab" aria-controls="google" aria-selected="true">
                                                                Google Calendar
                                                            </button>
                                                        </li>
                                                        <li class="nav-item">
                                                            <button style ="font-size:12px; font-family:'Poppins'" class="nav-link" id="outlook-tab" data-bs-toggle="tab" data-bs-target="#outlook" type="button" role="tab" aria-controls="outlook" aria-selected="false">
                                                                Outlook Calendar
                                                            </button>
                                                        </li>
                                                    </ul>

                                                    <!-- Tab Content -->
                                                    <div class="tab-content mt-3" id="calendarGuideTabContent">
                                                        <!-- Google Calendar Tab -->
                                                        <div class="tab-pane fade show active" id="google" role="tabpanel" aria-labelledby="google-tab">
                                                            <div id="googleCarousel" class="carousel slide" data-bs-ride="carousel">
                                                                <div class="carousel-inner">
                                                                    <div class="carousel-item active">
                                                                        <img src="../images/1.png" class="d-block w-100" alt="Google Calendar Step 1">
                                                                    </div>
                                                                    <div class="carousel-item">
                                                                        <img src="../images/2.png" class="d-block w-100" alt="Google Calendar Step 2">
                                                                    </div>
                                                                    <div class="carousel-item">
                                                                        <img src="../images/3.png" class="d-block w-100" alt="Google Calendar Step 3">
                                                                    </div>
                                                                    <div class="carousel-item">
                                                                        <img src="../images/4.png" class="d-block w-100" alt="Google Calendar Step 4">
                                                                    </div>
                                                                </div>
                                                                <button class="carousel-control-prev" type="button" data-bs-target="#googleCarousel" data-bs-slide="prev">
                                                                    <span class="carousel-control-prev-icon" aria-hidden="true" style="color: #36b9cc;"></span>
                                                                    <span class="visually-hidden">Previous</span>
                                                                </button>
                                                                <button class="carousel-control-next" type="button" data-bs-target="#googleCarousel" data-bs-slide="next">
                                                                    <span class="carousel-control-next-icon" aria-hidden="true" style="color: #36b9cc;"></span>
                                                                    <span class="visually-hidden">Next</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <!-- Outlook Calendar Tab -->
                                                        <div class="tab-pane fade" id="outlook" role="tabpanel" aria-labelledby="outlook-tab">
                                                            <div id="outlookCarousel" class="carousel slide" data-bs-ride="carousel">
                                                                <div class="carousel-inner">
                                                                    <div class="carousel-item active">
                                                                        <img src="../images/6.png" class="d-block w-100" alt="Outlook Calendar Step 1">
                                                                    </div>
                                                                    <div class="carousel-item">
                                                                        <img src="../images/7.png" class="d-block w-100" alt="Outlook Calendar Step 2">
                                                                    </div>
                                                                    <div class="carousel-item">
                                                                        <img src="../images/8.png" class="d-block w-100" alt="Outlook Calendar Step 3">
                                                                    </div>
                                                                    
                                                                </div>
                                                                <button class="carousel-control-prev" type="button" data-bs-target="#outlookCarousel" data-bs-slide="prev">
                                                                    <span class="carousel-control-prev-icon" aria-hidden="true" style="color: #dc3545;"></span>
                                                                    <span class="visually-hidden">Previous</span>
                                                                </button>
                                                                <button class="carousel-control-next" type="button" data-bs-target="#outlookCarousel" data-bs-slide="next">
                                                                    <span class="carousel-control-next-icon" aria-hidden="true" style="color: #dc3545;"></span>
                                                                    <span class="visually-hidden">Next</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




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
                            <div class="card shadow-sm" style="background: #f9ce45; border:none;">
                                <div class="card-body" id="calendar-container" style="min-height: 400px; color: white;">
                                    <h1 class="h5 mb-4" style="color:#1f2024;">Calendar Content</h1>
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
     <script src="calendar/outlook/calendar.js"></script>
     <script src="calendar/google/gcalendar.js"></script>
    <script src="alerts/notif.js"></script>
    <script src="notif.js"></script>
    <script src="alerts/notifCount.js"></script>
    <script src="calendar/update/updateCal.js"></script>
    <script src="current_year.js"></script>
     
   
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