<?php

include "db.php";
session_start();
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate user input (You should add more robust validation)
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Perform your authentication logic here using prepared statements
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User found, check password
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Password is correct, authentication successful
                header("Location: ../code/project.html");
                exit();
            } else {
                // Invalid password
                echo "Invalid email or password. Please try again.";
            }
        } else {
            // User not found
            echo "Invalid email or password. Please try again.";
        }
        $stmt->close();
    } else {
        // Invalid email format
        echo "Invalid email format. Please enter a valid email.";
    }
}

// Close the database connection
$conn->close();
?>
