<?php
require_once('db_connect.php');

function displayProducts($searchTerm, $category)
{
    global $conn;

    // Prepare the search query
    $searchTerm = $conn->real_escape_string($searchTerm); // Sanitize the search term to prevent SQL injection

    $sql = "SELECT * FROM users";

    // Add search term filter if a search term is provided
    if (!empty($searchTerm)) {
        $sql .= " WHERE Title LIKE '%$searchTerm%'";
    }

    // Add category filter if a category is selected
    if (!empty($category)) {
        $category = $conn->real_escape_string($category); // Sanitize the category to prevent SQL injection

        if (strpos($sql, 'WHERE') !== false) {
            $sql .= " AND Category = '$category'";
        } else {
            $sql .= " WHERE Category = '$category'";
        }
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

            // Display the product card
            echo '<div class="col-md-4">';
            echo '<div class="product-card">';
            echo "<h2>$title</h2>";
            echo "<img src='uploads/resized_$image' alt='Product Image'>";
            echo '</div>'; // Close product-card
            echo '</div>'; // Close col-md-4
        }
        echo '</div>'; // Close row product-container
    } else {
        echo "No records found.";
    }
}

// Check if a search term or category is provided
if (isset($_GET['search']) || isset($_GET['category'])) {
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : "";
    $category = isset($_GET['category']) ? $_GET['category'] : "";

    // Call the displayProducts() function with the search term and category
    displayProducts($searchTerm, $category);
} else {
    echo "No search term or category provided.";
}

$conn->close();
?>
