<?php
include("connection.php");
$dsn = 'mysql:host=localhost;dbname=your_database_name';
$username = 'your_username';
$password = 'your_password';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $imageData = file_get_contents($_FILES["image"]["tmp_name"]);
    $imageName = $_FILES["image"]["name"];
    
    // Insert image data into database
    $sql = "INSERT INTO img (image_data, image_name) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $imageData, PDO::PARAM_LOB);
    $stmt->bindParam(2, $imageName);
    $stmt->execute();
}
?>
<form action="img.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="image" id="image">
    <input type="submit" value="Upload Image" name="submit">
</form>
