<?php
// Start session
session_start();

// Check if staff is already logged in
if(isset($_SESSION["staffID"])){
  header("Location: dashboardStaff.php");
  exit();
}

// Check if the login form has been submitted
if(isset($_POST["submit"])){

  // Include the database connection file
  include_once "database.php";

  // Get the username and password from the form
  $staffName = $_POST["staffName"];
  $staffPassword = $_POST["staffPassword"];

  // Prepare the query to fetch the staff details based on the provided staffName and staffPassword
  $query = "SELECT staffID, staffName FROM staffDetails WHERE staffName=? AND staffPassword=?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ss", $staffName, $staffPassword);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if the staff details exist in the database
  if($result->num_rows == 1){
    // Staff details are correct, set session variables and redirect to dashboard
    $row = $result->fetch_assoc();
    $_SESSION["staffID"] = $row["staffID"];
    $_SESSION["staffName"] = $row["staffName"];
    header("Location: dashboardStaff.php");
    exit();
  } else {
    // Staff details are incorrect, display error message
    $errorMessage = "Invalid staff name or password.";
  }

  // Close the database connection
  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Staff Login</title>
</head>
<body>
  <h1>Staff Login</h1>
  <form method="post" action="">
    <label for="staffName">Staff Name:</label>
    <input type="text" name="staffName" required>
    <br><br>
    <label for="staffPassword">Password:</label>
    <input type="password" name="staffPassword" required>
    <br><br>
    <input type="submit" name="submit" value="Login">
  </form>

  <?php
  // Display error message if there is one
  if(isset($errorMessage)){
    echo "<p style='color:red;'>$errorMessage</p>";
  }
  ?>

</body>
</html>
