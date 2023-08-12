<?php
session_start();
include_once "database.php";

$requestID = $_GET['id'];
$staffID = $_SESSION["staffID"];
$staffName = $_SESSION["staffName"];

if(isset($_POST['respond'])) {
  $requestStatus = $_POST['requestStatus'];
  $response = $_POST['response'];

  if($requestStatus == 2) {
    $selectedDate = $_POST['selectedDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    $dateTimeStart = date('Y-m-d H:i:s', strtotime("$selectedDate $startTime"));
    $dateTimeEnd = date('Y-m-d H:i:s', strtotime("$selectedDate $endTime"));
  } else {
    $dateTimeStart = NULL;
    $dateTimeEnd = NULL;
  }

  $sql = "UPDATE requests SET requestStatus = ?, response = ?, dateTimeStart = ?, dateTimeEnd = ? WHERE requestID = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("isssi", $requestStatus, $response, $dateTimeStart, $dateTimeEnd, $requestID);
  $stmt->execute();

  header("Location: dashboardStaff.php");
}

$sql = "SELECT r.requestID, r.title, r.description, r.requestStatus, r.response, r.dateTimeStart, r.dateTimeEnd, s.studentName, s.studentID FROM requests r JOIN studentDetails s ON r.fromStudent = s.studentID WHERE r.requestID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $requestID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="respond.css">
  <title>Respond to Request</title>
</head>
<body>
  <h1>Respond to Request</h1>
  <br><br><p>Request ID: <?php echo $row['requestID']; ?></p>
  <p>Title: <?php echo $row['title']; ?></p>
  <br><br><p>Description: <br><?php echo $row['description']; ?></p>
  <br><br><p>From: <?php echo $row['studentName']; ?></p>
  <form method="post">
    <input type="text" name="stID" value="<?php echo $row['studentID']; ?>" readonly style="display: none;">
    <label for="requestStatus">Request Status:</label>
    <select id="requestStatus" name="requestStatus">
      <option value="1" <?php if($row['requestStatus'] == 1) echo 'selected'; ?>>Pending</option>
      <option value="2" <?php if($row['requestStatus'] == 2) echo 'selected'; ?>>Approved</option>
      <option value="3" <?php if($row['requestStatus'] == 3) echo 'selected'; ?>>Rejected</option>
    </select>
    <br><br>
    <label for="response">Response:</label>
    <textarea id="response" name="response"><?php echo $row['response']; ?></textarea>
    <br><br>
    <div id="appointmentFields" <?php if($row['requestStatus'] != 2) echo 'style="display:none;"'; ?>>
      <label for="selectedDate">Select Date:</label>
      <input type="date" id="selectedDate" name="selectedDate" value="<?php echo date('Y-m-d', strtotime($row['dateTimeStart'])); ?>">
      <br><br>
      <label for="startTime">Start Time:</label>
<input type="time" id="startTime" name="startTime" value="<?php echo date('H:i', strtotime($row['dateTimeStart'])); ?>">
<br><br>
<label for="endTime">End Time:</label>
<input type="time" id="endTime" name="endTime" value="<?php echo date('H:i', strtotime($row['dateTimeEnd'])); ?>">
<br><br>
</div>
<input type="submit" name="respond" value="Respond" class="cb">

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
