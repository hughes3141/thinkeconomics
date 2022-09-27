<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");

if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");

  
  
}
else {
  $userInfo = getUserInfo($_SESSION['userid']);
  $userType = $userInfo['usertype'];
  if (!($userType == "teacher" || $userType =="admin")) {
    header("location: /index.php");
  }
}

print_r($_POST);
//  print_r($_SESSION);
//var_dump($_SESSION['userid']);

function insertTopic() {
  global $conn;
  global $_POST;

  $topics = explode(",", $_POST['topics']);
  foreach ($topics as &$value) {
    $value = trim($value);
  }
  unset($value);
  $topics = json_encode($topics);


  $sql = "INSERT INTO flashcard_collections (name, topics, userCreate) VALUES (?,?,?)";
  $stmt=$conn->prepare($sql);  
  $stmt->bind_param("ssi", $_POST['name'], $topics, $_SESSION['userid']);

  $stmt->execute();
  echo "New records entered successfully";
  


}

function retreiveTopics() {
  global $conn;
  $sql = "SELECT * FROM flashcard_collections";
  $stmt=$conn->prepare($sql);
  //$stmt->bind_param();
  $stmt->execute();
  $result = $stmt->get_result();

  $output = array();

  if($result->num_rows>0) {
    while($row=$result->fetch_assoc()) {
      array_push($output, $row);
    }
    return $output;
  }
}



if(($_SERVER['REQUEST_METHOD']) == 'POST' && isset($_POST['collection_enter'])) {

  insertTopic();
  }



?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    table {
      border-collapse: collapse;
    }
     td, th {
      border: solid 1px black;
      padding: 5px;
     }
  </style>

</head>
<body>
  <h1> Flashcard Collections</h1>


  <form method="post" action="">
    <label for="name">Collection Name:</label>
    <input id="name" type="text" name ="name"></input>
    <label for="topics">Topics:</label>
    <input id="topics" type="text" name="topics"></input>
    <input type="submit" name="collection_enter" value="submit">



  </form>

  <table>
    <tr>
      <th>id</th>
      <th>Name</th>
      <th>Topics</th>
  </tr>

  <?php
    $rows = retreiveTopics();
    foreach ($rows as $row) {
      ?>
      <tr>
        <td><?=htmlspecialchars($row['id']);?>
        </td>
        <td><?=htmlspecialchars($row['name']);?>
        </td>
        <td>
        <?php
          $topics = json_decode($row['topics']);
          if(isset($topics)) {
            foreach ($topics as $key=>$topic) {
              echo $topic;
              if($key !== array_key_last($topics)) {
                echo ", ";
              }
            }
        }

        ?>
        </td>



      </tr>

      <?php


    }
  ?>


  </table>
</body>
</html>