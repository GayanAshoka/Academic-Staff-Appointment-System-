<?php
// Start session
session_start();

// Check if student is logged in
if(!isset($_SESSION["studentID"])){
  header("Location: studentLogin.php");
  exit();
}

// Retrieve student ID and name from session variables
$studentID = $_SESSION["studentID"];
$studentName = $_SESSION["studentName"];

// Include the database connection file
include_once "database.php";

// Retrieve staff member names and IDs from staffDetails table
$sql = "SELECT staffID, staffName FROM staffDetails";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="studentDB.css">
  <title>Student Dashboard</title>
</head>
<body>
  <h1>Welcome, <?php echo $studentName; ?>!</h1>
  
  <form action="createRequest.php" method="post" onsubmit="return validateForm()">
    <label for="title">Request Title:</label><br>
    <input type="text" id="title" name="title"><br><br>
    <label for="description">Request Description:</label><br>
    <textarea id="description" name="description"></textarea><br><br>
    <label for="toStaff">Select staff member:</label><br>
    <select id="toStaff" name="toStaff">
        <option value="" selected disabled>Select staff member</option>
      <?php while($row = mysqli_fetch_assoc($result)): ?>
        <option value="<?php echo $row['staffID']; ?>"><?php echo $row['staffName']; ?></option>
      <?php endwhile; ?>
    </select><br><br>
    <input type="hidden" name="fromStudent" value="<?php echo $studentID; ?>">
    <input type="hidden" name="requestStatus" value="0">
    <input type="submit" name="submit" value="Submit Request" class="sr">
  </form>
  


  <a href="studentRecords.php?id=<?php echo $studentID; ?>">records</a></td>

  <form action="studentLogout.php" method="post">
    <input type="submit" name="logout" value="Logout" class="logOut">
  </form>

<script>
  function validateForm() {
    var toStaff = document.getElementById("toStaff").value;
    if (toStaff == "") {
      alert("Please select a staff member.");
      return false;
    }
    return true;
  }
</script>

  
</body>
</html>

