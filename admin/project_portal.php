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
     <!-- Include Bootstrap CSS for styling -->
 
    <!-- Include Font Awesome for icons -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrQkTy9I6bLXJe5B4zEfaQf0P3x7Ih94c5eNsDcFpzNxXk3mOZZYC+iF+Iq5LZkzx7u+0dZPhu7GDYkNzg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/spportal.css" rel="stylesheet">
    <link href="css/user_date_dp.css" rel="stylesheet">
    <link href="css/fetch_user_table.css" rel="stylesheet">

</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
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
                <a class="nav-link selected " href="spportal.php" style="border-radius:10px;padding-left:10px;">
                    <i class="fas fa-fw fa-home"></i>
                    <span style="font-size:13px; font-family:'Poppins';">Dashboard</span>
                </a>
            </li>
            <li class="nav-item active" >
                <a class="nav-link" href="project_portal.php" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-calendar-alt" style="white"></i>
                    <span style="font-size:13px; font-family:'Poppins';">Projects</span>
                </a>
            </li>
            <li class="nav-item " >
                <a class="nav-link" href="contacts_portal.php" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-address-book"></i>
                    <span style="font-size:13px; font-family:'Poppins';">Teams</span>
                </a>
            </li>
            <li class="nav-item" >
                <a class="nav-link" href="employees_portal.php" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-users"></i>
                    <span style="font-size:13px; font-family:'Poppins'; ">Employees</span>
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
                    <div class="d-flex align-items-center" style="margin-top: 30px;"> <!-- Added margin-top to lower the left section -->
                        <div>
                            <h1 style="color:#36b9cc; font-family:'Poppins'; font-weight:bold; margin-bottom: 1px;">PORTAL</h1> <!-- Reduced spacing -->
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
                        
                    </div>
                </div>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Cards Content -->
                     <div class="col-mb-12" >
                        <div class="card" style="background-color:transparent; border: none;"  >
                            <div class="card-body" style="margin-top: 0.25rem; margin-bottom: 0.5rem; background-color:transparent;">
                                <!-- Start of Cards -->
                                <div class="row" style="padding: 10px; gap: 4px; margin-top: -0.5rem;"> <!-- Reduced margin above cards -->
                                    <div class="rectangle-card" onclick="filterTable('Completed')">
                                        <i class="card-icon">
                                            <img src="../images/comP.png" alt="icon" width="30" height="30">
                                        </i>
                                        <div class="card-content">
                                            <div class="card-title" style="font-family:'Poppins'">USERS</div>
                                            <div id="totalUsers" class="card-number" style="font-family:'Poppins'">0</div>
                                        </div>
                                    </div>
                                    <div class="rectangle-card" onclick="filterTable('Ongoing')">
                                        <i class="card-icon">
                                            <img src="../images/ongoingP.png" alt="icon" width="30" height="30">
                                        </i>
                                        <div class="card-content">
                                            <div class="card-title" style="font-family:'Poppins'">PROJECTS</div>
                                            <div id="totalProjects" class="card-number" style="font-family:'Poppins'">0</div>
                                        </div>
                                    </div>
                                    <div class="rectangle-card" onclick="filterTable('Cancelled')">
                                        <i class="card-icon">
                                            <img src="../images/cancelP.png" alt="icon" width="30" height="30">
                                        </i>
                                        <div class="card-content">
                                            <div class="card-title" style="font-family:'Poppins'">DURATION</div>
                                            <div class="card-number" style="font-family:'Poppins'" id="avgDuration">0</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="dropdown">
                                            <button class="btn dropdown-card w-100 dropdown-toggle text-truncate" type="button" id="usersDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <img src="../images/user.png" style="height:30px; width:30px;" alt="month">
                                                <div class="card-content">
                                                    <div class="card-title">Users</div>
                                                    <div class="card-number text-truncate" id="selected-user" title="Select">Select</div>
                                                </div>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="usersDropdown" id="usersDropdownMenu">
                                                <!-- Dropdown items will be dynamically added here -->
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="dropdown">
                                            <button class="btn dropdown-card w-100 dropdown-toggle" type="button" id="usersDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <img src="../images/project.png" style="height:30px; width:30px;" alt="month">
                                                <div class="card-content">
                                                    <div class="card-title">Projects</div>
                                                    <div class="card-number" id="selected-user">Select </div>
                                                </div>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="projectsDropdown" id="projectsDropdownMenu">
                                                
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Months Dropdown -->
                                    <div class="col">
                                        <div class="dropdown">
                                            <button class="btn dropdown-card w-100 dropdown-toggle" type="button" id="monthsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <img src="../images/month.png" style="height:30px; width:30px;" alt="month">
                                                <div class="card-content">
                                                    <div class="card-title">Months</div>
                                                    <div class="card-number" id="selected-month">Select </div>
                                                </div>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="monthsDropdown" id="monthsDropdownMenu">
                                                <li><a class="dropdown-item month-item" data-month="All" href="#">All Months</a></li>
                                                <li><a class="dropdown-item month-item" data-month="January" href="#">January</a></li>
                                                <li><a class="dropdown-item month-item" data-month="February" href="#">February</a></li>
                                                <li><a class="dropdown-item month-item" data-month="March" href="#">March</a></li>
                                                <li><a class="dropdown-item month-item" data-month="April" href="#">April</a></li>
                                                <li><a class="dropdown-item month-item" data-month="May" href="#">May</a></li>
                                                <li><a class="dropdown-item month-item" data-month="June" href="#">June</a></li>
                                                <li><a class="dropdown-item month-item" data-month="July" href="#">July</a></li>
                                                <li><a class="dropdown-item month-item" data-month="August" href="#">August</a></li>
                                                <li><a class="dropdown-item month-item" data-month="September" href="#">September</a></li>
                                                <li><a class="dropdown-item month-item" data-month="October" href="#">October</a></li>
                                                <li><a class="dropdown-item month-item" data-month="November" href="#">November</a></li>
                                                <li><a class="dropdown-item month-item" data-month="December" href="#">December</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="container my-0 px-0"> <!-- Remove padding with px-0 -->
                                        <!-- Row to Hold the Cards -->
                                        <div class="row mx-0"> <!-- Remove margin with mx-0 -->
                                            <div class="col-md-6" >
                                                <div class="card shadow mb-4">
                                                    <div class="card-header">
                                                    <h6 class="m-0 font-weight-bold " style="color:#36b9cc">Projects per Account Manager</h6>
                                                    </div>
                                                    <div class="card-body" style="height: 500px;">
                                                    <canvas id="projectsPerAccountManagerChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card shadow mb-4">
                                                    <div class="card-header">
                                                        <h6 class="m-0 font-weight-bold " style="color:#36b9cc">Project Status Distribution</h6>
                                                    </div>
                                                    <div class="card-body" style="height: 500px;">
                                                        <canvas id="projectStatusChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="card shadow mb-4">
                                                    <div class="card-header py-2 d-flex justify-content-between align-items-center">
                                                        <h6 class="m-0 font-weight-bold" style="color:#36b9cc;">Projects</h6>
                                                        <!-- Row to hold the search bar and dropdowns -->
                                                        <div class="d-flex align-items-center" style="gap: 10px;">
                                                            <!-- Search Bar -->
                                                            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." 
                                                                style="font-size: 10px; border: 1px solid #36b9cc; border-radius: 4px; outline: none; width: 200px; height: 30px; margin: 0;">
                                                            
                                                            <!-- Dropdown for Export Options -->
                                                            <div class="btn-group" role="group">
                                                                <!-- Export Dropdown -->
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
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive" style="max-height: 250px; overflow-y: auto; ">
                                                            <table id="appUserTable" class="table table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Project ID</th>
                                                                    <th>Client Name</th>
                                                                    <th>Account Manager</th>
                                                                    <th>Product Type</th>
                                                                    <th>Source</th>
                                                                    <th>Current Stage</th>
                                                                    <th>Start Date</th>
                                                                    <th>End Date</th>
                                                                    <th>Status</th>
                                                                    <th>Duration</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
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
                    <!-- End of Cards -->
                </div>
                <!-- /.container-fluid -->
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

    <!-- Table Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Calendar script (if needed in the future) -->
    <!-- <script src="path_to_calendar_script.js"></script> -->
    <script src="../Director/toogleNav.js"></script>
    <script src="js/export_table.js"></script>
    <script src="js/search_item.js"></script>
    <script src="js/fetch_project_table.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
</body>
</html>