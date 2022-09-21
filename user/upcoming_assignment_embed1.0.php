
<?php 

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/../secrets/secrets.php";
include($path);

date_default_timezone_set("Europe/London");


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed");
}


$userid = $_SESSION['userid'];



$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userid);
$stmt->execute();

$result = $stmt->get_result();

if($result) {
  $row=$result->fetch_assoc();
  $groupid = json_decode($row['groupid_array']);
  $name = $row['name'];
}



function getUpcomingAssignmentsArray($groupIdArray) {

  /*
  This function generates an array of upcoming assignmnents. Input is an array (in JSON form) of the groups that a studnet is listed in.
  */

  global $conn;
  $t = time();
  $now = $now = date("Y-m-d H:i:s", $t);

  $groupIdSql = array();

  $list = array();
  $paramType = "";

  $sql = "SELECT * FROM assignments WHERE (";

  $count = count($groupIdArray);
  for($x =0; $x< $count; $x++) {
    $valueSql = '%\"'.$groupIdArray[$x].'\"%';
    array_push($groupIdSql, $valueSql);
    $sql .= "groupid_array LIKE ? ";
    if($x < ($count - 1)) {
      $sql .= " OR ";
    }
    $paramType .= "s";
  }
  
  $sql .= ") AND dateDue > CURRENT_TIMESTAMP()";

  //echo $sql."<br>".$paramType;
  $stmt = $conn->prepare($sql);
  $stmt->bind_param($paramType, ...$groupIdSql);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      array_push($list, $row);
    }
  }

  return $list;

}

function getUpcomingAssignments($groupId) {
  global $conn;
  $t = time();
  $now = date("Y-m-d H:i:s", $t);

  $groupIdSql = '%\"'.$groupId.'\"%';

  //echo $groupIdSql;

  $list = array();
  
  $sql = "SELECT * FROM assignments WHERE groupid_array LIKE ? AND dateDue > CURRENT_TIMESTAMP()";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $groupIdSql);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      array_push($list, $row);
    }
  }

  return $list;

}

$assignments = getUpcomingAssignmentsArray($groupid);

//print_r($assignments);




if(count($assignments) == 0) {
  
  ?>
  
  <p>You have no upcoming assignments.</p>
  
  
  <?php
  
} else {
  
  
  
  ?>
  
  <table>
    <tr>
      <th>Assignment Name</th>
      <th>Due Date</th>
      <th>Link to Assignment</th>
    </tr>
  
  
  <?php
  
  foreach ($assignments as $value) {

      echo "<tr>";
      echo "<td>".$value['assignName']."</td>";
      echo "<td>".$value['dateDue']."</td>";
      
      if ($value['type'] == "mcq") {
        echo "<td>";
// THIS IS WHERE TO CHANGE THE LINK AFTER MAKING CHANGES TO MCQ PAGE
        echo "<a href = '../mcq/login.php?assignid=".$value['id']."'>Link to MCQ</a>";
        echo "</td>";
      }
      
      if ($value['type'] == "saq") {
        echo "<td>";
// THIS IS WHERE TO CHANGE THE LINK AFTER MAKING CHANGES TO SAQ PAGE
        echo "<a href = '../saq/saq1.7.php?assignid=".$value['id']."'>Complete Assignment</a>";
        echo "</td>";
      }
      
      
      echo "</tr>";
      //print_r($value);
      //echo "<br>";
    
    
  
  }
  
  ?> </table> <?php
  
}



?>


