<?php
include("connection.php");

$errors = array();
$proceedToNextField = true; // Flag to indicate whether to proceed to the next field

$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';
$privacyPolicy = isset($_POST['privacyPolicy']) ? $_POST['privacyPolicy'] : '';

if (isset($_POST['submit'])) {
    // Clear previous errors
    $errors = array();

    // Server-side validation
    if (empty($name)){
        $errors['name'] = 'Please enter your name';
        $proceedToNextField = false; // Don't proceed to the next field if there's an error
    }

    if ($proceedToNextField && (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))) {
        $errors['email'] = 'Please enter a valid email';
        $proceedToNextField = false;
    }

    if ($proceedToNextField && empty($password)) {
        $errors['password'] = 'Please enter a password';
        $proceedToNextField = false;
    } elseif ($proceedToNextField && strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long';
        $proceedToNextField = false;
    } elseif ($proceedToNextField && !preg_match('/[A-Z]/', $password)) {
        $errors['password'] = 'Password must contain at least one uppercase letter';
        $proceedToNextField = false;
    } elseif ($proceedToNextField && !preg_match('/[0-9]/', $password)) {
        $errors['password'] = 'Password must contain at least one numeric digit';
        $proceedToNextField = false;
    } elseif ($proceedToNextField && !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $errors['password'] = 'Password must contain at least one special character';
        $proceedToNextField = false;
    }

    if ($proceedToNextField && ($password !== $confirmPassword)) {
        $errors['confirmPassword'] = 'Passwords do not match';
        $proceedToNextField = false;
    }

    if ($proceedToNextField && empty($privacyPolicy)) {
        $errors['privacyPolicy'] = 'Please agree to the privacy policy';
        $proceedToNextField = false;
    }

    // Check if name or email already exists
    if ($proceedToNextField) {
        $existingQuery = "SELECT * FROM signup WHERE name='$name' OR email='$email'";
        $existingResult = mysqli_query($conn, $existingQuery);
        if (mysqli_num_rows($existingResult) > 0) {
            $errors['existing'] = 'Name or email already exists';
            echo "<script>alert('Name or email already exists');</script>";
        } else {
            // If there are no validation errors and no existing records
            // Proceed with database insertion
            $username = mysqli_real_escape_string($conn, $name);
            $email = mysqli_real_escape_string($conn, $email);
            $password = mysqli_real_escape_string($conn, $password);

            // Insert new record into the database
            $insertQuery = "INSERT INTO signup (name, email, password) VALUES ('$username', '$email', '$password')";
            $insertResult = mysqli_query($conn, $insertQuery);

            if ($insertResult) {
                // Values inserted successfully
                echo "<script>alert('Signup successful!');</script>";
                // Clear form values after successful signup
                $name = '';
                $email = '';
                $password = '';
                $confirmPassword = '';
            } else {
                // Error in insertion
                $errors['serverError'] = 'Error: ' . mysqli_error($conn);
            }
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
  
    <title>Signup</title>
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
            <h2>Sign Up</h2>
            <form method="post" novalidate>

                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="name" name="name" required placeholder="Name" value="<?php echo htmlspecialchars($name); ?>">
                </div>
                <?php if(isset($errors['name'])) { echo '<div class="error-message">' . $errors['name'] . '</div>'; } ?>

                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" required placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
                </div>
                <?php if(isset($errors['email'])) { echo '<div class="error-message">' . $errors['email'] . '</div>'; } ?>

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required placeholder="Password" value="<?php echo htmlspecialchars($password); ?>">
                </div>
                <?php if(isset($errors['password'])) { echo '<div class="error-message">' . $errors['password'] . '</div>'; } ?>

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Confirm Password" value="<?php echo htmlspecialchars($confirmPassword); ?>">
                </div>
                <?php if(isset($errors['confirmPassword'])) { echo '<div class="error-message">' . $errors['confirmPassword'] . '</div>'; } ?>

                <div class="checkbox-container">
                    <input type="checkbox" id="privacyPolicy" name="privacyPolicy" required value="1">
                    <label for="privacyPolicy">I agree to the privacy policy</label>
                </div>
                <?php if(isset($errors['privacyPolicy'])) { echo '<div class="error-message">' . $errors['privacyPolicy'] . '</div>'; } ?>

                <button type="submit" name="submit">Sign Up</button>
            </form>
            <p>Already have an account? <a href="login.php">Log In</a></p>
            <p>or</p>
            <div id="google"><i class="fab fa-google"></i></div>
        </div>
    </div>   
</body>
</html>
