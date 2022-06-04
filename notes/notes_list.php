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

/*
print_r($_SESSION);
echo "<br>";
print_r($_POST);
echo "<br>";
echo ($_SERVER['REQUEST_METHOD'] == 'POST');
*/

//Define the current maximum order number as $maxOrder:
$sql = "SELECT MAX(orderNo) AS maxOrder FROM notes_index";
$result = $conn->query($sql);
if($result) {
  $maxOrder = $result->fetch_assoc();
}
$maxOrder = intval($maxOrder['maxOrder']);

//This function updates all records upon the input of a new orderNo.
function orderUpdate($input) {
  global $maxOrder, $conn;
  
  //Update Order List of others:
  $sql = "SELECT * FROM notes_index WHERE user = ? ORDER BY orderNo";
  $stmt=  $conn->prepare($sql);
  $stmt-> bind_param("i", $_SESSION['userid']);
  $stmt-> execute();      
  $result = $stmt-> get_result();     
  if($result ->num_rows>0) {
    $sql = "UPDATE notes_index SET orderNo = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);     
    $stmt->bind_param("ii", $x, $y);   

    //For any records that have an order number equal to or higher than the new order number input, increase their order number by 1:
    while($row = $result->fetch_assoc()) {
      if($row['orderNo'] >= $input) {
        $newOrder = $row['orderNo'] +1;    
        $x = $newOrder;
        $y = $row['id'];
        $stmt->execute();
      }   
    }
  }
}

//This function cleans up orderNo, to ensure it starts with 1 and goes to maximum.
function orderCleanup() {
  global $conn;
  $sql = "SELECT * FROM notes_index WHERE user = ? ORDER BY orderNo";
  $stmt=  $conn->prepare($sql);
  $stmt-> bind_param("i", $_SESSION['userid']);
  $stmt-> execute();      
  $result = $stmt-> get_result();     
  
  $orderIteration = 1;
  if($result ->num_rows>0) {    
    $sql = "UPDATE notes_index SET orderNo = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);     
    $stmt->bind_param("ii", $x, $y);   

    while($row = $result->fetch_assoc()) {
      $newOrder = $orderIteration;
      $x = $newOrder;
      $y = $row['id'];
      $stmt->execute();
      $orderIteration ++;
      
    }
  }
}

//Set date:
date_default_timezone_set('Europe/London');
$datetime = date("Y-m-d H:i:s");
//echo $datetime;

//Set link validation error:
$link_validation_error = "";



//Update Database:
//If the form has been submitted:
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  //Define heading
  $heading_type = "";
  if ($_POST['heading'] == "") {
    $heading_type = "a";
  } else {
    $heading_type = $_POST['heading'];
  }

  //Validate link, so long as the input is not a 'header'
  if((filter_var($_POST['link'], FILTER_VALIDATE_URL)) || $_POST['heading']!="") {

    //Ensure that new order input is not greater than maximum orderNo.
    $orderInstance = $_POST['order'];
    if($orderInstance >  $maxOrder) {
      $orderInstance =  $maxOrder+1;
    }
    //Ensure that new order input is not less than 1;
    if($orderInstance < 1) {
      $orderInstance = 1;
    }

    //Update all records where the current orderNo is eqeual to or higher than the orderNo for the inserted/changed record.
    orderUpdate($orderInstance);
        
    //Update database with new information:
    
    //If the record is new:
    if ($_POST['submit'] == "Create New Notes Entry") {
      $inserts = array(
        $_POST['title'], 
        $_POST['link'], 
        $_POST['explanation'], 
        $_POST['topic'], 
        $_POST['source'], 
        $datetime, 
        $_SESSION['userid'], 
        $_POST['active'],
        $orderInstance,
        $heading_type
      );
      $sql = "INSERT INTO notes_index (title, link, explanation, topic, source, dateCreated, user, active, orderNo, heading) VALUES (?,?,?,?,?,?,?,?,?,?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssssssiiis", ...$inserts);

    }
    
    //If the record is an update:
    if ($_POST['submit'] == "Update Entry") {
      $updates = array(
        $_POST['title'], 
        $_POST['link'], 
        $_POST['explanation'], 
        $_POST['topic'], 
        $_POST['source'], 
        $datetime, 
        $_SESSION['userid'], 
        $_POST['active'],
        $orderInstance,
        $heading_type,
        $_POST['id']
      );
      $sql = "UPDATE notes_index SET title = ?, link = ?, explanation = ?, topic = ?, source = ?, dateCreated = ?,  user = ?, active = ?, orderNo = ?, heading =? WHERE id = ?";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssssssiiisi", ...$updates);
    }

    //Execute the statement:
    $stmt->execute();
    echo "New record created"; 

    //Clean up orderNo to ensure order goes from 1 to the maximum order.
    orderCleanup(); 

    //Update $maxOrder to reflect that a new value has been created (strictly for when page reloads for input max value)
    $maxOrder ++;
    

  } else {
    $link_validation_error = "Please enter a valid link.<br>";
  }

  
}

?>

<!DOCTYPE html>
<html>
  <head>
    <style>
      table {
        border-collapse: collapse;
      }
      td, th {
        border: 1px solid black;
        padding: 5px;
      }
      .hide {
        display: none;
      }
    </style>

  </head>
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

  <label for="heading">Heading:</label><br>
  <select name="heading" id="heading">
    <option value = "" <?= (isset($_POST['heading']) && $_POST['heading']=="") ? "selected" : "";?> ></option>

    <option value = "h2" <?= (isset($_POST['heading']) && $_POST['heading']=="h2") ? "selected" : "";?> >h2</option>
    <option value = "h3" <?= (isset($_POST['heading']) && $_POST['heading']=="h3") ? "selected" : "";?> >h3</option>
    <option value = "h4" <?= (isset($_POST['heading']) && $_POST['heading']=="h4") ? "selected" : "";?> >h3</option>

  </select>
  <br>


  <label for="order">Order:</label><br>
  <input type ="number" name="order" id="order" value="<?= isset($_POST['order']) ? $orderInstance : $maxOrder+1;?>" max = "<?=$maxOrder+1?>" min ="1"><br>



  <input type="radio" id="active_yes" name="active" value="1" checked>
  <label for="active_yes">Active</label><br>
  <input type="radio" id="active_no" name="active" value="0">
  <label for="active_no">Inactive</label><br>




  

  <input type ="submit" name="submit" value="Create New Notes Entry">



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
        <form method="post" action ="">
          <td>
            <?=$row['id']?>
          </td>
          <td>
            <div class = "show_<?=$row['id'];?>">
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
            </div>
            <div class = "hide hide_<?=$row['id'];?>">
              <input type="hidden" name = "id" value = "<?=$row['id']?>">

              <input type ="text" name = "title" value ="<?=$row['title']?>"></input>
              <br>
              <input type ="text" name = "link" value ="<?=$row['link']?>"></input>
              <br>
              
              <input type ="text" name = "source" value ="<?=$row['source']?>"></input>
              <br>

              <input type ="text" name = "explanation" value ="<?=$row['explanation']?>"></input>
              <br>
              <input type ="text" name = "topic" value ="<?=$row['topic']?>"></input>
              <br>
              <input type ="text" name = "heading" value ="<?=$row['heading']?>"></input>
              <br>
              <input type="radio" id="active_yes" name="active" value="1" <?= $row['active'] ? "checked" : ""?> >
              <label for="active_yes">Active</label><br>
              <input type="radio" id="active_no" name="active" value="0" <?= !$row['active'] ? "checked" : ""?>>
              <label for="active_no">Inactive</label><br>
            </div>
          </td>
          <td>
            <div class = "show_<?=$row['id'];?>">
              <?=$row['orderNo']?>
            </div>
            <div class = "hide hide_<?=$row['id'];?>">
            <input type ="number" name="order" id="order" value="<?=$row['orderNo']?>" max = "<?=$maxOrder?>" min ="1"></input>
            </div>
          </td>
          <td>
            <div>
              <button type ="button" id = "button_<?=$row['id'];?>" onclick = "changeVisibility(this, <?=$row['id'];?>)"">Edit</button>
            </div>
            <div class ="hide hide_<?=$row['id'];?>">
              <input type="hidden" name = "id" value = "<?=$row['id'];?>">
              <input type="submit" name = "submit" value = "Update Entry"></intput>
            </div>
            
          </td>
        </form>
      </tr>

      <?php


    }
  }
  
  
  
  ?>

  </table>

  </body>

  <script>

    function changeVisibility(button, id) {
      
      if(button.innerHTML =="Edit") {
        button.innerHTML = "Hide Edit";
        var hiddens = document.getElementsByClassName("hide_"+id);
        for (var i=0; i<hiddens.length; i++) {
          hiddens[i].style.display = "block";
        }
    
        var shows = document.getElementsByClassName("show_"+id);
        //console.log(shows);
        for (var i=0; i<shows.length; i++) {
          
          shows[i].style.display = "none";
        }
      } else {
        button.innerHTML = "Edit";
        var hiddens = document.getElementsByClassName("hide_"+id);
        for (var i=0; i<hiddens.length; i++) {
          hiddens[i].style.display = "none";
        }
    
        var shows = document.getElementsByClassName("show_"+id);
        //console.log(shows);
        for (var i=0; i<shows.length; i++) {
          
          shows[i].style.display = "block";
        }
      }
    
    
    }
    
    
    
    </script>
</html>
