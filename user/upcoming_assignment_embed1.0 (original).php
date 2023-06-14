
<?php 

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/secrets.php";

include_once($path);


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


$assignments = array();
$assignmentsFilter = array();

$sql = "SELECT * FROM assignments;";

$result = $conn->query($sql);

if($result) {
  while($row = $result->fetch_assoc()){

    
    $assignment2 = array();
    
    $assignment2['id'] = $row['id'];
		$assignment2['assignName'] =  $row['assignName'];
		$assignment2['quizid'] =  $row['quizid'];
		$assignment2['groupid'] =  explode(",", ($row['groupid']));
		$assignment2['notes'] =  $row['notes'];
		$assignment2['dateCreated'] =  $row['dateCreated'];
		$assignment2['dateDue'] =  $row['dateDue'];
		$assignment2['type'] =  $row['type'];
    
    foreach ($assignment2['groupid'] as $x => $val) {
      $assignment2['groupid'][$x] = intval($val);
      //echo "$x is $val<br>";
    }
    
    if( strtotime($assignment2['dateDue']) > strtotime('now') ) {
      $assignment2['upcoming'] = 1;
    } else {
     $assignment2['upcoming'] = 0; 
    }
    
    
    array_push($assignments, $assignment2);

  }
}



for ($x=0; $x<count($assignments); $x++) {
  if (in_array($groupid, $assignments[$x]['groupid'], TRUE)) {
    array_push($assignmentsFilter, $assignments[$x]);
  }
}




$upcomingCheck = false;
foreach ($assignmentsFilter as $value) {
  if ($value['upcoming']==1) {
    $upcomingCheck = true;
  }
}

if ($upcomingCheck == false) {
  
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
  
  foreach ($assignmentsFilter as $value) {

    if ($value['upcoming']==1) {
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
    
  
  }
  
  ?> </table> <?php
  
}



?>


