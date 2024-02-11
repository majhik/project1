<?php
include "db.php";
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $ConfirmPassword = $_POST["Confirm_password"];

    // Validate and sanitize inputs (you may want to add more robust validation)
    $firstName = mysqli_real_escape_string($conn, $firstName);
    $lastName = mysqli_real_escape_string($conn, $lastName);
    $email = mysqli_real_escape_string($conn, $email);

    // Perform password hashing for security
    $hashedPassword1 = password_hash($password, PASSWORD_DEFAULT);
    $hashedPassword2 = password_hash($Confirm_password, PASSWORD_DEFAULT);

    // Check if the email already exists in the database
    $checkQuery = "SELECT * FROM user WHERE email = '$email'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Email already exists, handle accordingly (redirect, show error, etc.)
        echo "Error: This email is already registered.";
    } else {
        // Insert user data into the database using prepared statement
        $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, email, password, Confirm_password) 
        VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $hashedPassword1, $hashedPassword2);

        if ($stmt->execute()) {
            // Registration successful
            echo "Registration successful!";
            $stmt->close();
            header('Location: ../code/signin.html');
            exit();
        } else {
            // Registration failed
            echo "Error: " . $stmt->error;
            $stmt->close();
        }
    }
}

// Close the database connection
$conn->close();
?>
