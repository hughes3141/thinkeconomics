<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];


if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");
  
}

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");
//include ($path."/header_tailwind.php");


function getFlashcardSummaryByClass($classid, $dateStart = null, $dateEnd = null) {
  /*
  This function will take input $classid and return a list of questions that has been completed by members of this class.
  Filter by dates as second argument.
  */
  global $conn;
  $responses = array();
  if (!isset($dateEnd)) {
    $dateEnd = date('Ymd');
  }


  

  $users = getGroupUsers($classid);
  //array_push($responses, $users);

  $sql = "SELECT q.topic, r.gotRight response, q.question, COUNT(*) count

 
          FROM flashcard_responses r
          JOIN (SELECT id, name FROM users) u
          ON r.userID = u.id
          JOIN (SELECT id, topic, question FROM saq_question_bank_3 WHERE type LIKE '%flashCard%' AND userCreate = 1) q
          ON r.questionId = q.id
          WHERE (";

          foreach ($users as $key=>$array) {
            $sql .= " r.userId = ".$array['id']." ";

            if($key < (count($users)-1)) {
              $sql .= " OR ";
            }
          }
    $sql .= " ) ";
    if (isset($dateStart)) {
      $sql .= " AND DATE(r.timeSubmit) BETWEEN ? AND ?";
    }

    $sql .= " GROUP BY q.id, r.gotRight            ORDER BY count DESC";

  //echo $sql;

  $stmt = $conn->prepare($sql);

  if (isset($dateStart)) {
    $stmt->bind_param('ss',$dateStart, $dateEnd);
  } 

  


  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($responses, $row);
    }
  }

  return $responses;

}



$results = getFlashcardSummaryByClass($_GET['groupId'], $_GET['dateStart'], $_GET['dateEnd']);

echo "<!-- GET variables: groupId, dateStart, dateEnd
    
-->";
echo "<table>";
foreach ($results as $array) {
  //print_r($array);
  
  ?>
  <tr>
    <td><?=$array['topic']?></td>
    <td><?php 
      if($array['response']==0) {
        echo "Don't Know";
      }
      else if ($array['response']==1) {
        echo "Wrong";
      }

      else if ($array['response']==2) {
        echo "Right";
      }
      
      
      ?></td>
    <td><?=$array['question']?></td>
    <td><?=$array['count']?></td>
  </tr>

<?php

  //echo "<br>";
}

echo "</table>"

?>