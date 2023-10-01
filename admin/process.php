<?php
include('../db.php');

// Handle image upload
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $projectStatus = $_POST["projectStatus"];

    // Check if a file was uploaded
    if ($_FILES["image"]["error"] === 0) {
        $targetDirectory = "projects/"; // Change this to your desired directory path
        $targetFileName = $targetDirectory . basename($_FILES["image"]["name"]);

        // Check file type
        $imageFileType = strtolower(pathinfo($targetFileName, PATHINFO_EXTENSION));
        if ($imageFileType !== "jpg" && $imageFileType !== "jpeg" && $imageFileType !== "png" && $imageFileType !== "gif") {
            echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
        } else {
            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFileName)) {
                // Insert image information into the database
                $sql = "INSERT INTO projects (title, type, photo) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $title, $projectStatus, $targetFileName);

                if ($stmt->execute()) {
                    echo '<script>';
                    echo 'alert("Image uploaded and information saved successfully.");';
                    echo 'window.location.href = "addp.php";';
                    echo '</script>';
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Error uploading the file.";
            }
        }
    } else {
        echo "Error: " . $_FILES["image"]["error"];
    }
}

// Close the database connection
$conn->close();
?>
