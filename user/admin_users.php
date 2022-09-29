<?php

// Initialize the session
session_start();

date_default_timezone_set("Europe/London");


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

//The following ensures that only user id = 1 can use this!!! 
if($_SESSION['userid'] != 1) {
  header("location: /index.php");
}


function userStringToArray($userString) {
    $groupId_array = $userString;
    $groupId_array = explode(",", $groupId_array);
    foreach($groupId_array as &$value) {
      $value = trim($value);
    }
    $groupId_array = json_encode($groupId_array);
    return $groupId_array;
}

if($_SERVER['REQUEST_METHOD']=='POST') {
  if(isset($_POST['changeRow'])) {

    $groupId_array = userStringToArray($_POST['groupid']);
    

    //echo $groupId_array;
    
    $sql= "UPDATE users SET name = ?, password = ?, usertype = ?, schoolid = ?, groupid = ?, groupid_array =?, active =? WHERE id = ?";

    $stmt=$conn->prepare($sql);
    
    $stmt->bind_param("sssissii", $_POST['name'], $_POST['password'], $_POST['usertype'], $_POST['schoolid'], $_POST['groupid'], $groupId_array, $_POST['active'], $_POST['id']);

    $stmt->execute();
    echo "User ".$_POST['id']." changed successfully.";


  }

  if(isset($_POST['addRow'])) {

    $groupId_array = userStringToArray($_POST['groupid']);

    $sql = "INSERT INTO users (name, password, usertype, schoolid, groupid, groupid_array, active) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("sssissi", $_POST['name'], $_POST['password'], $_POST['usertype'], $_POST['schoolid'], $_POST['groupid'], $groupId_array, $_POST['active']);

    $stmt->execute();
    echo "New record entered successfully";



  }




}



//print_r($_POST);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>www.thinkeconomics.co.uk</title>
  <style>
    table {
      border-collapse: collapse;
    }

    td, th {
      border: 1px solid black;
      padding: 5px;
    }
  </style>
</head>
<body>
  
</body>
</html>
<h1>All Users</h1>
<p>Guide to $_GET variables:</p>
  <ul>
    <li>$_GET['active']: filter for active (1) or inactive (0); default 1;</li>
    <li>$_GET['sort']: sort results by column</li>
  </ul>


<h2>New User</h2>

<table>

<tr>

  <th>Name</th>
  <th>Password</th>
  <th>usertype</th>
  <th>schoolid</th>
  <th>group</th>
  <th>active</th>
  <th></th>
</tr>
<tr>
  <form method = "post" action="">
    <th><input required type="text" name="name"</th>
    <th><input required type="text" name="password"</th>
    <th>
      <select name = "usertype">
        <option value = "student">Student</option>
        <option value = "teacher">Teacher</option>
        <option value = "admin">Admin</option>
      </select>

    <th><input required type="text" name="schoolid"</th>
    <th><input required type="text" name="groupid"</th>
    <th><input required type="text" name="active"</th>
    <th><input required type="submit" name="addRow" value="Add User"</th>
  </form>
</tr>
</table>

<br>

<table>
  <tr>
    <th>id</th>
    <th>Name</th>
    <th>Password</th>
    <th>usertype</th>
    <th>schoolid</th>
    <th>group</th>
    <th>active</th>
  </tr>


  <?php

  if(!isset($_GET['active'])) {
    $_GET['active']=1;
  }

  $sort = "id";
  

  //echo $sort;
  $sortArray = array("id", "name", "usertype", "schoolid", "groupid");
  

  $sql="SELECT * FROM users WHERE usertype != 'admin' AND active = ?";

  if(isset($_GET['sort'])) {
    if(in_array($_GET['sort'], $sortArray)) {

      $sort = $_GET['sort'];
      $sql .=  " ORDER BY ".$sort;
    }
  }
  echo $sql;
  $stmt=$conn->prepare($sql);
  
  $stmt->bind_param("i", $_GET['active']);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      ?>
        <tr>
        <form method ="post" action="">
          <td><?=$row['id']?></td>
          <td><input type="text" name="name" style="//width: 50px" value="<?=htmlspecialchars($row['name'])?>"></td>
          <td><input type="text" name="password" style="width: 60px" value="<?=htmlspecialchars($row['password'])?>"></td>
          <td><input type="text" name="usertype" style="width: 100px" value="<?=htmlspecialchars($row['usertype'])?>"></td>
          <td><input type="text" name="schoolid" style="width: 60px" value="<?=htmlspecialchars($row['schoolid'])?>"></td>
          <td><input type="text" name="groupid" style="width: 40px" value="<?=htmlspecialchars($row['groupid'])?>">
          <?=$row['groupid_array']?>
          </td>
          <td><input type="text" name="active" style="width: 20px" value="<?=htmlspecialchars($row['active'])?>"></td>
          <td>
            <input type="submit" name="changeRow" value="Change">
            <input type="hidden" name="id" value="<?=htmlspecialchars($row['id'])?>">
          </td>
      </form>


        </tr>


      <?php



    }
  }



  ?>


  
</table>