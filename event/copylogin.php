<?php
include("connection.php");

$errors = array();

if (isset($_POST['login'])) {
    // Clear previous errors
    $errors = array();

    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Server-side validation
    if (empty($email)) {
        $errors['email'] = 'Please enter your email';
    }

    if (empty($password)) {
        $errors['password'] = 'Please enter your password';
    }

    if (empty($errors)) {
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);

        $query = "SELECT * FROM signup WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            // Login successful
            session_start();
            $_SESSION['email'] = $email;
            header("Location:main.html"); // Redirect to the welcome page
            exit();
        } else {
            // Login failed
            $errors['login'] = 'Invalid email or password';
            echo "<script>alert('Invalid email or password');</script>";
        }
    } else {
        // Display first error message if any
        $firstError = reset($errors);
        echo "<script>alert('$firstError');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>

<body>
    <div class="ripple-background">
        <div class="circle small shade1"></div>
        <div class="circle medium shade2"></div>
        <div class="circle large shade3"></div>
        <div class="circle xlarge shade4"></div>
        <div class="circle xxlarge shade5"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <h2>Sign In</h2>
            <form method="post" novalidate>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" required placeholder="Email">
                </div>
                <?php if(isset($errors['email'])) { echo '<div class="error-message">' . $errors['email'] . '</div>'; } ?>

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required placeholder="Password">
                </div>
                <?php if(isset($errors['password'])) { echo '<div class="error-message">' . $errors['password'] . '</div>'; } ?>

                <button type="submit" name="login">Login</button>
            </form>
            <p>New user? <a href="signup.php">Sign Up</a></p>
            <p>or</p>
            <div id="google"><i class="fab fa-google"></i></div>
        </div>
    </div>
</body>

</html>
