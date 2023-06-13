<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  include($path."/php_header.php");
?>

<!DOCTYPE html>

<html lang="en">

<head>

<?php include "../header.php";?>

</head>



<body>
<?php include "../navbar.php";?>

<?php

// Using OOP:


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['exerciseid'];

$sql = "SELECT * FROM nde_exercises WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result) {
  $row = $result->fetch_assoc();
  //print_r($row);
  
  $components = json_decode($row['components']);

  //print_r($components);

  $components_number = array();
  $components_text = array();

  foreach ($components as $val) {
    if(isset($val[1])) {
      array_push($components_number, $val);
    }
    else  {
      array_push($components_text, $val[0]);
    }
  }
  //print_r($components_number);
  //print_r($components_text);

  
}

$sql2 ="SELECT * FROM nde_exercises ORDER BY id";
$stmt2 = $conn->prepare($sql2);
//$stmt2->bind_param("i", $id);
$stmt2->execute();
$result2 = $stmt2->get_result();

?>


<?php if(!isset($_GET['exerciseid'])) {
  
  ?>  
  

  <form method ="get">

  <label for ="exerciseid">Exercise</label>
    
  <select id="exerciseid" name="exerciseid">
    <?php
      if($result2) {
        while($row2 = $result2->fetch_assoc()) {
          echo "<option value ='".$row2['id']."'>".$row2['exerciseName']."</option>";
        }
      }
      ?>
  </select>

  <input type="submit">

  </form>
  
  <?php 
  
}

?>

<h1>Exercise Details</h1>
<p><strong>Exercise Name</strong>: <?php echo $row['exerciseName'];?></p>

<?php
if($row['instructions']!="") {
  echo "<p><strong>Instructions</strong>: ".$row['instructions']."</p>";
}
if($row['type']!="") {
  echo "<p><strong>Type</strong>: ".$row['type']."</p>";
}


?>

<?php 

if (!empty($components_number)) {
  echo "<p><strong>Marks Breakdown</strong>:";
    echo"<ul>";
    
      $totalScore;
      foreach ($components_number as $val) {
        echo "<li>";
        echo $val[0].": <strong>".$val[1];
        if ($val[1]=="1") {
          echo " point.</strong>";
          } else {
          echo " points.</strong>";
        }
        if ($val[2] != "") {
          echo " (Skill: ".$val[2].")";
        }
        echo "</li>";
        
        $totalScore = $totalScore + $val[1];
      }
    
    echo "</ul>";
  echo"</p>";

  echo"<p><strong>Total Marks</strong>: ".$totalScore."</p>";
}

if (!empty($components_text)) {
  echo "<p><strong>Text Input Breakdown</strong>:";
    echo"<ul>";
    
    
      foreach ($components_text as $val) {
        echo "<li>";
        echo $val;
        echo "</li>";
        

      }
    
    echo "</ul>";
  echo"</p>";


}

?>
<?php

  $link = json_decode($row['link']);
  //print_r($link);

  foreach($link as $val) {
    if($val[0]!="") {
      if($val[1]!="") {
        $link_desc = $val[1];
      } else {
        $link_desc = "Link";
      }
      echo "<a href='".$val[0]."' target='_blank'>".$link_desc."</a><br>";
    }
    
  }
  


?>

<?php include "../footer.php";?>

</body>


</html>