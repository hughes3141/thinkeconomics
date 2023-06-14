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


function userFlashcardSummary($userid = null, $control = null, $where = null) {

  /*
  This does a lot with the responses from the flashcardResponses table. It can
  -Show all results from table
    -Filtered by userid
    -Filtered by date
    -Counts
    -Averages

  $control:
    -"count": returns count of questions done;
    -"count_category": returns counts of question by whether student got right or not
    -"average": returns average time taken to answer
    -"count_by_date": returns counts of question by date
    -"count_quetions": returns counts of quesitons completed
  $where:
    -A date value: limits results to that date.
  */

  global $conn;
  $list = array();
  
  $sql = "SELECT * ";

  if($control == "count") {
    $sql = "SELECT COUNT(*) ";
  }

  if($control =="count_category") {
    $sql = "SELECT gotRight, COUNT(*) ";
  }
  if(($control =="average")||($control=="average_category")) {
    $sql = "SELECT gotRight, AVG(timeDuration) ";
  }
  if($control == "count_by_date") {
    $sql = "SELECT date(timeSubmit), COUNT(*) ";
  }




    $sql .= " FROM flashcard_responses";

  if($control == "count_questions") {
    $sql = "SELECT r.questionId, COUNT(*), q.question, q.topic
    FROM flashcard_responses r
    LEFT JOIN (SELECT id, question, topic FROM saq_question_bank_3) q
      ON r.questionId = q.id";
  }

  if ($userid) {
    $sql .= " WHERE userId = ?";

    if(strtotime($where)>0) {
      $sql .= " AND date(timeSubmit) = ? ";
    }
  }
  elseif (strtotime($where)>0) {
    $sql .= " WHERE date(timeSubmit) = ? ";
  }

  if(($control == "count_category")||($control == "average_category")) {
    $sql .= " GROUP BY gotRight";
  }

  if($control == "count_by_date") {
    $sql .= " GROUP BY date(timeSubmit) ";
  }
  
  if($control == "count_questions") {
    $sql .= " GROUP BY r.questionId";
  }

  echo $sql;
  
  

  Sandbox:
  
  $sql = "SELECT r.questionId, COUNT(*), q.question, q.topic
          FROM flashcard_responses r
          LEFT JOIN (SELECT id, question, topic FROM saq_question_bank_3) q
            ON r.questionId = q.id
          GROUP BY r.questionId;

          ";

          
         
    $sql = "SELECT DISTINCT gotRight FROM flashcard_responses";
/*
    $sql = "SELECT r.gotRight, COUNT(*) count, cat.gotRight
    FROM flashcard_responses r
    RIGHT JOIN (SELECT DISTINCT gotRight FROM flashcard_responses) cat
      ON r.gotRight = cat.gotRight
";
          */

    $sql = "SELECT DISTINCT cat.gotRight, r.count
            FROM flashcard_responses cat
            LEFT JOIN (SELECT gotRight, COUNT(*) count FROM flashcard_responses GROUP BY gotRight) r
              ON cat.gotRight = r.gotRight";

    $sql ="SELECT DISTINCT cat.gotRight, r.count FROM flashcard_responses cat LEFT JOIN (SELECT gotRight, COUNT(*) count FROM flashcard_responses GROUP BY gotRight) r ON cat.gotRight = r.gotRight WHERE userId = ?";

    $sql ="SELECT r.gotRight, r.count
          FROM (SELECT gotRight, COUNT(*) count FROM flashcard_responses GROUP BY gotRight WHERE userId = ?) r
          LEFT JOIN (SELECT DISTINCT gotRight FROM flashcard_responses) cat
      ON r.gotRight = cat.gotRight
      ";

      $sql = "SELECT DISTINCT gotRight
              FROM flashcard_responses";

      $sql = "SELECT COUNT(*), gotRight
              FROM flashcard_responses
              GROUP BY gotRight";

      $sql = "SELECT v.valueId, r.count
              FROM (values (0), (1), (2)) v(valueId)
              LEFT JOIN 
              (SELECT gotRight, COUNT(*) count FROM flashcard_responses WHERE userId = ? GROUP BY gotRight) r
                ON  v.valueId = r.gotRight";

      $sql = "SELECT *
              FROM (values (0), (1), (2))";

                echo $sql;

     

      


  $stmt=$conn->prepare($sql);

  if (($userid)&& !(strtotime($where)>0)) {
    $stmt->bind_param("i", $userid);
  }

  if(!$userid && strtotime($where)>0) {
    $stmt->bind_param("s", $where);
  }

  if($userid && strtotime($where)>0) {
    $stmt->bind_param("is", $userid, $where);
  }
  
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      array_push($list, $row);
    }
  }

  return $list;
}

echo strtotime("2022-11-28");
echo "<br>";
echo strtotime("something else");

$results = userFlashcardSummary();
//$results = flashCardSummary(90);
echo "<pre>";
print_r($results);
echo "</pre>";

?>