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

// Retrieve requests data for the current student, along with the corresponding staffName from staffDetails
$sql = "SELECT r.title, r.description, s.staffName, r.requestStatus, r.response, r.dateTimeStart, r.dateTimeEnd FROM requests r
        INNER JOIN staffDetails s ON r.toStaff = s.staffID
        WHERE r.fromStudent = $studentID";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="stRec.css">
  <title>Student Records</title>
</head>
<body>
  <h1>Your Requests</h1>
  <p>Welcome, <?php echo $studentName; ?>!</p>
  
  <table>
    <tr>
      <th>Title</th>
      <th>Description</th>
      <th>To Staff</th>
      <th>Status</th>
      <th>Response</th>
      <th>Date Time Start</th>
      <th>Date Time End</th>
    </tr>
    
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
      <td><?php echo $row['title']; ?></td>
      <td><?php echo $row['description']; ?></td>
      <td><?php echo $row['staffName']; ?></td>
      <td>
        <?php 
        if ($row['requestStatus']==1) {
          echo "Pending"; 
        }
        elseif ($row['requestStatus']==2) {
          echo "Accepted"; 
        }
        else {
          echo "Rejected"; 
        }
        
        
        ?>
      </td>
      <td><?php echo $row['response']; ?></td>
      <td><?php echo $row['dateTimeStart']; ?></td>
      <td><?php echo $row['dateTimeEnd']; ?></td>
    </tr>
    <?php endwhile; ?>
  </table>
  
  <a href="dashboardStudent.php">Go back to Dashboard</a>

</body>
</html>
