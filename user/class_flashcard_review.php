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

function getFlashcardSummaryByClass($classid) {
  global $conn;
  $responses = array();

  $timeSubmit = 0;
  if(isset($_GET['timeSubmit'])) {
    $timeSubmit = $_GET['timeSubmit'];
  }

  $users = getGroupUsers(7);
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
    if ($timeSubmit != 0 ) {
      $sql .= " AND DATE(r.timeSubmit) = ?";
    }

    $sql .= " GROUP BY q.id, r.gotRight
            ORDER BY count DESC";

  //echo $sql;

  $stmt = $conn->prepare($sql);

  $stmt->bind_param('s',$timeSubmit);

  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($responses, $row);
    }
  }

  return $responses;

}

$results = getFlashcardSummaryByClass(1);

echo "<!-- GET variables: timeSubmit, format e.g. 20221212 to show responses from a particular day
    
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