<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sales Pulse</title>
  <link rel="icon" href="../images/logo_blue.ico" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    /* General Reset */
    body, html {
      margin: 0;
      padding-left: 0;
      padding-right: 0;
      font-family: 'Arial', sans-serif;
      background: #1f2024;
      height: 100%;
    }
    * {
      box-sizing: border-box;
    }
    /* Main Container */
    .container {
    display: flex;
    align-items: center; /* Center align vertically */
    justify-content: space-between; /* Align sections at both ends */
    height: 100vh; /* Set height equal to the viewport height */
    flex-wrap: wrap;
    margin: 0; /* Remove margin */
    padding: 0;
    background-color: #1f2024;
}

    .left-section {
      flex: 1;
      max-width: 400px;
      height: 100vh; /* Full height of the viewport */
      text-align: center;
      background-color: #f9ce45;
      border-top-left-radius: 50px; /* Curved top-left corner */
      border-bottom-left-radius: 50px; /* Curved bottom-left corner */
      display: flex; /* Center content */
      justify-content: center;
      align-items: center;
    }
    
    /* Right Section */
    .right-section {
      flex: 1;
      max-width: 800px;
      background: transparent;
      border-radius: 10px;
      padding: 40px;
      margin-top:0;
    }
    .right-section h1 {
      font-family: 'Poppins';
      font-size: 2rem;
      color: white;
      margin-bottom: 0;
    }
    .right-section p {
      font-size: 1rem;
      color: white;
      font-family: 'Poppins';
      font-weight: bold;
    }

    form {
    display: flex;
    flex-direction: column;
    gap: 20px;
    }
    .row {
    display: flex;
    gap: 20px;
    }
    .input-group {
      margin-bottom: 0;
      position: relative;
      text-align: left; 
      flex: 1;
      display: flex;
      flex-direction: column;
    }
    .input-group.full-width {
    flex: 100%; /* Takes the full width in the row */
    }

    .input-group label {
      font-size: 14px;
      font-family: 'Poppins';
      color: #555;
      display: block;
      margin-bottom: 2px;
      
    }
    .input-group input {
   
      padding: 15px;
      font-size: 12px;
      font-family:'Poppins';
      border: 1px solid #555;
      border-radius: 10px;
      background-color: #1f2024; /* Light green background */
      color: white;
      width: 100%;
      margin: 0 auto; 
      height: 40px;
      
    }
    .input-group input::placeholder {
      color: #555;
      font-size:12px;
      font-family:'Poppins'
    }
    .input-group input:focus::placeholder {
    color: #555; /* Makes the placeholder invisible */
    }
    .input-group input:focus {
      border-color: #555;
      outline: none;

      background-color:#1f2024; /* Slightly darker green when focused */
    }
    .input-group span {
    position: absolute;
    right: 30%; /* Aligns "Forgot Password" to the right edge */
    top: 120%; /* Vertically centers the text */
    transform: translateY(-50%);
    font-size: 12px;
    font-weight:bold;
    font-family:'Poppins';
    color: white;
    cursor: pointer;

  }

  .input-group select {
    padding: 5px;
    font-size: 12px;
    font-family: 'Poppins';
    border: 1px solid #555;
    border-radius: 10px;
    background-color: white; /* Matches the input background */
    color: #36b9cc;
    width: 100%;
    height: 40px;
    }

    .input-group select:focus {
        border-color: white ;
        outline: none;
        background-color: white; /* Slightly darker green for focus */
    }

    .input-group select option {
        color: white; /* Black text for dropdown items */
    }

    .login-btn {
      width: 130px;
      height: 40px;
      padding: 5px;
      background: #f9ce45 ;
      color: #ffffff;
      font-size: 15px;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-family:'Poppins';
      font-weight:bold;
      display: block; /* Ensure it's treated as a block-level element */
      margin:1% auto; 
      margin-left:41%;
    }
    .login-btn:hover {
      background: rgb(232, 180, 11) ;
    }
    .signup-link {
      margin-left: 36%;
      margin-top: 1%;
      font-family:'Poppins';
      font-size:12px;
     
    }
    .signup-link a {
      color:  #f9ce45;
      text-decoration: none;
    }
    .signup-link a:hover {
      text-decoration: underline;
    }
    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        text-align: center;
      }
      .left-section {
        border-radius: 0; /* Remove curves on small screens */
        height: auto; /* Adjust height for smaller devices */
      }
      .left-section img {
        margin: auto;
      }
    }

    .overlay-image {
    position: absolute;
    top: 55%;
    left: 68%;
    transform: translate(-50%, -50%);
    width: 700px; /* Default size for larger screens */
    max-width: 100%; /* Ensures it doesn't exceed the screen width */
    z-index: 2;
    pointer-events: none;
    animation: float 3s ease-in-out infinite;
    }

    @media (max-width: 1024px) {
    .overlay-image {
        width: 500px; /* Reduce size for medium screens */
        top: 60%; /* Adjust position */
        left: 65%;
    }
    }

    @media (max-width: 768px) {
    .overlay-image {
        width: 350px; /* Further reduce size for small screens */
        top: 65%; /* Adjust position */
        left: 50%;
    }
    }

    @media (max-width: 480px) {
    .overlay-image {
        width: 250px; /* Minimum size for very small screens */
        top: 70%;
        left: 50%;
    }
    }
    @keyframes float {
      0%, 100% {
        transform: translate(-50%, -50%) translateY(0);
      }
      50% {
        transform: translate(-50%, -50%) translateY(-20px); /* Float upward */
      }
    }

  </style>
</head>
<body>
  <div class="container">
    <!-- Right Section -->
    <div class="right-section">
      <h1>
        <img src="../images/log_icon_x.png" alt="Logo" style="width: 45px; height: 40px; vertical-align: middle; margin-right: 10px;">
        Sales Pulse
      </h1>
      <p class="loginP" style="font-size: 40px; font-family:'Poppins'; margin-top: 1%; margin-bottom: 10px; color: black;">Register</p>
        <form class="user" action="regBack.php" method="POST">
            <!-- First Row - Two Columns -->
            <div class="row">
                <div class="input-group">
                    <label for="firstName">First Name</label>
                    <input required name="firstname" type="text" placeholder="Enter your first name" autocomplete="off" />
                </div>
                <div class="input-group">
                    <label for="lastName">Last Name</label>
                    <input required name="lastname" type="text" placeholder="Enter your last name" autocomplete="off" />
                </div>
                <div class="input-group">
                    <label for="gender">Gender</label>
                    <select required name="gender" id="gender" autocomplete="off">
                        <option value="">Select your gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>
            <!-- Second Row - One Column -->
            <div class="row">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input required name="email" type="email" placeholder="Enter your email" autocomplete="off" />
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Enter your password"
                        autocomplete="off"
                        required
                    />
                    <small id="passwordValidation" style="color: red;"></small>
                </div>
                <div class="input-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input
                        id="confirmPassword"
                        name="repeatpass"
                        type="password"
                        placeholder="Confirm your password"
                        autocomplete="off"
                        required
                    />
                    <small id="confirmPasswordValidation" style="color: red;"></small>
                </div>
            </div>
            <div class="row">
                <div class="input-group">
                    <label for="dob">Company</label>
                    <input required name="company" type="text" placeholder="Enter your company" autocomplete="off" />
                </div>
                <div class="input-group">
                    <label for="address">Position</label>
                    <input required name="position" type="text" placeholder="Enter your position" autocomplete="off" />
                </div>
                <div class="input-group">
                    <label for="zipCode">Role</label>
                    <select name="role" class="form-select" id="roleSelect">
                        <option value="" disabled selected>Select a Role</option> <!-- Visible text before selection -->
                        <option value="salesdirector">Sales and Marketing Director</option>
                        <option value="unithead">Business Unit Head</option>
                        <option value="salesmanager">Sales Manager</option>
                        <option value="accountmanager">Account Manager</option>
                    </select>
                </div>
            </div>
            <!-- Submit Button -->
            <button type="submit" class="login-btn">REGISTER</button>
        </form>

      <div class="signup-link">
        Already have an account? <a href="../index.php">Login</a>
      </div>
    </div>
    <img class="overlay-image" src="../images/logpic.png" alt="Illustration" />

    <div class="left-section">
      <!-- Left Section Content -->
    </div>
  </div>

  <script>
    function togglePassword() {
      alert('Password recovery is not implemented yet.');
    }
  </script>
  <script>
      document.addEventListener("DOMContentLoaded", () => {
      const passwordField = document.getElementById("password");
      const confirmPasswordField = document.getElementById("confirmPassword");
      const passwordValidationMessage = document.getElementById("passwordValidation");
      const confirmPasswordValidationMessage = document.getElementById("confirmPasswordValidation");

      // Function to validate password
      function validatePassword() {
          const password = passwordField.value;
          const regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#])[A-Za-z\d@#]{8,}$/;

          if (password.length === 0) {
              passwordValidationMessage.textContent = ""; // Clear message when empty
          } else if (!regex.test(password)) {
              passwordValidationMessage.textContent =
                  "Password must be at least 8 characters, include @ or #, one uppercase, one lowercase, and a number.";
          } else {
              passwordValidationMessage.textContent = "Valid password.";
              passwordValidationMessage.style.color = "green";
          }
      }

      // Function to validate confirm password
      function validateConfirmPassword() {
          const password = passwordField.value;
          const confirmPassword = confirmPasswordField.value;

          if (confirmPassword.length === 0) {
              confirmPasswordValidationMessage.textContent = ""; // Clear message when empty
          } else if (password !== confirmPassword) {
              confirmPasswordValidationMessage.textContent = "Passwords do not match.";
              confirmPasswordValidationMessage.style.color = "red";
          } else {
              confirmPasswordValidationMessage.textContent = "Passwords match.";
              confirmPasswordValidationMessage.style.color = "green";
          }
      }

      // Event listeners for real-time validation
      passwordField.addEventListener("input", validatePassword);
      confirmPasswordField.addEventListener("input", validateConfirmPassword);
  });

  </script>
</body>
</html>
