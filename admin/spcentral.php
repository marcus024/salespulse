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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrQkTy9I6bLXJe5B4zEfaQf0P3x7Ih94c5eNsDcFpzNxXk3mOZZYC+iF+Iq5LZkzx7u+0dZPhu7GDYkNzg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/spportal.css" rel="stylesheet">
    <link href="css/user_date_dp.css" rel="stylesheet">

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
            <li class="nav-item active" >
                <a class="nav-link selected " href="spportal.php" style="border-radius:10px;padding-left:10px;">
                    <i class="fas fa-fw fa-home"></i>
                    <span style="font-size:13px; font-family:'Poppins';">Dashboard</span>
                </a>
            </li>
            <li class="nav-item " >
                <a class="nav-link" href="project_portal" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-calendar-alt" style="white"></i>
                    <span style="font-size:13px; font-family:'Poppins';">Projects</span>
                </a>
            </li>
            <li class="nav-item" >
                <a class="nav-link" href="contacts_portal" style="border-radius:10px; padding-left:10px;">
                    <i class="fas fa-fw fa-address-book"></i>
                    <span style="font-size:13px; font-family:'Poppins';">Contacts</span>
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
                            <h1 style="color:#36b9cc; font-family:'Poppins'; font-weight:bold; margin-bottom: 1px;">CENTRAL</h1> <!-- Reduced spacing -->
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
                                            <div class="card-title" style="font-family:'Poppins'">Completed</div>
                                            <div class="card-number" style="font-family:'Poppins'">12</div>
                                        </div>
                                    </div>
                                    <div class="rectangle-card" onclick="filterTable('Ongoing')">
                                        <i class="card-icon">
                                            <img src="../images/ongoingP.png" alt="icon" width="30" height="30">
                                        </i>
                                        <div class="card-content">
                                            <div class="card-title" style="font-family:'Poppins'">On Going</div>
                                            <div class="card-number" style="font-family:'Poppins'">23</div>
                                        </div>
                                    </div>
                                    <div class="rectangle-card" onclick="filterTable('Cancelled')">
                                        <i class="card-icon">
                                            <img src="../images/cancelP.png" alt="icon" width="30" height="30">
                                        </i>
                                        <div class="card-content">
                                            <div class="card-title" style="font-family:'Poppins'">Cancelled</div>
                                            <div class="card-number" style="font-family:'Poppins'">12</div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="dropdown">
                                            <button class="btn dropdown-card w-100 dropdown-toggle" type="button" id="usersDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-users card-icon"></i>
                                                <div class="card-content">
                                                    <div class="card-title">Users</div>
                                                    <div class="card-number" id="selected-user">Select</div>
                                                </div>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="usersDropdown">
                                                <li><a class="dropdown-item" href="#" onclick="selectUser('All')">All Users</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectUser('User1')">User1</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectUser('User2')">User2</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectUser('User3')">User3</a></li>
                                                <!-- Add more users as needed -->
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="margin:0px;">
                                        <div class="dropdown">
                                            <button class="btn dropdown-card w-100 dropdown-toggle" type="button" id="usersDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-users card-icon"></i>
                                                <div class="card-content">
                                                    <div class="card-title">Projects</div>
                                                    <div class="card-number" id="selected-user">Select </div>
                                                </div>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="usersDropdown">
                                                <li><a class="dropdown-item" href="#" onclick="selectUser('All')">All Projects</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectUser('User1')">Project1</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectUser('User2')">Project2</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectUser('User3')">Project3</a></li>
                                                <!-- Add more users as needed -->
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Months Dropdown -->
                                    <div class="col-md-2">
                                        <div class="dropdown">
                                            <button class="btn dropdown-card w-100 dropdown-toggle" type="button" id="monthsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-calendar-alt card-icon"></i>
                                                <div class="card-content">
                                                    <div class="card-title">Months</div>
                                                    <div class="card-number" id="selected-month">Select </div>
                                                </div>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="monthsDropdown">
                                                <li><a class="dropdown-item" href="#" onclick="selectMonth('All')">All Months</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectMonth('January')">January</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectMonth('February')">February</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectMonth('March')">March</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectMonth('April')">April</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectMonth('May')">May</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectMonth('June')">June</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectMonth('July')">July</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectMonth('August')">August</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectMonth('September')">September</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectMonth('October')">October</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectMonth('November')">November</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="selectMonth('December')">December</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="container my-2">
                                    <!-- Row to Hold the Cards -->
                                    <div class="row g-4"> <!-- g-4 adds gutter (spacing) between columns -->
                                        <!-- First Card: Peak Users per Day -->
                                        <div class="col-md-6"> <!-- Adjust the column size as needed -->
                                            <div class="card shadow mb-4">
                                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                                    <!-- Header Title -->
                                                    <h6 class="m-0 font-weight-bold" style="color:#36b9cc;">Peak Users per Day</h6>
                                                    <!-- Optional: Add an icon or button in the header -->
                                                    <i class="fas fa-chart-line" style="color:#36b9cc;"></i>
                                                </div>
                                                <div class="card-body">
                                                    <canvas id="peakUsersChart1" width="400" height="200"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Second Card: Peak Users per Day -->
                                        <div class="col-md-6">
                                            <div class="card shadow mb-4">
                                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                                    <!-- Header Title -->
                                                    <h6 class="m-0 font-weight-bold" style="color:#36b9cc;">No. of Projects per User</h6>
                                                    <!-- Optional: Add an icon or button in the header -->
                                                    <i class="fas fa-chart-line" style="color:#36b9cc;"></i>
                                                </div>
                                                <div class="card-body">
                                                    <canvas id="peakUsersChart2" width="400" height="200"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                        <!-- Header Title -->
                                        <h6 class="m-0 font-weight-bold" style="color:#36b9cc;">Users</h6>
                                        <!-- Add User Button -->
                                        <button class="btn  btn-sm" data-toggle="modal" data-target="#addUserModal" style="background:#36b9cc; color:white;">
                                            Add User
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-smaller" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Email</th>
                                                        <th>Role</th>
                                                        <th>User ID</th>
                                                        <th>Status</th>
                                                        <th>Actions</th> <!-- Added Actions column -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Check if the query was successful and if there are rows
                                                    try {
                                                        $sql = "SELECT firstname, lastname, email, position, role, company, apass, status, id,user_id_current FROM salesauth";
                                                        $stmt = $conn->query($sql);
                                                        if ($stmt->rowCount() > 0) {
                                                            // Output data for each row
                                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                echo "<tr>";
                                                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['user_id_current']) . "</td>";
                                                                // Conditional check for the "Status" column
                                                                $status = $row['status'] === 'YES' ? 'Activated' : 'Not Active';
                                                                echo "<td>" . htmlspecialchars($status) . "</td>";

                                                                // Display Activate/Deactivate buttons
                                                                if ($row['status'] === 'YES') {
                                                                    echo "<td>
                                                                        <button class='btn btn-danger btn-sm' onclick='updateStatus(" . $row['id'] . ", \"NO\")'>Deactivate</button>
                                                                        <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editUserModal' onclick='editUser(" . json_encode($row) . ")'>Edit</button>
                                                                    </td>";
                                                                } else {
                                                                    echo "<td>
                                                                        <button class='btn btn-success btn-sm' onclick='updateStatus(" . $row['id'] . ", \"YES\")'>Activate</button>
                                                                        <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editUserModal' onclick='editUser(" . json_encode($row) . ")'>Edit</button>
                                                                    </td>";
                                                                }

                                                                echo "</tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='9'>No users found.</td></tr>";
                                                        }
                                                    } catch (PDOException $e) {
                                                        echo "<tr><td colspan='9'>Error fetching data: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Notification card to display success/failure messages -->
                                        <div id="notifCard" class="alert alert-info" style="display:none;">
                                            <strong>Success!</strong> Status updated successfully.
                                        </div>
                                        <div id="notifCardError" class="alert alert-danger" style="display:none;">
                                            <strong>Error!</strong> Failed to update the status.
                                        </div>
                                        <script>
                                            // Function to update user status (Activate/Deactivate)
                                            function updateStatus(userId, newStatus) {
                                                // Send the AJAX request to update the status
                                                $.ajax({
                                                    type: "POST",
                                                    url: "update_status.php",
                                                    data: { id: userId, status: newStatus },
                                                    dataType: "json",
                                                    success: function(response) {
                                                        if (response.success) {
                                                            // Show the success notification card
                                                            $("#notifCard").show();
                                                            setTimeout(function() {
                                                                $("#notifCard").fadeOut();
                                                            }, 3000);
                                                            
                                                            // Optionally reload the page or update the table dynamically
                                                            location.reload();  // Reload the page to reflect changes
                                                        } else {
                                                            // Show error notification card
                                                            $("#notifCardError").show();
                                                            setTimeout(function() {
                                                                $("#notifCardError").fadeOut();
                                                            }, 3000);
                                                        }
                                                    },
                                                    error: function() {
                                                        // Show error notification card if request fails
                                                        $("#notifCardError").show();
                                                        setTimeout(function() {
                                                            $("#notifCardError").fadeOut();
                                                        }, 3000);
                                                    }
                                                });
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Cards -->
                    
                    <!-- Modal for Add User -->
                    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document" style="max-width: 800px;">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color:#36b9cc; height: 50px;">
                                    <h5 class="modal-title" id="addUserModalLabel" style="font-size: 15px; color:white;">Add New User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="add_user.php" method="POST">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <!-- Grid layout with 2 rows and 4 columns -->
                                                <div class="row">
                                                    <div class="col-md-3 mb-3">
                                                        <label for="firstName" class="form-label" style="color:#555; font-size: 12px; font-family:'Poppins'">First Name</label>
                                                        <input name="firstname" type="text" class="form-control" id="firstName" placeholder="Enter First Name" style="color:#555; font-size: 12px; font-family:'Poppins'" required>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="lastName" class="form-label" style="color:#555; font-size: 12px; font-family:'Poppins'">Last Name</label>
                                                        <input name="lastname" type="text" class="form-control" id="lastName" placeholder="Enter Last Name" required style="color:#555; font-size: 12px; font-family:'Poppins'">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="email" class="form-label" style="color:#555; font-size: 12px; font-family:'Poppins'">Email</label>
                                                        <input name="email" type="text" class="form-control" id="lastName" placeholder="Enter Last Name" required style="color:#555; font-size: 12px; font-family:'Poppins'">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="password" class="form-label" style="color:#555; font-size: 12px; font-family:'Poppins'">Password</label>
                                                        <input name="password" type="text" class="form-control" id="lastName" placeholder="e.g. Aaa@123" required style="color:#555; font-size: 12px; font-family:'Poppins'">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mb-3">
                                                        <label for="position" class="form-label" style="color:#555; font-size: 12px; font-family:'Poppins'">Position</label>
                                                        <input name="position" type="text" class="form-control" id="position" placeholder="Enter Position" required style="color:#555; font-size: 12px; font-family:'Poppins'">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="role" class="form-label" style="color:#555; font-size: 12px; font-family:'Poppins'">Role</label>
                                                        <select name="role" class="form-control" id="role" required style="color:#555; font-size: 12px; font-family:'Poppins'">
                                                            <option value="" disabled selected>Select a Role</option> <!-- Visible text before selection -->
                                                            <option value="director">Director</option>
                                                            <option value="ithead">IT Head</option>
                                                            <option value="itmember">IT Member</option>
                                                            <option value="saleshead">Sales Head</option>
                                                            <option value="salesmember">Sales Member</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="company" class="form-label" style="color:#555; font-size: 12px; font-family:'Poppins'">Company</label>
                                                        <input name="company" type="text" class="form-control" id="company" placeholder="Enter Company" required style="color:#555; font-size: 12px; font-family:'Poppins'">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-size:15px; ">Close</button>
                                            <button type="submit"  class="btn " style="font-size:15px; background:#36b9cc; color:white;">Add User</button>
                                        </div>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal for Edit User (Optional) -->
                    <div class="modal fade" id="editUserModal" tabindex="-1"  aria-labelledby="editUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog" >
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="font-size: 12px;">
                                    <form>
                                        <!-- Edit User Form Fields (Same as Add User) -->
                                        <div class="form-group">
                                            <label for="editFirstName">First Name</label>
                                            <input type="text" class="form-control" id="editFirstName" placeholder="Enter First Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="editLastName">Last Name</label>
                                            <input type="text" class="form-control" id="editLastName" placeholder="Enter Last Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="editEmail">Email</label>
                                            <input type="email" class="form-control" id="editEmail" placeholder="Enter Email">
                                        </div>
                                        <div class="form-group">
                                            <label for="editPassword">Password</label>
                                            <input type="password" class="form-control" id="editPassword" placeholder="Enter Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="editPosition">Position</label>
                                            <input type="text" class="form-control" id="editPosition" placeholder="Enter Position">
                                        </div>
                                        <div class="form-group">
                                            <label for="editRole">Role</label>
                                            <select class="form-control" id="editRole">
                                                <option>Admin</option>
                                                <option>Manager</option>
                                                <option>Member</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="editCompany">Company</label>
                                            <input type="text" class="form-control" id="editCompany" placeholder="Enter Company">
                                        </div>
                                        <div class="form-group">
                                            <label for="editStatus">Status</label>
                                            <select class="form-control" id="editStatus">
                                                <option>Active</option>
                                                <option>Inactive</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save Changes</button>
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
     <script src="calendar/outlook/calendar.js"></script>
     <script src="calendar/google/gcalendar.js"></script>
    <script src="alerts/notif.js"></script>
    <script src="notif.js"></script>
    <script src="alerts/notifCount.js"></script>
    <script src="calendar/update/updateCal.js"></script>
    <script src="../Director/toogleNav.js"></script>
    <script src="js/peak.js"></script>
    
    <script>
        // Example functions for edit and delete actions
        function editUser(userId) {
            // Logic for editing the user details (e.g., fill the modal fields with existing data)
            console.log('Edit user:', userId);
        }

        function deleteUser(userId) {
            // Logic for deleting the user
            if (confirm('Are you sure you want to delete this user?')) {
                console.log('Deleted user:', userId);
                // Add your delete logic here (e.g., make an API call to delete the user)
            }
        }
    </script>
</body>
</html>