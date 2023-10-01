<?php
// Include your database connection code here (e.g., db.php)

// Receptionist's details
$username = 'Admin';
$email = 'admin@gmail.com';
$mobile = '9515446080';
$password = 'demo@123'; // The plaintext password

// Hash the password securely
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Database insertion
try {
    // Establish a database connection
    include('db.php'); // Replace with your actual database connection code

 

    // SQL query to insert the data
    $sql = "INSERT INTO admin (name, email, phone, password) 
            VALUES (?, ?, ?, ?)";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("SQL statement preparation failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssss", $username, $email, $mobile, $hashed_password);



    // Execute the query
    if ($stmt->execute() === false) {
        die("Error executing the query: " . $stmt->error);
    }

    // Close the database connection
    $stmt->close();
    $conn->close();

    echo "Receptionist record inserted successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
