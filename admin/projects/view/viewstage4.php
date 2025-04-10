<!DOCTYPE html>
<?php 
include_once('../model/view_project.php');
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        /* Set Poppins as the default font for the entire document */
        body, html {
            font-family: 'Poppins', sans-serif;
        }

        /* Ensure headings and other elements use Poppins */
        h1, h2, h3, h4, h5, h6, p, span, button, input, a, label {
            font-family: 'Poppins', sans-serif;
        }

        /* Override any specific styles that may set a different font */
        .btn, .form-control, .table, .modal-title, .nav-item, .nav-link, .dropdown-item {
            font-family: 'Poppins', sans-serif !important;
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
    <style>
        .play-bt {
            background-color: white; /* White background */
            color: #36b9cc; /* Text color matching the sidebar */
            border: 2px solid #36b9cc; /* Border color */
            padding: 10px 20px; /* Padding for button size */
            border-radius: 50px; /* Rounded edges */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Elevated effect */
            font-family: 'Poppins', sans-serif;
            font-size: 14px; /* Adjust text size */
            transition: all 0.3s ease; /* Smooth transition for hover effect */
        }

        .play-bt:hover {
            background-color: #36b9cc; /* Change background to #36b9cc on hover */
            color: white; /* Change text color to white */
            border-color: #36b9cc; /* Maintain border color on hover */
            transform: translateY(-3px); /* Slight upward movement on hover */
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
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <!-- Sidebar -->
        <ul class="navbar-nav floating-sidebar" id="accordionSidebar" style="background-color:#36b9cc; width: 200px; transition: all 0.3s; padding-left: 20px;">
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
            <li class="nav-item " >
                <a class="nav-link selected " href="../../spportal.php" style="border-radius:10px;padding-left:10px;">
                    <i class="fas fa-fw fa-home"></i>
                    <span style="font-size:13px; font-family:'Poppins';">Dashboard</span>
                </a>
            </li>
            <li class="nav-item active" >
                <a class="nav-link" href="../../project_portal.php" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-calendar-alt" style="white"></i>
                    <span style="font-size:13px; font-family:'Poppins';">Projects</span>
                </a>
            </li>
            <li class="nav-item " >
                <a class="nav-link" href="../../contacts_portal.php" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-address-book"></i>
                    <span style="font-size:13px; font-family:'Poppins';">Teams</span>
                </a>
            </li>
            <li class="nav-item" >
                <a class="nav-link" href="../../employees_portal.php" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-users"></i>
                    <span style="font-size:13px; font-family:'Poppins'; ">Employees</span>
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
                <div id="topbartoggle" class="d-flex justify-content-between align-items-center fixed-top" style="background-color:white; padding-right:30px; padding-left:220px; z-index: 300;">
                    <!-- Left Section: Home and Welcome Message -->
                    <div class="d-flex align-items-center" style="margin-top: 10px;"> <!-- Added margin-top to lower the left section -->
                        <div>
                            <h1 style="color:#36b9cc; font-family:'Poppins'; font-weight:bold; margin-bottom: 1px;">Home</h1> <!-- Reduced spacing -->
                            <p style="font-size:15px; color: #555; font-family:'Poppins'; margin: 0px;">Welcome Back <?php echo $_SESSION['user_name']; ?>!</p>
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
                            </div>
                            <img src="<?php echo $_SESSION['image']; ?>" alt="Profile Picture" class="rounded-circle" style="width: 40px; height: 40px; margin-left: 10px; cursor: pointer;" onclick="togglePopup()">
                        </div>
                        <!-- Popup Container -->
                        <div id="popup-container" 
                            class="popup" 
                            style="position: absolute; top: 50px; right: 0; width: 200px; background-color: #fff; border: 1px solid #ccc; border-radius: 8px; padding: 10px; display: none; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                            <nav style="display: flex; flex-direction: column; font-family: 'Poppins'; font-size: 14px;">
                                <a href="#" class="popup-link" onclick="showProfile()">Profile</a>
                                <a href="#" class="popup-link" onclick="showProfile()">Settings</a>
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
                <div class="container-fluid">
                    <div class="col-md-12 mb-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                    <div class="stage-container" style="display: flex; justify-content: space-between; align-items: center; padding: 0px;">
                                    <div class="stage-title" style="width: 100%; text-align: left; margin-bottom: 0; padding-bottom: 0; display: flex; align-items: start;">
                                        <div style="margin-right: 10px;">
                                            <img src="../images/projecticon.png" alt="Project Icon" style="width: 60px; height: 60px; vertical-align: middle;" />
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <p style="color: #36b9cc; margin-top: 0; font-family: 'Poppins'; font-size:30px; font-weight:bold; display: inline;">PROJECT PROFILE</p>
                                            <p id="projectUniqueId" style="color: #36b9cc; margin-top: 0; margin-bottom: 5px; font-family: 'Poppins'; font-size: 12px; font-weight: 500;">
                                                Project ID: <span id="project-id-placeholder"><strong><?php echo htmlspecialchars($project['project_unique_id']); ?></strong></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="stage-percentage" style="width: 45%; text-align: right; font-size: 16px; color: #36b9cc;">
                                        <button onclick="history.back()" style="background: none; border: none; color: #36b9cc; font-size: 24px; cursor: pointer;">
                                            <i class="fas fa-arrow-left"></i> 
                                        </button>
                                    </div>
                                </div>
                                <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px"> 
                                    <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px">
                                        <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label for="clientCompany" class="form-label" style="font-size: 12px; color: white;">Client/Company</label>
                                                        <input readonly type="text" class="form-control input-sm" id="clientCompany" value="<?php echo htmlspecialchars($project['company_name']); ?>" style="font-size: 12px; color: #555; padding: 5px;" required>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label for="accountManager" class="form-label" style="font-size: 12px; color: white;">Account Manager</label>
                                                        <input readonly type="text" class="form-control" id="accountManager" value="<?php echo htmlspecialchars($project['account_manager']); ?>" style="font-size: 12px; color: #555; padding: 5px;" required>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label for="productType" class="form-label" style="font-size: 12px; color: white;">Product Type</label>
                                                        <input readonly type="text" class="form-control" id="currentStage" value="<?php echo htmlspecialchars($project['product_type']); ?>" style="font-size: 12px; color: #555; padding: 5px;" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label for="startDate" class="form-label" style="font-size: 12px; color: white;">Start Date</label>
                                                        <input readonly type="text" class="form-control" value="<?php echo htmlspecialchars($project['start_date']); ?>" id="startDate" style="font-size: 12px; color: #555; padding: 5px;" required>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label for="endDate" class="form-label" style="font-size: 12px; color: white;">End Date</label>
                                                        <input readonly type="text" class="form-control" value="<?php echo htmlspecialchars($project['end_date']); ?>" id="endDate" style="font-size: 12px; color: #555; padding: 5px;" required>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label for="source" class="form-label" style="font-size: 12px; color: white;">Source</label>
                                                        <input readonly type="text" class="form-control" value="<?php echo htmlspecialchars($project['source']); ?>" id="source" style="font-size: 12px; color: #555; padding: 5px;" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label for="status" class="form-label" style="font-size: 12px; color: white;">Status</label>
                                                        <input readonly type="text" class="form-control" value="<?php echo htmlspecialchars($project['status']); ?>" id="currentStage"  style="font-size: 12px; color: #555; padding: 5px;" required>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label for="currentStage" class="form-label" style="font-size: 12px; color: white;">Current Stage</label>
                                                        <input readonly type="text" class="form-control" id="currentStage" value="<?php echo htmlspecialchars($project['current_stage']); ?>" style="font-size: 12px; color: #555; padding: 5px;" required>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label for="clientType" class="form-label" style="font-size: 12px; color: white;">Client Type</label>
                                                        <input readonly type="text" class="form-control" id="currentStage" value="<?php echo htmlspecialchars($project['client_type']); ?>" style="font-size: 12px; color: #555; padding: 5px;" required>
                                                    </div>
                                                </div>
                                                <?php include("dirback/pro_stage_details.php"); ?>
                                                  
                                              
                                                <div class="container mt-4 p-3" style="background: white; border-radius: 8px;">
                                                    <h3 style="font-family: 'Poppins', sans-serif; font-weight: bold; color: #555; text-align: center; margin-bottom: 5pxpx;">Stage 4 of <?php echo htmlspecialchars($project['company_name']); ?></h3>
                                                   <!-- Row to hold the search bar and export buttons -->
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <!-- Placeholder for future left-side content (if needed) -->
                                                        <div></div>
                                                        <!-- Right side: Search bar and Export dropdown -->
                                                        <!-- <div class="d-flex align-items-center" style="gap: 10px;">
                                                            <button type="button" class="btn btn-link" onclick="refreshPage()" 
                                                                    style="font-size: 12px; text-decoration: underline; color: #36b9cc; margin: 0; padding: 0;">
                                                                Refresh
                                                            </button>
                                                            <div class="btn-group" role="group">
                                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" 
                                                                        style="font-size: 10px; height: 30px; margin: 0; border:none; background-color:#36b9cc">
                                                                    Export
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item" href="#" onclick="exportToPDF()">Download PDF</a></li>
                                                                    <li><a class="dropdown-item" href="#" onclick="exportToExcel()">Download Excel</a></li>
                                                                    <li><a class="dropdown-item" href="#" onclick="exportToCSV()">Download CSV</a></li>
                                                                    <li><a class="dropdown-item" href="#" onclick="printTable()">Print</a></li>
                                                                </ul>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <?php include('dirback/fetch_s4.php'); ?>
                                                    <div id="details-view" >
                                                       <?php
                                                        // Ensure data exists before populating the fields
                                                        if (!empty($data)) {
                                                            $stageFourRow = $data['stage_four'];
                                                            $requirements = $data['requirements'];
                                                        }
                                                        ?> 

                                                        <div class="container" style="background-color:white; padding: 10px; border-radius: 20px">
                                                            <div class="container" style="background-color:white; padding: 5px; border-radius: 20px">
                                                                <div class="row mb-3">
                                                                    <!-- Start Date -->
                                                                    <div class="col-md-3">
                                                                        <label style="font-size:12px; color:#555" class="form-label">Start Date</label>
                                                                        <input
                                                                            style="font-size:12px; color:#555"
                                                                            type="text"
                                                                            class="form-control"
                                                                            id="stage-four-start"
                                                                            readonly
                                                                            value="<?php echo htmlspecialchars($stageFourRow['start_date_stage_four'] ?? ''); ?>"
                                                                        >
                                                                    </div>
                                                                    <!-- End Date -->
                                                                    <div class="col-md-3">
                                                                        <label style="font-size:12px; color:#555" class="form-label">End Date</label>
                                                                        <input
                                                                            style="font-size:12px; color:#555"
                                                                            type="text"
                                                                            class="form-control"
                                                                            id="stage-four-end"
                                                                            readonly
                                                                            value="<?php echo htmlspecialchars($stageFourRow['end_date_stage_four'] ?? ''); ?>"
                                                                        >
                                                                    </div>
                                                                    <!-- Status -->
                                                                    <div class="col-md-3">
                                                                        <label style="font-size:12px; color:#555" class="form-label">Status</label>
                                                                        <input
                                                                            style="font-size:12px; color:#555"
                                                                            type="text"
                                                                            class="form-control"
                                                                            id="stage-four-status"
                                                                            readonly
                                                                            value="<?php echo htmlspecialchars($stageFourRow['status_stage_four'] ?? ''); ?>"
                                                                        >
                                                                    </div>
                                                                    <!-- Technology -->
                                                                    <div class="col-md-3">
                                                                        <label style="font-size:12px; color:#555" class="form-label">Technology</label>
                                                                        <input
                                                                            style="font-size:12px; color:#555"
                                                                            type="text"
                                                                            class="form-control"
                                                                            id="technology4"
                                                                            readonly
                                                                            value="<?php echo htmlspecialchars($stageFourRow['technology'] ?? ''); ?>"
                                                                        >
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <!-- Product -->
                                                                    <div class="col-md-3">
                                                                        <label style="font-size:12px; color:#555" class="form-label">Product</label>
                                                                        <input
                                                                            style="font-size:12px; color:#555"
                                                                            type="text"
                                                                            class="form-control"
                                                                            id="product4"
                                                                            readonly
                                                                            value="<?php echo htmlspecialchars($stageFourRow['product'] ?? ''); ?>"
                                                                        >
                                                                    </div>
                                                                    <!-- Deal Size -->
                                                                    <div class="col-md-3">
                                                                        <label style="font-size:12px; color:#555" class="form-label">Deal Size</label>
                                                                        <input
                                                                            style="font-size:12px; color:#555"
                                                                            type="number"
                                                                            class="form-control"
                                                                            id="dealSize4"
                                                                            readonly
                                                                            value="<?php echo htmlspecialchars($stageFourRow['deal_size'] ?? ''); ?>"
                                                                        >
                                                                    </div>
                                                                    <!-- Solution -->
                                                                    <div class="col-md-6">
                                                                        <label style="font-size:12px; color:#555" class="form-label">Solution</label>
                                                                        <textarea
                                                                            style="font-size:12px; color:#555"
                                                                            class="form-control"
                                                                            id="solution4"
                                                                            readonly
                                                                        ><?php echo htmlspecialchars($stageFourRow['solution'] ?? ''); ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="container" style="background-color:white; padding: 5px; border-radius: 20px">
                                                                <!-- Fixed Labels Row -->
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <label style="font-size:12px; color:#555" class="form-label">Requirement</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label style="font-size:12px; color:#555" class="form-label">Quantity</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label style="font-size:12px; color:#555" class="form-label">Bills of Materials</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label style="font-size:12px; color:#555" class="form-label">Pricing</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label style="font-size:12px; color:#555" class="form-label">Date Required</label>
                                                                    </div>
                                                                </div>

                                                                <!-- Container for input Rows -->
                                                                <div id="requirement-fields-container4">
                                                                    <!-- Loop over all Stage 4 requirements -->
                                                                    <?php if (!empty($requirements)): ?>
                                                                        <?php foreach ($requirements as $req4): ?>
                                                                            <div class="row mb-3 requirement-fields">
                                                                                <div class="col-md-2">
                                                                                    <input
                                                                                        style="font-size:12px; color:#555"
                                                                                        type="text"
                                                                                        class="form-control"
                                                                                        readonly
                                                                                        value="<?php echo htmlspecialchars($req4['requirement_four'] ?? ''); ?>"
                                                                                    >
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <input
                                                                                        style="font-size:12px; color:#555"
                                                                                        type="text"
                                                                                        class="form-control"
                                                                                        readonly
                                                                                        value="<?php echo htmlspecialchars($req4['quantity'] ?? ''); ?>"
                                                                                    >
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <input
                                                                                        style="font-size:12px; color:#555"
                                                                                        type="text"
                                                                                        class="form-control"
                                                                                        readonly
                                                                                        value="<?php echo htmlspecialchars($req4['bill_of_materials'] ?? ''); ?>"
                                                                                    >
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <input
                                                                                        style="font-size:12px; color:#555"
                                                                                        type="text"
                                                                                        class="form-control"
                                                                                        readonly
                                                                                        value="<?php echo htmlspecialchars($req4['pricing'] ?? ''); ?>"
                                                                                    >
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <input
                                                                                        style="font-size:12px; color:#555"
                                                                                        type="text"
                                                                                        class="form-control"
                                                                                        readonly
                                                                                        value="<?php echo htmlspecialchars($req4['date_required'] ?? ''); ?>"
                                                                                    >
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    <?php else: ?>
                                                                        <p style="font-size:12px; color:#555;">No requirements found.</p>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>

                                                            <!-- Stage Remarks -->
                                                            <div class="container" style="background-color:white; padding: 10px; border-radius: 20px">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label style="font-size:12px; color:#555" class="form-label">Stage Remarks</label>
                                                                        <input
                                                                            style="font-size:12px; color:#555"
                                                                            type="text"
                                                                            class="form-control"
                                                                            id="stage-four-remarks"
                                                                            style="height: 50px;"
                                                                            readonly
                                                                            value="<?php echo htmlspecialchars($stageFourRow['stage_four_remarks'] ?? ''); ?>"
                                                                        >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
 
                                                    </div>
                                                </div>
                                                <style>
                                                    .action-buttons {
                                                        display: flex;
                                                        gap: 10px; /* Space between buttons */
                                                        align-items: center;
                                                    }
                                                    

                                                    .action-buttons .view-btn i,
                                                    .action-buttons .edit-btn i,
                                                    .action-buttons .delete-btn i {
                                                        transition: color 0.3s ease, transform 0.3s ease;
                                                        cursor: pointer;
                                                    }

                                                    .action-buttons .view-btn i:hover {
                                                        color: #009394; /* Hover color for view icon */
                                                        transform: scale(1.2); /* Slightly enlarge */
                                                    }

                                                    .action-buttons .edit-btn i:hover {
                                                        color: #009394; /* Hover color for edit icon */
                                                        transform: scale(1.2); /* Slightly enlarge */
                                                    }

                                                    .action-buttons .delete-btn i:hover {
                                                        color: #cc0000; /* Hover color for delete icon */
                                                        transform: scale(1.2); /* Slightly enlarge */
                                                    }

                                                </style>

                                                    <div class="container" style="background-color: #36b9cc; padding-top: 100px; border-radius: 20px; position: relative;">
                                                        <?php if ($status === 'Completed'): ?>
                                                            <!-- Show the "Complete Project" button -->
                                                           <button 
                                                                class="btn btn-white play-btn" 
                                                                id="completeProjectButton" 
                                                                onclick="completeProject('<?php echo htmlspecialchars($project['project_unique_id']); ?>')"
                                                                style="position: absolute; bottom: 10px; right: 10px;">
                                                                <i class="fas fa-play"></i> Complete Project
                                                            </button>
                                                        <?php elseif ($status != 'Ongoing'): ?>
                                                            <!-- Original logic: if not 'Ongoing', show "Start Journey" -->
                                                            <button 
                                                                class="btn btn-white play-btn" 
                                                                id="startJourneyButton" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#startJourneyModal" 
                                                                style="position: absolute; bottom: 10px; right: 10px;">
                                                                <i class="fas fa-play"></i> Start Journey
                                                            </button>
                                                        <?php else: ?>
                                                            <!-- Otherwise, show "Continue Journey" -->
                                                            <button 
                                                                class="btn btn-white play-btn" 
                                                                id="continueJourneyButton" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#multiStepModal" 
                                                                onclick="openModal('<?php echo htmlspecialchars($project['project_unique_id']); ?>')"
                                                                style="position: absolute; bottom: 10px; right: 10px;">
                                                                <i class="fas fa-play"></i> Continue Journey
                                                            </button>
                                                            <?php include("multistepModal.php"); ?>
                                                        <?php endif; ?>
                                                    </div>

                                                    <style>
                                                        .btn.play-btn {
                                                            background-color: white;
                                                            border: 2px solid #36b9cc; /* Button border color */
                                                            color: #36b9cc; /* Text color */
                                                            padding: 10px 20px;
                                                            font-size: 16px;
                                                            font-weight: bold;
                                                            border-radius: 5px;
                                                            display: flex;
                                                            align-items: center;
                                                            gap: 10px; /* Space between icon and text */
                                                            transition: all 0.3s ease;
                                                        }

                                                        /* Style for the icon inside the button */
                                                        .btn.play-btn i {
                                                            color: #36b9cc; /* Icon color */
                                                            transition: color 0.3s ease; /* Smooth transition when changing color */
                                                        }

                                                        /* Button hover effect */
                                                        .btn.play-btn:hover {
                                                            background-color: #36b9cc; /* Change background color on hover */
                                                            color: white; /* Change text color on hover */
                                                            border-color:white; /* Change border color on hover */
                                                            
                                                        }

                                                        /* Change icon color when the button is hovered */
                                                        .btn.play-btn:hover i {
                                                            color: white; /* Change icon color to white on hover */
                                                        }

                                                        /* Button focus effect */
                                                        .btn.play-btn:focus {
                                                            box-shadow: 0 0 5px rgba(54, 185, 204, 0.5); /* Light shadow for focus effect */
                                                        }

                                                        /* Button disabled state */
                                                        .btn.play-btn:disabled {
                                                            background-color: #f1f1f1;
                                                            color: #aaa;
                                                            border-color: #ddd;
                                                            cursor: not-allowed;
                                                        }


                                                    </style>
                                                    <!-- Start Journey Modal -->
                                                    <div class="modal fade" id="startJourneyModal" tabindex="-1" aria-labelledby="startJourneyModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="startJourneyModalLabel" style="font-family:'Poppins'; font-size:'12px'; color:#36b9cc;" >Are you sure to start your journey?</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Confirm to start
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="button" class="btn " style="font-size:15px; font-family:'Poppins'; color: white; background: #36b9cc" onclick="startPhase()">Yes, Start Journey</button>
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../index.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    
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

    <script src="../js/demo/datatables-demo.js"></script>
    <script src="openModal.js"></script>
    <script src="comProj.js"></script>
    <script src="toogleNav.js"></script>
    <script src="alerts/notif.js"></script>
    <script src="alerts/notifCount.js"></script>
    <script src="current_year.js"></script>
    <!-- Table Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="dirviewproject.js"></script>
    <script src="notif.js"></script>
    <script>

    </script>
    
    <script>
        // Export to PDF
        async function exportToPDF() {
            const { jsPDF } = window.jspdf; // Get jsPDF
            const doc = new jsPDF();

            // Add title to the PDF
            doc.setFontSize(16);
            doc.text("Project Stages", 14, 20);

            // Fetch the table
            const table = document.getElementById("stageTable");

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
            doc.save("ProjectStages.pdf");
        }

        // Export to CSV
        function exportToCSV() {
            const table = document.getElementById("stageTable");
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
            link.setAttribute("download", "Projectstages.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Export to Excel
        function exportToExcel() {
            const table = document.getElementById("stageTable");

            // Convert HTML table to an array of arrays
            const rows = Array.from(table.rows).map(row =>
                Array.from(row.cells).map(cell => cell.innerText)
            );

            // Create a new workbook and worksheet
            const workbook = XLSX.utils.book_new();
            const worksheet = XLSX.utils.aoa_to_sheet(rows); // Convert array of arrays to a sheet

            // Append worksheet to workbook
            XLSX.utils.book_append_sheet(workbook, worksheet, "Project Stages");

            // Write file
            XLSX.writeFile(workbook, "Project Stages.xlsx");
        }

        // Print Table
        function printTable() {
            const printContent = document.getElementById("stageTable").outerHTML;
            const newWindow = window.open("", "", "width=800,height=600");
            newWindow.document.write("<html><head><title>Project Stages</title></head><body>");
            newWindow.document.write(printContent);
            newWindow.document.write("</body></html>");
            newWindow.document.close();
            newWindow.print();
        }
    </script>



    <script>
        // Refresh the page
        function refreshPage() {
            location.reload();
        }
    </script>
    <script>
        // Function to start the phase
function startPhase() {
    // Fetch the project ID from the <strong> tag
    var projectId = document.querySelector("#project-id-placeholder strong").textContent.trim();
    console.log("Project ID from HTML: " + projectId); // Debugging line to confirm the project ID

    // Get the current date in YYYY-MM-DD format
    var currentDate = new Date().toISOString().slice(0, 10);

    // Create an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "start_project.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Send the start date and project ID to the server
    xhr.send("start_date=" + encodeURIComponent(currentDate) + "&project_id=" + encodeURIComponent(projectId));

    // Handle the response
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText); // Assuming the response is JSON
            console.log(response); // Debugging line to check the response

            if (response.status === 'error') {
                // Handle error (project not found or access denied)
                alert(response.message); // Display the error message
            } else {
                // Update the button text based on the project status
                var button = document.querySelector(".play-btn");

                if (response.project_status === 'Ongoing') {
                    button.innerHTML = '<i class="fas fa-play"></i> Continue Journey'; // Change text to Continue Journey
                    button.id = "continueJourneyButton"; // Update the button ID
                    button.setAttribute("onclick", "continuePhase()"); // Update the onclick action
                } else {
                    button.innerHTML = '<i class="fas fa-play"></i> Start Journey'; // Default text
                }

                // Dismiss the modal programmatically
                var modal = document.getElementById("startJourneyModal");
                var modalInstance = bootstrap.Modal.getInstance(modal);
                modalInstance.hide();

                // Show a success message
                alert(response.message);
            }
        } else {
            alert("Failed to update start date.");
        }
    };
}

// Function to check project status on page load
function checkProjectStatus() {
    var projectId = document.querySelector("#project-id-placeholder strong").textContent.trim();

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "check_project_status.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Send the project ID to check the status
    xhr.send("project_id=" + encodeURIComponent(projectId));

    // Handle the response
    xhr.onload = function() {
        if (xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            console.log(response); // Debugging line to check the response

            if (response.status === 'success') {
                var button = document.querySelector(".play-btn");

                if (response.project_status === 'Ongoing') {
                    button.innerHTML = '<i class="fas fa-play"></i> Continue Journey'; // Change text to Continue Journey
                    button.setAttribute("onclick", "continuePhase()"); // Update the onclick action
                } else {
                    button.innerHTML = '<i class="fas fa-play"></i> Start Journey'; // Default text
                    button.setAttribute("onclick", "startPhase()"); // Set onclick action for start
                }
            }
        }
    };
}

// Call the function to check project status when the page loads
// window.onload = function() {
//     checkProjectStatus();
// };

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
    // Function to fetch project stage and navigate to the correct step
    function checkProjectStageAndNavigate() {
        // Fetch the project ID from the <strong> tag
        var projectId = document.querySelector("#project-id-placeholder strong").textContent.trim();
        console.log("Project ID from HTML: " + projectId); // Debugging line to confirm the project ID

        // Make an AJAX request to fetch the current stage of the project
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "dirback/current_stage.php", true);  // Your PHP script to get current stage
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Send the project ID to the server
        xhr.send("project_id=" + encodeURIComponent(projectId));

        // Handle the response when the request is complete
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);

                if (response.status === 'success') {
                    var currentStage = response.current_stage;  // Get the current stage from the response
                    console.log("Current Stage: " + currentStage);  // Debugging the current stage

                    // Map the current stage to the corresponding step in the modal
                    var stageToStepMap = {
                        'Stage 1': '#step1',
                        'Stage 2': '#step2',
                        'Stage 3': '#step3',
                        'Stage 4': '#step4',
                        'Stage 5': '#step5'
                    };

                    // If a valid stage exists, show the corresponding step
                    if (stageToStepMap[currentStage]) {
                        // Hide all steps before showing the relevant one
                        $('.step').hide();  // Hide all steps
                        $(stageToStepMap[currentStage]).show();  // Show the corresponding step
                    }
                } else {
                    alert('Error fetching project stage');
                }
            } else {
                alert('Failed to fetch project stage');
            }
        };
    }

    // Call the function on page load or when the modal is triggered
    document.addEventListener('DOMContentLoaded', function() {
        checkProjectStageAndNavigate();
    });
    </script>




</body>
</html>