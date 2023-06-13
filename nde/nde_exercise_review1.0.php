<?php

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");

session_start();


?>

<!DOCTYPE html>

<html lang="en">

<head>

<?php include '../header.php'; ?>

<?php 


// Using OOP:


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}





?>

<style>

th, td {

border: 1px solid black;
padding: 5px;

}

table {
	
	border-collapse: collapse;
	
}


</style>

</head>

<body>

<?php include '../navbar.php';?>

<?php 

//print_r($_POST);

if (isset($_SESSION['userid'])==false) {

  $_SESSION['name'] = $_POST['name'];
  $_SESSION['userid'] = $_POST['userid'];
  $_SESSION['usertype'] = $_POST['usertype'];
  $_SESSION['groupid'] = $_POST['groupid'];

}

//print_r($_SESSION);

?>

<h1>Non-Digital Entry: Exercises Review</h1>

<?php 

if (isset($_SESSION['userid'])==false) {
  
  ?>
    
  <div id = 'logindiv'>
  <h2>User Login:</h2>


  <?php include "../login_embed_envelope.php"; ?>
    


  </div>
  
  <?php
  
} else {
  echo "<p>Logged in as ".$_SESSION['name']."</p>";
}


if (isset($_SESSION['userid'])) {

  
  $sql = "SELECT * FROM nde_exercises ORDER BY id";
  $result = $conn->query($sql);
  
  
  
  ?>

  <table>
    <tr>
      <th>id</th>
      <th>Exercise Name</th>
      <th>Description</th>
      <th>Student Instructions</th>
      <th>Components</th>
      <th>Type</th>
      <th>Topic</th>
      <th>Notes</th>
      <th>Link</th>
      <th>Date Created</th>
      <th>userCreate</th>
     </tr>
      
  

  <?php

  if($result) {
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>".$row['id']."</td>";
      echo "<td>".$row['exerciseName']."</td>";
      echo "<td>".$row['description']."</td>";
      echo "<td>".$row['instructions']."</td>";
      $components = json_decode($row['components']);
      


      echo "<td>";
      echo "<ul>";
      foreach ($components as $val) {
        if(isset($val[1])) {
          $type = "number";
        } else {
          $type = "text";
        }
        echo "<li>";
        echo $val[0];
        echo "<br>";
        if ($type=="number") {
          echo $val[1];
        
          if ($val[1]=="1") {
            echo " point";
          } else {
            echo " points";
          }
          echo "<br>";
          if ($val[2] != "") {
            echo " (skill: ".$val[2].")";
          }
        }
        echo "</li>";
      }
      echo "</ul>";

      //print_r($components);
      
      echo "</td>";
      echo "<td>".$row['type']."</td>";
      //echo "<td>".$row['topic']."</td>";
      echo "<td>";
      $topic = json_decode($row['topic']);
      $topic = implode(",", $topic);
      echo $topic;
      echo "</td>";

      echo "<td>".$row['notes']."</td>";
      echo "<td>";

      $link = json_decode($row['link']);
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
      echo "</td>";
      echo "<td>".$row['dateCreated']."</td>";
      echo "<td>".$row['userCreate']."</td>";
      //print_r($row);
      echo "</tr>";
    }
  }
  
  ?>
  
  </table>
  
  <?php
  
  
  






  

}

$stmt->close();
$conn->close();


?>

<?php include "../footer.php";?>
</body>

<script>

</script>


</html>