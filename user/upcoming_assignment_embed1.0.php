
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
  $groupid = $row['groupid'];
  $name = $row['name'];
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

$assignments = getUpcomingAssignments($groupid);

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


