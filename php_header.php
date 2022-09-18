<?php



//Commands which are common to all scripts:


  // Initialize the session
  session_start();

  $_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

  /*
  if (!isset($_SESSION['userid'])) {
    
    header("location: /login.php");
    
  }
  */

  //Define server path:
  $path = $_SERVER['DOCUMENT_ROOT'];
  $path .= "/../secrets/secrets.php";
  include($path);

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
  }


//Functions:


/*
checkGroupAccess(int $userId, int $groupID): bool

Given a username, will determine whether the user has teacher priviliges for the group in question.
*/

function checkGroupAccess() {

  
}

/*
getGroupUsers(int $groupId): array

Will produce an array of all users in a given groupId.
  
*/

function getGroupUsers($groupId) {
  global $conn;

  $groupIdSql = '%\"'.$groupId.'\"%';

  $sql = "SELECT * FROM users WHERE groupid_array LIKE ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $groupIdSql);
  $stmt->execute();

  $students = array();

  $result=$stmt->get_result();
  
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()){
      array_push($students, $row);
    }
  }

  return $students;

}



?>