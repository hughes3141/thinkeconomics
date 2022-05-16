<?php

session_start();


?>


<!DOCTYPE html>

<html lang="en">


<head>

<?php include "../header.php"; ?>

<style>

th, td {
  
  border: 1px solid black;
  padding: 5px;
  word-wrap:break-word;
}

table {
  
  border-collapse: collapse;
  table-layout: fixed;
  width: 100%;
}


/*
.col1, .col2, .col3, .col4, .col5 {
  width: 20%;
}


.col1 {
  width: 10%;
}

.col2 {
  width: 20%;
}

.col3 {
  width: 40%;
}

.col4 {
  width: 25%;
}

.col5 {
  width: 5%;
}
*/
</style>
</head>


<body>

<?php include "../navbar.php"; ?>

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

<h1>News List</h1>

<?php 

if (isset($_SESSION['userid'])==false) {
  
  ?>
    
  <div id = 'logindiv'>
  <h2>User Login:</h2>
  <p>Please login to contribute to the news database:</p>

  <?php include "../login_embed_envelope.php"; ?>
    


  </div>
  
  <?php
  
} else {
  echo "<p>Logged in as ".$_SESSION['name']."</p>";
}


if (isset($_SESSION['userid'])) {

 

  echo "<table><tr><th class='col1'>Topic</th><th class='col2'>Headline</th><th class='col3'>Link</th><th class='col4'>Date Published</th></tr>";


  

  $path = $_SERVER['DOCUMENT_ROOT'];
  $path .= "/../secrets/secrets.php";
  include($path);

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

   $sql = "SELECT * FROM news_data";

   $result = $conn->query($sql);
   if($result->num_rows>0) {
     while($row = $result->fetch_assoc()) {
      echo "<tr>";
      
      //print_r($row);
      //echo "<td>".$row['id']."</td>";
      echo "<td class='col1'>".$row['topic']."</td>";
      echo "<td class='col2'>".$row['headline']."</td>";
      echo "<td class='col3'><a target ='_blank' href='".$row['link']."'>".$row['link']."</a></td>";
      echo "<td class='col4'>".$row['datePublished']."</td>";
      echo "<td class='col5'><button>Edit</button></td>";

     }
   }
   


  echo "</table>";

}

?>



</body>

</html>