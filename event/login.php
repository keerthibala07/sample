<?php
include("connection.php");

$errors = array();
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (isset($_POST['login'])) {
    // Clear previous errors
    $errors = array();
   
    // Server-side validation for email
    if (empty($email)) {
        $errors['email'] = 'Please enter your email';
    }

    // Server-side validation for password
    if (empty($password)) {
        $errors['password'] = 'Please enter your password';
    }

    // Check if there are any errors
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
            echo "<script>alert('Invalid email or password');</script>";
            // Add the failed values back to the form
            $email = htmlspecialchars($email);
            $password = htmlspecialchars($password);
        }
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
            <form method="post" novalidate oninput="clearError()">
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" required placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
                </div>
                <div class="error-message" id="emailError"><?php if(isset($errors['email'])) { echo $errors['email']; } ?></div>

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required placeholder="Password" value="<?php echo htmlspecialchars($password); ?>">
                </div>
                <div class="error-message" id="passwordError"><?php if(isset($errors['password'])) { echo $errors['password']; } ?></div>

                <button type="submit" name="login">Login</button>
            </form>
            <p>New user? <a href="signup.php">Sign Up</a></p>
            <p>or</p>
            <div id="google"><i class="fab fa-google"></i></div>
        </div>
    </div>
    <script src="script.js"></script>
    
</body>

</html>
