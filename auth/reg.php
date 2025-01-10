<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Secure Registration Form">
    <meta name="author" content="">

    <title>Secure Registration Form</title>
    
    <!-- Bootstrap CSS with SRI -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-QF4VXHZqJ/vlQmNj52eua1wP+F09rICwGZyF6t8Pi6U2FmwSHTZ4+Zmw9K18qt" 
          crossorigin="anonymous">
    
    <!-- FontAwesome CSS -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create a Secure Account!</h1>
                            </div>
                            <form class="user" action="regBack.php" method="POST" id="registrationForm">
                                <!-- CSRF Token -->
                                <input type="hidden" name="csrf_token" value="PLACEHOLDER_FOR_CSRF_TOKEN">

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input name="firstname" type="text" class="form-control form-control-user" 
                                               placeholder="First Name" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input name="lastname" type="text" class="form-control form-control-user" 
                                               placeholder="Last Name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input name="email" type="email" class="form-control form-control-user" 
                                           placeholder="Email Address" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input name="password" type="password" class="form-control form-control-user" 
                                               id="password" placeholder="Password" minlength="8" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input name="repeatpass" type="password" class="form-control form-control-user" 
                                               id="repeatPassword" placeholder="Repeat Password" minlength="8" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="company" class="form-control form-control-user" 
                                               placeholder="Company" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input name="position" type="text" class="form-control form-control-user" 
                                               placeholder="Position" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <select name="role" class="form-select" required>
                                            <option value="" disabled selected>Select a Role</option>
                                            <option value="director">Director</option>
                                            <option value="ithead">IT Head</option>
                                            <option value="itmember">IT Member</option>
                                            <option value="saleshead">Sales Head</option>
                                            <option value="salesmember">Sales Member</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="gender" class="form-select" required>
                                            <option value="" disabled selected>Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="../index.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS with SRI -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-GQDAgIPy8+lgwE+e9X1qlSUnUU7g6yJhWOUQxgtE1z+s7Ygb9pmXvjOYe3fcdHo8" 
            crossorigin="anonymous"></script>
    
    <!-- JavaScript for Validation -->
    <script>
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            const repeatPassword = document.getElementById('repeatPassword').value;

            if (password !== repeatPassword) {
                alert('Passwords do not match!');
                event.preventDefault();
            }

            // Additional validation can go here
        });
    </script>
</body>
</html>
