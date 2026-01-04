<?php
include("connect.php");
session_start();

/* Protect page: redirect if not logged in */
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

/* Logout logic */
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home Page</title>
  <link rel="stylesheet" href="homepage.css">
</head>
<body>

<section class="hero">
  <div class="hero-content">
    <h2>Hey Mokshitha</h2>

    <div class="profile-card">
      <img src="profil image.png" alt="Profile Picture" class="profile-img">

      <p>Your space, your rules. Take a look at your profile or log out whenever you want.</p>

      <p class="email">
        <?php echo htmlspecialchars($_SESSION['email']); ?>
      </p>

      <div class="home-buttons">

        <!-- ✅ PROFILE BUTTON (NO PHP LOGIC NEEDED) -->
        <a href="profile.php">
          <button type="button">Profile</button>
        </a>

        <!-- ✅ LOGOUT BUTTON -->
        <form method="POST" style="display:inline;">
          <button type="submit" name="logout">Logout</button>
        </form>

      </div>
    </div>
  </div>
</section>

</body>
</html>
