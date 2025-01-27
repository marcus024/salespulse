<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sales Pulse</title>
  <link rel="icon" href="images/logo_blue.ico" type="image/x-icon">
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
      height: 100vh;
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
      max-width: 600px;
      background: transparent;
      border-radius: 10px;
      padding: 40px;
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
    .input-group {
      margin-bottom: 20px;
      position: relative;
      text-align: left; 
    }
    .input-group label {
      font-size: 14px;
      font-weight: bold;
      font-family: 'Poppins';
      color: #555;
      display: block;
      margin-bottom: 5px;
    }
    .input-group input {
   
      padding: 15px;
      font-size: 12px;
      font-family:'Poppins';
      border: 1px solid #555;
      border-radius: 10px;
      background-color: transparent; /* Light green background */
      color: white;
      width: 70%;
      margin: 0 auto; 
    }
    .input-group input::placeholder {
      color: #555d;
      font-size:12px;
      font-family:'Poppins'
    }
    .input-group input:focus::placeholder {
    color: white; /* Makes the placeholder invisible */
    }
    .input-group input:focus {
      border-color:#555;
      outline: none;
      background-color: transparent; /* Slightly darker green when focused */
    }
    .input-group span {
    position: absolute;
    right: 30%; /* Aligns "Forgot Password" to the right edge */
    top: 120%; /* Vertically centers the text */
    transform: translateY(-50%);
    font-size: 12px;
    font-weight:bold;
    font-family:'Poppins';
    color: #17a2b8;
    cursor: pointer;

  }
    .login-btn {
      width: 130px;
      height: 40px;
      padding: 5px;
      background: #17a2b8;
      color: #ffffff;
      font-size: 15px;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-family:'Poppins';
      font-weight:bold;
      display: block; /* Ensure it's treated as a block-level element */
      margin:30px auto; 
      margin-left:20%;
    }
    .login-btn:hover {
      background: #138996;
    }
    .signup-link {
      margin-left: 12%;
      margin-top: 1%;
      font-family:'Poppins';
      font-size:12px;
      color:white;
     
    }
    .signup-link a {
      color: #f9ce45;
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

    /* Loading Overlay */
.loading-overlay {
    display: none; /* Hidden by default */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    z-index: 9999; /* Ensure it overlays all content */
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

/* Loading Spinner */
.spinner {
    width: 50px;
    height: 50px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #17a2b8; /* Color of the spinner */
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-bottom: 10px;
}

/* Spinner Animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Loading Text */
.loading-text {
    color: white;
    font-family: 'Poppins', sans-serif;
    font-size: 1.2rem;
    font-weight: bold;
    text-align: center;
}

  </style>
</head>
<body>
  <div class="container">
    <!-- Right Section -->
    <div class="right-section">
      <h1>
        <img src="images/salespulselogo.png" alt="Logo" style="width: 45px; height: 40px; vertical-align: middle; margin-right: 10px;">
        Sales Pulse
      </h1>
      <p>Welcome back!</p>
      <p class="loginP" style="font-size: 40px; font-family:'Poppins'; margin: 0; margin-bottom: 10px; color: white;">Log In</p>
      <div class="loading-overlay" id="loadingOverlay">
          <div class="spinner"></div>
          <div class="loading-text">Logging in, please wait...</div>
      </div>
        <form class="user" action="auth/loginBack.php" method="POST" onsubmit="showLoading(event)">
            <div class="input-group">
                <label for="email">Email</label>
                <input required  name="email" type="email" placeholder="Enter your email" autocomplete="off" />
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input required name="password" type="password" placeholder="Enter your password" autocomplete="off" />
                <span onclick="togglePassword()" style="color:white;">Forgot Password?</span>
            </div>
            <button type="submit" class="login-btn">LOGIN</button>
        </form>
      <div class="signup-link">
        Don't have an account yet? <a href="auth/register.php">Sign up for Free!</a>
      </div>
    </div>
    <img class="overlay-image" src="images/logpic.png" alt="Illustration" />

    <div class="left-section">
      <!-- Left Section Content -->
    </div>
  </div>

  <script>
    function showLoading(event) {
        event.preventDefault(); // Prevent immediate form submission for testing
        const loadingOverlay = document.getElementById('loadingOverlay');
        loadingOverlay.style.display = 'flex'; // Show the loading overlay

        const loginBtn = document.querySelector('.login-btn');
        loginBtn.disabled = true; // Disable the login button

        // Simulate form submission delay (remove this in production)
        setTimeout(() => {
            event.target.submit(); // Submit the form after showing the spinner
        }, 2000);
    }

    function togglePassword() {
      alert('Password recovery is not implemented yet.');
    }
  </script>
  
</body>
</html>
