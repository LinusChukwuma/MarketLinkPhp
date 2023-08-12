<?php
require_once('db_connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $category = $_POST["category"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $phone = $_POST["phone"];

    // Process the uploaded image, assuming the file input name is "image"
    $image = $_FILES["image"]["name"]; // Get the image file name
    $image_tmp = $_FILES["image"]["tmp_name"]; // Get the temporary location of the image

    // Move the uploaded image to the desired directory
    $target_dir = "uploads/"; // Specify the target directory to store the uploaded images
    $target_file = $target_dir . basename($image); // Set the destination path for the image
    $destination = dirname(__FILE__) . '/' . $target_file; // Get the full path to the destination file

    // Create the target directory if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create the directory with write permissions (0777)
    }

    // Move the uploaded file to the destination
    if (move_uploaded_file($image_tmp, $destination)) {
        // Prepare the SQL statement to insert the form data
        $sql = "INSERT INTO users (category, title, description, price, phone, image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Check for errors in prepare()
        if (!$stmt) {
            echo "Error: " . $conn->error; // Display the specific error message
            exit;
        }

        // Bind the values to the prepared statement
        $stmt->bind_param("ssssss", $category, $title, $description, $price, $phone, $target_file);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to the home page after successful submission
            header("Location: index.php");
            exit();
        } else {
            echo "Failed to insert form data.";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Failed to move the uploaded file.";
    }
}

// Close the database connection
$conn->close();
?>
