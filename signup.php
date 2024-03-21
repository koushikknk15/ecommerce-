<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $phone = $_POST["Phone"];

    // Validate and sanitize the input (not implemented in this example)

    // Perform database operations (insert user data into database)
    // Replace 'your_database_host', 'your_database_username', 'your_database_password', 'your_database_name' with your actual database credentials
    $conn = new mysqli('localhost', 'root', '1506', 'knk', 3307);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the INSERT statement
    $stmt = $conn->prepare("INSERT INTO signup (name, gmail, phno, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $password);

    // Execute the statement
    if ($stmt->execute()) {
        header('Location: home.html');
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
