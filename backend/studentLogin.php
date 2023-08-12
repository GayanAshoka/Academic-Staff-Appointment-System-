<?php
// Start session
session_start();

// Check if student is already logged in
if(isset($_SESSION["studentID"])){
  header("Location: dashboardStudent.php");
  exit();
}

// Check if the login form has been submitted
if(isset($_POST["submit"])){

  // Include the database connection file
  include_once "database.php";

  // Get the username and password from the form
  $studentName = $_POST["studentName"];
  $studentPassword = $_POST["studentPassword"];

  // Prepare the query to fetch the student details based on the provided studentName and studentPassword
  $query = "SELECT studentID, studentname FROM studentDetails WHERE studentname=? AND studentPassword=?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ss", $studentName, $studentPassword);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if the student details exist in the database
  if($result->num_rows == 1){
    // Student details are correct, set session variables and redirect to dashboard
    $row = $result->fetch_assoc();
    $_SESSION["studentID"] = $row["studentID"];
    $_SESSION["studentName"] = $row["studentname"];
    header("Location: dashboardStudent.php");
    exit();
  } else {
    // Student details are incorrect, display error message
    $errorMessage = "Invalid student name or password.";
  }

  // Close the database connection
  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="studentLogin.css">
  <title>Student Login</title>
</head>
<body>
  <div class="tNBar">
    <h1 class="tUOV"><span>UOV</span> LOGIN</h1>
  </div>
  

  <h2>UOV Academic Staff Appointment<br>System</h2>



  <form method="post" action="">
    <div class="formIn">
      <div class="cDv">
      <h2>STUDENT LOGIN</h2>
      <div>
        
      <br>
        <div><label for="studentName">Student Name:</label></div>
        <div><input type="text" name="studentName" required></div>
        <br>
      </div>
      <div>
        <div><label for="studentPassword">Password:</label></div>
        <div><input type="password" name="studentPassword" required></div>
        <br>
      </div>
      <div>
        <input class="btns" type="submit" name="submit" value="Login">
      </div>
      </div>
    </div>

  </form>






  <?php
  // Display error message if there is one
  if(isset($errorMessage)){
    echo "<p style='color:red;'>$errorMessage</p>";
  }
  ?>

</body>
</html>
