<?php 


// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];


if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");
  
}


$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/../secrets/secrets.php";
include($path);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


print_r($_SESSION);
echo "<br>";
print_r($_POST);
echo "<br>";
echo ($_SERVER['REQUEST_METHOD'] == 'POST');

$sql = "SELECT MAX(orderNo) AS maxOrder FROM notes_index";
$result = $conn->query($sql);
if($result) {
  $maxOrder = $result->fetch_assoc();
}


$maxOrder = intval($maxOrder['maxOrder']);


date_default_timezone_set('Europe/London');
$datetime = date("Y-m-d H:i:s");
$link_validation_error = "";
echo $datetime;
if($_SERVER['REQUEST_METHOD'] == 'POST') {

  if(filter_var($_POST['link'], FILTER_VALIDATE_URL)) {

    //Ensure that new order input is not greater than maximum
    $orderInstance = $_POST['order'];
    if($orderInstance > $maxOrder) {
      $orderInstance = $maxOrder+1;
    }
    //Ensure that new order input is not less than 1;
    if($orderInstance < 1) {
      $orderInstance = 1;
    }

    //Update Order List of others:
    $sql = "SELECT * FROM notes_index WHERE user = ? AND orderNo >= ?";
    $stmt= $conn->prepare($sql);
    $stmt-> bind_param("ii", $_SESSION['userid'], $orderInstance);
    $stmt-> execute();      
    $result = $stmt-> get_result();     
    if($result ->num_rows>0) {    
      $sql = "UPDATE notes_index SET orderNo = ? WHERE id = ?";
      $stmt = $conn->prepare($sql);     
      $stmt->bind_param("ii", $x, $y);   

      while($row = $result->fetch_assoc()) {
        echo "<br>";
        print_r($row);

        $newOrder = $row['orderNo'] +1;    
        $x = $newOrder;
        $y = $row['id'];
        $stmt->execute();
        
      }
    }

    
    //Update database with new information:

    $sql = "INSERT INTO notes_index (title, link, explanation, topic, source, dateCreated, user, active, orderNo) VALUES (?,?,?,?,?,?,?,?,?)";
    
    

    $inserts = array(
      $_POST['title'], 
      $_POST['link'], 
      $_POST['explanation'], 
      $_POST['topic'], 
      $_POST['source'], 
      $datetime, 
      $_SESSION['userid'], 
      $_POST['active'],
      $orderInstance
    );

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssiii", ...$inserts);
    $stmt->execute();
    echo "New record created";  

    //Update $maxOrder to reflect that a new value has been created (strictly for when page reloads for input max value)
    $maxOrder ++;
    

  } else {
    $link_validation_error = "Please enter a valid link.<br>";
  }

  
}

?>

<!DOCTYPE html>
<html>
  <body>
  
  <form method="post" action ="">

  <label for="title">Title:</label><br>
  <input type="text" name="title" id="title" value="<?= isset($_POST['title']) ? $_POST['title'] : null;?>"><br>
  
  <label for="topic" >Topic:</label><br>
  <input type="text" name="topic" id="topic" value="<?= isset($_POST['topic']) ? $_POST['topic'] : null;?>"><br>



  <label for="link">Link:</label><br>
  <input type ="text" name="link" id="link" value="<?= isset($_POST['link']) ? $_POST['link'] : null;?>"><br>
  <span><?= $link_validation_error;?></span>

  <label for="source">Source:</label><br>
  <input type ="text" name="source" id="source" value="<?= isset($_POST['source']) ? $_POST['source'] : null;?>"><br>

  <label for="explanation">Explanation:</label><br>
  <textarea name="explanation" id="explanation"><?= isset($_POST['explanation']) ? $_POST['explanation'] : null;?></textarea><br>

  <label for="order">Order:</label><br>
  <input type ="number" name="order" id="order" value="<?= isset($_POST['order']) ? $orderInstance : $maxOrder+1;?>" max = "<?=$maxOrder+1?>" min ="1"><br>



  <input type="radio" id="active_yes" name="active" value="1" checked>
  <label for="active_yes">Active</label><br>
  <input type="radio" id="active_no" name="active" value="0">
  <label for="active_no">Inactive</label><br>




  

  <input type ="submit" name="submit" value="Click to Submit">



  </form>


  <?php
  
  

  $sql = "SELECT * FROM notes_index WHERE user = ? ORDER BY orderNo";
  $stmt= $conn->prepare($sql);

  $stmt-> bind_param("i", $_SESSION['userid']);
  $stmt-> execute();

  $result = $stmt-> get_result();



  ?>

  <table>
    <tr>
      <th>id</th>
      <th>Info</th>
      <th>Order</th>

    </tr>
    
  


  <?php



  if($result ->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      //print_r($row);
      //echo "<br>";

      ?>

      <tr>
        <td>
          <?=$row['id']?>
        </td>
        <td>
          <?=$row['title']?>
          <br>
          <?=$row['link']?>
          <br>
          <!--
          <?=$row['explanation']?>
          <br>
          <?=$row['topic']?>
          <br>
          <?=$row['dateCreated']?>
          <br>
          -->
        </td>
        <td>
          <?=$row['orderNo']?>
        </td>
      </tr>

      <?php


    }
  }
  
  
  
  ?>

  </table>

  </body>
</html>
