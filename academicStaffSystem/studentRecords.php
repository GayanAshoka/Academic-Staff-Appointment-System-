<?php
// Start session
session_start();

// Check if student is logged in
if(!isset($_SESSION["studentID"])){
  header("Location: studentLogin.php");
  exit();
}

// Retrieve student ID from session variable
$studentID = $_SESSION["studentID"];

// Include the database connection file
include_once "database.php";

// Retrieve student and staff details from database
$sql = "SELECT studentDetails.studentname, staffDetails.staffName, timeTable.dateTimeStart, timeTable.dateTimeEnd, requests.title, requests.description, requests.requestStatus, requests.response 
FROM requests
INNER JOIN studentDetails ON requests.fromStudent = studentDetails.studentID
INNER JOIN staffDetails ON requests.toStaff = staffDetails.staffID
INNER JOIN timeTable ON requests.timeTableID = timeTable.timeTableID
WHERE requests.fromStudent = $studentID";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Student Dashboard</title>
</head>
<body>
  <h1>Student Records</h1>
  <table>
    <tr>
      <th>Student Name</th>
      <th>Staff Name</th>
      <th>Date/Time Start</th>
      <th>Date/Time End</th>
      <th>Title</th>
      <th>Description</th>
      <th>Status</th>
      <th>Response</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
      <td><?php echo $row["studentname"]; ?></td>
      <td><?php echo $row["staffName"]; ?></td>
      <td><?php echo $row["dateTimeStart"]; ?></td>
      <td><?php echo $row["dateTimeEnd"]; ?></td>
      <td><?php echo $row["title"]; ?></td>
      <td><?php echo $row["description"]; ?></td>
      <td><?php echo $row["requestStatus"]; ?></td>
      <td><?php echo $row["response"]; ?></td>
    </tr>
    <?php endwhile; ?>
  </table>

  <br>
  <a href="studentDashboard.php">Back to Dashboard</a>

</body>
</html>
