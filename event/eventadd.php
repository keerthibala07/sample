<?php
include("connection.php");

$errors = array();

if (isset($_POST['submit'])) {
    // Clear previous errors
    $errors = array();

    // Validate Event Name
    $name = isset($_POST['eventName']) ? $_POST['eventName'] : '';
    if (empty($name)) {
        $errors['eventName'] = 'Please enter Event name';
    }

    // Validate Event Description
    $desc = isset($_POST['eventDescription']) ? $_POST['eventDescription'] : '';
    if (empty($desc)) {
        $errors['eventDescription'] = 'Please enter Event description';
    }

   // Validate Event Poster
$poster = isset($_FILES['eventposter']['name']) ? $_FILES['eventposter']['name'] : '';
if (empty($poster)) {
    $errors['eventposter'] = 'Please upload Event poster';
}

// Check for file upload errors
if ($_FILES['eventposter']['error'] !== UPLOAD_ERR_OK) {
    $errors['eventposter'] = 'File upload error: ' . $_FILES['eventposter']['error'];
}

// Specify the target directory and move the uploaded file
$targetDirectory = "uploads/";

// Check if the directory exists, and create it if it doesn't
if (!is_dir($targetDirectory)) {
    mkdir($targetDirectory, 0755, true); // Create directory with permissions
}

$targetFile = $targetDirectory . basename($_FILES["eventposter"]["name"]);

if (move_uploaded_file($_FILES["eventposter"]["tmp_name"], $targetFile)) {
    echo "The file " . htmlspecialchars(basename($_FILES["eventposter"]["name"])) . " has been uploaded.";
} else {
    $errors['eventposter'] = "Sorry, there was an error uploading your file.";
}


    // Validate Start Date
    $startdate = isset($_POST['eventDate']) ? $_POST['eventDate'] : '';
    if (empty($startdate)) {
        $errors['eventDate'] = 'Please enter Start Date';
    }

    // Validate Start Time
    $starttime = isset($_POST['eventtime']) ? $_POST['eventtime'] : '';
    if (empty($starttime)) {
        $errors['eventtime'] = 'Please enter Start Time';
    }

    // Validate End Date
    $enddate = isset($_POST['endDate']) ? $_POST['endDate'] : '';
    if (empty($enddate)) {
        $errors['endDate'] = 'Please enter End Date';
    }

    // Validate End Time
    $endtime = isset($_POST['endTime']) ? $_POST['endTime'] : '';
    if (empty($endtime)) {
        $errors['endTime'] = 'Please enter End Time';
    }

    // Validate Registration Close Date
    $registration = isset($_POST['registrationCloseDate']) ? $_POST['registrationCloseDate'] : '';
    if (empty($registration)) {
        $errors['registrationCloseDate'] = 'Please enter Registration Close Date';
    }

    // Validate Person 1 Name
    $np1 = isset($_POST['n1']) ? $_POST['n1'] : '';
    if (empty($np1)) {
        $errors['n1'] = 'Please enter Name (person-1)';
    }

    // Validate Person 1 Contact Number
    $cp1 = isset($_POST['cn1']) ? $_POST['cn1'] : '';
    if (empty($cp1)) {
        $errors['cn1'] = 'Please enter Contact.no (person-1)';
    }

    // Validate Person 2 Name
    $np2 = isset($_POST['n2']) ? $_POST['n2'] : '';
    if (empty($np2)) {
        $errors['n2'] = 'Please enter Name (person-2)';
    }

    // Validate Person 2 Contact Number
    $cp2 = isset($_POST['cn2']) ? $_POST['cn2'] : '';
    if (empty($cp2)) {
        $errors['cn2'] = 'Please enter Contact.no (person-2)';
    }

    // If there are no errors, insert data into the database
    if (empty($errors)) {
        // Insert data into the database
        $sql = "INSERT INTO your_table_name (eventName, eventDescription, eventposter, eventDate, eventtime, endDate, endTime, registrationCloseDate, n1, cn1, n2, cn2) 
                VALUES ('$name', '$desc', '$poster', '$startdate', '$starttime', '$enddate', '$endtime', '$registration', '$np1', '$cp1', '$np2', '$cp2')";

        if (mysqli_query($conn, $sql)) {
            echo "New record inserted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
    <link rel="stylesheet" href="eventadd.css">
    <title>Your Website</title>
</head>

<body>
    <header>
        <span><img src="event_logo.png" alt="Event Logo"></span>
    </header>
    <button class="small-button"><i class="fas fa-arrow-left"></i></button>

    <div id="card">
        <div id="event-container">
            <p>Add Event</p>
        </div>

        <form id="event-form" class="form-container" onsubmit="return validateEventForm()" novalidate method="post" enctype="multipart/form-data">

            <label for="eventName">Event Name:</label>
            <input type="text" id="eventName" name="eventName" required oninput="removeError('eventName')" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
            <small id="eventNameError" class="error-message"><?php echo isset($errors['eventName']) ? $errors['eventName'] : ''; ?></small>

            <label for="eventDescription">Event Description:</label>
            <textarea id="eventDescription" name="eventDescription" rows="4" required><?php echo isset($desc) ? htmlspecialchars($desc) : ''; ?></textarea>
            <small id="eventDescriptionError" class="error-message"><?php echo isset($errors['eventDescription']) ? $errors['eventDescription'] : ''; ?></small>

            <label for="eventposter">Event Poster:</label>
            <div class="file-upload-container">
                <label for="eventposter" class="file-input-label" id="fileInputLabel">Upload Event Poster</label>
                <input type="file" id="eventposter" name="eventposter" accept="image/*" onchange="validateAndDisplayChosenImageName()">
            </div>
            <span id="selectedFileName"></span>
            <small id="fileSizeError" class="error-message"><?php echo isset($errors['eventposter']) ? $errors['eventposter'] : ''; ?></small>

            <label for="eventDate">Start Date:</label>
            <input type="date" id="eventDate" name="eventDate" required value="<?php echo isset($startdate) ? htmlspecialchars($startdate) : ''; ?>">
            <small id="eventDateError" class="error-message"><?php echo isset($errors['eventDate']) ? $errors['eventDate'] : ''; ?></small>

            <label for="eventtime">Start Time:</label>
            <input type="time" id="eventtime" name="eventtime" required value="<?php echo isset($starttime) ? htmlspecialchars($starttime) : ''; ?>">
            <small id="eventTimeError" class="error-message"><?php echo isset($errors['eventtime']) ? $errors['eventtime'] : ''; ?></small>

            <label for="endDate">End Date:</label>
            <input type="date" id="endDate" name="endDate" required value="<?php echo isset($enddate) ? htmlspecialchars($enddate) : ''; ?>">
            <small id="endDateError" class="error-message"><?php echo isset($errors['endDate']) ? $errors['endDate'] : ''; ?></small>

            <label for="endTime">End Time:</label>
            <input type="time" id="endTime" name="endTime" required value="<?php echo isset($endtime) ? htmlspecialchars($endtime) : ''; ?>">
            <small id="endTimeError" class="error-message"><?php echo isset($errors['endTime']) ? $errors['endTime'] : ''; ?></small>

            <label for="registrationCloseDate">Registration Closes at:</label>
            <input type="date" id="registrationCloseDate" name="registrationCloseDate" required value="<?php echo isset($registration) ? htmlspecialchars($registration) : ''; ?>">
            <small id="registrationCloseDateError" class="error-message"><?php echo isset($errors['registrationCloseDate']) ? $errors['registrationCloseDate'] : ''; ?></small>

            <label for="n1">Name (person-1):</label>
            <input type="text" id="n1" name="n1" required value="<?php echo isset($np1) ? htmlspecialchars($np1) : ''; ?>">
            <small id="n1Error" class="error-message"><?php echo isset($errors['n1']) ? $errors['n1'] : ''; ?></small>

            <label for="cn1">Contact.no (person-1):</label>
            <input type="text" id="cn1" name="cn1" required value="<?php echo isset($cp1) ? htmlspecialchars($cp1) : ''; ?>">
            <small id="cn1Error" class="error-message"><?php echo isset($errors['cn1']) ? $errors['cn1'] : ''; ?></small>

            <label for="n2">Name (person-2):</label>
            <input type="text" id="n2" name="n2" required value="<?php echo isset($np2) ? htmlspecialchars($np2) : ''; ?>">
            <small id="n2Error" class="error-message"><?php echo isset($errors['n2']) ? $errors['n2'] : ''; ?></small>

            <label for="cn2">Contact.no (person-2):</label>
            <input type="text" id="cn2" name="cn2" required value="<?php echo isset($cp2) ? htmlspecialchars($cp2) : ''; ?>">
            <small id="cn2Error" class="error-message"><?php echo isset($errors['cn2']) ? $errors['cn2'] : ''; ?></small>

            <div class="add-list-container">
                <h2 style="font-weight: normal;">Add List of Events</h2>
                <div id="eventsContainer"></div>
                <div class="button-container">
                    <button type="button" class="custom-button" onclick="addEventFields()">Add Event</button>
                    <button type="button" class="custom-button2" onclick="removeEventFields()">Remove Event</button>
                </div>
            </div>

            <button type="submit" name="submit" class="submit-button">Submit</button>
        </form>
    </div>

    <footer>
        <p>Developed by Logitech Group</p>
        <p id="foot">Your ultimate event management group</p>
    </footer>

    <script src="script.js"></script>
</body>

</html>
