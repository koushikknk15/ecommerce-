<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '1506', 'knk', '3307');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Prepare SQL statement to fetch user data by email
    $sql = "SELECT * FROM signup WHERE gmail='$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        // User found, verify password
        $row = $result->fetch_assoc();
        $storedPassword = $row["password"]; // Plain text password
        
        if ($password === $storedPassword) {
            // Password is correct, login successful
            // Redirect to home.html
            header('Location: home.html');
            exit;
        } else {
            // Incorrect password
            echo "Login failed: Incorrect password";
        }
    } else {
        // User not found
        echo "Login failed: User not found";
    }
    
    $conn->close();
}
?>
