<?php
require_once('db_connect.php');

function displayProducts($category)
{
    global $conn;

    // Prepare the SQL query
    $sql = "SELECT * FROM users";

    // Add category filter if a category is provided
    if (!empty($category)) {
        $category = $conn->real_escape_string($category); // Sanitize the category to prevent SQL injection
        $sql .= " WHERE Category = '$category'";
    }

    // Fetch data from the database
    $result = $conn->query($sql);

    // Check if any records were returned
    if ($result->num_rows > 0) {
        // Start displaying the data
        echo '<div class="row product-container">';
        while ($row = $result->fetch_assoc()) {
            // Access the individual fields of each row
            $title = $row["Title"];
            $image = $row["Image"];

            // Resize the image to a specific width and height
            $resizedImage = 'uploads/resized_' . $image; // Set the path for the resized image
            $desiredWidth = 200; // Desired width of the resized image
            $desiredHeight = 200; // Desired height of the resized image

            list($originalWidth, $originalHeight, $imageType) = getimagesize("uploads/" . basename($image));

            // Create the appropriate image resource based on the image type
            $sourceImage = createImageResource($imageType, "uploads/$image");
            if (!$sourceImage) {
                // Unsupported image type
                continue; // Skip to the next iteration of the loop
            }

            // Calculate the new dimensions while preserving the aspect ratio
            $aspectRatio = $originalWidth / $originalHeight;
            if ($originalWidth > $desiredWidth || $originalHeight > $desiredHeight) {
                if ($desiredWidth / $desiredHeight > $aspectRatio) {
                    $newWidth = $desiredHeight * $aspectRatio;
                    $newHeight = $desiredHeight;
                } else {
                    $newWidth = $desiredWidth;
                    $newHeight = $desiredWidth / $aspectRatio;
                }
            } else {
                $newWidth = $originalWidth;
                $newHeight = $originalHeight;
            }

            // Create the resized image resource
            $resizedImageResource = imagecreatetruecolor($desiredWidth, $desiredHeight);
            imagecopyresampled($resizedImageResource, $sourceImage, 0, 0, 0, 0, $desiredWidth, $desiredHeight, $originalWidth, $originalHeight);

            // Save the resized image
            saveImage($imageType, $resizedImageResource, $resizedImage);
            imagedestroy($resizedImageResource);

            // Display the product card
            echo '<div class="col-md-4">';
            echo '<div class="product-card">';
            echo "<img src='$resizedImage' alt='Product Image' width='$desiredWidth' height='$desiredHeight'>";
            echo "<h2>$title</h2>";
            echo "<button class='btn btn-primary' onclick='showAdditionalInfo(this)'>Shop Now</button>";
            echo '<div class="additional-info" style="display: none;">';
            echo "<p>Category: {$row['Category']}</p>";
            echo "<p>Description: {$row['Description']}</p>";
            echo "<p>Price: {$row['Price']}</p>";
            echo "<p>Phone: {$row['Phone']}</p>";
            echo '</div>'; // Close additional-info
            echo '</div>'; // Close product-card
            echo '</div>'; // Close col-md-4
        }
        echo '</div>'; // Close row product-container
    } else {
        echo "No records found.";
    }
}

// Function to create the appropriate image resource based on the image type
function createImageResource($imageType, $imagePath)
{
    $absoluteImagePath = dirname(__FILE__) . '/' . str_replace('uploads/', '', dirname($imagePath)) . '/' . basename($imagePath);

    switch ($imageType) {
        case IMAGETYPE_JPEG:
            return imagecreatefromjpeg($absoluteImagePath);
        case IMAGETYPE_PNG:
            return imagecreatefrompng($absoluteImagePath);
        case IMAGETYPE_GIF:
            return imagecreatefromgif($absoluteImagePath);
        default:
            return false;
    }
}

// Function to save the resized image based on the image type
function saveImage($imageType, $imageResource, $imagePath)
{
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            imagejpeg($imageResource, $imagePath);
            break;
        case IMAGETYPE_PNG:
            imagepng($imageResource, $imagePath);
            break;
        case IMAGETYPE_GIF:
            imagegif($imageResource, $imagePath);
            break;
    }
}

// Get the category from the query string
$category = isset($_GET['category']) ? $_GET['category'] : "";

// Call the displayProducts() function with the category
displayProducts($category);

$conn->close();
?>
