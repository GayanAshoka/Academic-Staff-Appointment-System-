<?php
// Start session
session_start();

// Check if student is logged in
if(!isset($_SESSION["studentID"])){
  header("Location: studentLogin.php");
  exit();
}

// Include the database connection file
include_once "database.php";

// Retrieve the request data from the form
$title = $_POST["title"];
$description = $_POST["description"];
$fromStudent = $_POST["fromStudent"];
$toStaff = $_POST["toStaff"];
$requestStatus = $_POST["requestStatus"];

// Prepare the SQL statement to insert the request into the requests table
$sql = "INSERT INTO requests (title, description, fromStudent, toStaff, requestStatus) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssiii", $title, $description, $fromStudent, $toStaff, $requestStatus);

// Execute the statement and check if it was successful
if(mysqli_stmt_execute($stmt)){
  // Redirect the user back to the dashboard with a success message
  $_SESSION["successMessage"] = "Your request has been submitted successfully!";
  header("Location: dashboardStudent.php");
  exit();
} else {
  // Redirect the user back to the dashboard with an error message
  $_SESSION["errorMessage"] = "Failed to submit request. Please try again later.";
  header("Location: dashboardStudent.php");
  exit();
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
