<?php
session_start();
include("connect.php");

/* ===== SESSION CHECK ===== */
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

/* ===== FETCH USER DATA ===== */
$query = mysqli_query($conn, "SELECT * FROM userlogin WHERE email='$email'");

if (!$query || mysqli_num_rows($query) == 0) {
    echo "User data not found!";
    exit();
}

$user = mysqli_fetch_assoc($query);

/* ===== PROFILE IMAGE ===== */
$profile_image = (!empty($user['profile_image']))
    ? $user['profile_image']
    : "default.png";

/* ===== USER NAME ===== */
/* Use email as fallback if 'name' does not exist */
$name = $user['name'] ?? $user['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>

<div class="profile-box">

    <!-- PROFILE IMAGE -->
    <img src="profil image.png"<?php echo htmlspecialchars($profile_image); ?>" alt="Profile">

    <!-- USER DETAILS -->
    <h2><?php echo htmlspecialchars($name); ?></h2>
    <!-- <p><?php echo htmlspecialchars($user['email']); ?></p> -->

    <!-- NAVIGATION -->
    <div class="profile-links">

        <a href="homepage.php">Back to Home</a>
        <form method="POST" action="login.php" style="display:inline;">
            
            <button type="submit">Logout</button>
        </form>
        <a href="Editprofile.php">Edit Profile</a>
    </div>

  
</body>
</html>
