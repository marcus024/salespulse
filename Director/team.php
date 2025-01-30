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
            color: #76777a;  /* Optional: Adjust text color when the item is active */
            font-weight: bold; /* Optional: Make the active menu text bold */
            border-radius:10px;
            margin-bottom:5px;
        }
        /* Active Nav Item Background Color */
        .nav-item.active .nav-link {
            padding-left:10px;
            background-color: #2a2925; /* Change this color to your preferred background color */
            color: white; /* Optional: Adjust text color when the item is active */
            font-weight: bold; /* Optional: Make the active menu text bold */
            border-radius:10px;
            margin-bottom:5px;
            border-left: 5px solid var(--accent-color);
        }
        /* Hover Effect for Nav Items */
        .nav-item .nav-link:hover {
            padding-left:10px;
            background-color: #2a2925; /* Same color for hover effect */
            color: white; /* Text color for hover */
            border-radius:10px;
            margin-bottom:5px;
            border-left: 5px solid var(--accent-color);
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
            <li class="nav-item active" >
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
                <div id="topbartoggle" class="d-flex justify-content-between align-items-center fixed-top" style="background-color:#15151a; padding-right:30px; padding-left:220px; z-index: 300;">
                    <!-- Left Section: Home and Welcome Message -->
                    <div class="d-flex align-items-center" style="margin-top: 30px;"> <!-- Added margin-top to lower the left section -->
                        <div>
                            <h1 style="color:#73726e; font-family:'Poppins'; font-weight:bold; margin-bottom: 1px;">Team Members</h1> <!-- Reduced spacing -->
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
                <!-- Begin Page Content -->
                <div class="container-fluid" style=" background-color:#15151a;">
                    <div class="row">
                        <!-- Narrow Container for Add Calendar -->
                        <div class="col-md-3 mb-4">
                            <div class="card shadow-sm" style="background-color:#1f2024; border:none;">
                                <div class="card-body">
                                    <p style="font-family:'Poppins'; font-size:15px; font-weight:700; color:#555">Team Members</p>
                                    <a href="#" class="btn btn-info btn-icon-split w-70" style="background-color:#f9ce45; border:none;" data-bs-toggle="modal" data-bs-target="<?php echo ($_SESSION['role'] === 'salesdirector' || $_SESSION['role'] === 'unithead') ? '#addTeam' : '#contactAdmin'; ?>">
                                        <span class="icon text-white-0">
                                        <i class="fas fa-plus"></i>
                                        </span>
                                        <style>
                                            .icon i{
                                                background: none;
                                                border: none;
                                                padding: 0;
                                                margin: 0;
                                                box-shadow: none; 
                                                display: inline-block; 
                                                color: #1f2024; 
                                                font-size: 16px;
                                            }
                                        </style>
                                        <span class="text" style="font-family:'Poppins'; color:#1f2024">Add Members</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Wide Container for Calendar Content -->
                        <div class="col-md-9 mb-4">
                            <div class="card shadow-sm" style="background: #1f2024; border:none;">
                                <div class="card-body" id="calendar-container" style="min-height: 400px; color: white;">
                                    <h1 class="h5 mb-4" style="font-family:'Poppins'">My Team Members</h1>
                                    <!-- Contact List Cards -->
                                    <div id="contact-list" class="contact-list">
                                        <style>
                                            #contact-list {
                                                    max-height: 400px;
                                                    overflow-x: auto;
                                                    padding-right: 10px; 
                                                }
                                                #contact-list::-webkit-scrollbar {
                                                    width: 8px;
                                                }
                                                #contact-list::-webkit-scrollbar-thumb {
                                                    background-color: #009394;
                                                    border-radius: 4px;
                                                }
                                                #contact-list::-webkit-scrollbar-thumb:hover {
                                                    background-color: #004d47;
                                                }
                                                #contact-list::-webkit-scrollbar-track {
                                                    background: #f0f0f0;
                                                }
                                        </style>
                                        <!-- Example Contact Card 1 -->
                                        <?php
                                            include("dirback/fetchTeam.php");

                                            if (empty($teamMembers)) {
                                                echo "<p>No team members found.</p>";
                                            } else {
                                                foreach ($teamMembers as $member):
                                            ?>
                                            <div class="card mb-3" style="border-radius: 20px;">
                                                <div class="card-header" style="font-family:'Poppins';background: linear-gradient(to right, #36b9cc,rgb(25, 230, 230)); color: white; border-radius:20px; font-size: 18px; font-weight: bold;">
                                                    Profile
                                                </div>
                                                <div class="card-body" style="background-color: white; color: #555; padding: 10px; border-radius:20px; padding-left: 20px;">
                                                    <div class="d-flex align-items-center mb-2" style="gap: 30px;">
                                                        <img src="../images/<?php echo ($member['gender'] === 'Male') ? 'man.png' : 'woman.png'; ?>" 
                                                            alt="Profile Picture" class="contact-image" 
                                                            style="width: 130px; height: 130px; border-radius: 50%;">
                                                        <div class="contact-info">
                                                            <p class="mb-1" style="font-size: 30px; font-weight: bold; font-family: 'Poppins';">
                                                                <?php echo htmlspecialchars($member['name']); ?>
                                                            </p>
                                                            <p class="mb-1" style="font-size: 15px; font-family: 'Poppins';">
                                                                <?php echo htmlspecialchars($member['role_display']); ?>
                                                            </p>
                                                            <div class="row mt-0" style="gap: 10px; padding-right:5px;">
                                                                <div class="col card text-center" style="border-color:white; background: white; border-radius: 15px; padding: 2px; width: 140px;">
                                                                    <p style="font-size: 30px; color:#006270; font-weight: bold; margin: 0; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">
                                                                        <?php echo $member['completed_projects'] ?? 0; ?>
                                                                    </p>
                                                                    <p style="font-size: 9px; font-weight: bold; color: #006270; margin: 0; width: 100%;">Completed Projects</p>
                                                                </div>
                                                                <div class="col card text-center" style="border-color:white; background: white; border-radius: 15px; padding: 2px; width: 140px;">
                                                                    <p style="font-size: 30px; color:#006270; font-weight: bold; margin: 0; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">
                                                                        <?php echo $member['ongoing_projects'] ?? 0; ?>
                                                                    </p>
                                                                    <p style="font-size: 9px; font-weight: bold; color: #006270; margin: 0; width: 100%;">Ongoing Projects</p>
                                                                </div>
                                                                <div class="col card text-center" style="border-color:white; background: white; border-radius: 15px; padding: 2px; width: 100px;">
                                                                    <p style="font-size: 30px; color:#006270; font-weight: bold; margin: 0; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">
                                                                        <?php echo $member['cancelled_projects'] ?? 0; ?>
                                                                    </p>
                                                                    <p style="font-size: 9px; font-weight: bold; color:#006270; margin: 0; width: 100%;">Cancelled Projects</p>
                                                                </div>
                                                                <div class="col card text-center" style="border-color:white; background: white; border-radius: 15px; padding: 2px; width: 140px;">
                                                                    <p style="font-size: 30px; color:#006270; font-weight: bold; margin: 0; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">
                                                                        <?php echo $member['avg_project_duration'] ?? 0; ?>
                                                                    </p>
                                                                    <p style="font-size: 9px; font-weight: bold; color:#006270; margin: 0; width: 100%;">Avg. Days/Comp. Proj.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <!-- Modals -->
            <!-- Contact Admin Modal -->
            <div class="modal fade" id="contactAdmin" tabindex="-1" aria-labelledby="contactAdminLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div style="background-color:red; border:none;" class="modal-header">
                            <h6 style="color:white;"class="modal-title" id="contactAdminLabel">Access Denied</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="background:#1f2024;">
                            <p style="color:white;">You are not authorized to add team members. Please contact your admin or head for assistance.</p>
                        </div>
                    </div>
                </div>
            </div>
             <!-- Add Team Modal -->
                <div class="modal fade" id="addTeam" tabindex="-1" aria-labelledby="addTeamModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header" style="background-color:#f9ce45; color:#1f2024; height: 50px;">
                                <h5 class="modal-title" id="addTeamModalLabel" style="font-family:'Poppins'; color:#1f2024; font-size: 15px; ">Add Team Member</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body" style="height: 400px; background:#1f2024; ">
                                <!-- Search Engine -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <input type="text" id="userSearch" class="form-control" onkeyup="filterUsers()" placeholder="Search users by name or position..." 
                                            style="font-family:'Poppins'; font-size: 14px; border: 1px solid #36b9cc; border-radius: 4px; padding: 8px;">
                                    </div>
                                </div>
                                <style>
                                /* Optional: Add a border or styling for the scrollable area */
                                    .userClass::-webkit-scrollbar {
                                        width: 4px; /* Width of the vertical scrollbar */
                                        height: 4px; /* Height of the horizontal scrollbar */
                                    }

                                    .userClass::-webkit-scrollbar-thumb {
                                        background-color: #36b9cc;
                                        border-radius: 10px;
                                        height: 5px; /* Minimum height for the scrollbar thumb */
                                    }

                                    .userClass::-webkit-scrollbar-thumb:hover {
                                        background-color: #555;
                                    }
                                </style>
                                <!-- User List -->
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="list-group" id="userList" class="userClass" style="max-height: 380px; overflow-y: auto;">
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="font-family:'Poppins'; font-size: 12px;">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <a class="btn btn-primary" href="index.php">Logout</a>
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
    <script src="toogleNav.js"></script>
    <script src="alerts/notif.js"></script>
    <script src="alerts/notifCount.js"></script>
    <script src="current_year.js"></script>
    <!-- <script>
        // Toggle sidebar collapse
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            const sidebar = document.getElementById('accordionSidebar');
            sidebar.classList.toggle('collapsed');
        });
    </script> -->
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
    let users = []; // Global variable to store the fetched users
    

    // Fetch users dynamically from the server
    async function fetchUsers() {
        try {
            const response = await fetch("dirback/teamUser.php");
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            users = await response.json(); // Store the users globally
            renderUserList(users); // Render the initial user list
        } catch (error) {
            console.error("Error fetching users:", error);
        }
    }

    // Render user list dynamically
    function renderUserList(userList) {
        const userListContainer = document.getElementById("userList");
        userListContainer.innerHTML = ""; // Clear existing list

        userList.forEach(user => {
            const li = document.createElement("li");
            li.className = "list-group-item d-flex justify-content-between align-items-center";
            li.style.fontFamily = "Poppins";
            li.style.fontSize = "14px";

            li.innerHTML = `
                <div>
                    <strong>${user.name}</strong>
                    <p class="mb-0 text-muted" style="font-size: 12px;">${user.position}</p>
                </div>
                <button class="btn btn-sm btn-primary" style="background-color: #36b9cc; border: none;" onclick="addUser('${currentUserId}', '${user.user_id_current}')">
                    <i class="fas fa-plus"></i> Add
                </button>
            `;

            userListContainer.appendChild(li);
        });
    }

    // Filter user list based on search input
    function filterUsers() {
        const searchValue = document.getElementById("userSearch").value.toLowerCase();
        const filteredUsers = users.filter(user => 
            user.name.toLowerCase().includes(searchValue) || user.position.toLowerCase().includes(searchValue)
        );

        renderUserList(filteredUsers); // Render the filtered list
    }

   // Add user function (custom logic to handle adding the user)
    async function addUser(currentUserId, selectedUserId) {
         const confirmAdd = confirm(`Are you sure you want to add user with ID ${selectedUserId} to your team?`);

        if (!confirmAdd) {
            // If the user cancels, exit the function
            return;
        }
        try {
            // Send the user IDs to the backend
            const response = await fetch("dirback/addTeam.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    head_user_id: currentUserId,
                    team_user_id: selectedUserId,
                }),
            });

            // Parse the response
            const result = await response.json();

            if (result.success) {
                alert(`User successfully added to the team: ${result.message}`);
                window.location.reload();
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.error("Error adding user to the team:", error);
            alert("Failed to add user to the team. Please try again.");
        }
    }


    // Initialize the user list on page load
    document.addEventListener("DOMContentLoaded", () => {
        fetchUsers(); // Fetch the users list
    });
</script>



</body>

</html>