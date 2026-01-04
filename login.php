<?php
session_start();
include("connect.php");

if (isset($_POST['submit'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM userlogin WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {

        $user = mysqli_fetch_assoc($result);

        if ($password === $user['password']) {

            $_SESSION['email'] = $user['email'];
            header("Location: homepage.php");
            exit();

        } else {
            echo "Wrong password";
        }

    } else {
        echo "User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Page</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-container">
  <h2>Welcome Back</h2>
  <p>Please login to your account</p>

  <form method="POST">

    <!-- ✅ FIXED name -->
    <input type="email" name="email" placeholder="Email" required>

    <input type="password" name="password" placeholder="Password" required>

    <button type="submit" name="submit">Login</button>

    <span class="link">Forgot password?</span>
    <div class="link">
      <a href="signup.php">Sign Up</a>
    </div>

  </form>
</div>

</body>
</html>
