<?php

session_start();


?>

<!DOCTYPE html>

<html lang="en">

<head>
<?php include '../header.php'; ?>

<style>

@media (min-width: 640px) {
  #phone_entry_div {
    display: none;
  }
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

<h1>News Input</h1>

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

  ?>



  <div id="phone_entry_div">
    <label for="phone_entry_input">Phone Optimised Entry:</label><br>
    <input type = "text" id ="phone_entry_input" onchange="phone_fill();"></input><br>
  
  </div>


  <form method="post">

  <label for="headline">Headline:</label><br>
  <input type="text" name="headline" id="headline" required><br>

  <label for="link">Link:</label><br>
  <input type ="text" name="link" id="link" required><br>

  <label for="datePublished">Date Published:</label><br>
  <input type ="date" name="datePublished" id="datePublished" required value="<?= date('Y-m-d'); ?>" ><br>

  <label for="explanation">Explanation:</label><br>
  <textarea name="explanation" id="explanation"></textarea><br>

  <label for="explanation_long">Long Explanation:</label><br>
  <textarea name="explanation_long" id="explanation_long"></textarea><br>

  <label for="topic">Topic:</label><br>
  <input type ="text" name="topic" id ="topic"><br>

  <label for="keyWords">Key Words:</label><br>
  <input type ="text" name="keyWords" id ="keyWords"><br>
  
  <input type="radio" id="active_yes" name="active" value="1" checked>
  <label for="active_yes">Active</label><br>
  <input type="radio" id="active_no" name="active" value="0">
  <label for="active_no">Inactive</label><br>

  
  

  <input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">

  <input type ="submit" name="submit" value="Click to Submit">



  </form>


  <?php

}

//Set parameters: 

if($_SERVER['REQUEST_METHOD'] === 'POST') {

  $headline = $_POST['headline'];
  $hyperlink =  $_POST['link'];
  $datePublished = $_POST['datePublished'];
  $explanation =  $_POST['explanation'];
  $explanation_long = $_POST['explanation_long'];
  $topic =  $_POST['topic'];

  $datetime = date("Y-m-d H:i:s");
  $keyWords = $_POST['keyWords'];
  $userid = $_POST['userid'];
  $active = $_POST['active'];
}

$query2 = "SELECT * FROM news_data ORDER BY id DESC";

// Using OOP:

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/../secrets/secrets.php";
include($path);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO news_data (headline, link, datePublished, explanation, explanation_long, topic, keyWords, dateCreated, user, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("ssssssssii", $headline, $hyperlink, $datePublished, $explanation, $explanation_long, $topic, $keyWords, $datetime, $userid, $active);

if (isset($_POST['submit'])) {
  //Execute
  
  $stmt->execute();
  
  //echo $headline.$hyperlink.$datePublished.$explanation.$explanation_long.$topic.$keyWords.$datetime;
  
  echo "New records created successfully";
  
}








$stmt->close();
$conn->close();

?>



<?php include '../footer.php'; ?>

<script>
  function phone_fill() {
    var phone_fill_entry = document.getElementById("phone_entry_input").value;
    var entries = phone_fill_entry.split("https://");
    
    entries[1] = "https://"+entries[1];
    //console.log(entries);
    document.getElementById("headline").value = entries[0];
    document.getElementById("link").value = entries[1];
    
  }

</script>
</body>

</html>