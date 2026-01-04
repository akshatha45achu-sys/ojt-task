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
    echo "User not found!";
    exit();
}

$user = mysqli_fetch_assoc($query);
$profile_image = !empty($user['profile_image']) ? $user['profile_image'] : "default.png";

/* ===== HANDLE FORM SUBMISSION ===== */
$message = "";

if (isset($_POST['update'])) {

    // Sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $img_name = $_FILES['profile_image']['name'];
        $img_tmp = $_FILES['profile_image']['tmp_name'];
        $ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $new_img_name = uniqid() . "." . $ext;
        $upload_dir = "uploads/";

        if (move_uploaded_file($img_tmp, $upload_dir . $new_img_name)) {
            $profile_image = $new_img_name;
        }
    }

    // Update database
    $update = mysqli_query($conn, "UPDATE userlogin SET email='$new_email', name='$name', profile_image='$profile_image' WHERE email='$email'");

    if ($update) {
        $_SESSION['email'] = $new_email; // update session email
        $message = "Profile updated successfully!";
    } else {
        $message = "Error updating profile: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="Editprofile.css">
</head>
<body>

<div class="profile-box">
    <h2>Edit Profile</h2>

    <?php if($message != ""): ?>
        <p style="color: green;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

        <!-- PROFILE IMAGE PREVIEW -->
        <img src="profil image.png"<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Image" style="width:100px;height:100px;border-radius:50%;object-fit:cover;margin-bottom:10px;">

        <div>
            <label>Name:</label><br>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>
        </div>
        <br>
        <div>
            <label>Email:</label><br>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <br>
        <div>
            <label>Profile Image:</label><br>
            <input type="file" name="profile_image" accept="image/*">
        </div>
        <br>
        <button type="submit" name="update">Update Profile</button>
    </form>

    <br>
    <a href="profile.php">Back to Profile</a>
</div>

</body>
</html>
