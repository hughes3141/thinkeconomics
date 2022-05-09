<?php 


//print_r($_POST); 



if((isset($_POST['userid'])==false)) {

?>


  <form method="post">

  <p>
    <label for="login_name">Name:</label>
    <input type="text" id="login_name" name="name" placeholder=Name value = "<?php echo $_POST['name']; ?>">
  </p>
  <p>
    <label for="login_password">Password:</label>
    <input type="password" id="login_password" name="password" placeholder=Password>
  </p>
  <input type="submit" value="Login">

  </form>

<?php

}

?>

<form method="post" id="login_form2">

<?php



$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/../secrets/secrets.php";
include($path);

$conn = new mysqli($servername, $username, $dbpassword, $dbname);

if ($conn->connect_error) {
  die("Connection failed");
}

$name2= $_POST['name'];
$password2 = $_POST['password'];

//echo $name2.$password2;



$sql = "SELECT id, name, password, usertype, groupid FROM users WHERE name = ?"; 
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $name2);
$stmt->execute();
//$result = $stmt->get_result(); // get the mysqli result
//$result = $stmt->get_result();
//$user = $result->fetch_assoc(); // fetch data   

      /* Store the result (to get properties) */
      $stmt->store_result();
      
      /* Get the number of rows */
      $num_of_rows = $stmt->num_rows;

      /* Bind the result to variables */
      
      $stmt->bind_result($id, $name, $password, $usertype, $groupid);
  
      
/*
while ($stmt->fetch()) {

  echo 'ID: '.$id.'<br>';
  echo 'First Name: '.$name.'<br>';
  echo 'Last Name: '.$password.'<br>';
    
}

*/

$stmt->fetch();

if((isset($_POST['userid'])==false)) {

  if(($num_of_rows == 0)and(empty($_POST['name'])==false)) {
    
    echo "<script type='text/javascript'>alert('This name is not in the database');</script>";
    
  } else {
    
    if(($password != $password2)) {
      echo "<script type='text/javascript'>alert('Incorrect password');</script>";
    
    } elseif (empty($_POST['name'])==false) {
      
      
      
      ?>
      
      <input type="hidden" name = "name" value = "<?php echo $name;?>">      
      <input type="hidden" name = "userid" value = "<?php echo $id;?>">
      <input type="hidden" name = "usertype" value = "<?php echo $usertype;?>">
      <input type="hidden" name = "groupid" value = "<?php echo $groupid;?>">
     
      <script type='text/javascript'>document.getElementById('login_form2').submit();</script>
      

      <?php
      
      
      
      
    }
    
  }
} else {
  //echo "Logged in as: ".$_POST['name'];
}


//echo "User entered: ".$name2.$password2."<br>";
//echo "Database: ".$name.$password;
//phpinfo();

$conn->close();
?>
</form>