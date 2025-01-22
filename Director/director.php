<!DOCTYPE html>
<?php 
session_start();
include("../auth/db.php");
?>
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

    <!-- Bootstrap CSS (use only one version) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        }
        #myTable {
            width: 100%;
            border-collapse: collapse;
        }
        #myTable th, #myTable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .action-buttons button {
            margin: 0 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px; /* Set font size to 9px */
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            color: #333;
        }

        /* Header Style */
        table th {
            background-color: #36b9cc;
            color: white;
            font-weight: bold;
        }

        /* Table Row Hover Effect */
        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Search Box */
        #searchInput {
            margin-bottom: 15px;
            padding: 8px;
            width: 250px;
            font-size: 9px;
            border: 1px solid #36b9cc;
            border-radius: 4px;
            outline: none;
        }

        #searchInput:focus {
            border-color: #007b7f;
        }

        .pagination {
            display: inline-block;
            margin-top: 10px;
        }

        .pagination a {
            padding: 5px 10px;
            margin: 0 5px;
            text-decoration: none;
            border: 1px solid #ddd;
            color: #36b9cc;
            border-radius: 4px;
            font-size:10px;
        }
        .pagination a.active {
            background-color: #36b9cc;
            color: white;
            border: 1px solid #36b9cc;
        }
        .pagination a:hover {
            background-color: #007b7f;
            color: white;
        }

        /* Buttons for each row */
        .action-buttons {
            display: flex;
            justify-content: space-around;
        }

        .action-buttons button {
            padding: 4px 8px;
            font-size: 8px;
            cursor: pointer;
            border: 1px solid #36b9cc;
            border-radius: 4px;
            background-color: white;
            color: #36b9cc;
            transition: background-color 0.3s, color 0.3s;
        }

        .action-buttons button:hover {
            background-color: #36b9cc;
            color: white;
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            #searchInput {
                width: 100%;
            }

            table th, table td {
                padding: 6px;
            }

            .pagination {
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            table th, table td {
                font-size: 8px;
                padding: 4px;
            }

            .pagination a {
                padding: 4px 8px;
            }

            .action-buttons button {
                padding: 3px 6px;
                font-size: 7px;
            }
        }
    </style>
    <!-- Card Style --> 
    <style>
    .rectangle-card {
        width: calc(25% - 4px); 
        height: 90px;
        background-color:#f9ce45;
        box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        padding: 10px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        transition: all 0.3s ease;
        
    }
    .card-title {
        font-size: 12px;
        font-weight: bold;
        color:black;
        text-transform: uppercase;
        margin-bottom: 3px;
    }

    .card-number {
        font-size: 40px;
        font-weight: bold;
        color:black;
    }

    .card-icon {
        font-size: 40px;
        color: black;
        margin-right: 10px;
    }
    .card-content {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        flex-grow: 1;
        
    }
    .rectangle-card:hover {
        transform: translateY(-5px);
        box-shadow: 4px 6px 12px rgba(0, 0, 0, 0.3);
    }
    .sidebar.collapsed ~ .rectangle-card {
        width: 80%;
        max-width: 120px;
    }
    @media (max-width: 768px) {
        .rectangle-card {
            width: calc(100% - 10px);
            height: auto;
            padding: 10px;
        }

        .card-title {
            font-size: 10px;
        }

        .card-number {
            font-size: 30px;
        }

        .card-icon {
            font-size: 30px;
        }
    }

    @media (max-width: 480px) {
        .rectangle-card {
            width: 100%;
            padding: 8px;
        }

        .card-title,
        .card-number,
        .card-icon {
            font-size: 50%;
        }
    }
    </style>
    <style>
       .floating-sidebar {
            position: fixed;
            top: 10px;
            left: 10px;
            height: 95vh; 
            z-index: 1000;
            box-shadow: 2px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 10px; 
            overflow-y: auto;
            display: flex;
        }
        body{
            padding-left:200px;
            padding-bottom:30px;
            padding-top:50px;
            color:black;
        }
    </style>
    <style>
        .sidebar.collapsed {
            width: 50px;
            overflow: hidden;
        }
        .sidebar.collapsed .nav-link span {
            display: none; 
        }
        .sidebar.collapsed #sidebarToggleBtn {
            display: block;
        }
        .sidebar {
            width: 200px;
            transition: all 0.3s;
        }
        .sidebar:not(.collapsed) #sidebarToggleBtn {
            display: none;
        }
    </style>
    <!-- navbarstyle -->
    <style>
    :root {
        --accent-color: #f9ce45; /* Accent color */
    }

    /* General nav-item styling */
    .nav-item {
        color: #76777a; 
        font-weight: bold;
        border-radius: 10px;
        margin-bottom: 5px;
    }

    /* Active nav-item */
    .nav-item.active .nav-link {
        background-color: #2a2925; 
        color: white; 
        font-weight: bold;
        border-radius: 10px;
        margin-bottom: 5px;
        border-left: 5px solid var(--accent-color); /* Accent color on the left */
        padding-left: 10px; 
    }

    /* Hover state for nav-link */
    .nav-item .nav-link:hover {
        background-color: #2a2925; 
        color: white;
        border-left: 5px solid var(--accent-color); /* Accent color on hover */
        border-radius: 10px;
        margin-bottom: 5px;
        padding-left: 10px; 
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
        <!-- Sidebar -->
        <ul class="navbar-nav floating-sidebar" id="accordionSidebar" style="background-color:#1f2024; width: 200px; transition: all 0.3s; padding-left: 20px;">
            <!-- Sidebar - Brand -->
            <!-- <i 
                id="sidebarToggleIcon" 
                class="fas fa-bars" 
                onclick="toggleSidebar()" 
                style="cursor: pointer; font-size: 20px; color: white; margin: 10px;"
            ></i> -->
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
                <span style="color:white;">SALES PULSE</span>
            </div>
            <!-- <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div style="color:white; font-weight:bold; font-family:'Poppins'; font-size:20px">
                    SALES PULSE
                </div>
            </a> -->
            <div style="height: 0.5px;"></div>
            <!-- Divider -->
            <hr class="sidebar-divider my-2">
            <!-- Nav Items -->
            <li class="nav-item active" >
                <a class="nav-link selected" href="" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-home"></i>
                    <span style="font-size:13px; font-family:'Poppins'">Home</span>
                </a>
            </li>
            <li class="nav-item" >
                <a class="nav-link" href="calendar.php" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-calendar-alt"></i>
                    <span style="font-size:13px; font-family:'Poppins'">Calendar</span>
                </a>
            </li>
            <li class="nav-item" >
                <a class="nav-link" href="contacts.php" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-address-book"></i>
                    <span style="font-size:13px; font-family:'Poppins'">Contacts</span>
                </a>
            </li>
            <li class="nav-item" >
                <a class="nav-link" href="team.php" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-users"></i>
                    <span style="font-size:13px; font-family:'Poppins'">Team Members</span>
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
               <!-- Fixed Topbar -->
                <div id="topbartoggle" class="d-flex justify-content-between align-items-center fixed-top" style="background-color:#15151a; padding-right:30px; padding-left:220px; z-index: 300;">
                    <!-- Left Section: Home and Welcome Message -->
                    <div class="d-flex align-items-center" style="margin-top: 10px;"> <!-- Added margin-top to lower the left section -->
                        <div>
                            <h1 style="color:#73726e; font-family:'Poppins'; font-weight:bold; margin-bottom: 1px;">Home</h1> <!-- Reduced spacing -->
                            <p style="font-size:15px; color: white; font-family:'Poppins'; margin: 0px;">
                                Welcome Back, 
                                <span style="font-weight: 800;">
                                    <?php echo $_SESSION['user_name']; ?>!
                                </span>
                            </p>
                        </div>
                    </div>
                    <!-- Right Section: Notification and Profile -->
                    <div class="d-flex align-items-center">
                        <!-- Notification Button -->
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
                                <h6 style=" color: black; padding: 8px; margin: 0; border-bottom: 1px solid #ccc; font-size: 14px; font-family:'Poppins'">Notifications</h6>

                                <!-- Notification Items -->
                                <div class="notify" id="notifs" style="padding: 8px; font-size: 13px; color: #555; max-height: 200px; overflow-y: auto;"></div>
                                <div style="text-align: center; border-top: 1px solid #ccc; padding: 8px;">
                                    <a href="#" id="toggleNotifications"  style="font-size: 12px; color: #36b9cc; text-decoration: none;">Show All Alerts</a>
                                </div>
                                <style>
                                    .notify::-webkit-scrollbar {
                                        width: 4px; 
                                        height: 4px; 
                                    }
                                    .notify::-webkit-scrollbar-thumb {
                                        background-color: #36b9cc;
                                        border-radius: 10px;
                                        height: 5px; 
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
                            </div>
                            <img src="<?php echo $_SESSION['image']; ?>" alt="Profile Picture" class="rounded-circle" style="width: 40px; height: 40px; margin-left: 10px; cursor: pointer;" onclick="togglePopup()">
                        </div>
                        <!-- Popup Container -->
                        <div id="popup-container" 
                            class="popup" 
                            style="position: absolute; top: 50px; right: 0; width: 200px; background-color: #fff; border: 1px solid #ccc; border-radius: 8px; padding: 10px; display: none; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                            <nav style="display: flex; flex-direction: column; font-family: 'Poppins'; font-size: 14px;">
                                <a href="#" class="popup-link" onclick="showProfile()">Profile</a>
                                <a href="#" class="popup-link">Settings</a>
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
                <!-- Home Content -->
                <div class="container-fluid" style="padding-top: 50px; background-color:#15151a;">
                    <div class="d-flex" style="width: 100%;">

                    <div class="row g-0">
                        <!-- Column for Add Project -->
                        <div class="col-auto" >
                            <div class="card shadow-sm" id="collapsible-card" style="background-color:#1f2024; width: 330px; transition: width 0.3s ease; border:none;">
                                <div class="card-body">
                                    <div  class="d-flex justify-content-between align-items-center">
                                        <p id="project-collapse" style="font-family: 'Poppins'; color: #555; font-size: 15px; font-weight: 700;">Projects</p>
                                    </div>
                                    <div class="col-12 mb-3" id="card-content">
                                        <div class="d-flex justify-content-between align-items-center">
                                        <!-- LEFT END: Add Project Button (opens modal) -->
                                        <a href="#" class="btn btn-info btn-icon-split w-70 add-btn-p"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addProjectModal" id="addProjectBtn" style="border:none; background-color: #f9ce45">
                                        <span class="icon text-white-0" id="icon-col">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <style>
                                            .icon i {
                                            background: none;
                                            border: none;
                                            padding: 0;
                                            margin: 0;
                                            box-shadow: none;
                                            display: inline-block;
                                            color: black;
                                            font-size: 15px;
                                            }
                                        </style>
                                        <span id="addProjectBtnText" class="text" style="color: black; font-family: 'Poppins'; font-size: 15px;">
                                            Add Project
                                        </span>
                                        </a>
                                        
                                        <!-- RIGHT END: Toggle Arrow Button -->
                                        <button onclick="toggleCardWidth()" class="btn" type="button">
                                        <i id="toggle-icon" class="fas fa-chevron-left" style="color: #f9ce45"></i>
                                        </button>
                                    </div>
                                        <hr class="sidebar-divider my-3">
                                        <!-- Dynamic Navbar -->
                                        <style>
                                            .nav-tabs {
                                                background-color:black;
                                                transition: background-color 0.3s ease;
                                                border-radius: 10px;
                                                padding: 8px; /* Adjusted for consistent spacing */
                                                gap: 8px; /* Consistent spacing between tabs */
                                                display: flex;
                                                max-width: 520px;
                                                margin: 0 auto; /* Center the tabs */
                                                align-items: center; /* Align items vertically */
                                                border:none;
                                            }

                                            .nav-tabs .project-nav-link {
                                                border: none;
                                                padding: 5px 5px; /* Symmetrical padding for a balanced look */
                                                color: white;
                                                background-color:#2a2925;
                                                font-weight: 500;
                                                font-family: 'Poppins';
                                                font-size: 12px; /* Slightly larger for readability */
                                                border-radius: 8px; /* Rounded edges for symmetry */
                                                transition: background-color 0.3s ease, color 0.3s ease;
                                                text-align: center; /* Center-align text */
                                                flex: 1; /* Ensure equal width for all tabs */
                                            }

                                            .nav-tabs .project-nav-link.ongoing.active {
                                                background-color: #3393ff;
                                                color: white;
                                            }

                                            .nav-tabs .project-nav-link.completed.active {
                                                background-color: #90EE90;
                                                color: white;
                                            }

                                            .nav-tabs .project-nav-link.cancelled.active {
                                                background-color: #FF7074;
                                                color: white;
                                            }

                                            .nav-tabs .project-nav-link.ongoing:hover {
                                                background-color: #3393ff;
                                                color: white;
                                            }

                                            .nav-tabs .project-nav-link.completed:hover {
                                                background-color: #90EE90;
                                                color: white;
                                            }

                                            .nav-tabs .project-nav-link.cancelled:hover {
                                                background-color: #FF7074;
                                                color: white;
                                            }

                                            /* General styling for list-group */
                                            .list-group {
                                                counter-reset: project-count;
                                                padding: 0;
                                                margin-right: 5px;
                                                background-color: transparent;
                                                max-height: 200px;
                                                overflow-y: auto;
                                            }
                                            /* Optional: Add a border or styling for the scrollable area */
                                            .list-group::-webkit-scrollbar {
                                                width: 4px;
                                            }

                                            .list-group::-webkit-scrollbar-thumb {
                                                background-color: #36b9cc;
                                                border-radius: 10px;
                                                height: 40px;
                                            }

                                            .list-group::-webkit-scrollbar-thumb:hover {
                                                background-color: #555;
                                            }
                                            .list-group-item {
                                                
                                                color:white;
                                                font-size: 12px;
                                                padding: 12px; /* Consistent padding inside list items */
                                                border-radius: 10px;
                                                font-family: 'Poppins';
                                                transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
                                                margin-bottom: 8px; 
                                                margin-right: 8px;/* Even spacing between list items */
                                                list-style: none;
                                                background-color: #2a2925; /* Light background */
                                                border: none; /* Removed border for cleaner look */
                                                box-sizing: border-box; /* Include border in element size */
                                                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Elevation effect */
                                                display: flex; /* Ensure consistent alignment for content */
                                                align-items: center; /* Align items vertically */
                                            }
                                            :root{
                                                    --accent-color: #f9ce45; /* Accent color */
                                                }
                                            .list-group-item:hover {
                                                border-left: 5px solid var(--accent-color);
                                                box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2); 
                                                background-color: #e0e0e0; 
                                            }
                                            .list-group-item::before {
                                                content: counter(project-count) ". "; /* Space added after the period */
                                                counter-increment: project-count;
                                                font-weight: bold;
                                                color: white;
                                            }

                                            /* Tab-specific hover styles */
                                            .tab-pane#nav-ongoing .list-group-item:hover {
                                                background-color: #3393ff;
                                                color: white;
                                            }

                                            .tab-pane#nav-completed .list-group-item:hover {
                                                background-color: #90EE90;
                                                color: white;
                                            }

                                            .tab-pane#nav-cancelled .list-group-item:hover {
                                                background-color: #FF7074;
                                                color: white;
                                            }

                                            @media (max-width: 768px) {
                                                .nav-tabs {
                                                    flex-direction: column;
                                                    max-width: 100%;
                                                    gap: 10px; /* Increased gap for better spacing on small screens */
                                                }
                                            }
                                        </style>
                                        <style>
                                            #collapsible-card {
                                                transition: width 0.3s ease;
                                            }

                                            .col-md-8 {
                                                transition: width 0.3s ease;
                                            }

                                            .rectangle-card {
                                                transition: width 0.3s ease;
                                            }

                                            .table-responsive {
                                                transition: width 0.3s ease;
                                            }

                                            #projectTable {
                                                transition: width 0.3s ease;
                                            }
                                        </style>
                                        <nav id="project-collapse">
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <button class="project-nav-link active ongoing" id="nav-ongoing-tab" data-bs-toggle="tab" data-bs-target="#nav-ongoing" type="button" role="tab" aria-controls="nav-ongoing" aria-selected="true">On Going</button>
                                                <button class="project-nav-link completed" id="nav-completed-tab" data-bs-toggle="tab" data-bs-target="#nav-completed" type="button" role="tab" aria-controls="nav-completed" aria-selected="false">Completed</button>
                                                <button class="project-nav-link cancelled" id="nav-cancelled-tab" data-bs-toggle="tab" data-bs-target="#nav-cancelled" type="button" role="tab" aria-controls="nav-cancelled" aria-selected="false">Cancelled</button>
                                            </div>
                                        </nav>
                                        <div class="tab-content mt-3" id="nav-tabContent"  style="display:flex;">
                                            <?php
                                            $user_id = $_SESSION['user_id_c'] ?? null;
                                            if (!$user_id) {
                                                echo "<script>alert('User not logged in. Please log in.'); window.location.href = '../../login.php';</script>";
                                                exit;
                                            }
                                            $ongoing_projects = [];
                                            $completed_projects = [];
                                            $cancelled_projects = [];
                                            try {
                                                $sql = "
                                                    SELECT 
                                                        p.project_unique_id, 
                                                        p.company_name, 
                                                        p.status,
                                                        p.start_date,
                                                        sf.status_stage_five
                                                    FROM 
                                                        projecttb p
                                                    INNER JOIN 
                                                        salesauth s 
                                                    ON 
                                                        p.user_id_cur = s.user_id_current
                                                    LEFT JOIN 
                                                        stagefive sf
                                                    ON 
                                                        p.project_unique_id = sf.project_unique_id
                                                    WHERE 
                                                        s.user_id_current = :current_user
                                                ";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->bindParam(':current_user', $user_id, PDO::PARAM_STR);
                                                $stmt->execute();

                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    // Include the stage 5 status in each project row
                                                    $row['status_stage_five'] = $row['status_stage_five'] ?? null;

                                                    if ($row['status'] === 'Ongoing') {
                                                        $ongoing_projects[] = $row;
                                                    } elseif ($row['status'] === 'Completed') {
                                                        $completed_projects[] = $row;
                                                    } elseif ($row['status'] === 'Cancelled') {
                                                        $cancelled_projects[] = $row;
                                                    }
                                                }
                                            } catch (PDOException $e) {
                                                echo "Error: " . $e->getMessage();
                                            }
                                            catch (PDOException $e) {
                                                echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
                                            }
                                            ?>
                                            <!-- Ongoing Projects -->
                                            <div class="tab-pane fade show active" id="nav-ongoing" role="tabpanel" aria-labelledby="nav-ongoing-tab">
                                                <ul class="list-group">
                                                    <?php if (!empty($ongoing_projects)): ?>
                                                        <?php foreach ($ongoing_projects as $project): ?>
                                                            <?php 
                                                            // Determine the action based on Stage 5 status
                                                            $isStageFiveCompleted = !empty($project['status_stage_five']) && $project['status_stage_five'] === 'Completed';
                                                            ?>
                                                            <li 
                                                                class="list-group-item" 
                                                                <?php if ($isStageFiveCompleted): ?>
                                                                    onclick="window.location.href='dirviewproject.php?project_id=<?php echo htmlspecialchars($project['project_unique_id']); ?>'"
                                                                <?php else: ?>
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#multiStepModal" 
                                                                    onclick="openModal('<?php echo htmlspecialchars($project['project_unique_id']); ?>')"
                                                                <?php endif; ?>
                                                            >
                                                                <?php echo htmlspecialchars($project['company_name']); ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <p style="color:#555; font-size:12px; font-family:'Poppins'">No ongoing projects available.</p>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                            <!-- Completed Projects -->
                                            <div class="tab-pane fade" id="nav-completed" role="tabpanel" aria-labelledby="nav-completed-tab">
                                                <ul class="list-group">
                                                    <?php if (!empty($completed_projects)): ?>
                                                        <?php foreach ($completed_projects as $project): ?>
                                                            <?php 
                                                            // Check if Stage 5 is completed
                                                            $isStageFiveCompleted = !empty($project['status_stage_five']) && $project['status_stage_five'] === 'Completed';
                                                            ?>
                                                            <li 
                                                                class="list-group-item"
                                                                <?php if ($isStageFiveCompleted): ?>
                                                                    onclick="window.location.href='dirviewproject.php?project_id=<?php echo htmlspecialchars($project['project_unique_id']); ?>'"
                                                                <?php endif; ?>
                                                            >
                                                                <?php echo htmlspecialchars($project['company_name']); ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <p style="color:#555; font-size:12px; font-family:'Poppins'">No completed projects available.</p>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                            <!-- Cancelled Projects -->
                                            <div class="tab-pane fade" id="nav-cancelled" role="tabpanel" aria-labelledby="nav-cancelled-tab">
                                                <ul class="list-group">
                                                    <?php if (!empty($cancelled_projects)): ?>
                                                        <?php foreach ($cancelled_projects as $project): ?>
                                                            <li 
                                                                class="list-group-item"
                                                                onclick="window.location.href='dirviewproject.php?project_id=<?php echo htmlspecialchars($project['project_unique_id']); ?>'"
                                                            >
                                                                <?php echo htmlspecialchars($project['company_name']); ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <p style="color:#555; font-size:12px; font-family:'Poppins'">No cancelled projects available.</p>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- Blank Column -->
                    <div class="col" id="table-card-collapse" style="transition: width 0.3s ease; width: 690px;">
                        <div class="card shadow-sm"  style="background-color:#1f2024; border:none;">
                            <div class="card-body" style="margin-top: 0.25rem; margin-bottom: 0.5rem; ">
                                <!-- Start of Cards -->
                                 <?php include('dirback/cardsStatus.php'); ?>
                                <div class="row" style="padding: 10px; gap: 4px; margin-top: -0.5rem;"> <!-- Reduced margin above cards -->
                                    <div class="rectangle-card" onclick="filterTable('Completed')">
                                        <i class="card-icon">
                                            <img src="../images/comP.png" alt="icon" width="30" height="30">
                                        </i>
                                        <div class="card-content">
                                            <div class="card-title" style="font-family:'Poppins'">Completed</div>
                                            <div class="card-number" style="font-family:'Poppins'"><?php echo $completedCount; ?></div>
                                        </div>
                                    </div>
                                    <div class="rectangle-card" onclick="filterTable('Ongoing')">
                                        <i class="card-icon">
                                            <img src="../images/ongoingP.png" alt="icon" width="30" height="30">
                                        </i>
                                        <div class="card-content">
                                            <div class="card-title" style="font-family:'Poppins'">On Going</div>
                                            <div class="card-number" style="font-family:'Poppins'"><?php echo $ongoingCount; ?></div>
                                        </div>
                                    </div>
                                    <div class="rectangle-card" onclick="filterTable('Cancelled')">
                                        <i class="card-icon">
                                            <img src="../images/cancelP.png" alt="icon" width="30" height="30">
                                        </i>
                                        <div class="card-content">
                                            <div class="card-title" style="font-family:'Poppins'">Cancelled</div>
                                            <div class="card-number" style="font-family:'Poppins'"><?php echo $cancelledCount; ?></div>
                                        </div>
                                    </div>
                                    <div class="rectangle-card" onclick="filterTable('All')">
                                        <i class="card-icon">
                                            <img src="../images/durationP.png" alt="icon" width="30" height="30">
                                        </i>
                                        <div class="card-content">
                                            <div class="card-title" style="font-family:'Poppins'">Duration</div>
                                            <div class="card-number" style="font-family:'Poppins'"><?php echo round($avgDuration, 2); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Cards -->
                                <div class="col-md-14 mb-3">
                                    <div class="card shadow mb-4" style="box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2); margin-bottom: 0.2rem; background-color:#2a2925; border:none;">
                                        <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background-color: #2a2925;  height: auto;">
                                            <!-- Title -->
                                            <h6 class="m-0 font-weight-bold" style="color: white; line-height: 1;">Project Lists</h6>
                                            
                                            <!-- Row to hold the search bar and dropdowns -->
                                            <div class="d-flex align-items-center" style="gap: 10px;">
                                                <!-- Search Bar -->
                                                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." 
                                                    style="background-color:#2a2925; color:white; font-size: 10px; border: 1px solid white; border-radius: 4px; outline: white; width: 200px; height: 30px; margin: 0;">
                                                
                                                <!-- Dropdown for Export Options -->
                                                <div class="btn-group" role="group">
                                                    <!-- Export Dropdown -->
                                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" 
                                                            style="color:black; font-size: 10px; height: 30px; margin: 0; border:none; background-color:#f9ce45">
                                                        Export
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#" onclick="exportToPDF()">Download PDF</a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="exportToExcel()">Download Excel</a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="exportToCSV()">Download CSV</a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="printTable()">Print</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" style="padding-top: 0.5rem; background-color:#2a2925; padding-bottom: 0.5rem;">
                                            <style>
                                                 .table-responsive::-webkit-scrollbar {
                                                    width: 4px;
                                                    height: 4px;
                                                }

                                                .table-responsive::-webkit-scrollbar-thumb {
                                                    background-color: #36b9cc;
                                                    border-radius: 10px;
                                                    height: 10px;
                                                }

                                                .table-responsive::-webkit-scrollbar-thumb:hover {
                                                    background-color: #555;
                                                }
                                                #projectTable {
                                                    background-color: #2a2925;
                                                    color: white;
                                                }
                                            </style>
                                            <div class="table-responsive" style="max-height: 250px; overflow-y: auto; background-color:#2a2925; color:white;">
                                                <?php
                                                // Fetch the current user's ID from the session
                                                $user_id = $_SESSION['user_id_c'] ?? null;
                                                if (!$user_id) {
                                                    echo "<script>alert('User not logged in. Please log in.'); window.location.href = '../../login.php';</script>";
                                                    exit; 
                                                }

                                                $projects = [];
                                                try {
                                                    // Join projecttb with salesauth and filter by the current user's ID
                                                    $sql = "
                                                        SELECT 
                                                            p.project_unique_id, 
                                                            p.company_name, 
                                                            p.account_manager, 
                                                            p.status AS pstatus,
                                                            p.start_date, 
                                                            p.end_date, 
                                                            p.created_at,
                                                            p.product_type,
                                                            p.current_stage,
                                                            p.client_type,
                                                            p.source,
                                                            DATEDIFF(p.end_date, p.start_date) + 1 AS duration,
                                                            s.user_id_current
                                                        FROM projecttb p
                                                        INNER JOIN salesauth s 
                                                            ON p.user_id_cur = s.user_id_current
                                                        WHERE s.user_id_current = :current_user
                                                        ORDER BY p.created_at DESC

                                                    ";
                                                    $stmt = $conn->prepare($sql);
                                                    $stmt->bindParam(':current_user', $user_id, PDO::PARAM_STR); 
                                                    $stmt->execute();
                                                    
                                                    // Fetch all rows
                                                    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                } catch (PDOException $e) {
                                                    echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
                                                }
                                                ?>

                                                <!-- HTML Table to Display Project Data -->
                                                <?php if (!empty($projects)): ?>
                                                    <table id="projectTable" class="table" background-color:#2a2925; color:white;>
                                                        <thead style="background-color:#2a2925; color:white;">
                                                            <tr style="background-color:#2a2925; color:white;">
                                                                <th style="background-color:#2a2925; color:white;">Project ID</th>
                                                                <th style="background-color:#2a2925; color:white;">Company Name</th>
                                                                <th style="background-color:#2a2925; color:white;">Account Manager</th>
                                                                <th style="background-color:#2a2925; color:white;">Start Date</th>
                                                                <th style="background-color:#2a2925; color:white;">End Date</th>
                                                                <th style="background-color:#2a2925; color:white;">Status</th>
                                                                <th style="background-color:#2a2925; color:white;">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody style="background-color:#2a2925; color:white;">
                                                            <?php foreach ($projects as $project): ?>
                                                                <tr data-status="<?php echo htmlspecialchars($project['pstatus']); ?>" style="background-color:#2a2925; color:white;">
                                                                    <td style="padding-left:5px; padding-right:5px; background-color:#2a2925; color:white;"><?php echo htmlspecialchars($project['project_unique_id']); ?></td>
                                                                    <td style="padding-left:5px; background-color:#2a2925; color:white;"><?php echo htmlspecialchars($project['company_name']); ?></td>
                                                                    <td style="padding-left:5px; background-color:#2a2925; color:white;"><?php echo htmlspecialchars($project['account_manager']); ?></td>
                                                                    <td style="padding-left:5px; background-color:#2a2925; color:white;"><?php echo htmlspecialchars($project['start_date']); ?></td>
                                                                    <td style="padding-left:5px; background-color:#2a2925; color:white;"><?php echo htmlspecialchars($project['end_date']); ?></td>
                                                                    <td style=" color: white; padding-left:5px; background-color: <?php 
                                                                        if ($project['pstatus'] == 'Cancelled') {
                                                                            echo 'red'; 
                                                                        } elseif ($project['pstatus'] == 'Ongoing') {
                                                                            echo '#3393ff'; 
                                                                        } elseif ($project['pstatus'] == 'Completed') {
                                                                            echo 'green'; 
                                                                        } else {
                                                                            echo 'grey'; // Default background color if status doesn't match
                                                                        }
                                                                    ?>;"><?php echo htmlspecialchars($project['pstatus']); ?></td>
                                                                    <td class="action-buttons" style="background-color:#2a2925; color:white;">
                                                                        <a href="dirviewproject.php?project_id=<?php echo $project['project_unique_id']; ?>" class="view-btn">
                                                                            <i class="fas fa-eye" style="font-size: 12px; color: #36b9cc;"></i> 
                                                                        </a>
                                                                        <!-- <button type="button" class="edit-btn" data-bs-toggle="modal" data-bs-target="#editProjectModal" data-project-id="<?php echo $project['project_unique_id']; ?>">
                                                                            <i class="fas fa-pencil-alt" style="font-size: 10px; color: #36b9cc;"></i>
                                                                        </button> -->
                                                                        <style>
                                                                            .view-btn i {
                                                                                font-size: 10px;
                                                                                color: #36b9cc;
                                                                                transition: color 0.3s ease, transform 0.3s ease;
                                                                            }

                                                                            .view-btn:hover i {
                                                                                color: #009394; /* Change to desired hover color */
                                                                                transform: scale(1.2); /* Slightly enlarge the icon */
                                                                            }
                                                                        </style>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                <?php else: ?>
                                                    <p style="color:#555; font-family:'Poppins'; font-size:13px;">No projects available.</p>
                                                <?php endif; ?>
                                            </div>
                                            <!-- <div class="pagination">
                                                <a href="#" onclick="changePage(1)" class="active">1</a>
                                                <a href="#" onclick="changePage(2)">2</a>
                                                <a href="#" onclick="changePage(3)">3</a>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="viewProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" style="width:1250px;">
                                        <!-- Centered and large modal for better responsiveness -->
                                        <div class="modal-content" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(2px); border-radius: 5px;">
                                            <div class="modal-header" style="background-color:#36b9cc; height: 50px;">
                                                <h5 class="modal-title" id="addProjectModalLabel" style="font-size: 15px; color:white;">Project Profile</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Form to add project -->
                                                <form>
                                                    <div class="row">
                                                        <!-- Client/Company -->
                                                        <div class="col-md-4 mb-2">
                                                            <label for="clientCompany" class="form-label" style="font-size: 10px; color: #000;">Client</label>
                                                            <input type="text" class="form-control input-sm" id="modalCompanyName" placeholder="Enter client or company name" style="font-size: 10px; color: #000; padding: 5px;" required>
                                                        </div>
                                                        <!-- Account Manager -->
                                                        <div class="col-md-4 mb-2">
                                                            <label for="accountManager" class="form-label" style="font-size: 10px; color: #000;">Account Manager</label>
                                                            <input type="text" class="form-control" id="modalAccountManager" placeholder="Enter account manager name" style="font-size: 10px; color: #000; padding: 5px;" required>
                                                        </div>
                                                        <!-- Product Type -->
                                                        <div class="col-md-4 mb-2">
                                                            <label for="productType" class="form-label" style="font-size: 10px; color: #000;">Account Type</label>
                                                            <select class="form-select" id="productType" style="font-size: 10px; color: #000; padding: 5px;" required>
                                                                <option value="" selected disabled>Select Product</option>
                                                                <option value="New">New</option>
                                                                <option value="Existing">Existing</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <!-- Start Date -->
                                                        <div class="col-md-4 mb-2">
                                                            <label for="startDate" class="form-label" style="font-size: 10px; color: #000;">Start Date</label>
                                                            <input type="date" class="form-control" id="modalStartDate" style="font-size: 10px; color: #000; padding: 5px;" required>
                                                        </div>
                                                        <!-- End Date -->
                                                        <div class="col-md-4 mb-2">
                                                            <label for="endDate" class="form-label" style="font-size: 10px; color: #000;">End Date</label>
                                                            <input type="date" class="form-control" id="modalEndDate" style="font-size: 10px; color: #000; padding: 5px;" required>
                                                        </div>
                                                        <!-- Source -->
                                                        <div class="col-md-4 mb-2">
                                                            <label for="source" class="form-label" style="font-size: 10px; color: #000;">Source</label>
                                                            <input type="text" class="form-control" id="source" placeholder="Enter source" style="font-size: 10px; color: #000; padding: 5px;" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <!-- Status -->
                                                        <div class="col-md-4 mb-2">
                                                            <label for="status" class="form-label" style="font-size: 10px; color: #000;">Status</label>
                                                            <select class="form-select" id="modalStatus" style="font-size: 10px; color: #000; padding: 5px;" required>
                                                                <option value="" selected disabled>Select status</option>
                                                                <option value="active">Active</option>
                                                                <option value="inactive">Inactive</option>
                                                                <option value="completed">Completed</option>
                                                            </select>
                                                        </div>
                                                        <!-- Current Stage -->
                                                        <div class="col-md-4 mb-2">
                                                            <label for="currentStage" class="form-label" style="font-size: 10px; color: #000;">Current Stage</label>
                                                            <input type="text" class="form-control" id="currentStage" placeholder="Enter current stage" style="font-size: 10px; color: #000; padding: 5px;" required>
                                                        </div>
                                                        <!-- Client Type -->
                                                        <div class="col-md-4 mb-2">
                                                            <label for="clientType" class="form-label" style="font-size: 10px; color: #000;">Client Type</label>
                                                            <select class="form-select" id="clientType" style="font-size: 10px; color: #000; padding: 5px;" required>
                                                                <option value="" selected disabled>Select status</option>
                                                                <option value="active">IT Company</option>
                                                                <option value="inactive">HealthCare</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </form>

                                                <!-- Divider -->
                                                <hr class="my-1">
                                                <!-- Stages Summary Section -->
                                                <div>
                                                    <h6 style="font-size: 12px;">Stages Summary</h6>
                                                    <table class="table table-bordered table-sm" style="color:white">
                                                        <thead style="background-color: #00934; color:white; font-size:12px;">
                                                            <tr>
                                                                <th>Stage</th>
                                                                <th>Summary</th>
                                                                <th>Start Date</th>
                                                                <th>End Date</th>
                                                                <th>Duration</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody style="font-size:10px;">
                                                            <tr>
                                                                <td>Stage 1</td>
                                                                <td>Awareness and Prospecting</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Stage 2</td>
                                                                <td>Engagement/Discovery</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Stage 3</td>
                                                                <td>Presentation/Proposal</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Stage 4</td>
                                                                <td>Negotiation/Commitment</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Stage 5</td>
                                                                <td>Delivery/Follow Up</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="font-size: 12px;">Close</button>
                                                <button type="submit" class="btn" style="background-color:#36b9cc; color:white; font-size: 12px;">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Modal -->

                                <div class="col-md-14 mb-1 ">
                                    <div class="row mt-0 " style=" margin-top: 0.25rem">
                                        <div class="card col-md-5 shadow mb-1 mx-3 p-0" style="box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2);">
                                            <div class="card-header py-1" style="background:white">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <!-- Left-aligned text -->
                                                    <p class="m-0 font-weight-bold" style="color: #36b9cc">Schedule Today</p>
                                                    <!-- Right-aligned icon -->
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#addSchedule">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#36b9cc" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                            <style>
                                                .scheduleScroll::-webkit-scrollbar {
                                                    width: 4px;
                                                }

                                                .scheduleScroll::-webkit-scrollbar-thumb {
                                                    background-color: #36b9cc;
                                                    border-radius: 10px;
                                                    height: 20px;
                                                }

                                                .scheduleScroll::-webkit-scrollbar-thumb:hover {
                                                    background-color: #555;
                                                }
                                                .view-schedule-btn i {
                                                    font-size: 10px;
                                                    color: #36b9cc;
                                                    transition: color 0.3s ease, transform 0.3s ease;
                                                }

                                                .view-schedule-btn:hover i {
                                                    color: #009394; /* Change to desired hover color */
                                                    transform: scale(1.2); /* Slightly enlarge the icon */
                                                }
                                            
                                            </style>
                                            <div class="card-body scheduleScroll" style="height: 180px; overflow-y: auto; padding-top: 0.5rem; padding-bottom: 0.5rem;">
                                                <!-- Schedule Widget -->
                                                 <div class="d-flex flex-column gap-3">
                                                    <div id="scheduleContainer"></div>
                                                    <?php
                                                
                                                    // Get current user ID from session
                                                    $userId = $_SESSION['user_id_c'] ?? 0; 

                                                    // Fetch schedules for this user
                                                    $query = "
                                                            SELECT sched_id, event, start, time
                                                            FROM schedule_tb
                                                            WHERE user_id_cur = :user_id
                                                            AND DATE(start) = CURDATE()
                                                            ORDER BY start ASC
                                                        ";
                                                        $stmt = $conn->prepare($query);
                                                        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                                                        $stmt->execute();
                                                        $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        if (empty($schedules)) {
                                                            echo '<div class="p-2 rounded border" style="font-size: 10px; color: #555;">
                                                                    There is no schedule today.
                                                                </div>';
                                                        } else{

                                                        // Loop through each schedule and display
                                                        foreach ($schedules as $schedule) {
                                                        $scheduleId  = $schedule['sched_id'];
                                                        $eventName   = $schedule['event']  ?? 'No Event';
                                                        $eventDate   = $schedule['start']  ?? 'No Date';
                                                        $eventTime   = $schedule['time']   ?? 'No Time';
                                                        ?>
                                                    
                                                    <div class="p-2 rounded border d-flex flex-column" style="position: relative; min-height: 120px;">
                                                        <!-- Event Details -->
                                                        <div class="mb-auto">
                                                            <strong style="font-size: 10px;"><?php echo htmlspecialchars($eventName); ?></strong>
                                                            <br>
                                                            <span style="font-size: 10px; color: #555;">Date: <?php echo htmlspecialchars($eventDate); ?></span>
                                                            <br>
                                                            <span style="font-size: 10px; color: #555;">Time: <?php echo htmlspecialchars($eventTime); ?></span>
                                                        </div>
                                                        <!-- Action Buttons -->
                                                        <div class="d-flex justify-content-end" style="position: absolute; bottom: 10px; right: 10px;">
                                                            <a href="" class="view-schedule-btn" data-bs-toggle="modal"
                                                            data-bs-target="#schedModal" data-sched-id="<?php echo $scheduleId; ?>">
                                                                <i class="fas fa-eye" style="font-size: 12px; color: #36b9cc;"></i>
                                                            </a>
                                                          <!-- Delete Button -->
                                                            <a href="javascript:void(0)" class="delete-schedule-btn" data-bs-toggle="modal" 
                                                            data-bs-target="#schedDel" onclick="setDeleteScheduleId('<?php echo $scheduleId; ?>')">
                                                                <i class="fas fa-trash" style="font-size: 12px; color: red; margin-left: 10px;"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    }
                                                }
                                                    ?>
                                                    <!-- Schedule 1 Modal -->
                                                    <div class="modal fade" id="schedModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true" data-sched-id="<?php echo $scheduleId; ?>">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #36b9cc; color: white;">
                                                                <h5 class="modal-title" id="scheduleModalLabel" style="font-size: 14px;color:white;">Schedule Detail</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                                                            </div>
                                                            <div class="modal-body" style="font-size: 12px;">
                                                                <!-- Existing structure, do NOT change IDs of spans -->

                                                                <p>
                                                                <strong>Event:</strong>
                                                                <span id="modalEvent"></span>
                                                                <!-- New hidden <input> for editing Event -->
                                                                <input type="text" id="modalEvent_edit" class="form-control d-none" />
                                                                </p>

                                                                <p>
                                                                <strong>Date:</strong>
                                                                <span id="modalDate"></span>
                                                                <!-- New hidden <input> for editing Date -->
                                                                <input type="date" id="modalDate_edit" class="form-control d-none" />
                                                                </p>

                                                                <p>
                                                                <strong>Time:</strong>
                                                                <span id="modalTime"></span>
                                                                <!-- New hidden <input> for editing Time -->
                                                                <input type="time" id="modalTime_edit" class="form-control d-none" />
                                                                </p>

                                                                <p>
                                                                <strong>Location:</strong>
                                                                <span id="modalVenue"></span>
                                                                <!-- New hidden <input> for editing Venue -->
                                                                <input type="text" id="modalVenue_edit" class="form-control d-none" />
                                                                </p>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button 
                                                                type="button" 
                                                                class="btn btn-secondary btn-sm" 
                                                                data-bs-dismiss="modal" 
                                                                style="font-size: 10px;"
                                                                >
                                                                Close
                                                                </button>
                                                                <!-- The toggle button for edit/save -->
                                                                <button 
                                                                type="button" 
                                                                id="editSaveButton" 
                                                                class="btn btn-primary btn-sm" 
                                                                style="font-size: 10px; background-color: #36b9cc; border: none;"
                                                                >
                                                                Edit
                                                                </button>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end of Schedule 1 Modal -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Delete Schedule Modal -->
                                        <div class="modal fade" id="schedDel" tabindex="-1" aria-labelledby="deleteSchedModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color: #dc3545; color: white;">
                                                        <h5 class="modal-title" id="deleteTaskModalLabel" style="font-size: 14px; color:white;">Delete Schedule</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                                                    </div>
                                                    <div class="modal-body" style="font-size: 12px;">
                                                        Are you sure you want to delete this schedule?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="font-size: 10px;">Cancel</button>
                                                        <button type="button" class="btn btn-danger btn-sm" style="font-size: 10px;" onclick="deleteSchedule()">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card col-md-6 shadow mb-1 mr-0 p-0" style=" box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2);"> 
                                            <div class="card-header py-2" style="background: white">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <!-- Left-aligned text -->
                                                    <p class="m-0 font-weight-bold" style="color:#36b9cc;">To-Do Lists</p>
                                                    <!-- Right-aligned icon -->
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#addTask">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#36b9cc" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                            <style>
                                                .todo-scroll::-webkit-scrollbar {
                                                    width: 4px;
                                                }

                                                .todo-scroll::-webkit-scrollbar-thumb {
                                                    background-color: #36b9cc;
                                                    border-radius: 10px;
                                                    height: 20px;
                                                }

                                                .todo-scroll::-webkit-scrollbar-thumb:hover {
                                                    background-color: #555;
                                                }
                                            </style>
                                            <div class="card-body todo-scroll" style="height: 120px; overflow-y: auto;">
                                                <!-- To-Do List Widget -->
                                                <div class="d-flex flex-column gap-2">

                                                    <div id="taskList" class="d-flex flex-column gap-2 p-2 border rounded" style="height: auto; min-height: 40px;">
                                                    <!-- Tasks will be dynamically appended here -->
                                                    </div>
                                                    <!-- Edit Task Modal -->
                                                    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header" style="background-color: #36b9cc; color: white;">
                                                                    <h5 class="modal-title" id="editTaskModalLabel" style="font-size: 14px;color:white;">Edit Task</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background: white;"></button>
                                                                </div>
                                                                <div class="modal-body" style="font-size: 12px;">
                                                                    <form id="editTaskForm">
                                                                        <div class="mb-3">
                                                                            <label for="taskTitle" class="form-label" style="font-size: 10px; color:#555">Task Title</label>
                                                                            <input type="text" class="form-control form-control-sm" id="taskTitle" value="Prepare meeting notes and finalize agenda for upcoming meeting">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="taskDescription" class="form-label" style="font-size: 10px; color:#555">Description</label>
                                                                            <textarea class="form-control form-control-sm" id="taskDescription" rows="3">Add more details about the task here...</textarea>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="font-size: 10px;">Cancel</button>
                                                                    <button type="button" class="btn btn-primary btn-sm" style="font-size: 10px; background-color: #36b9cc; border: none;">Save Changes</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Delete Task Modal -->
                                                    <div class="modal fade" id="deleteTaskModal" tabindex="-1" aria-labelledby="deleteTaskModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header" style="background-color: #dc3545; color: white;">
                                                                    <h5 class="modal-title" id="deleteTaskModalLabel" style="font-size: 14px; color:white;">Delete Task</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                                                                </div>
                                                                <div class="modal-body" style="font-size: 12px;">
                                                                    Are you sure you want to delete this task?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="font-size: 10px;">Cancel</button>
                                                                    <button type="button" class="btn btn-danger btn-sm" style="font-size: 10px;">Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <style>
            /* Custom styles for text fields, labels, titles, and buttons */
            .modal-body .form-control {
                font-size: 10px; /* Set font size for text fields */
                padding: 5px; /* Adjust padding for smaller input fields */
            }

            .modal-body .form-label {
                font-size: 12px; /* Set font size for labels */
            }

            .modal-title {
                font-size: 14px; /* Set font size for the modal title */
            }

            .modal-footer .btn {
                font-size: 12px; /* Set font size for buttons */
                padding: 8px 12px; /* Adjust button padding */
            }
            </style>

            <!-- Add New Schedule Modal -->
            <div class="modal fade" id="addSchedule" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(2px); border-radius: 5px;">
                <div class="modal-header" style="background-color:#36b9cc; height: 50px;">
                    <font color="white">
                    <h5 class="m" id="addProjectModalLabel">Add New Schedule</h5>
                    </font>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form to add schedule -->
                    <form id="addScheduleForm">
                    <div class="row">
                        <!-- Event/Activity/Meeting -->
                        <div class="col-md-6 mb-3">
                        <label for="eventInput" class="form-label" style="color:#555">Event/Activity/Meeting</label>
                        <input name="event" type="text" class="form-control" id="eventInput" placeholder="Enter event or activity" required>
                        </div>
                        <!-- Venue -->
                        <div class="col-md-6 mb-3">
                        <label for="venueInput" class="form-label" style="color:#555">Venue</label>
                        <input name="venue" type="text" class="form-control" id="venueInput" placeholder="Enter venue" required>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Start Date -->
                        <div class="col-md-6 mb-3">
                        <label for="startDate" class="form-label" style="color:#555">Start Date</label>
                        <input name="start" type="date" class="form-control" id="startDate" required>
                        </div>

                        <!-- Hidden user_id if needed -->
                        <input hidden name="user_id_cur" value="<?php echo $_SESSION['user_id_c']; ?>" type="text" class="form-control" id="userID">

                        <!-- Time -->
                        <div class="col-md-6 mb-3">
                        <label for="timeInput" class="form-label" style="color:#555">Time</label>
                        <input name="time" type="time" class="form-control" id="timeInput" required>
                        </div>
                    </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- Give the button an ID so we can bind an event to it -->
                    <button type="button" id="saveScheduleBtn" class="btn btn-primary" style="background-color:#36b9cc; color:white;">
                    Save
                    </button>
                </div>
                </div>
            </div>
            </div>


            <!-- Add New Task Modal -->
            <div class="modal fade" id="addTask" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <!-- Centered and large modal for better responsiveness -->
                    <div class="modal-content" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(2px); border-radius: 5px;">
                        <div class="modal-header" style="background-color:#36b9cc; height: 50px;">
                            <font color="white">
                                <h5 class="modal-title" id="addProjectModalLabel">Add New Task</h5>
                            </font>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form to add task -->
                            <form id="taskForm">
                                <div class="row">
                                    <!-- Task -->
                                    <div class="col-md-6 mb-3">
                                        <label for="taskName" class="form-label" style="color:#555">Task</label>
                                        <input name="taskname" type="text" class="form-control" id="taskName" placeholder="Enter task name" required>
                                    </div>
                                    <!-- Assign to -->
                                    <div class="col-md-6 mb-3">
                                        <label for="assignedTo" class="form-label" style="color:#555">Assign to</label>
                                        <input name="assigned" type="text" class="form-control" id="assignedTo" placeholder="Enter assignee name" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Start Date -->
                                    <div class="col-md-6 mb-3">
                                        <label for="startDate" class="form-label" style="color:#555">Start Date</label>
                                        <input name="starttask" type="date" class="form-control" id="startTask" required>
                                    </div>
                                    <!-- End Date -->
                                    <div class="col-md-6 mb-3">
                                        <label for="endDate" class="form-label" style="color:#555">End Date</label>
                                        <input name="endtask" type="date" class="form-control" id="endTask" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary todo-save" style="background-color:#36b9cc; color:white;" id="saveTaskBtn">Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--  Task Modal -->
            <div class="modal fade" id="editTask" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header" style="background-color: #36b9cc; color: white;">
                        <h5 class="modal-title" id="taskModalLabel" style="font-size: 14px;color:white;">Task Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                    </div>
                    <div class="modal-body" style="font-size: 12px;">
                        <!-- Existing structure, do NOT change IDs of spans -->

                        <p>
                        <strong style="color:black">Task:</strong>
                        <span style="color:#555" id="modalTask"></span>
                        <!-- New hidden <input> for editing Event -->
                        <input name="taskname" type="text" id="modalTask_edit" class="form-control d-none" />
                        </p>

                        <p>
                        <strong style="color:black">Assigned to:</strong>
                        <span style="color:#555" id="modalAssign"></span>
                        <!-- New hidden <input> for editing Date -->
                        <input name="assigned" type="text" id="modalAssign_edit" class="form-control d-none" />
                        </p>

                        <p>
                        <strong style="color:black">Start Date:</strong>
                        <span style="color:#555" id="modalstartDate"></span>
                        <!-- New hidden <input> for editing Time -->
                        <input name="starttask" type="date" id="modalStart_edit" class="form-control d-none" />
                        </p>

                        <p>
                        <strong style="color:black">End Date:</strong>
                        <span style="color:#555" id="modalendDate"></span>
                        <!-- New hidden <input> for editing Venue -->
                        <input name="endtask" type="date" id="modalEnd_edit" class="form-control d-none" />
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button 
                        type="button" 
                        class="btn btn-secondary btn-sm" 
                        data-bs-dismiss="modal" 
                        style="font-size: 10px;"
                        >
                        Close
                        </button>
                        <!-- The toggle button for edit/save -->
                        <button 
                        type="button" 
                        id="editSaveButton" 
                        class="btn btn-primary btn-sm" 
                        style="font-size: 10px; background-color: #36b9cc; border: none;"
                        >
                        Edit
                        </button>
                    </div>
                    </div>
                </div>
            </div>
            <!-- End of Schedule Modal -->

            <!-- MultiStep Form Modal -->
            <?php include('multistepModal.php'); ?>
            <!-- End of Multi Step form -->
            <!-- Modal -->
            <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" style="width:1250px;" role="document">
                    <!-- Centered and large modal for better responsiveness -->
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#36b9cc; height: 50px;">
                            <h5 class="modal-title" id="addProjectModalLabel" style="font-size: 15px; color:white;">Add New Project</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form to add project -->
                            <form method="post" action="dirback/diradd_project.php">
                                <div class="row">
                                    <!-- Client/Company -->
                                    <div class="col-md-6 mb-2">
                                        <label for="clientCompany" class="form-label" style="font-size: 10px; color: #000;">Client</label>
                                        <input name="company_name" type="text" class="form-control input-sm" id="clientCompany" placeholder="Enter client or company name" style="font-size: 10px; color: #000; padding: 5px;" required>
                                    </div>
                                    <!-- Account Manager -->
                                    <div class="col-md-6 mb-2">
                                        <label for="accountManager" class="form-label" style="font-size: 10px; color: #000;">Account Manager</label>
                                        <input readonly  name="account_manager" type="text" class="form-control" id="accountManager" value="<?php echo $_SESSION['user_name']; ?>" style="font-size: 10px; color: #000; padding: 5px;" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Product Type -->
                                    <div class="col-md-4 mb-2">
                                        <label for="product_type" class="form-label" style="font-size: 10px; color: #000;">Account Type</label>
                                        <select name="product_type" class="form-select" id="productType" style="font-size: 10px; color: #000; padding: 5px;" required>
                                            <option value="" selected disabled>Select Product Type</option>
                                            <option value="New">New</option>
                                            <option value="Existing">Existing</option>
                                        </select>
                                    </div>
                                    <!-- Start Date -->
                                    <!-- <div class="col-md-4 mb-2">
                                        <label for="startDate" class="form-label" style="font-size: 10px; color: #000;">Start Date</label>
                                        <input name="start_date"readonly type="text" placeholder="Auto-generated" class="form-control" id="startDate" style="font-size: 10px; color: #000; padding: 5px;">
                                    </div> -->
                                    <!-- End Date -->
                                    <!-- <div class="col-md-4 mb-2">
                                        <label for="endDate" class="form-label" style="font-size: 10px; color: #000;">End Date</label>
                                        <input name="end_date" readonly type="text" placeholder="Auto-generated" class="form-control" id="endDate" style="font-size: 10px; color: #000; padding: 5px;">
                                    </div> -->
                                    <!-- Source -->
                                   <div class="col-md-4 mb-2">
                                        <label for="source" class="form-label" style="font-size: 10px; color: #000;">Source</label>
                                        <select name="source" class="form-control" id="sourceSelect" style="font-size: 10px; color: #000; padding: 5px;" required>
                                            <option value="" disabled selected>Select source</option>
                                            <!-- Option for adding a new source -->
                                            <option value="add_new_source">+ Add New Source...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="clientType" class="form-label" style="font-size: 10px; color: #000;">Industry</label>
                                        <select name="client_type" id="clientTypeSelect" class="form-select" style="font-size: 10px; color: #000; padding: 5px;" required>
                                            <option value="" disabled selected>Select</option>
                                            <!-- Special option for adding a new client type -->
                                            <option value="add_new">+ Add New Client Type...</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="row"> -->
                                    <!-- Status -->
                                    <!-- <div class="col-md-4 mb-2">
                                        <label for="status" class="form-label" style="font-size: 10px; color: #000;">Status</label>
                                        <input readonly name="status" readonly type="text" placeholder="Auto-generated" class="form-control" id="status" style="font-size: 10px; color: #000; padding: 5px;">
                                    </div> -->
                                    <!-- Current Stage -->
                                    <!-- <div class="col-md-4 mb-2">
                                        <label for="currentStage" class="form-label" style="font-size: 10px; color: #000;">Current Stage</label>
                                        <input readonly name="current_stage" readonly type="text" class="form-control" id="currentStage" placeholder="Auto-generated" style="font-size: 10px; color: #000; padding: 5px;">
                                    </div> -->
                                    <!-- Client Type -->
                                    
                                <!-- </div> -->
                                <!-- Divider -->
                                <hr class="my-1">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="font-size: 12px;">Close</button>
                                    <button type="submit" class="btn" style="background-color:#36b9cc; color:white; font-size: 12px;">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Home Content -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Powered by Workforce Management Team 2024</span>
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
    <button 
        id="continueJourneyButton" 
        type="button" 
        class="d-none" 
        data-bs-toggle="modal" 
        data-bs-target="#multistepModal">
        
    </button>
    
    
   

    <script>
        function showNotification(message, redirectUrl = null, isError = false) {
            const notification = document.getElementById('notification');
            const messageSpan = document.getElementById('notification-message');

            // Set the message and style
            messageSpan.textContent = message;
            notification.style.backgroundColor = isError ? '#ff4c4c' : '#36b9cc'; // Red for error, blue for success

            // Show the notification
            notification.style.display = 'block';

            // Hide the notification after 4 seconds
            setTimeout(() => {
                notification.style.display = 'none';
                if (redirectUrl) {
                    window.location.href = redirectUrl;
                }
            }, 4000);
        }
        </script>


    <!-- Notification bar -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.nav-tabs .nav-link');
            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    tabs.forEach(t => {
                        t.style.backgroundColor = '';
                        t.style.color = 'black';
                    });
                    this.style.backgroundColor = 'lightgray';
                    this.style.color = 'black';
                });
            });
        });
    </script>
        <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript -->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages -->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="notif.js"></script>
    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./openModal.js"></script>
    <script src="toogleNav.js"></script>
    <script src="dirback/schedule/sched.js"></script>
    <script src="dirback/schedule/fetchSched.js"></script>
    <script src="dirback/schedule/editSched.js"></script>
    <script src="dirback/schedule/deleteSched.js"></script>
    <script src="dirback/to-do/inser_task.js"></script>
    <script src="dirback/to-do/load_task.js"></script>
    <script src="alerts/notif.js"></script>
    <script src="current_year.js"></script>
    <script src="insert_fetch_distributor.js"></script>
    <script src="insert_fetch_client.js"></script>
    <script src="insert_fetch_source.js"></script>
    <script src="insert_fetch_product.js"></script>
    <script src="insert_fetch_technology.js"></script>
    <!-- <script src="idle.js"></script> -->
    
    <!-- Table Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
    // Export to PDF
    async function exportToPDF() {
        const { jsPDF } = window.jspdf; // Get jsPDF
        const doc = new jsPDF();

        // Add title to the PDF
        doc.setFontSize(16);
        doc.text("Project Lists", 14, 20);

        // Fetch the table
        const table = document.getElementById("projectTable");

        // Parse table data for autoTable
        const data = [];
        const rows = table.querySelectorAll("tr");
        rows.forEach((row, rowIndex) => {
            const rowData = [];
            const cells = row.querySelectorAll("th, td");
            cells.forEach(cell => {
                rowData.push(cell.innerText);
            });
            data.push(rowData);
        });

        // AutoTable options
        doc.autoTable({
            head: [data[0]], // First row is the table header
            body: data.slice(1), // Remaining rows are the body
            startY: 30, // Start after title
            styles: {
                fontSize: 9, // Font size for table
            },
            headStyles: {
                fillColor: [54, 185, 204], // Header color matching your theme
                textColor: 255, // White text
                halign: "center" // Center align header text
            },
        });

        // Save the PDF
        doc.save("ProjectLists.pdf");
    }

    // Export to CSV
    function exportToCSV() {
        const table = document.getElementById("projectTable");
        const rows = Array.from(table.rows).map(row =>
            Array.from(row.cells).map(cell => cell.innerText)
        );

        let csvContent = "data:text/csv;charset=utf-8,";

        rows.forEach(row => {
            const rowData = row.join(",");
            csvContent += rowData + "\r\n";
        });

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "ProjectLists.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Export to Excel
    function exportToExcel() {
        const table = document.getElementById("projectTable");

        // Convert HTML table to an array of arrays
        const rows = Array.from(table.rows).map(row =>
            Array.from(row.cells).map(cell => cell.innerText)
        );

        // Create a new workbook and worksheet
        const workbook = XLSX.utils.book_new();
        const worksheet = XLSX.utils.aoa_to_sheet(rows); // Convert array of arrays to a sheet

        // Append worksheet to workbook
        XLSX.utils.book_append_sheet(workbook, worksheet, "Project Lists");

        // Write file
        XLSX.writeFile(workbook, "ProjectLists.xlsx");
    }

    // Print Table
    function printTable() {
        const printContent = document.getElementById("projectTable").outerHTML;
        const newWindow = window.open("", "", "width=800,height=600");
        newWindow.document.write("<html><head><title>Project Lists</title></head><body>");
        newWindow.document.write(printContent);
        newWindow.document.write("</body></html>");
        newWindow.document.close();
        newWindow.print();
    }
</script>

   <script>
        let currentStep = 1;
        const totalSteps = 5;

        // Save Button Logic
        document.getElementById('saveButton').addEventListener('click', () => {
            const projectId = document.getElementById('project-unique-id').value;

            if (projectId) {
                alert(`Project ID fetched: ${projectId}`); 

                if (confirm('Do you want to save changes?')) {
                    let formData = new FormData();
                    formData.append('project_id', projectId);
                    formData.append('current_step', currentStep);

                    // Get form fields specific to the current step
                    const currentStepFields = document.querySelectorAll(`#step${currentStep} input`);
                    currentStepFields.forEach(field => {
                        formData.append(field.name, field.value);
                    });

                    const saveUrl = `dirback/save/save_stage${currentStep}.php`; 
                    fetch(saveUrl, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json()) 
                    .then(data => {
                        if (data.success) {
                            alert('Data saved successfully! Your changes have been applied.');
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error during fetch:', error);
                        alert('An error occurred while saving. Please try again.');
                    });
                }
            } else {
                alert('Error: Project ID is missing.');
            }
        });

        // Complete Button Logic
        document.getElementById('completeButton').addEventListener('click', () => {
            const projectId = document.getElementById('project-unique-id').value;

            if (projectId) {
                const stages = document.querySelectorAll('[id^="project-id-placeholder-stage"]');
                stages.forEach((stage) => {
                    stage.textContent = projectId;
                });

                alert(`Project ID fetched and displayed across all stages: ${projectId}`);

                passProjectToNextStage(projectId, currentStep);
            } else {
                alert('Error: Project ID is missing.');
            }
        });

        // Function to handle the transition between stages
        function passProjectToNextStage(projectId, currentStep) {
            if (!projectId) {
                alert('Error: Project ID is missing.');
                return;
            }

            // Confirm the transition
            if (!confirm(`Do you want to complete stage ${currentStep} and proceed to stage ${currentStep + 1}?`)) {
                return;
            }

            let formData = new FormData();
            formData.append('project_id', projectId);
            formData.append('current_step', currentStep);

            // Get form fields specific to the current step
            const currentStepFields = document.querySelectorAll(`#step${currentStep} input`);
            currentStepFields.forEach(field => {
                formData.append(field.name, field.value);
            });

            const saveUrl = `dirback/complete/complete_stage${currentStep}.php`;

            fetch(saveUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Stage ${currentStep} completed. Moving to stage ${currentStep + 1}.`);

                    // Update UI for stage completion
                    document.getElementById(`step${currentStep}-circle`).classList.add('completed');
                    document.getElementById(`step${currentStep}-circle`).textContent = '✔';
                    document.getElementById(`line${currentStep}`).classList.add('active');

                    // Populate the next stage details
                    if (data.next_stage_details) {
                        const nextStep = currentStep + 1;
                        document.getElementById(`requirementStartDate${nextStep}`).value = data.next_stage_details.start_date;
                        document.getElementById(`requirementEndDate${nextStep}`).value = data.next_stage_details.end_date;
                        document.getElementById(`requirementStatus${nextStep}`).value = data.next_stage_details.status;
                    }

                    // Proceed to the next step
                    currentStep++;
                    if (currentStep <= totalSteps) {
                        showStep(currentStep);
                    } else {
                        alert('All stages completed!');
                    }
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error during fetch:', error);
                alert('An error occurred while completing the stage. Please try again.');
            });
        }

        // Delete Button Logic
        document.getElementById('deleteButton').addEventListener('click', () => {
            const projectId = document.getElementById('project-unique-id').value;
            if (!projectId) {
                alert('Project ID is missing. Please try again.');
                return;
            }
            if (confirm('Are you sure you want to cancel this project? This action cannot be undone.')) {
                const deleteUrl = `dirback/delete/delete_stage1.php`; 
                const formData = new FormData();
                formData.append('project_id', projectId); 
                fetch(deleteUrl, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json()) 
                .then(data => {
                    if (data.success) {
                        alert('Project and stage statuses updated to "Cancelled" successfully.');
                        window.location.reload(); 
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error during cancellation:', error);
                    alert('An error occurred while cancelling the project. Please try again.');
                });
            }
        });

        // Show the current step and hide others
        function showStep(step) {
            for (let i = 1; i <= totalSteps; i++) {
                document.getElementById(`step${i}`).classList.add('d-none');
            }
            document.getElementById(`step${step}`).classList.remove('d-none');
        }

        // Reset steps if the form is deleted or reset
        function resetSteps() {
            for (let i = 1; i <= totalSteps; i++) {
                document.getElementById(`step${i}-circle`).classList.remove('active', 'completed');
                document.getElementById(`step${i}-circle`).textContent = i;
                document.getElementById(`line${i}`).classList.remove('active');
            }
            currentStep = 1;
            showStep(currentStep); 
        }

   </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const navLinks = document.querySelectorAll('.project-nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function () {
                    navLinks.forEach(navLink => {
                        navLink.classList.remove('active');
                    });
                    this.classList.add('active');
                });
                link.addEventListener('mouseenter', function () {
                    if (!this.classList.contains('active')) {
                        this.classList.add('hover'); 
                    }
                });
                link.addEventListener('mouseleave', function () {
                    if (!this.classList.contains('active')) {
                        this.classList.remove('hover'); 
                    }
                });
            });
        });
    </script>
    <script>
        document.getElementById("addRequirement").addEventListener("click", function() {
            const container = document.getElementById("requirement-container");
            const newField = document.createElement("div");

            newField.classList.add("row", "align-items-center", "requirement-field");
            newField.style.marginBottom = "10px"; 
            newField.style.marginTop = "10px";

            const inputField = document.createElement("input");
            inputField.type = "text";
            inputField.classList.add("form-control");
            inputField.placeholder = "e.g. Sample Requirement";
            inputField.name = "requirements"; // Set the name to 'requirement_one'
            inputField.style.width = "100%";  

            const buttonContainer = document.createElement("div");
            buttonContainer.classList.add("col-2", "d-flex", "justify-content-end");
            buttonContainer.style.display = "flex"; 

            const deleteButton = document.createElement("button");
            deleteButton.type = "button";
            deleteButton.classList.add("btn", "btn-danger", "btn-sm");
            deleteButton.style.marginLeft = "5px";
            deleteButton.innerHTML = "<i class='fas fa-minus'></i>";

            buttonContainer.appendChild(deleteButton);

            const inputContainer = document.createElement("div");
            inputContainer.classList.add("col-9");
            inputContainer.style.display = "flex";
            inputContainer.style.alignItems = "center";
            inputContainer.appendChild(inputField);

            newField.appendChild(inputContainer);
            newField.appendChild(buttonContainer);
            container.appendChild(newField);

            deleteButton.addEventListener("click", function() {
                newField.remove();
            });
        });

        document.getElementById("deleteRequirement").addEventListener("click", function() {
            const fields = document.getElementsByClassName("requirement-field");
            if (fields.length > 0) {
                fields[fields.length - 1].remove();
            }
        });
    </script>
    <!-- Stage 2 -->
    
    <!-- Stage 2 -->
    <script>
        let currentPage = 1;
        const rowsPerPage = 5; 
        let totalRows = 0;

        function generatePagination() {
            const rows = document.getElementById("myTable").getElementsByTagName("tr");
            totalRows = 0;
            
            for (let i = 1; i < rows.length; i++) {
                if (rows[i].style.display !== "none") {
                    totalRows++;
                }
            }
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            const paginationContainer = document.querySelector(".pagination");
            paginationContainer.innerHTML = "";

            for (let page = 1; page <= totalPages; page++) {
                const link = document.createElement("a");
                link.href = "#";
                link.innerText = page;
                link.onclick = function() {
                    changePage(page);
                };
                if (page === currentPage) {
                    link.classList.add("active");
                }
                paginationContainer.appendChild(link);
            }
        }
        function searchTable() {
            const filter = document.getElementById("searchInput").value.toUpperCase();
            const rows = document.getElementById("myTable").getElementsByTagName("tr");
            
            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName("td");
                let rowMatches = false;

                for (let j = 0; j < cells.length - 1; j++) { 
                    if (cells[j] && cells[j].innerText.toUpperCase().includes(filter)) {
                        rowMatches = true;
                    }
                }

                if (rowMatches) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
            generatePagination(); // Re-generate pagination after filtering
            changePage(1); // Reset to first page after search
        }

        function changePage(pageNumber) {
            currentPage = pageNumber;
            const rows = document.getElementById("myTable").getElementsByTagName("tr");
            const start = (currentPage - 1) * rowsPerPage + 1;
            const end = start + rowsPerPage - 1;

            let rowCount = 0;
            for (let i = 1; i < rows.length; i++) {
                if (rows[i].style.display !== "none") {
                    rowCount++;
                    rows[i].style.display = (rowCount >= start && rowCount <= end) ? "" : "none";
                }
            }
            const paginationLinks = document.querySelectorAll(".pagination a");
            paginationLinks.forEach(link => link.classList.remove("active"));
            paginationLinks[pageNumber - 1].classList.add("active");
        }
        function addRow(rowData) {
            const table = document.getElementById("myTable").getElementsByTagName('tbody')[0];
            const row = table.insertRow();
            row.innerHTML = `<td>${rowData.name}</td><td>${rowData.position}</td><td>${rowData.office}</td><td>${rowData.age}</td><td>${rowData.start}</td><td>${rowData.salary}</td><td class="action-buttons"><button>View</button><button>Edit</button></td>`;
            generatePagination();
            changePage(currentPage); 
        }
        generatePagination();
        changePage(1);
    </script>
    <script>
            // Get elements
            const sidebar = document.getElementById("accordionSidebar");
            const toggleButton = document.getElementById("sidebarToggleBtn");
            const toggleIcon = document.getElementById("sidebarToggleIcon");

            // Function to toggle sidebar visibility
            toggleButton.onclick = function() {
                sidebar.classList.toggle("collapsed"); // Add or remove collapsed class to sidebar
                // Change icon on toggle
                if (sidebar.classList.contains("collapsed")) {
                    toggleIcon.classList.remove("fa-chevron-left");
                    toggleIcon.classList.add("fa-chevron-right");
                } else {
                    toggleIcon.classList.remove("fa-chevron-right");
                    toggleIcon.classList.add("fa-chevron-left");
                }
            };
    </script>
    <!-- View Project Profile -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const viewButtons = document.querySelectorAll('.view-btn');
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const projectId = this.getAttribute('data-project-id');
                fetch('dirback/dirviewback.php', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ projectId: projectId })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalProjectId').textContent = data.project_unique_id;
                    document.getElementById('modalCompanyName').textContent = data.company_name;
                    document.getElementById('modalAccountManager').textContent = data.account_manager;
                    document.getElementById('modalStartDate').textContent = data.start_date;
                    document.getElementById('modalEndDate').textContent = data.end_date;
                    document.getElementById('modalStatus').textContent = data.status;
                })
                .catch(error => console.error('Error fetching project details:', error));
            });
        });
    });
    </script>
    <!-- stage project unique id fetcher -->
  

    <script>
        function toggleIcon() {
        var icon = document.getElementById("toggle-icon");
        if (container.style.display === "none" || container.style.height === "0px" || icon.classList.contains("fa-chevron-left")) {
            container.style.display = "block"; 
            container.style.height = "auto";
            icon.classList.remove("fa-chevron-left");
            icon.classList.add("fa-chevron-right");
        } else {
            container.style.display = "none";
            container.style.height = "0px";
            icon.classList.remove("fa-chevron-right");
            icon.classList.add("fa-chevron-left");
        };
    }
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
    <script>
        function searchTable() {
            const input = document.getElementById('searchInput'); // Get the search input field
            const filter = input.value.toLowerCase(); // Convert input to lowercase
            const table = document.getElementById('projectTable'); // Get the table element
            const rows = table.getElementsByTagName('tr'); // Get all rows in the table

            // Loop through all table rows (except the first, which is the header)
            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td'); // Get all cells in the current row
                let isMatch = false;

                // Check if any cell in the current row matches the search query
                for (let j = 0; j < cells.length; j++) {
                    const cellText = cells[j].textContent || cells[j].innerText;
                    if (cellText.toLowerCase().indexOf(filter) > -1) {
                        isMatch = true;
                        break;
                    }
                }
                // Show or hide the row based on whether it matches the search query
                rows[i].style.display = isMatch ? '' : 'none';
            }
        }
    </script>
    <script>
        function filterTable(status) {
            const rows = document.querySelectorAll('#projectTable tbody tr');
            rows.forEach(row => {
                if (status === 'All' || row.getAttribute('data-status') === status) {
                    row.style.display = ''; // Show the row
                } else {
                    row.style.display = 'none'; // Hide the row
                }
            });
        }
    </script>
    <script>
        function toggleCardWidth() {
        const projectCard = document.getElementById('collapsible-card');
        const tableCard = document.getElementById('table-card-collapse'); // ← Grab the table column
        const toggleIcon = document.getElementById('toggle-icon');
        const projectText = document.getElementById('project-collapse');
        const otherContainers = document.querySelectorAll(
            ' .rectangle-card, .table-responsive, #projectTable'
        );

        // Get the span that holds "Add Project" text
        const addProjectBtnText = document.getElementById('addProjectBtnText');
        const nav = document.getElementById('nav-tabContent');
        const navlist = document.getElementById('nav-tab');
        const pbutton = document.getElementById('icon-col');

        // Check if the project card is currently "expanded" at 330px
        if (projectCard.style.width === '330px') {
            // -------- COLLAPSE project card --------
            projectCard.style.width = '100px'; // shrink the left card
            projectCard.style.height = '70px'; 
            toggleIcon.classList.remove('fa-chevron-left');
            toggleIcon.classList.add('fa-chevron-right');

            // Hide the “Add Project” text when collapsed
            addProjectBtnText.style.display = 'none';
            projectText.style.display = 'none';
            nav.style.display = 'none';
            navlist.style.display = 'none';
            pbutton.style.display = 'none';

            // Increase the size of the table card
            tableCard.style.width = '900px'; 

            // Adjust other containers if needed
            otherContainers.forEach((container) => {
            if (container.classList.contains('col-md-8')) {
                container.style.width = '120%'; // or whatever suits your layout
                container.style.transition = 'width 0.3s ease';
            } else if (container.classList.contains('rectangle-card')) {
                container.style.width = '24.5%';
            } else if (container.id === 'projectTable') {
                container.style.width = '100%';
            }
            });
        } else {
            // -------- EXPAND project card --------
            projectCard.style.width = '330px'; // expand the left card
            projectCard.style.height = ''; 
            toggleIcon.classList.remove('fa-chevron-right');
            toggleIcon.classList.add('fa-chevron-left');

            // Show the “Add Project” text when expanded
            addProjectBtnText.style.display = '';
            projectText.style.display = '';
            nav.style.display = '';
            navlist.style.display = '';
            pbutton.style.display = '';

            // Restore table card (remove manual width or reset to default)
            tableCard.style.width = '685px';

            // Reset other containers
            otherContainers.forEach((container) => {
            if (container.classList.contains('col-md-8')) {
                container.style.width = ''; // revert to default or auto
            } else if (container.classList.contains('rectangle-card')) {
                container.style.width = ''; // revert to default
            } else if (container.id === 'projectTable') {
                container.style.width = ''; // revert to default
            }
            });
        }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const table = $('#projectTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'print',
                        text: 'Print',
                        title: 'Project Data',
                        className: 'btn btn-light btn-sm'
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'CSV',
                        title: 'Project Data',
                        className: 'btn btn-light btn-sm'
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        title: 'Project Data',
                        className: 'btn btn-light btn-sm'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        title: 'Project Data',
                        className: 'btn btn-light btn-sm',
                        orientation: 'landscape',
                        pageSize: 'A4'
                    }
                ],
                scrollX: true,
                paging: true,
                searching: true,
                ordering: true
            });

            // Attach search functionality
            $('#searchTable').on('keyup', function () {
                table.search(this.value).draw();
            });

            // Attach button click handlers for dropdown
            $('#exportPrint').on('click', function () {
                table.button('.buttons-print').trigger();
            });

            $('#exportCSV').on('click', function () {
                table.button('.buttons-csv').trigger();
            });

            $('#exportExcel').on('click', function () {
                table.button('.buttons-excel').trigger();
            });

            $('#exportPDF').on('click', function () {
                table.button('.buttons-pdf').trigger();
            });
        });

    </script>

</body>
</html>