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

    <!-- Bootstrap core CSS (only the latest version is needed) -->
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
            <li class="nav-item " >
                <a class="nav-link" href="calendar.php" style="border-radius:10px;padding-left:10px; ">
                    <i class="fas fa-fw fa-calendar-alt" style="white"></i>
                    <span style="font-size:13px; font-family:'Poppins';">Calendar</span>
                </a>
            </li>
            <li class="nav-item active" >
                <a class="nav-link" href="contacts.php" style="border-radius:10px;padding-left:10px;">
                    <i class="fas fa-fw fa-address-book"></i>
                    <span style="font-size:13px; font-family:'Poppins';">Contacts</span>
                </a>
            </li>
            <li class="nav-item" >
                <a class="nav-link" href="team.php" style="border-radius:10px;padding-left:10px;">
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
                            <h1 style="color:#36b9cc; font-family:'Poppins'; font-weight:bold; margin-bottom: 1px;">Contacts</h1> <!-- Reduced spacing -->
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
                                        <?php

                                        // Fetch current user ID from the session
                                        $userId = $_SESSION['user_id_c'];  // Assuming the user ID is stored in session

                                        // Prepare the SQL query to fetch all contact details for the current user
                                        $query = "SELECT * FROM contact_tb WHERE user_id = :userId ORDER BY contact_id DESC";


                                        // Prepare the statement
                                        $stmt = $conn->prepare($query);

                                        // Bind the parameter to the statement
                                        $stmt->bindParam(':userId', $userId);

                                        // Execute the query
                                        $stmt->execute();

                                        // Fetch all results
                                        $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        ?>

                                        <div class="container">
                                            <?php foreach ($contacts as $contact): ?>
                                                <div class="card mb-3" style="border-radius: 20px;">
                                                    <div class="card-header" style="font-family:'Poppins';background: linear-gradient(to right, #36b9cc,rgb(25, 230, 230)); color: white; border-radius:20px; font-size: 18px; font-weight: bold;">
                                                        Contact Profile
                                                    </div>
                                                    <div class="card-body" style="background-color: white; color: #555; padding: 10px; border-radius:20px; padding-left: 50px;">
                                                        <div class="d-flex align-items-center mb-2" style="gap: 50px;">
                                                                <!-- Change image source based on gender -->
                                                                <?php if ($contact['gender'] == 'Male'): ?>
                                                                    <img src="../images/man.png" alt="Contact 1" class="contact-image" style="width: 120px; height: 120px; border-radius: 50%;">
                                                                <?php else: ?>
                                                                    <img src="../images/woman.png" alt="Contact 1" class="contact-image" style="width: 120px; height: 120px; border-radius: 50%;">
                                                                <?php endif; ?>
                                                            <div class="contact-info">
                                                                <p class="mb-1" style="font-size: 15px; font-family: 'Poppins';">
                                                                    <strong><?php echo htmlspecialchars($contact['company']); ?></strong>
                                                                    <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                                </p>
                                                                <p class="mb-1" style="font-size: 30px; font-weight: bold; font-family: 'Poppins';">
                                                                    <?php echo htmlspecialchars($contact['name']); ?>
                                                                    <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                                </p>
                                                                <p class="mb-1" style="font-size: 15px; font-family: 'Poppins';">
                                                                    <?php echo htmlspecialchars($contact['position']); ?>
                                                                    <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                                </p>
                                                                <div style="height:10px;"></div>
                                                                <div class="d-flex justify-content-between align-items-center" style="font-size: 14px;">
                                                                    <p class="mb-0" style="font-size: 10px; font-family: 'Poppins';">
                                                                        <i class="fas fa-envelope" style="font-size: 20px; color: #009394; margin-right: 5px;"></i> 
                                                                        <?php echo htmlspecialchars($contact['email']); ?>
                                                                        <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                                    </p>
                                                                    <div style="width: 20px;"></div>
                                                                    <p class="mb-0" style="font-size: 10px; font-family: 'Poppins';">
                                                                        <i class="fas fa-phone-alt" style="font-size: 20px; color: #009394; margin-right: 8px;"></i> 
                                                                        <?php echo htmlspecialchars($contact['contact_number']); ?>
                                                                        <i class="fas fa-edit" style="font-size: 10px; color: #555; cursor: pointer; margin-left: 10px;" title="Edit"></i>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
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
                            <div class="modal-header" style="background-color:#36b9cc; height: 50px;">
                                <h5 class="modal-title" id="addProjectModalLabel" style="font-family:'Poppins';font-size: 15px; color:white;">Add Contact</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="font-size: 12px;">
                                <form id="editTaskForm" method="POST"action="dirback/add_contact.php">
                                    <!-- Third Row: Company and Name -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="company" class="form-label" style="font-family:'Poppins'; font-size: 12px;">Company</label>
                                            <input name="companyContact" type="text" style="font-family:'Poppins'; font-size:14px" class="form-control form-control-sm" id="company" placeholder="Enter company name">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="name" class="form-label" style="font-family:'Poppins'; font-size: 12px;">Name</label>
                                            <input name="nameContact" type="text" style="font-family:'Poppins'; font-size:14px" class="form-control form-control-sm" id="name" placeholder="Enter name">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="position" class="form-label" style="font-family:'Poppins'; font-size: 12px;">Position</label>
                                            <input name="position" type="text" style="font-family:'Poppins'; font-size:14px" class="form-control form-control-sm" id="position" placeholder="Enter position">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="position" class="form-label" style="font-family:'Poppins'; font-size: 12px;">Gender</label>
                                            <select name="gender" class="form-select" style="color:#555; font-family:'Poppins'; font-size:14px" required>
                                                <option value="" selected disabled>Select gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Fourth Row: Position, Number, and Email -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="number" class="form-label" style="font-family:'Poppins'; font-size: 12px;">Number</label>
                                            <input name="contactNum" type="number" style="font-family:'Poppins'; font-size:14px" class="form-control form-control-sm" id="number" placeholder="Enter number">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label" style="font-family:'Poppins'; font-size: 12px;">Email</label>
                                            <input name="email" type="email" style="font-family:'Poppins'; font-size:14px" class="form-control form-control-sm" id="email" placeholder="Enter email">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="font-family:'Poppins'; font-size: 12px;">Cancel</button>
                                        <button type="submit"  class="btn btn-primary btn-sm" style="font-family:'Poppins'; font-size: 12px; background-color: #36b9cc; border: none;">Save Changes</button>
                                    </div>
                                </form>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="toogleNav.js"></script>

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
    <script>
        $(document).ready(function() {
            // When the "Save Changes" button is clicked
            $('#saveChangesButton').on('click', function() {
                // Collect form data
                var company = $('#company').val();
                var name = $('#name').val();
                var position = $('#position').val();
                var gender = $('select[name="gender"]').val();  // For gender select
                var contactNum = $('#number').val();
                var email = $('#email').val();

                // Validate if fields are empty
                if (company === "" || name === "" || position === "" || gender === "" || contactNum === "" || email === "") {
                    alert("Please fill in all the fields.");
                    return; // Stop the function if validation fails
                }

                // Send AJAX request to the backend PHP file
                $.ajax({
                    url: 'dirback/add_contact.php', // Replace with your PHP file's path
                    type: 'POST',
                    data: {
                        companyContact: company,
                        nameContact: name,
                        position: position,
                        gender: gender,
                        contactNum: contactNum,
                        email: email
                    },
                    success: function(response) {
                        // Handle success: show success message and close modal
                        alert(response); // This could be a success message from your backend
                        $('#addContact').modal('hide'); // Close the modal
                        // Optionally, you can refresh or update a contact list here
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        alert("An error occurred: " + error);
                    }
                });
            });
        });
    </script>


    
</body>

</html>