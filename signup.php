<!DOCTYPE html>
<html lang="en">
<head>  
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <link rel="stylesheet" href="signup.css">
</head>
<body>
    
    <div class="signup-container">
  <h2>Create Account</h2>

  <form action="" method="POST">
    
    <input type="text" name="fullname" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="confirm" placeholder="Confirm Password" required>

    <button type="submit" name="submit">submit</button>
  </form>

     <span class="login-link">Already have an account? <a href="login.php">Login</a></span>
     </div>
   


</body>
</html>
<?php
include ("connect.php");


if (isset($_POST['submit'])) {
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';



    if ($password !== $confirm) {
        echo "Passwords do not match";
        exit;
    }
    
    $sql ="INSERT INTO userlogin  (fullname, email, password) VALUES ('$fullname', '$email', '$password')";

    if (mysqli_query($conn, $sql)) {

        header("Location: login.php");
        exit;
    } else {
        echo "Error:".mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
