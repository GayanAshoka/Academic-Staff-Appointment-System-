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

// Get the request ID from the URL parameter
$requestID = $_GET['id'];

// Retrieve the request information from the requests table
$sql = "SELECT requests.requestID, requests.title, requests.description, studentDetails.studentName,studentDetails.studentID FROM requests 
INNER JOIN studentDetails ON requests.fromStudent = studentDetails.studentID 
WHERE requests.requestID = $requestID";
$result = mysqli_query($conn, $sql);

// Check if the form has been submitted
if(isset($_POST['respond'])){
  // Get the request status and response message
  $requestStatus = $_POST['requestStatus'];
  $response = $_POST['response'];

  // Update the requests table
  $sql = "UPDATE requests SET requestStatus = $requestStatus, response = '$response' WHERE requestID = $requestID";
  $result = mysqli_query($conn, $sql);

  // Check if query was successful
  if (!$result) {
    die("Query failed: " . mysqli_error($conn));
  }

  // If the request is approved, insert a new appointment into the timeTable table
  if($requestStatus == 2){
    // Get the selected date and time range
    $selectedDate = $_POST['selectedDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    // Check if the selected time range overlaps with any existing appointments
    $sql = "SELECT * FROM timeTable WHERE toStaff = $staffID AND dateTimeStart BETWEEN '$selectedDate $startTime' AND '$selectedDate $endTime'";
    $result = mysqli_query($conn, $sql);

    // Check if query was successful
    if (!$result) {
      die("Query failed: " . mysqli_error($conn));
    }

    // If there is an overlap, display an error message and do not insert the new appointment
    if(mysqli_num_rows($result) > 0){
        // Display a warning message
        echo "<script>
        alert('Selected time range overlaps with an existing appointment. Please select a different time.');
        window.location.href = 'respond.php?id=$requestID';
    </script>";
        goto here;
    }
    // Otherwise, insert the new appointment into the timeTable table
    else {
        $stID = $_POST["stID"];
      $sql = "INSERT INTO timeTable (toStaff, fromStudent, dateTimeStart, dateTimeEnd) VALUES ($staffID, $stID, '$selectedDate $startTime', '$selectedDate $endTime')";
      $result = mysqli_query($conn, $sql);

      // Check if query was successful
      if (!$result) {
        die("Query failed: " . mysqli_error($conn));
      }
    }
  }

  // Redirect to the staff dashboard
  header("Location: dashboardStaff.php");
  here:
  exit();
}



// Check if query was successful
if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Respond to Request</title>
</head>
<body>
  <h1>Respond to Request</h1>
  <p>Request ID: <?php echo $row['requestID']; ?></p>
  <p>Title: <?php echo $row['title']; ?></p>
  <p>Description: <?php echo $row['description']; ?></p>

<p>From: <?php echo $row['studentName']; ?></p>

<form method="post">
    <input type="text" name="stID" value="<?php echo $row['studentID']; ?>" readonly style="display: none;">
  <label for="requestStatus">Request Status:</label>
  <select id="requestStatus" name="requestStatus">
    <option value="1">Pending</option>
    <option value="2">Approved</option>
    <option value="3">Rejected</option>
  </select>
  <br><br>
  <label for="response">Response:</label>
  <textarea id="response" name="response"></textarea>
  <br><br>
  <div id="appointmentFields" style="display:none;">
    <label for="selectedDate">Select Date:</label>
    <input type="date" id="selectedDate" name="selectedDate">
    <br><br>
    <label for="startTime">Start Time:</label>
    <input type="time" id="startTime" name="startTime">
    <br><br>
    <label for="endTime">End Time:</label>
    <input type="time" id="endTime" name="endTime">
    <br><br>
  </div>
  <input type="submit" name="respond" value="Respond">
</form>
<script>
  // Display the appointment fields if the request is approved
  document.getElementById("requestStatus").addEventListener("change", function(){
    if(this.value == 2){
      document.getElementById("appointmentFields").style.display = "block";
    } else {
      document.getElementById("appointmentFields").style.display = "none";
    }
  });
</script>
</body>
</html>
