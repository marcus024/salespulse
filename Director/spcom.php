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
            <li class="nav-item active" >
                <a class="nav-link" href="spcom.php" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-money-bill-wave"></i>
                    <span style="font-size:13px; font-family:'Poppins'; ">Commissions</span>
                </a>
            </li>
            <li class="nav-item " >
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
                            <h1 style="color:#73726e; font-family:'Poppins'; font-weight:bold; margin-bottom: 1px;">Commissions</h1> <!-- Reduced spacing -->
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
                <!-- End of Topbar -->
                <div class="container-fluid" style=" background-color:#15151a;">
                    <div class="row">
                        <!-- Commission Calculator -->
                        <div class="col-md-3 mb-4">
                            <div class="card shadow-sm" style="background-color:#1f2024; border:none;">
                                <div class="card-body">
                                    <p style="color:#ddd; font-weight:bold; font-size:20px; font-family:'Poppins' ">SaleSync</p>
                                    <form id="commission-form">
                                        <div class="mb-1">
                                            <label for="grossProfit" class="form-label ">Actual Gross Profit</label>
                                            <input type="number" class="form-control" id="actualGross" name="grossProfit" placeholder="Enter actual gross profit" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="netSales" class="form-label ">Target Gross Profit</label>
                                            <input type="number" class="form-control" id="targetGross" name="netSales" placeholder="Enter net sales">
                                        </div>
                                        <button type="button" class="btn w-100 calcBtn">Calculate</button> <!-- Changed type to 'button' -->
                                    </form>
                                    <div style="margin-top:20px;">
                                        <p style="color:white;  font-family:'Poppins'; font-size:15px; ">Potential Commission</p>
                                        <div style=" border-radius: 10px; height:70px; background:#2a2925; padding:20px;">
                                            <p id="potentialCommission" style="color:white;  font-family:'Poppins'; font-size:15px; font-weight:bold;">
                                                
                                            </p>
                                        </div>
                                    </div>
                                    <div style="margin-top:20px;">
                                        <p style="color:white; font-weight:bold; font-size:15px; font-family:'Poppins';">History</p>
                                        <div id="recent-history" style="color:white; font-family:'Poppins'; font-size:14px;">
                                            <!-- Recent calculations will be dynamically inserted here -->
                                        </div>
                                        <p onclick="viewAllHistory()" style="color:#f9ce45; font-family:'Poppins'; font-size:12px; cursor:pointer; text-decoration:underline; margin-top:5px;">
                                            See All
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Chart Panels -->
                        <div class="col-md-9 mb-2">
                            <div class="card shadow-sm" style="background: #1f2024; border:none;">
                                <div class="card-body" id="calendar-container" style="min-height: 400px; background:#1f2024 ; margin-top: 0px; padding-top:0px;">
                                    <!-- Cards and Charts Here -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Table Panel -->
                    <div class="row">
                        <div class="col-md-13 mb-4">
                            <div class="card shadow-sm" style="background: #1f2024; border:none;">
                                <div class="d-flex justify-content-between align-items-center" style="padding: 10px 20px;">
                                    <!-- Title -->
                                    <p style="color:white; font-size:20px; font-family:'Poppins'; font-weight:bold; margin: 0;">Completed Projects Commissions</p>

                                    <!-- Row to hold the search bar and dropdowns -->
                                    <div class="d-flex align-items-center" style="gap: 10px;">
                                        <!-- Search Bar -->
                                        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." 
                                            style="background-color:#2a2925; color:white; font-size: 12px; border: none; font-family:'Poppins'; border-radius: 4px; outline: white; width: 200px; height: 30px; margin: 0; padding-left: 10px;">
                                        <!-- Dropdown for Export Options -->
                                        <div class="btn-group" role="group">
                                            <!-- Export Dropdown -->
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" 
                                                    style="color:black; font-size: 12px; font-family:'Poppins'; height: 30px; margin: 0; border:none; background-color:#f9ce45">
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

                                <div class="card-body" style="min-height: 400px; color: white; padding-top: 5px;">
                                    <!-- Table Header -->
                                    <div class="d-flex p-3 mb-2" style="background: #2a2925; border-radius: 8px; font-weight: bold;">
                                        <div class="col-2 comHead">Project Name</div>
                                        <div class="col-2 comHead">Start Date</div>
                                        <div class="col-2 comHead">End Date</div>
                                        <div class="col-2 comHead">Net Sales</div>
                                        <div class="col-2 comHead">Gross Profit</div>
                                        <div class="col-2 comHead">Commission</div>
                                    </div>

                                    <div id="commission-table">
                                        <!-- rows here -->
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


</body>
</html>