<?php
// Start session
session_start();

// Check if staff is logged in
if(!isset($_SESSION["staffID"])){
  header("Location: staffLogin.php");
  exit();
}

// Get the staffID and staffName from the session variables
$staffID = $_SESSION["staffID"];
$staffName = $_SESSION["staffName"];

// Include the database connection file
include_once "database.php";

// Retrieve all requests with the same staffID from the requests table
$sql = "SELECT requests.requestID, requests.title, requests.description, studentDetails.studentName FROM requests 
INNER JOIN studentDetails ON requests.fromStudent = studentDetails.studentID 
WHERE requests.toStaff = $staffID
ORDER BY requests.requestID DESC";
$result = mysqli_query($conn, $sql);

// Check if query was successful
if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="dbStaff.css">
  <title>Staff Dashboard</title>
</head>
<body>
  <h1>Welcome <?php echo $staffName; ?></h1>




  <!-- Display requests -->
  <h2>Requests</h2>
  <table>
    <tr>
      <th>Title</th>
      <th>Description</th>
      <th>From Student</th>
      <th>Action</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
      <td><?php echo $row['title']; ?></td>
      <td><?php echo $row['description']; ?></td>
      <td><?php echo $row['studentName']; ?></td>
      <td><a href="respond.php?id=<?php echo $row['requestID']; ?>">Respond</a></td>
    </tr>
    <?php endwhile; ?>
  </table>


    <!-- Add logout button -->
    <form method="post" action="staffLogout.php">
    <input type="submit" name="logout" value="Logout" class="lbtn">
  </form>

</body>
</html>
