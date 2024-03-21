<?php
// Create a connection
$conn = new mysqli('localhost', 'root', '1506', 'knk', '3307');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging: Output form data
    echo "<pre>";
    print_r($_POST);
    print_r($_FILES);
    echo "</pre>";

    // Check if all required form fields are set
    if (isset($_POST['name'], $_POST['description'], $_POST['price'], $_POST['category'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        // Check if image file is uploaded
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
            $image_tmp_name = $_FILES["image"]["tmp_name"];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if uploaded file is an image
            $check = getimagesize($image_tmp_name);
            if ($check !== false) {
                // Upload image
                if (move_uploaded_file($image_tmp_name, $target_file)) {
                    // Determine the table to insert data based on the category
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
                            echo "Invalid category";
                            exit;
                    }
                    

                    // Insert product into the database
                    $stmt = $conn->prepare("INSERT INTO $table (name, description, price, image_url) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssds", $name, $description, $price, $target_file);
                    $stmt->execute();

                    // Check if the product was inserted successfully
                    if ($stmt->affected_rows > 0) {
                        echo "Product added successfully";
                    } else {
                        echo "Error adding product: " . $conn->error;
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "File is not an image.";
            }
        } else {
            echo "No image uploaded.";
        }
    } else {
        echo "Missing form fields.";
    }

    // Close the statement if it was created
    if (isset($stmt)) {
        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>
