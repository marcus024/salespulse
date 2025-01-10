<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin 2 - Blank</title>
     <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
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
        <ul class="navbar-nav  sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color:#36b9cc;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SALES PULSE</div>
            </a>
            <button id="sidebarToggle" style="border-color:#009394" class="btn btn-primary m-2">
                <i class="fas fa-bars"></i>
            </button>
            <!-- Divider -->
            <hr class="sidebar-divider my-2">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="home.php">
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
            <li class="nav-item active">
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

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <!-- Narrow Container for Add Calendar -->
                        <div class="col-md-3 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <p style="font-family:'Poppins'; font-size:15px; font-weight:700; color:#555">Contacts</p>
                                        <a href="#" class="btn btn-info btn-icon-split w-70" data-bs-toggle="modal" data-bs-target="#addContact">
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
                                                    font-size: 16px;
                                                }
                                            </style>
                                            <span class="text" style="font-family:'Poppins'">Add Contacts</span>
                                        </a>
                                </div>
                            </div>
                        </div>

                        <!-- Wide Container for Calendar Content -->
                        <div class="col-md-9 mb-4">
                            <div class="card shadow-sm" style="background-color:#36b9cc;">
                                <div class="card-body" id="calendar-container" style="min-height: 400px; color: white;">
                                    <h1 class="h5 mb-4" style="font-family:'Poppins'">My Contacts</h1>
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
                                        <div class="card mb-3" style="border-radius: 20px;">
                                            <div class="card-header" style="font-family:'Poppins';background: linear-gradient(to right, #36b9cc,rgb(25, 230, 230)); color: white; border-radius:20px; font-size: 18px; font-weight: bold;">
                                                Contact Profile
                                            </div>
                                            <div class="card-body" style="background-color: white; color: #555; padding: 10px; border-radius:20px; padding-left: 50px;">
                                                <div class="d-flex align-items-center mb-2" style="gap: 50px;">
                                                    <img src="images/profile1.png" alt="Contact 1" class="contact-image" style="width: 120px; height: 120px; border-radius: 50%;">
                                                    <div class="contact-info">
                                                        <p class="mb-1" style="font-size: 15px; font-family: 'Poppins';">
                                                            <strong>SMDC</strong>
                                                            <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                        </p>
                                                        <p class="mb-1" style="font-size: 30px; font-weight: bold; font-family: 'Poppins';">
                                                            Juan Dela Cruz
                                                            <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                        </p>
                                                        <p class="mb-1" style="font-size: 15px; font-family: 'Poppins';">
                                                            Product Manager
                                                            <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                        </p>
                                                        <div style="height:10px;"></div>
                                                        <div class="d-flex justify-content-between align-items-center" style="font-size: 14px;">
                                                            <p class="mb-0" style="font-size: 15px; font-family: 'Poppins';">
                                                                <i class="fas fa-envelope" style="font-size: 20px; color: #009394; margin-right: 5px;"></i> johndoe@example.com
                                                                <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                            </p>
                                                            <div style="width: 20px;"></div>
                                                            <p class="mb-0" style="font-size: 15px; font-family: 'Poppins';">
                                                                <i class="fas fa-phone-alt" style="font-size: 20px; color: #009394; margin-right: 8px;"></i> +123 456 7890
                                                                <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-3" style="border-radius: 20px;">
                                            <div class="card-header" style="font-family:'Poppins';background: linear-gradient(to right, #36b9cc,rgb(25, 230, 230)); color: white; border-radius:20px; font-size: 18px; font-weight: bold;">
                                                Contact Profile
                                            </div>
                                            <div class="card-body" style="background-color: white; color: #555; padding: 10px; border-radius:20px; padding-left: 50px;">
                                                <div class="d-flex align-items-center mb-2" style="gap: 50px;">
                                                    <img src="images/profile1.png" alt="Contact 1" class="contact-image" style="width: 120px; height: 120px; border-radius: 50%;">
                                                    <div class="contact-info">
                                                        <p class="mb-1" style="font-size: 15px; font-family: 'Poppins';">
                                                            <strong>SMDC</strong>
                                                            <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                        </p>
                                                        <p class="mb-1" style="font-size: 30px; font-weight: bold; font-family: 'Poppins';">
                                                            Juan Dela Cruz
                                                            <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                        </p>
                                                        <p class="mb-1" style="font-size: 15px; font-family: 'Poppins';">
                                                            Product Manager
                                                            <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                        </p>
                                                        <div style="height:10px;"></div>
                                                        <div class="d-flex justify-content-between align-items-center" style="font-size: 14px;">
                                                            <p class="mb-0" style="font-size: 15px; font-family: 'Poppins';">
                                                                <i class="fas fa-envelope" style="font-size: 20px; color: #009394; margin-right: 5px;"></i> johndoe@example.com
                                                                <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                            </p>
                                                            <div style="width: 20px;"></div>
                                                            <p class="mb-0" style="font-size: 15px; font-family: 'Poppins';">
                                                                <i class="fas fa-phone-alt" style="font-size: 20px; color: #009394; margin-right: 8px;"></i> +123 456 7890
                                                                <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-3" style="border-radius: 20px;">
                                            <div class="card-header" style="font-family:'Poppins';background: linear-gradient(to right, #36b9cc,rgb(25, 230, 230)); color: white; border-radius:20px; font-size: 18px; font-weight: bold;">
                                                Contact Profile
                                            </div>
                                            <div class="card-body" style="background-color: white; color: #555; padding: 10px; border-radius:20px; padding-left: 50px;">
                                                <div class="d-flex align-items-center mb-2" style="gap: 50px;">
                                                    <img src="images/profile1.png" alt="Contact 1" class="contact-image" style="width: 120px; height: 120px; border-radius: 50%;">
                                                    <div class="contact-info">
                                                        <p class="mb-1" style="font-size: 15px; font-family: 'Poppins';">
                                                            <strong>SMDC</strong>
                                                            <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                        </p>
                                                        <p class="mb-1" style="font-size: 30px; font-weight: bold; font-family: 'Poppins';">
                                                            Juan Dela Cruz
                                                            <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                        </p>
                                                        <p class="mb-1" style="font-size: 15px; font-family: 'Poppins';">
                                                            Product Manager
                                                            <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                        </p>
                                                        <div style="height:10px;"></div>
                                                        <div class="d-flex justify-content-between align-items-center" style="font-size: 14px;">
                                                            <p class="mb-0" style="font-size: 15px; font-family: 'Poppins';">
                                                                <i class="fas fa-envelope" style="font-size: 20px; color: #009394; margin-right: 5px;"></i> johndoe@example.com
                                                                <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                            </p>
                                                            <div style="width: 20px;"></div>
                                                            <p class="mb-0" style="font-size: 15px; font-family: 'Poppins';">
                                                                <i class="fas fa-phone-alt" style="font-size: 20px; color: #009394; margin-right: 8px;"></i> +123 456 7890
                                                                <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                            </p>
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
                <!-- /.container-fluid -->
                <!-- Modals -->
                <!-- Add Contacts Modal -->
                <div class="modal fade" id="addContact" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#009394; height: 50px;">
                                <h5 class="modal-title" id="addProjectModalLabel" style="font-family:'Poppins';font-size: 15px; color:white;">Add Contact</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="font-size: 12px;">
                                <form id="editTaskForm">
                                    <!-- Third Row: Company and Name -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="company" class="form-label" style="font-family:'Poppins'; font-size: 12px;">Company</label>
                                            <input type="text" style="font-family:'Poppins'; font-size:14px" class="form-control form-control-sm" id="company" placeholder="Enter company name">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="name" class="form-label" style="font-family:'Poppins'; font-size: 12px;">Name</label>
                                            <input type="text" style="font-family:'Poppins'; font-size:14px" class="form-control form-control-sm" id="name" placeholder="Enter name">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="position" class="form-label" style="font-family:'Poppins'; font-size: 12px;">Position</label>
                                            <input type="text" style="font-family:'Poppins'; font-size:14px" class="form-control form-control-sm" id="position" placeholder="Enter position">
                                        </div>
                                    </div>
                                    <!-- Fourth Row: Position, Number, and Email -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="number" class="form-label" style="font-family:'Poppins'; font-size: 12px;">Number</label>
                                            <input type="number" style="font-family:'Poppins'; font-size:14px" class="form-control form-control-sm" id="number" placeholder="Enter number">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label" style="font-family:'Poppins'; font-size: 12px;">Email</label>
                                            <input type="email" style="font-family:'Poppins'; font-size:14px" class="form-control form-control-sm" id="email" placeholder="Enter email">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="font-family:'Poppins'; font-size: 12px;">Cancel</button>
                                <button type="button" class="btn btn-primary btn-sm" style="font-family:'Poppins'; font-size: 12px; background-color: #006270; border: none;">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
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
   


    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar collapse
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            const sidebar = document.getElementById('accordionSidebar');
            sidebar.classList.toggle('collapsed');
        });
    </script>
</body>

</html>