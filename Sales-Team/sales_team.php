<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Blank</title>

    <!-- Custom fonts for this template -->
    <link href="https://cdn.jsdelivr.net/npm/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> <!-- FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"> <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> <!-- Google Fonts Nunito -->

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet"> <!-- Your custom styles -->

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> <!-- DataTables CSS -->

    <style>
        .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5); /* Overlay color with opacity */
        backdrop-filter: blur(5px); /* Adjust blur intensity */
        }

        .modal-backdrop.show {
        transition: backdrop-filter 0.3s ease, background-color 0.3s ease;
        }
    </style>
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
            background-color: #009394;
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
            border: 1px solid #009394;
            border-radius: 4px;
            outline: none;
        }

        #searchInput:focus {
            border-color: #007b7f;
        }

        /* Pagination */
        .pagination {
            display: inline-block;
            margin-top: 10px;
        }

        .pagination a {
            padding: 5px 10px;
            margin: 0 5px;
            text-decoration: none;
            border: 1px solid #ddd;
            color: #009394;
            border-radius: 4px;
            font-size:10px;
        }

        .pagination a.active {
            background-color: #009394;
            color: white;
            border: 1px solid #009394;
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
            border: 1px solid #009394;
            border-radius: 4px;
            background-color: white;
            color: #009394;
            transition: background-color 0.3s, color 0.3s;
        }

        .action-buttons button:hover {
            background-color: #009394;
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
    /* General styles for the card */
    .rectangle-card {
        width: calc(100% - 20px); /* Dynamic width with padding */
        max-width: 150px; /* Default max width */
        height: 100px;
        background-color: #ffffff;
        border: 2px solid #17a2b8;
        box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        padding: 15px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        transition: all 0.3s ease;
    }

    /* Card content styling */
    .card-title {
        font-size: 12px;
        font-weight: bold;
        color: #17a2b8;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .card-number {
        font-size: 40px;
        font-weight: bold;
        color: #17a2b8;
    }

    .card-icon {
        font-size: 40px;
        color: #17a2b8;
        margin-right: 10px;
    }

    .card-content {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    /* Hover effect */
    .rectangle-card:hover {
        transform: translateY(-3px);
        box-shadow: 4px 6px 12px rgba(0, 0, 0, 0.3);
    }

    /* Adjust when navigation is collapsed */
    .sidebar.collapsed ~ .rectangle-card {
        width: 80%;
        max-width: 120px;
    }

    /* Responsive behavior for small screens */
    @media (max-width: 768px) {
        .rectangle-card {
            width: calc(100% - 10px);
            height: auto; /* Allow height to adjust dynamically */
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
            font-size: 80%;
        }
    }

    </style>
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

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color:#36b9cc; width: 250px;">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SALES PULSE-Sales</div>
            </a>
            <button id="sidebarToggle" style="border-color:#009394" class="btn btn-primary m-2">
                <i class="fas fa-bars"></i>
            </button>
            <div style="height: 0.5px;">
            </div>
            <!-- Divider -->
            <hr class="sidebar-divider my-2">
            <!-- Nav Items -->
            <li class="nav-item active">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="calendar.php">
                    <i class="fas fa-fw fa-calendar-alt"></i>
                    <span>Calendar</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contacts.php">
                    <i class="fas fa-fw fa-address-book"></i>
                    <span>Contacts</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="team.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Team Members</span>
                </a>
            </li>
        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Search -->
                    <!-- <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>
                        <!-- Nav Item - Messages -->
                        <!-- <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                               
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li> -->
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                <!-- Home Content -->
                <div class="container-fluid">
                <div class="row">
                    <!-- Column for Add Project -->
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <p style="font-family:'Poppins'; color: #555; font-size:15px; font-weight:700;">Projects</p>
                                <a href="#" class="btn btn-info btn-icon-split w-70 " data-bs-toggle="modal" data-bs-target="#addProjectModal">
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
                                            color: inherit; 
                                            font-size:15px;
                                        }
                                    </style>
                                    <span class="text" style="font-family:'Poppins'; font-size: 15px">Add Projects</span>
                                </a>
                                <!-- Modal -->
                                <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" style="width:1250px;">
                                        <!-- Centered and large modal for better responsiveness -->
                                        <div class="modal-content" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(2px); border-radius: 5px;">
                                            <div class="modal-header" style="background-color:#009394; height: 50px;">
                                                <h5 class="modal-title" id="addProjectModalLabel" style="font-size: 15px; color:white;">Add New Project</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Form to add project -->
                                                <form>
                                                    <div class="row">
                                                        <!-- Client/Company -->
                                                        <div class="col-md-4 mb-2">
                                                            <label for="clientCompany" class="form-label" style="font-size: 10px; color: #000;">Client/Company</label>
                                                            <input type="text" class="form-control input-sm" id="clientCompany" placeholder="Enter client or company name" style="font-size: 10px; color: #000; padding: 5px;" required>
                                                        </div>
                                                        <!-- Account Manager -->
                                                        <div class="col-md-4 mb-2">
                                                            <label for="accountManager" class="form-label" style="font-size: 10px; color: #000;">Account Manager</label>
                                                            <input type="text" class="form-control" id="accountManager" placeholder="Enter account manager name" style="font-size: 10px; color: #000; padding: 5px;" required>
                                                        </div>
                                                        <!-- Product Type -->
                                                        <div class="col-md-4 mb-2">
                                                            <label for="productType" class="form-label" style="font-size: 10px; color: #000;">Product Type</label>
                                                            <select class="form-select" id="productType" style="font-size: 10px; color: #000; padding: 5px;" required>
                                                                <option value="" selected disabled>Select status</option>
                                                                <option value="active">New</option>
                                                                <option value="inactive">Old</option>
                                                                <option value="completed">Futuristic</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <!-- Start Date -->
                                                        <div class="col-md-4 mb-2">
                                                            <label for="startDate" class="form-label" style="font-size: 10px; color: #000;">Start Date</label>
                                                            <input type="date" class="form-control" id="startDate" style="font-size: 10px; color: #000; padding: 5px;" required>
                                                        </div>
                                                        <!-- End Date -->
                                                        <div class="col-md-4 mb-2">
                                                            <label for="endDate" class="form-label" style="font-size: 10px; color: #000;">End Date</label>
                                                            <input type="date" class="form-control" id="endDate" style="font-size: 10px; color: #000; padding: 5px;" required>
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
                                                            <select class="form-select" id="status" style="font-size: 10px; color: #000; padding: 5px;" required>
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
                                                <button type="submit" class="btn" style="background-color:#009394; color:white; font-size: 12px;">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Modal -->

                                <hr class="sidebar-divider my-3">
                                <!-- Dynamic Navbar -->
                                <style>
                                    .nav-tabs {
                                        background-color: #E0F7F6; 
                                        transition: background-color 0.3s ease;
                                        border-radius: 10px; 
                                        padding: 10px; 
                                        gap: 12px;
                                        display: flex; 
                                        max-width: 520px;
                                        margin: 0 auto;
                                    }

                                    .nav-tabs .project-nav-link {
                                        border: none;
                                        padding: 5px 10px; 
                                        color: #555555;  
                                        font-weight: 600;
                                        font-size: 12px; 
                                        border-radius: 10px; 
                                        transition: background-color 0.3s ease, color 0.3s ease;
                                    }
                                    .nav-tabs .project-nav-link.ongoing.active {
                                        background-color:#3393ff;
                                        color: white;
                                    }
                                    .nav-tabs .project-nav-link.completed.active {
                                        background-color:#90EE90;
                                        color: white;
                                    }
                                    .nav-tabs .project-nav-link.cancelled.active {
                                        background-color:#FF7074;
                                        color: white;
                                    }
                                    .nav-tabs .project-nav-link.ongoing:hover {
                                        background-color:#3393ff;
                                        color: white;
                                    }
                                    .nav-tabs .project-nav-link.completed:hover {
                                        background-color:#90EE90;
                                        color: white;
                                    }

                                    .nav-tabs .project-nav-link.cancelled:hover {
                                        background-color:#FF7074;
                                        color: white;
                                    }

                                    .list-group-item a {
                                        color: black;
                                        font-size: 12px;
                                        transition: color 0.3s ease;
                                    }

                                    .list-group-item a:hover {
                                        color: #009394;
                                    }

                                    /* Responsive styles */
                                    @media (max-width: 768px) {
                                        .nav-tabs {
                                            flex-direction: column;
                                            max-width: 100%; /* Allow full width on smaller screens */
                                        }
                                    }

                               
                                </style>
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="project-nav-link active ongoing" id="nav-ongoing-tab" data-bs-toggle="tab" data-bs-target="#nav-ongoing" type="button" role="tab" aria-controls="nav-ongoing" aria-selected="true">On Going</button>
                                        <button class="project-nav-link completed" id="nav-completed-tab" data-bs-toggle="tab" data-bs-target="#nav-completed" type="button" role="tab" aria-controls="nav-completed" aria-selected="false">Completed</button>
                                        <button class="project-nav-link cancelled" id="nav-cancelled-tab" data-bs-toggle="tab" data-bs-target="#nav-cancelled" type="button" role="tab" aria-controls="nav-cancelled" aria-selected="false">Cancelled</button>
                                    </div>
                                </nav>
                                <div class="tab-content mt-3" id="nav-tabContent">
                                    <!-- On Going Projects -->
                                    <div class="tab-pane fade show active" id="nav-ongoing" role="tabpanel" aria-labelledby="nav-ongoing-tab">
                                        <ul class="list-group">
                                            <li class="list-group-item"><a href="#" data-bs-toggle="modal" data-bs-target="#multiStepModal">Project Alpha</a></li>
                                            <li class="list-group-item"><a href="#" data-bs-toggle="modal" data-bs-target="#multiStepModal">Project Beta</a></li>
                                            <li class="list-group-item"><a href="#" data-bs-toggle="modal" data-bs-target="#multiStepModal">Project Gamma</a></li>
                                            <li class="list-group-item"><a href="#" data-bs-toggle="modal" data-bs-target="#multiStepModal">Project Charlie</a></li>
                                        </ul>
                                    </div>
                                    <!-- Completed Projects -->
                                    <div class="tab-pane fade" id="nav-completed" role="tabpanel" aria-labelledby="nav-completed-tab">
                                        <ul class="list-group">
                                            <li class="list-group-item"><a href="#" data-bs-toggle="modal" data-bs-target="#multiStepModal">Project Epsilon</a></li>
                                            <li class="list-group-item"><a href="#" data-bs-toggle="modal" data-bs-target="#multiStepModal">Project Sigma</a></li>
                                        </ul>
                                    </div>
                                    <!-- Cancelled Projects -->
                                    <div class="tab-pane fade" id="nav-cancelled" role="tabpanel" aria-labelledby="nav-cancelled-tab">
                                        <ul class="list-group">
                                            <li class="list-group-item"><a href="#" data-bs-toggle="modal" data-bs-target="#multiStepModal">Project Delta</a></li>
                                            <li class="list-group-item"><a href="#" data-bs-toggle="modal" data-bs-target="#multiStepModal">Project Omega</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Blank Column -->
                    <div class="col-md-8 mb-0">
                        <div class="card shadow-sm" style="background:#36b9cc; margin-top: 0.4rem; ">
                            <div class="card-body" style="margin-top: 0.25rem; margin-bottom: 0.5rem;">
                                <!-- Start of Cards -->
                                <div class="row" style="padding: 10px; gap: 4px; margin-top: -0.5rem;"> <!-- Reduced margin above cards -->
                                    <div class="rectangle-card">
                                        <i class="card-icon">
                                            <img src="../images/check.png" alt="icon" width="40" height="40">
                                        </i>
                                        <div class="card-content">
                                            <div class="card-title">Completed</div>
                                            <div class="card-number">45</div>
                                        </div>
                                    </div>
                                    <div class="rectangle-card">
                                        <i class="card-icon">
                                            <img src="../images/ongoing.png" alt="icon" width="40" height="40">
                                        </i>
                                        <div class="card-content">
                                            <div class="card-title">On Going</div>
                                            <div class="card-number">13</div>
                                        </div>
                                    </div>
                                    <div class="rectangle-card">
                                        <i class="card-icon">
                                            <img src="../images/cancel.png" alt="icon" width="40" height="40">
                                        </i>
                                        <div class="card-content">
                                            <div class="card-title">Cancelled</div>
                                            <div class="card-number">3</div>
                                        </div>
                                    </div>
                                    <div class="rectangle-card">
                                        <i class="card-icon">
                                            <img src="../images/dura.png" alt="icon" width="40" height="40">
                                        </i>
                                        <div class="card-content">
                                            <div class="card-title">Duration</div>
                                            <div class="card-number">3</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Cards -->
                                <div class="col-md-14 mb-3">
                                    <div class="card shadow mb-4" style="border: 2px solid #17a2b8; box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2); margin-bottom: 0.2rem;">
                                        <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background-color: #f8f9fa; border-bottom: 1px solid #ddd; height: 50px; padding: 0 15px;">
                                            <h6 class="m-0 font-weight-bold" style="color: #009394; line-height: 1;">Project Lists</h6>
                                            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." style="font-size: 9px; border: 1px solid #009394; border-radius: 4px; outline: none; width: 150px; padding: 5px 8px; height: 25px;">
                                        </div>
                                        <div class="card-body" style="padding-top: 0.5rem; padding-bottom: 0.5rem;">
                                            <div class="table-responsive">
                                                <table id="myTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Position</th>
                                                            <th>Office</th>
                                                            <th>Age</th>
                                                            <th>Start</th>
                                                            <th>Salary</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Brielle Williamson</td>
                                                            <td>Integration Specialist</td>
                                                            <td>New York</td>
                                                            <td>61</td>
                                                            <td>2012/12/02</td>
                                                            <td>$372,000</td>
                                                            <td class="action-buttons">
                                                                <button>View</button>
                                                                <button>Edit</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Herrod Chandler</td>
                                                            <td>Sales Assistant</td>
                                                            <td>San Francisco</td>
                                                            <td>59</td>
                                                            <td>2012/08/06</td>
                                                            <td>$137,500</td>
                                                            <td class="action-buttons">
                                                                <button>View</button>
                                                                <button>Edit</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Herrod Chandler</td>
                                                            <td>Sales Assistant</td>
                                                            <td>San Francisco</td>
                                                            <td>59</td>
                                                            <td>2012/08/06</td>
                                                            <td>$137,500</td>
                                                            <td class="action-buttons">
                                                                <button>View</button>
                                                                <button>Edit</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Herrod Chandler</td>
                                                            <td>Sales Assistant</td>
                                                            <td>San Francisco</td>
                                                            <td>59</td>
                                                            <td>2012/08/06</td>
                                                            <td>$137,500</td>
                                                            <td class="action-buttons">
                                                                <button>View</button>
                                                                <button>Edit</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Rhona Davidson</td>
                                                            <td>Integration Specialist</td>
                                                            <td>Tokyo</td>
                                                            <td>55</td>
                                                            <td>2010/10/14</td>
                                                            <td>$327,900</td>
                                                            <td class="action-buttons">
                                                                <button>View</button>
                                                                <button>Edit</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Brielle Williamson</td>
                                                            <td>Integration Specialist</td>
                                                            <td>New York</td>
                                                            <td>61</td>
                                                            <td>2012/12/02</td>
                                                            <td>$372,000</td>
                                                            <td class="action-buttons">
                                                                <button>View</button>
                                                                <button>Edit</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Herrod Chandler</td>
                                                            <td>Sales Assistant</td>
                                                            <td>San Francisco</td>
                                                            <td>59</td>
                                                            <td>2012/08/06</td>
                                                            <td>$137,500</td>
                                                            <td class="action-buttons">
                                                                <button>View</button>
                                                                <button>Edit</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Rhona Davidson</td>
                                                            <td>Integration Specialist</td>
                                                            <td>Tokyo</td>
                                                            <td>55</td>
                                                            <td>2010/10/14</td>
                                                            <td>$327,900</td>
                                                            <td class="action-buttons">
                                                                <button>View</button>
                                                                <button>Edit</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="pagination">
                                                <a href="#" onclick="changePage(1)" class="active">1</a>
                                                <a href="#" onclick="changePage(2)">2</a>
                                                <a href="#" onclick="changePage(3)">3</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-14 mb-1 ">
                                        <div class="row mt-0 " style=" margin-top: 0.25rem">
                                            <div class="card col-md-5 shadow mb-1 mx-3 p-0" style="border: 2px solid #17a2b8; box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2);">
                                                <div class="card-header py-1" style="background:white">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <!-- Left-aligned text -->
                                                        <p class="m-0 font-weight-bold" style="color: #009394">Schedule Today</p>
                                                        <!-- Right-aligned icon -->
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#addSchedule">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#009394" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="card-body" style="height: 180px; overflow-y: auto; padding-top: 0.5rem; padding-bottom: 0.5rem;">
                                                    <!-- Schedule Widget -->
                                                    <div class="d-flex flex-column gap-3">
                                                        <!-- Schedule Item 1 -->
                                                        <div class="d-flex justify-content-between align-items-center p-2 rounded border">
                                                            <div class="text-start" style="margin-right: 15px;">
                                                                <strong style="font-size: 10px;">Meeting with Team A</strong>
                                                                <br>
                                                                <span style="font-size: 10px; color: #555;">Date: 2024-12-15</span>
                                                                <br>
                                                                <span style="font-size: 10px; color: #555;">Time: 10:00 AM</span>
                                                            </div>
                                                            <button class="btn btn-sm view-schedule-btn" data-bs-toggle="modal" data-bs-target="#scheduleModal" 
                                                                style="font-size: 10px; height: 25px; background-color: #009394; color: white; border: none;">
                                                                View
                                                            </button>
                                                        </div>

                                                        <!-- Schedule 1 Modal -->
                                                        <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header" style="background-color: #009394; color: white;">
                                                                        <h5 class="modal-title" id="scheduleModalLabel" style="font-size: 14px;color:white;">Schedule Details</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background: white;"></button>
                                                                    </div>
                                                                    <div class="modal-body" style="font-size: 12px;">
                                                                        <p><strong>Meeting Title:</strong> Meeting with Team A</p>
                                                                        <p><strong>Date:</strong> 2024-12-15</p>
                                                                        <p><strong>Time:</strong> 10:00 AM</p>
                                                                        <p><strong>Location:</strong> Conference Room 1</p>
                                                                        <p><strong>Description:</strong> Discussion on project milestones and deliverables.</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="font-size: 10px;">Close</button>
                                                                        <button type="button" class="btn btn-primary btn-sm" style="font-size: 10px; background-color: #009394; border: none;">Edit</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end of Schedule 1 Modal -->
                                                        <!-- Schedule Item 2 -->
                                                        <div class="d-flex justify-content-between align-items-center p-2 rounded border">
                                                            <div class="text-start" style="margin-right: 15px;">
                                                                <strong style="font-size: 10px;">Project Review</strong>
                                                                <br>
                                                                <span style="font-size: 10px; color: #555;">Date: 2024-12-16</span>
                                                                <br>
                                                                <span style="font-size: 10px; color: #555;">Time: 2:00 PM</span>
                                                            </div>
                                                            <button class="btn btn-sm" style="font-size: 10px; height: 25px; background-color: #009394; color: white; border: none;">View</button>
                                                        </div>
                                                        <!-- Schedule Item 3 -->
                                                        <div class="d-flex justify-content-between align-items-center p-2 rounded border">
                                                            <div class="text-start" style="margin-right: 15px;">
                                                                <strong style="font-size: 10px;">Client Presentation</strong>
                                                                <br>
                                                                <span style="font-size: 10px; color: #555;">Date: 2024-12-17</span>
                                                                <br>
                                                                <span style="font-size: 10px; color: #555;">Time: 11:00 AM</span>
                                                            </div>
                                                            <button class="btn btn-sm" style="font-size: 10px; height: 25px; background-color: #009394; color: white; border: none;">View</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card col-md-6 shadow mb-1 mr-0 p-0" style="border: 2px solid #17a2b8; box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2);"> 
                                                <div class="card-header py-2" style="background: white">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <!-- Left-aligned text -->
                                                        <p class="m-0 font-weight-bold" style="color:#009394;">To-Do Lists</p>
                                                        <!-- Right-aligned icon -->
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#addTask">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#009394" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="card-body" style="height: 120px; overflow-y: auto;">
                                                    <!-- To-Do List Widget -->
                                                    <div class="d-flex flex-column gap-2">
                                                        <!-- Task 1 -->
                                                        <div class="d-flex flex-column p-2 border rounded" style="height: auto; min-height: 40px;">
                                                            <div>
                                                                <input type="checkbox" id="task1" style="margin-right: 10px;">
                                                                <label for="task1" style="font-size: 10px;">Prepare meeting notes and finalize agenda for upcoming meeting</label>
                                                            </div>
                                                            <div class="d-flex gap-1 justify-content-end mt-1">
                                                                <!-- Edit Button -->
                                                                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#editTaskModal" 
                                                                    style="font-size: 10px; height: 25px; background-color: #009394; color: white; border: none;">
                                                                    Edit
                                                                </button>
                                                                <!-- Delete Button -->
                                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteTaskModal" 
                                                                    style="font-size: 10px; height: 25px;">
                                                                    Delete
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <!-- Edit Task Modal -->
                                                        <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header" style="background-color: #009394; color: white;">
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
                                                                        <button type="button" class="btn btn-primary btn-sm" style="font-size: 10px; background-color: #009394; border: none;">Save Changes</button>
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
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background: white;"></button>
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
                                                        <!-- Task 2 -->
                                                        <div class="d-flex flex-column p-2 border rounded" style="height: auto; min-height: 40px;">
                                                            <div>
                                                                <input type="checkbox" id="task2" style="margin-right: 10px;">
                                                                <label for="task2" style="font-size: 10px;">Review project proposal with the team and make necessary revisions</label>
                                                            </div>
                                                            <div class="d-flex gap-1 justify-content-end mt-1">
                                                                <button class="btn btn-sm" style="font-size: 10px; height: 25px; background-color: #009394; color: white; border: none;">Edit</button>
                                                                <button class="btn btn-danger btn-sm" style="font-size: 10px; height: 25px;">Delete</button>
                                                            </div>
                                                        </div>
                                                        <!-- Task 3 -->
                                                        <div class="d-flex flex-column p-2 border rounded" style="height: auto; min-height: 40px;">
                                                            <div>
                                                                <input type="checkbox" id="task3" style="margin-right: 10px;">
                                                                <label for="task3" style="font-size: 10px;">Submit expense report by 5 PM to the finance department</label>
                                                            </div>
                                                            <div class="d-flex gap-1 justify-content-end mt-1">
                                                                <button class="btn btn-sm" style="font-size: 10px; height: 25px; background-color: #006270; color: white; border: none;">Edit</button>
                                                                <button class="btn btn-danger btn-sm" style="font-size: 10px; height: 25px;">Delete</button>
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
            <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Centered and large modal for better responsiveness -->
                <div class="modal-content" class="modal-content" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(2px); border-radius: 5px;">
                <div class="modal-header" style="background-color:#009394; height: 50px;">
                    <font color="white">
                    <h5 class="m" id="addProjectModalLabel">Add New Schedule</h5>
                    </font>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form to add schedule -->
                    <form>
                    <div class="row">
                        <!-- Event/Activity/Meeting -->
                        <div class="col-md-6 mb-3">
                        <label for="clientCompany" class="form-label" style="color:#555">Event/Activity/Meeting</label>
                        <input type="text" class="form-control" id="clientCompany" placeholder="Enter event or activity" required>
                        </div>
                        <!-- Venue -->
                        <div class="col-md-6 mb-3">
                        <label for="accountManager" class="form-label" style="color:#555">Venue</label>
                        <input type="text" class="form-control" id="accountManager" placeholder="Enter venue" required>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Start Date -->
                        <div class="col-md-6 mb-3">
                        <label for="startDate" class="form-label" style="color:#555">Start Date</label>
                        <input type="date" class="form-control" id="startDate" required>
                        </div>
                        <!-- End Date -->
                        <div class="col-md-6 mb-3">
                        <label for="endDate" class="form-label" style="color:#555">End Date</label>
                        <input type="date" class="form-control" id="endDate" required>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" style="background-color:#009394; color:white;">Save</button>
                </div>
                </div>
            </div>
            </div>

            <!-- Add New Task Modal -->
            <div class="modal fade" id="addTask" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Centered and large modal for better responsiveness -->
                <div class="modal-content" class="modal-content" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(2px); border-radius: 5px;">
                <div class="modal-header" style="background-color:#009394; height: 50px;">
                    <font color="white">
                    <h5 class="mo" id="addProjectModalLabel">Add New Task</h5>
                    </font>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form to add task -->
                    <form>
                    <div class="row">
                        <!-- Task -->
                        <div class="col-md-6 mb-3">
                        <label for="clientCompany" class="form-label" style="color:#555">Task</label>
                        <input type="text" class="form-control" id="clientCompany" placeholder="Enter task name" required>
                        </div>
                        <!-- Assign to -->
                        <div class="col-md-6 mb-3">
                        <label for="accountManager" class="form-label" style="color:#555">Assign to</label>
                        <input type="text" class="form-control" id="accountManager" placeholder="Enter assignee name" required>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Start Date -->
                        <div class="col-md-6 mb-3">
                        <label for="startDate" class="form-label" style="color:#555">Start Date</label>
                        <input type="date" class="form-control" id="startDate" required>
                        </div>
                        <!-- End Date -->
                        <div class="col-md-6 mb-3">
                        <label for="endDate" class="form-label" style="color:#555">End Date</label>
                        <input type="date" class="form-control" id="endDate" required>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" style="background-color:#009394; color:white;">Save</button>
                </div>
                </div>
            </div>
            </div>
            <!-- MultiStep Form Modal -->
            <style>
                .step {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .step-circle {
                    width: 50px;
                    height: 50px;
                    border-radius: 50%;
                    background: white;
                    color: #009394;
                    font-size: 20px;
                    font-family: 'Poppins';
                    font-weight : 700px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border: 2px solid #009394;
                }
                .step-line {
                    flex: 1;
                    height: 2px;
                    background: #ddd;
                }
                .step-circle.active {
                    background: #009394;
                    color: #fff;
                    border-color: #009394;
                }
                .step-line.active {
                    background: #009394;
                }
                .form-label, .btn {
                    font-size: 12px;
                    color:white;
                    font-family: 'Poppins'
                }
                .modal-title{
                    color:black;
                    font-size: 15px;
                    font-weight: 600px;
                    font-family: 'Poppins'
                }
                input, select {
                    font-size: 14px;
                    color:#555;
                    font-family: 'Poppins';
                }
                #multiStepModal .modal-dialog {
                    max-width: 800px; /* Increased width */
                }
                #multiStepModal .form-container {
                    background-color: #009393;
                    padding: 20px;
                    border-radius: 8px;
                }
                #multiStepModal .stage-title {
                    font-size: 1.5rem;
                    font-weight: bold;
                    color: #fff;
                    margin-bottom: 20px;
                    text-align: center;
                    font-family: 'Poppins';
                }
                #multiStepModal .sales-pulse {
                    position: absolute;
                    bottom: 10px;
                    left: 10px;
                    font-size: 1rem;
                    color: #555;
                }
            </style>
            <div class="modal fade" id="multiStepModal" tabindex="-1" aria-labelledby="multiStepModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" class="modal-content" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(2px); border-radius: 5px;">
                        <div class="modal-header" style="background-color:#009394; height: 50px;">
                            <h5 class="modal-title" id="addProjectModalLabel" style="font-size: 15px; color:white;">Client Name</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-4 step">
                                <div class="step-circle" id="step1-circle">1</div>
                                <div class="step-line" id="line1"></div>
                                <div class="step-circle" id="step2-circle">2</div>
                                <div class="step-line" id="line2"></div>
                                <div class="step-circle" id="step3-circle">3</div>
                                <div class="step-line" id="line3"></div>
                                <div class="step-circle" id="step4-circle">4</div>
                                <div class="step-line" id="line4"></div>
                                <div class="step-circle" id="step5-circle">5</div>
                            </div>
                            <form id="multiStepForm">
                                <div class="form-step" id="step1">
                                    <div class="stage-container" style="display: flex; justify-content: space-between; align-items: center; padding: 0px;">
                                        <div class="stage-title" style="width: 30%; text-align: left; margin-bottom: 0; padding-bottom: 0;">
                                            <p style="color: #009394; margin-bottom: 5px; font-family: 'Poppins', sans-serif;">Stage 1</p>
                                            <h4 style="color: #009394; margin-top: 0; font-family: 'Poppins', sans-serif;">Awareness/Prospecting</h4>
                                        </div>
                                        <div class="stage-percentage" style="width: 45%; text-align: right; font-size: 16px; color: #009394;">
                                            <p style="color:#555">Progress: <span  style="font-family: 'Poppins'; color: #009394;">70%</span></p>
                                        </div>
                                    </div>
                                    <div class="container" style="background-color: #009394; padding: 10px; border-radius: 20px"> 
                                        <div class="container" style="background-color: #009394; padding: 10px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="mb-2">
                                                        <label for="requirement" class="form-label text-white">Requirement</label>
                                                        <div class="row align-items-center requirement-field" id="requirement-container" style="margin-bottom:5px">
                                                            <div class="col-9" style="display: flex; align-items: center;">
                                                                <!-- Input field for Requirement -->
                                                                <input style="width: 100%;" type="text" class="form-control" id="requirement" placeholder="e.g. Sample Requirement">
                                                            </div>
                                                            <div class="col-3 d-flex justify-content-end" style="display: flex; align-items: center;">
                                                                <!-- Add Button -->
                                                                <button type="button" class="btn btn-success btn-sm" style="background-color:rgb(14, 195, 231); margin-left: 5px;" id="addRequirement">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                                <!-- Delete Button -->
                                                                <button type="button" class="btn btn-danger btn-sm" style="margin-left: 5px;" id="deleteRequirement">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="solution" class="form-label text-white">Solution</label>
                                                        <select class="form-control custom-select" id="solution">
                                                            <option disabled selected>Select</option>
                                                            <option>Cloud-Based Storage</option>
                                                            <option>Data Analytics Platform</option>
                                                            <option>Customer Relationship Management (CRM)</option>
                                                            <option>Inventory Management System</option>
                                                            <option>AI-Powered Chatbot</option>
                                                        </select>
                                                    </div>
                                                    <style>
                                                        .custom-select {
                                                            appearance: none; 
                                                            -moz-appearance: none;
                                                            -webkit-appearance: none;
                                                            background: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23555555"%3E%3Cpath d="M7 10l5 5 5-5z"/%3E%3C/svg%3E') no-repeat right 10px center;
                                                            background-color: #fff;
                                                            background-size: 12px 12px;
                                                            padding-right: 30px; 
                                                        }
                                                        .custom-select-dark {
                                                            background: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23ffffff"%3E%3Cpath d="M7 10l5 5 5-5z"/%3E%3C/svg%3E') no-repeat right 10px center;
                                                            background-color: #343a40;
                                                            color: white;
                                                            padding-right: 30px;
                                                        }
                                                    </style>
                                                    <div class="mb-2">
                                                        <label for="technology" class="form-label text-white">Technology</label>
                                                        <select class="form-control custom-select" id="technology">
                                                            <option disabled selected>Select</option>
                                                            <option>Artificial Intelligence</option>
                                                            <option>Machine Learning</option>
                                                            <option>Blockchain</option>
                                                            <option>Internet of Things (IoT)</option>
                                                            <option>Cloud Computing</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="dealSize" class="form-label text-white">Deal Size</label>
                                                        <input type="text" class="form-control" id="dealSize" placeholder="e.g. 5000">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-6">
                                                        <label for="remarks" class="form-label text-white">Remarks</label>
                                                        <textarea class="form-control" id="remarks" placeholder="e.g. Sample Remarks" 
                                                                style="height: 230px;"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label for="product" class="form-label text-white">Product</label>
                                                        <select class="form-control custom-select" id="product">
                                                            <option disabled>Select a Product</option>
                                                            <option>Mobile Application</option>
                                                            <option>Web Platform</option>
                                                            <option>Desktop Software</option>
                                                            <option>API Service</option>
                                                            <option>Embedded System</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="status" class="form-label text-white">Status</label>
                                                        <select class="form-control custom-select" id="status">
                                                            <option disabled>Select Status</option>
                                                            <option>In Development</option>
                                                            <option>Testing Phase</option>
                                                            <option>Ready for Launch</option>
                                                            <option>Launched</option>
                                                            <option>Maintenance</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="startDate" class="form-label text-white">Start Date</label>
                                                        <input type="text" class="form-control" id="startDate" placeholder="Auto-generated" readonly>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="endDate" class="form-label text-white">End Date</label>
                                                        <input type="text" class="form-control" id="endDate" placeholder="Auto-generated" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-step d-none" id="step2">
                                <div class="stage-container" style="display: flex; justify-content: space-between; align-items: center; padding: 0px;">
                                        <div class="stage-title" style="width: 30%; text-align: left; margin-bottom: 0; padding-bottom: 0;">
                                            <p style="color: #009394; margin-bottom: 5px; font-family: 'Poppins', sans-serif;">Stage 2</p>
                                            <h4 style="color: #009394; margin-top: 0; font-family: 'Poppins', sans-serif;">Engagement/Discovery</h4>
                                        </div>
                                        <div class="stage-percentage" style="width: 45%; text-align: right; font-size: 16px; color: #009394;">
                                            <p style="color:#555">Progress: <span  style="font-family: 'Poppins'; color: #009394;">70%</span></p>
                                        </div>
                                    </div>
                                    <div class="container" style="background-color: #009394; padding: 10px; border-radius: 20px"> 
                                        <div class="container" style="background-color: #009394; padding: 5px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="requirement" class="form-label text-white">Start Date</label>
                                                    <input type="text" class="form-control" id="requirement" placeholder="Auto-generated" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="requirement" class="form-label text-white">End Date</label>
                                                    <input type="text" class="form-control" id="requirement" placeholder="Auto-generated" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="status" class="form-label text-white">Status</label>
                                                    <select class="form-control custom-select" id="status">
                                                        <option disabled>Select</option>
                                                        <option>In Development</option>
                                                        <option>Testing Phase</option>
                                                        <option>Ready for Launch</option>
                                                        <option>Launched</option>
                                                        <option>Maintenance</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #009394; padding: 5px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Type of Engagement</label>
                                                    <select class="form-control custom-select" id="requirement">
                                                        <option disabled>Select</option>
                                                        <option>Consulting</option>
                                                        <option>Outsourcing</option>
                                                        <option>Partnership</option>
                                                        <option>Freelance</option>
                                                        <option>In-House Development</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Date</label>
                                                    <input type="date" class="form-control" id="requirement">
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="requirement" class="form-label text-white">Remarks</label>
                                                    <input type="textarea" class="form-control" id="requirement" placeholder="e.g. Sample Remarks">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #009394; padding: 5px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Requirement</label>
                                                    <input type="text" class="form-control" id="requirement" placeholder="e.g. Sample Requirement">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Date</label>
                                                    <input type="date" class="form-control" id="requirement">
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="requirement" class="form-label text-white">Remarks</label>
                                                    <input type="textarea" class="form-control" id="requirement" placeholder="e.g. Sample Remarks">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #009394; padding: 10px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="requirement" class="form-label text-white">Stage Remarks</label>
                                                    <input type="textarea" class="form-control" id="requirement"style="height: 50px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-step d-none" id="step3">
                                <div class="stage-container" style="display: flex; justify-content: space-between; align-items: center; padding: 0px;">
                                        <div class="stage-title" style="width: 30%; text-align: left; margin-bottom: 0; padding-bottom: 0;">
                                            <p style="color: #009394; margin-bottom: 5px; font-family: 'Poppins', sans-serif;">Stage 3</p>
                                            <h4 style="color: #009394; margin-top: 0; font-family: 'Poppins', sans-serif;">Presentation/Proposal</h4>
                                        </div>
                                        <div class="stage-percentage" style="width: 45%; text-align: right; font-size: 16px; color: #009394;">
                                            <p style="color:#555">Progress: <span  style="font-family: 'Poppins'; color: #009394;">70%</span></p>
                                        </div>
                                    </div>
                                    <div class="container" style="background-color: #009394; padding: 10px; border-radius: 20px"> 
                                        <div class="container" style="background-color: #009394; padding: 5px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="requirement" class="form-label text-white">Start Date</label>
                                                    <input type="text" class="form-control" id="requirement" placeholder="Auto-generated" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="requirement" class="form-label text-white">End Date</label>
                                                    <input type="text" class="form-control" id="requirement" placeholder="Auto-generated" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="status" class="form-label text-white">Status</label>
                                                    <select class="form-control custom-select" id="status">
                                                        <option disabled>Select</option>
                                                        <option>In Development</option>
                                                        <option>Testing Phase</option>
                                                        <option>Ready for Launch</option>
                                                        <option>Launched</option>
                                                        <option>Maintenance</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #009394; padding: 5px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Type of Engagement</label>
                                                    <select class="form-control custom-select" id="requirement">
                                                        <option disabled>Select</option>
                                                        <option>Consulting</option>
                                                        <option>Outsourcing</option>
                                                        <option>Partnership</option>
                                                        <option>Freelance</option>
                                                        <option>In-House Development</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Date</label>
                                                    <input type="date" class="form-control" id="requirement">
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="requirement" class="form-label text-white">Remarks</label>
                                                    <input type="textarea" class="form-control" id="requirement" placeholder="e.g. Sample Remarks">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #009394; padding: 5px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="requirement" class="form-label text-white">Requirement</label>
                                                    <input type="text" class="form-control" id="requirement" placeholder="e.g. Sample Requirement">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Quantity</label>
                                                    <input type="text" class="form-control" id="requirement">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Bills of Materials</label>
                                                    <input type="textarea" class="form-control" id="requirement" placeholder="e.g. 5000">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Pricing</label>
                                                    <input type="textarea" class="form-control" id="requirement" placeholder="e.g. 2000">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #009394; padding: 10px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="requirement" class="form-label text-white">Stage Remarks</label>
                                                    <input type="textarea" class="form-control" id="requirement"style="height: 50px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-step d-none" id="step4">
                                    <div class="stage-container" style="display: flex; justify-content: space-between; align-items: center; padding: 0px;">
                                        <div class="stage-title" style="width: 30%; text-align: left; margin-bottom: 0; padding-bottom: 0;">
                                            <p style="color: #009394; margin-bottom: 5px; font-family: 'Poppins', sans-serif;">Stage 4</p>
                                            <h4 style="color: #009394; margin-top: 0; font-family: 'Poppins', sans-serif;">Negotiation/Commitment</h4>
                                        </div>
                                        <div class="stage-percentage" style="width: 45%; text-align: right; font-size: 16px; color: #009394;">
                                            <p style="color:#555">Progress: <span  style="font-family: 'Poppins'; color: #009394;">70%</span></p>
                                        </div>
                                    </div>
                                    <div class="container" style="background-color: #009394; padding: 10px; border-radius: 20px"> 
                                        <div class="container" style="background-color: #009394; padding: 5px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="requirement" class="form-label text-white">Start Date</label>
                                                    <input type="text" class="form-control" id="requirement" placeholder="Auto-generated" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="requirement" class="form-label text-white">End Date</label>
                                                    <input type="text" class="form-control" id="requirement" placeholder="Auto-generated" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="status" class="form-label text-white">Status</label>
                                                    <select class="form-control custom-select" id="status">
                                                        <option disabled>Select</option>
                                                        <option>In Development</option>
                                                        <option>Testing Phase</option>
                                                        <option>Ready for Launch</option>
                                                        <option>Launched</option>
                                                        <option>Maintenance</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #009394; padding: 5px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="requirement" class="form-label text-white">Requirement</label>
                                                    <input type="text" class="form-control" id="requirement" placeholder="e.g. Sample Requirement">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Quantity</label>
                                                    <input type="text" class="form-control" id="requirement">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Bills of Materials</label>
                                                    <input type="textarea" class="form-control" id="requirement" placeholder="e.g. 5000">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Pricing</label>
                                                    <input type="textarea" class="form-control" id="requirement" placeholder="e.g. 2000">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #009394; padding: 10px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="requirement" class="form-label text-white">Stage Remarks</label>
                                                    <input type="textarea" class="form-control" id="requirement"style="height: 50px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-step d-none" id="step5">
                                <div class="stage-container" style="display: flex; justify-content: space-between; align-items: center; padding: 0px;">
                                        <div class="stage-title" style="width: 30%; text-align: left; margin-bottom: 0; padding-bottom: 0;">
                                            <p style="color: #009394; margin-bottom: 5px; font-family: 'Poppins', sans-serif;">Stage 5</p>
                                            <h4 style="color: #009394; margin-top: 0; font-family: 'Poppins', sans-serif;">Delivery/Follow-up</h4>
                                        </div>
                                        <div class="stage-percentage" style="width: 45%; text-align: right; font-size: 16px; color: #009394;">
                                            <p style="color:#555">Progress: <span  style="font-family: 'Poppins'; color: #009394;">70%</span></p>
                                        </div>
                                    </div>
                                    <div class="container" style="background-color: #009394; padding: 10px; border-radius: 20px"> 
                                        <div class="container" style="background-color: #009394; padding: 5px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="requirement" class="form-label text-white">Start Date</label>
                                                    <input type="text" class="form-control" id="requirement" placeholder="Auto-Generated" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="requirement" class="form-label text-white">End Date</label>
                                                    <input type="text" class="form-control" id="requirement" placeholder="Auto-Generated" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="status" class="form-label text-white">Status</label>
                                                    <select class="form-control custom-select" id="status">
                                                        <option disabled>Select</option>
                                                        <option>In Development</option>
                                                        <option>Testing Phase</option>
                                                        <option>Ready for Launch</option>
                                                        <option>Launched</option>
                                                        <option>Maintenance</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #009394; padding: 10px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label for="requirement" class="form-label text-white">SPR</label>
                                                        <input type="text" class="form-control" id="requirement" placeholder="e.g. SPR">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="solution" class="form-label text-white">Contract Duration</label>
                                                        <input type="text" class="form-control" id="requirement" placeholder="e.g. SPR">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="technology" class="form-label text-white">Billing Type</label>
                                                        <input type="text" class="form-control" id="requirement" placeholder="e.g. SPR">
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="requirement" class="form-label text-white">Start Date</label>
                                                            <input type="text" class="form-control" id="requirement" placeholder="Auto-Generated" readonly>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="requirement" class="form-label text-white">End Date</label>
                                                            <input type="text" class="form-control" id="requirement" placeholder="Auto-Generated" readonly>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="requirement" class="form-label text-white">Status</label>
                                                            <input type="text" class="form-control" id="requirement" placeholder="e.g. Sample Requirement">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #009394; padding: 10px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="requirement" class="form-label text-white">Stage Remarks</label>
                                                    <input type="textarea" class="form-control" id="requirement"style="height: 50px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Stage 2 -->
                            </form>
                        </div>
                            <style>
                                #saveButton {
                                    transition: all 0.3s ease;
                                }
                                #saveButton:hover {
                                    background-color: #009394;
                                    color: white;
                                    border-color: #fff;
                                    transform: scale(1.1);
                                }
                                #completeButton {
                                    transition: all 0.3s ease;
                                }
                                #completeButton:hover {
                                    background-color: #00796b;
                                    color: white;
                                    transform: scale(1.1); 
                                }
                                #deleteButton {
                                    transition: all 0.3s ease;
                                }
                                #deleteButton:hover {
                                    transform: scale(1.1);
                                }
                                .footer-left {
                                    display: flex;
                                    align-items: center;
                                    margin-right: auto;
                                }
                                #logoPlaceholder {
                                    width: 30px;
                                    height: 30px;
                                    background-color: #009394;
                                    border-radius: 50%;
                                    margin-right: 10px;
                                }
                                #salesPulse {
                                    font-weight: 800;
                                    color: #009394;
                                    font-size: 25px;
                                    font-family: 'Poppins', sans-serif;
                                }
                            </style>
                            <div class="modal-footer">
                                <div class="footer-left">
                                    <div id="logoPlaceholder"></div>
                                    <div id="salesPulse">Sales Pulse</div>
                                </div>
                                <button type="button" class="btn btn-danger" id="deleteButton" style="border-color: red; background-color: #fff; color: red; font-size: 12px;">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                                <button type="button" class="btn btn-success" id="saveButton" style="border-weight: 5px; border-color: #009394; background-color: #fff; color: #009394; font-size: 12px;">
                                    Save
                                </button>
                                <button type="button" class="btn btn-success" id="completeButton" style="background-color: #009394; color: white; font-size: 12px;">
                                    Complete
                                </button>
                            </div>
                    </div>
                </div>
            </div>
            <!-- End of Multi Step form -->
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
    <!-- Bootstrap core JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap Bundle JS (includes Popper.js) -->

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script> <!-- jQuery Easing Plugin -->

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script> <!-- Custom Admin Scripts -->

    <!-- DataTables JS -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script> <!-- DataTables JS -->
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script> <!-- DataTables Bootstrap Integration -->

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script> <!-- DataTables Customization -->

    <!-- Bootstrap and jQuery -->
   

    <script>
        // Toggle sidebar collapse
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            const sidebar = document.getElementById('accordionSidebar');
            sidebar.classList.toggle('collapsed');
        });
    </script>

    <script>
        let currentStep = 1;
        const totalSteps = 5;

        document.getElementById('saveButton').addEventListener('click', () => {
            if (confirm('Do you want to save changes?')) {
                alert('Changes saved.');
            }
        });
        document.getElementById('completeButton').addEventListener('click', () => {
            if (confirm('Are you sure you want to complete this step? This action cannot be undone.')) {
                document.getElementById(`step${currentStep}-circle`).classList.add('active');
                if (currentStep < totalSteps) {
                    document.getElementById(`line${currentStep}`).classList.add('active');
                    currentStep++;
                    showStep(currentStep);
                } else {
                    alert('Form completed!');
                }
            }
        });

        function showStep(step) {
            for (let i = 1; i <= totalSteps; i++) {
                document.getElementById(`step${i}`).classList.add('d-none');
            }
            document.getElementById(`step${step}`).classList.remove('d-none');
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
        // Event listener for adding a new Requirement field
        document.getElementById("addRequirement").addEventListener("click", function() {
            // Get the container where the requirement fields are stored
            const container = document.getElementById("requirement-container");

            // Create a new div element for the new requirement field
            const newField = document.createElement("div");
            newField.classList.add("row", "align-items-center", "requirement-field");
            newField.style.marginBottom = "10px"; // Add margin for spacing

            // Create the new input field
            const inputField = document.createElement("input");
            inputField.type = "text";
            inputField.classList.add("form-control");
            inputField.placeholder = "e.g. Sample Requirement";
            inputField.style.width = "100%";  // Make it responsive within the available space

            // Create the container for the buttons (for alignment)
            const buttonContainer = document.createElement("div");
            buttonContainer.classList.add("col-3", "d-flex", "justify-content-end");
            buttonContainer.style.display = "flex";  // Ensure the buttons align horizontally

            // Create the add button for the new field
            const addButton = document.createElement("button");
            addButton.type = "button";
            addButton.classList.add("btn", "btn-success", "btn-sm");
            addButton.style.backgroundColor = "rgb(14, 195, 231)";
            addButton.style.marginLeft = "5px";
            addButton.innerHTML = "<i class='fas fa-plus'></i>";
            buttonContainer.appendChild(addButton);

            // Create the delete button for the new field
            const deleteButton = document.createElement("button");
            deleteButton.type = "button";
            deleteButton.classList.add("btn", "btn-danger", "btn-sm");
            deleteButton.style.marginLeft = "5px";
            deleteButton.innerHTML = "<i class='fas fa-minus'></i>";
            buttonContainer.appendChild(deleteButton);

            // Create the column for the input field
            const inputContainer = document.createElement("div");
            inputContainer.classList.add("col-9");
            inputContainer.style.display = "flex";
            inputContainer.style.alignItems = "center"; // Align the input field vertically
            inputContainer.appendChild(inputField);

            // Append the input field and button container to the new field
            newField.appendChild(inputContainer);
            newField.appendChild(buttonContainer);

            // Append the new field to the container
            container.appendChild(newField);

            // Add event listener for the new delete button
            deleteButton.addEventListener("click", function() {
                newField.remove();
            });
        });
        // Event listener for deleting a Requirement field (for the first one)
        document.getElementById("deleteRequirement").addEventListener("click", function() {
            const fields = document.getElementsByClassName("requirement-field");
            if (fields.length > 1) {
                fields[fields.length - 1].remove();
            }
        });
    </script>
    <script>
    let currentPage = 1;
    const rowsPerPage = 5; // You can adjust this to control the number of rows per page
    let totalRows = 0;

    function generatePagination() {
        const rows = document.getElementById("myTable").getElementsByTagName("tr");
        totalRows = 0;
        
        // Count visible rows
        for (let i = 1; i < rows.length; i++) {
            if (rows[i].style.display !== "none") {
                totalRows++;
            }
        }

        // Calculate the number of pages
        const totalPages = Math.ceil(totalRows / rowsPerPage);
        
        // Create pagination links
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

            for (let j = 0; j < cells.length - 1; j++) { // Exclude the last column (Actions)
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
        
        // After adding the row, re-generate the pagination
        generatePagination();
        changePage(currentPage); // Stay on the current page
    }
    // Initial pagination setup
    generatePagination();
    changePage(1);
</script>

</body>

</html>