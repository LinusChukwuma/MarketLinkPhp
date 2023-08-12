<?php
require_once('db_connect.php');

// Fetch categories from the database
$sql = "SELECT DISTINCT Category FROM users";
$result = $conn->query($sql);

// Display categories as dropdown options
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $category = $row['Category'];
        echo "<option value='$category'>$category</option>";
    }
}

$conn->close();
?>
