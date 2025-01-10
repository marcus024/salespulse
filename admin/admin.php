<!DOCTYPE html>
<html lang="en">
<?php include("../auth/db.php");?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin 2 - Blank</title>
    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul style="background:#36b9cc;" class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SALES PULSE-ADMIN</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
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
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <img class="img-profile rounded-circle"
                                    src="../images/man.png">
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
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <!-- Header Title -->
                            <h6 class="m-0 font-weight-bold text-primary">Sales Pulse</h6>
                            <!-- Add User Button -->
                            <button class="btn  btn-sm" data-toggle="modal" data-target="#addUserModal" style="background:#36b9cc; color:white;">
                                Add User
                            </button>
                        </div>
                        <style>
                            .table-smaller th,
                            .table-smaller td {
                                font-size: 0.85rem; /* Adjust font size as needed */
                            }
                            /* Add this to your CSS */
                        </style>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-smaller" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Password</th>
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
                                                    echo "<td>" . htmlspecialchars($row['apass']) . "</td>";
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
                    <!-- Custom CSS to remove outline -->
                    <style>
                        .form-control:focus {
                            outline: none;
                            box-shadow: none;
                        }
                    </style>
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

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

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