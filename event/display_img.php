<?php
// Retrieve image data from database
$sql = "SELECT image_data, image_name FROM img WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $imageId);
$imageId = 1; // Change this to the appropriate image ID
$stmt->execute();
$image = $stmt->fetch(PDO::FETCH_ASSOC);

if ($image) {
    $imageData = $image["image_data"];
    $imageName = $image["image_name"];
    
    // Display the image
    header("Content-type: image/jpeg"); // Adjust content-type based on the image type
    echo $imageData;
} else {
    echo "Image not found.";
}
?>
