<?php 

// Initialize the session
session_start();


$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];
/*
echo $_SESSION['this_url'];
echo "<br>";
print_r($_SESSION);
*/
error_reporting(0);
$style_input = <<<END

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

.col1, .col3 {
  width: 10%;
}

.col2 {
  width: 80%;
}

@media only screen and (max-width: 600px) {
  .col1, .col3 {
    width: 25%;
  }

  .col2 {
    width: 50%;
}
}

td p {
  margin-top: 0px;
}

END;


?>

<?php include "header_tailwind.php"; ?>









<?php 

//print_r($_POST);
/*
if (isset($_SESSION['userid'])==false) {

  $_SESSION['name'] = $_POST['name'];
  $_SESSION['userid'] = $_POST['userid'];
  $_SESSION['usertype'] = $_POST['usertype'];
  $_SESSION['groupid'] = $_POST['groupid'];

}
*/
//print_r($_SESSION);

?>
<div class="container mx-auto px-4 pt-20 lg:pt-32 xl:pt-20">
<h1 class="font-mono text-2xl bg-pink-400 pl-1 mb-2">News List</h1>

<?php 
/*
if (isset($_SESSION['userid'])==false) {
  
  ?>
    
  <div id = 'logindiv'>
  <h2>User Login:</h2>
  <p>Please login to contribute to the news database:</p>

  <?php include "login_embed_envelope.php"; ?>
    


  </div>
  
  <?php
  
} else {
  echo "<p>Logged in as ".$_SESSION['name']."</p>";
}
*/
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

//print_r($_GET);


echo <<<END
    <table class="bg-white text-black">
      <tr>
        <th class='col1'>
          <form method = "get">
            <select class="text-black"style="width: 100%;" onchange="this.form.submit()" name="topic">
              <option value="">Topic</option>
END;

$sql = "SELECT * FROM topics";
$result = $conn->query($sql);
if($result) {
  while ($row = $result->fetch_assoc()) {
    echo "<option value = '".$row['topicCode']."'";
    if($_GET['topic']==$row['topicCode']) {
      echo " selected ";
    }
    echo ">";
    echo "(".$row['topicCode'].") ".$row['topicName'];
    
    echo "</option>"; 
  }
}

echo <<<END
            </select>
          </form>
        </th>
        <th class='col2'>Article</th><th class='col3'>Date Published</th>
      </tr>
END;




$topic = "%".$_GET['topic']."%";

$query = "SELECT * FROM news_data";
if((isset($_GET['topic']))&&($_GET['topic']!="")) {
  $sql = "SELECT * FROM news_data WHERE topic LIKE ? ORDER BY datePublished DESC";
} else {
  $sql = "SELECT * FROM news_data ORDER BY datePublished DESC";
}

//echo $sql;

$stmt = $conn -> prepare($sql);
$stmt->bind_param("s", $topic);
$stmt->execute();
$result = $stmt->get_result();

if($result) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
  
    //print_r($row);
    //echo "<td>".$row['id']."</td>";
    echo "<td>".$row['topic']."</td>";
    echo "<td><p><strong>Headline: </strong>".$row['headline'];
    
    echo "</p><p><strong>Link: </strong><a class = 'hover:bg-sky-100' target ='_blank' href='".$row['link']."'>".$row['link']."</a></p>";
    if ($row['explanation']!="") {
      echo "<p><strong>Explanation: </strong>".$row['explanation']."</p>";
    }
    echo "</td>";
    //echo "<td><a target ='_blank' href='".$row['link']."'>".$row['link']."</a></td>";
    echo "<td>".$row['datePublished']."</td>";
    

  }
}


  

  
  
  
      





echo "</table>";


?>
</div>
<?php


include "footer_tailwind.php";


?>



</body>

</html>