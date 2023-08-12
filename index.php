<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MarketLink - Your Online Marketplace</title>
    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">

    <style>
        .additional-info {
            display: none;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">MarketLink</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php if(isset($_GET['category'])) echo 'active'; ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item <?php if(empty($_GET['category'])) echo 'active'; ?>" href="product_listing.php">All Categories</a></li>
                            <li><a class="dropdown-item <?php if(isset($_GET['category']) && $_GET['category'] === 'properties') echo 'active'; ?>" href="product_listing.php?category=properties">Properties</a></li>
                            <li><a class="dropdown-item <?php if(isset($_GET['category']) && $_GET['category'] === 'electronics') echo 'active'; ?>" href="product_listing.php?category=electronics">Electronics</a></li>
                            <li><a class="dropdown-item <?php if(isset($_GET['category']) && $_GET['category'] === 'vehicles') echo 'active'; ?>" href="product_listing.php?category=vehicles">Vehicles</a></li>
                            <li><a class="dropdown-item <?php if(isset($_GET['category']) && $_GET['category'] === 'fashion') echo 'active'; ?>" href="product_listing.php?category=fashion">Fashion</a></li>
                            <li><a class="dropdown-item <?php if(isset($_GET['category']) && $_GET['category'] === 'others') echo 'active'; ?>" href="product_listing.php?category=others">Others</a></li>
                        </ul>

                    </li>
                </ul>

                <form class="d-flex" action="product_listing.php" method="GET">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search for Anything" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="welcome-section">
        <h1>Welcome to MarketLink</h1>

        <!-- Creating form for uploading goods/services -->
        <div class="post-form">
            <h2 onclick="toggleForm()">Post your product or services for free</h2>

            <form id="postForm" style="display: none;" action="insert.php" method="POST" enctype="multipart/form-data">
                <label for="category">Category:</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">Select Category</option>
                    <option value="properties">Properties</option>
                    <option value="electronics">Electronics</option>
                    <option value="vehicles">Vehicles</option>
                    <option value="fashion">Fashion</option>
                    <option value="others">Others</option>
                </select><br><br>

                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required><br><br>

                <label for="description">Description:</label><br>
                <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" required><br><br>

                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" required><br><br>

                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required><br><br>

                <input type="submit" value="Submit">
            </form>
        </div>
    </div>

    <div class="Product-Listings">
        <h1>Product Listings</h1>

        <div class="container">
            <div class="row product-container">
                <?php require_once('fetch.php'); ?>
            </div>
        </div>
    </div>

    <!-- Link to Bootstrap JS (jQuery dependency required) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleForm() {
            var form = document.getElementById("postForm");
            form.style.display = (form.style.display === "none") ? "block" : "none";
        }

        function showAdditionalInfo(button) {
            var productCard = button.closest('.product-card');
            var additionalInfo = productCard.querySelector('.additional-info');
            additionalInfo.style.display = (additionalInfo.style.display === 'block') ? 'none' : 'block';
        }
    </script>

</body>

</html>
