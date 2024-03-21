<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        /* CSS styles for product cards */
        .product {
            display: inline-block;
            width: 200px; /* Adjust as needed */
            margin: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .product__photo {
            height: 200px; /* Adjust as needed */
            overflow: hidden;
            border-bottom: 1px solid #ddd;
            position: relative;
        }

        .product__photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product:hover .product__photo img {
            transform: scale(1.1);
        }

        .product__info {
            padding: 10px;
        }

        .product__info h1 {
            font-size: 16px;
            margin: 0;
        }

        .product__info span {
            font-size: 14px;
            color: #888;
        }

        .product__info .price {
            font-size: 18px;
            color: #ff3f40; /* Adjust as needed */
            font-weight: bold;
        }

        .buy--btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #ff3f40; /* Adjust as needed */
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .buy--btn:hover {
            background-color: #e62124; /* Adjust as needed */
        }
    </style>
</head>
<body>
    <?php
    // Connect to the database
    $conn = new mysqli('localhost', 'root', '1506', 'knk', '3307');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch products based on the selected category
    if (isset($_GET['category'])) {
        $category = $_GET['category'];
        switch ($category) {
            case '1':
                $table = "men";
                break;
            case '2':
                $table = "women";
                break;
            case '3':
                $table = "kids";
                break;
            default:
                die("Invalid category");
        }

        $sql = "SELECT * FROM $table";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output products using while loop
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<div class='product__photo'>";
                echo "<img src='" . $row['image_url'] . "' alt='" . $row['name'] . "'>";
                echo "</div>";
                echo "<div class='product__info'>";
                echo "<h1>" . $row['name'] . "</h1>";
                if (!empty($row['product_code'])) {
                    echo "<span>COD: " . $row['product_code'] . "</span>";
                }
                
                echo "<div class='price'>R$ " . $row['price'] . "</div>";
                echo "<button class='buy--btn'>ADD TO CART</button>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "No products found";
        }

        // Free result set
        $result->free();
    }

    // Close the connection
    $conn->close();
    ?>
</body>
</html>
