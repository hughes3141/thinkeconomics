<?php

//Functions:


// based on original work from the PHP Laravel framework
//Polyfill function for str_contains:
  
if (!function_exists('str_contains')) {
  function str_contains($haystack, $needle) {
      return $needle !== '' && mb_strpos($haystack, $needle) !== false;
  }
}


/*
checkGroupAccess(int $userId, int $groupId): bool

Given a username, will determine whether the user has teacher priviliges for the group in question.
*/

function checkGroupAccess($userId, $groupId) {
  global $conn;

  $sql = "SELECT * FROM groups WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $groupId);
  $stmt->execute();

  $result = $stmt->get_result();

  if($result->num_rows>0) {
    $row = $result->fetch_assoc();
    $teachers = json_decode($row['teachers']);
    
    if(in_array($userId, $teachers)) {
      return true;
    } else {
      return  false;
    }
  }

}


/*

getGroupsList(int $userId, $activeReturn bool = true) : array

Returns a list of groups for whom the $userId is listed as a teacher


*/


function getGroupsList($userId, $activeReturn = true) {
  global $conn;

  $userIdSql = '%\"'.$userId.'\"%';

  $sql = "SELECT * FROM groups WHERE teachers LIKE ? AND active = 1";

  if($activeReturn == false) {
    $sql = "SELECT * FROM groups WHERE teachers LIKE ?";
  }
  
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("s", $userIdSql);
  $stmt->execute();
  $result = $stmt->get_result();

  $groups = array();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($groups, $row);
    }
  }
  return $groups;
}


function getAssignmentInfoById($assignId) {
  /*
  Returns information from assignments table from input id.

  */

  global $conn;
  $sql = "SELECT * FROM assignments WHERE id = ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("i", $assignId);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    $row = $result->fetch_assoc();
    return $row;
  }
  




}




function getAssignmentsList($userId, $classId = null, $type = "all") {

  /*
  Returns a list of assignments by the user who created it, optional filter by type by type.

  used in:
  -mcq_assignment_review3.0.php 
  */
  global $conn;

  $state = array(0,0);

  $sql ="SELECT * FROM assignments WHERE userCreate = ?";

  if($classId != null) {
    $classIdSql = '%\"'.$classId.'\"%';
    $sql .= " AND groupid_array LIKE ?";
    $state[0] = 1;
  }

  if($type != "all") {
    $sql .= " AND type = ?";
    $state[1]=1;
  }
    //echo $sql;
    $stmt=$conn->prepare($sql);
    //print_r($state);

    if($state == [0,0]) {
      $stmt->bind_param("i", $userId);
    } elseif ($state == [1,0]) {
      $stmt->bind_param("is", $userId, $classIdSql);
    } elseif ($state == [0,1]) {
      $stmt->bind_param("is", $userId, $type);
    } elseif ($state == [1,1]) {
      $stmt->bind_param("iss", $userId, $classIdSql, $type);
    }

  $stmt->execute();
  $result=$stmt->get_result();

  $assignments = array();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($assignments, $row);

    }
  }

  return $assignments;

  
  
}

/*
getGroupUsers(int $groupId): array

Will produce an array of all users in a given groupId.
  
*/

function getGroupUsers($groupId, $activeReturn = true) {
  global $conn;

  $groupIdSql = '%\"'.$groupId.'\"%';

  $sql = "SELECT id, name, name_first, name_last, username, usertype, permissions, email, schoolid, groupid, groupid_array, active FROM users WHERE groupid_array LIKE ?";

  if($activeReturn == true) {
    $sql .= " AND active = 1";

  }
  $sql .= " ORDER BY name_last";
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


/*

maxOrder(str $tableName) : int

Returns the current order number

Used in:
  -notes_list.php
*/

function maxOrder($tableName) {
  global $conn;

  $sql = $sql = "SELECT MAX(orderNo) AS maxOrder FROM ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $tableName);
  $stmt->execute();

  if($result) {
    $maxOrder = $result->fetch_assoc();
  }
  return intval($maxOrder['maxOrder']);

}


/*

orderUpdate($input, $userId) : null

*/


/*

getUserInfo ($userId) : array

Returns an array of all information about a user.


*/

function getUserInfo($userId) {
  global $conn;
  $sql = "SELECT id, name, name_first, name_last, username, usertype, permissions, email, schoolid, groupid, groupid_array, active FROM users WHERE id = ? ";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows>0) {	
  $row = $result->fetch_assoc();
  return $row;   
     
  }
}


function getUpcomingAssignmentsArray($groupIdArray) {

  /*
  This function generates an array of upcoming assignmnents. Input is an array (in JSON form) of the groups that a studnet is listed in.
  */

  global $conn;
  $t = time();
  $now = $now = date("Y-m-d H:i:s", $t);

  $groupIdSql = array();

  $list = array();
  $paramType = "";

  $sql = "SELECT * FROM assignments WHERE (";

  $count = count($groupIdArray);
  for($x =0; $x< $count; $x++) {
    $valueSql = '%\"'.$groupIdArray[$x].'\"%';
    array_push($groupIdSql, $valueSql);
    $sql .= "groupid_array LIKE ? ";
    if($x < ($count - 1)) {
      $sql .= " OR ";
    }
    $paramType .= "s";
  }
  
  $sql .= ") AND dateDue > CURRENT_TIMESTAMP()";

  //echo $sql."<br>".$paramType;
  $stmt = $conn->prepare($sql);
  $stmt->bind_param($paramType, ...$groupIdSql);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      array_push($list, $row);
    }
  }

  return $list;

}

function getUpcomingAssignments($groupId) {
  global $conn;
  $t = time();
  $now = date("Y-m-d H:i:s", $t);

  $groupIdSql = '%\"'.$groupId.'\"%';

  //echo $groupIdSql;

  $list = array();
  
  $sql = "SELECT * FROM assignments WHERE groupid_array LIKE ? AND dateDue > CURRENT_TIMESTAMP()";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $groupIdSql);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      array_push($list, $row);
    }
  }

  return $list;

}


function getAssignmentsArray($groupIdArray, $startDate = null) {

  /*
  This function generates an array of assigned work. Input is an array (in JSON form) of the groups that a studnet is listed in.
  $startDate is the first date when results are to be output by. format is e.g. 20221203
  */

  global $conn;

  $groupIdSql = array();

  $list = array();
  $paramType = "";

  $sql = "SELECT * FROM assignments WHERE (";

  $count = count($groupIdArray);
  for($x =0; $x< $count; $x++) {
    $valueSql = '%\"'.$groupIdArray[$x].'\"%';
    array_push($groupIdSql, $valueSql);
    $sql .= "groupid_array LIKE ? ";
    if($x < ($count - 1)) {
      $sql .= " OR ";
    }
    $paramType .= "s";
  }
  
  $sql .= ")";

  if($startDate) {
    $sql .= " AND dateDue > ".$startDate;
  }


  //echo $sql."<br>".$paramType;
  $stmt = $conn->prepare($sql);
  $stmt->bind_param($paramType, ...$groupIdSql);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      array_push($list, $row);
    }
  }
  
  return $list;

}


function getMCQquizInfo($quizId) {

  /*
  This function returns array of all columns for a particular id in mcq_quizzes
  */

  global $conn;
  $sql = "SELECT * FROM mcq_quizzes WHERE id = ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("i", $quizId);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    $row = $result->fetch_assoc();
    return $row;
  }
  
}


function getMCQquizzesByTopic($topic) {
  /*
  This function returns an array of all entries from mcq_quizzes table that match a $topic category
  */

  global $conn;
  $quizzes = array();
  $sql = "SELECT * FROM mcq_quizzes WHERE topic LIKE ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("s", $topic);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    
    while($row = $result->fetch_assoc()){
      array_push($quizzes, $row);
      
    }
    return $quizzes;
  }
  

}


function getGroupInfoById($groupId) {
  /*
  Returns array of all information from groups table from input $groupId
  */

  global $conn;
  $sql = "SELECT * FROM groups WHERE id = ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("i", $groupId);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    
    $row = $result->fetch_assoc();
    $row['teachers'] = json_decode($row['teachers']);
    return $row;
  }


}

function getQuestionById($questionId) {
  //Returns detail of SAQ_question_bank_3 from input id

  global $conn;
  $sql = "SELECT * FROM saq_question_bank_3 WHERE id = ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("i", $questionId);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    
    $row = $result->fetch_assoc();
    return $row;
  }


}

function getNewsArticlesByKeyword($keyword) {

  global $conn;

  $articles = array();

  $keywordSql = "%".$keyword."%";

  $sql = "SELECT * FROM news_data WHERE keyWords LIKE ? ORDER BY datePublished DESC";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("s", $keywordSql);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($articles, $row);
    }
  }

  return $articles;
}

function getNewsArticlesByTopic($topic) {

  global $conn;

  $articles = array();

  $topicSql = "%".$topic."%";

  $sql = "SELECT * FROM news_data WHERE topic LIKE ? ORDER BY datePublished DESC";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("s", $topicSql);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($articles, $row);
    }
  }

  return $articles;
}

function login_log($userid) {
  //Very simple: this function logs when a user has logged in. Used primarily wiht login.php
  global $conn;
  date_default_timezone_set('Europe/London');
  $datetime = date("Y-m-d H:i:s");
  $sql = "INSERT INTO login_log
          (userId, dateTime, last_url)
          VALUES (?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iss", $userid, $datetime, $_SESSION['last_url']);
  $stmt->execute();
}



function flashCardSummary($userid = null, $control = null, $where = null) {

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
    $sql = "SELECT COUNT(*) count ";
  }

  if($control =="count_category") {
    $sql = "SELECT gotRight, COUNT(*) count ";
  }
  if(($control =="average")||($control=="average_category")) {
    $sql = "SELECT gotRight, AVG(timeDuration) avg";
  }
  if($control == "count_by_date") {
    $sql = "SELECT date(timeSubmit) date, COUNT(*) count";
  }




    $sql .= " FROM flashcard_responses";

  if($control == "count_questions") {
    $sql = "SELECT r.questionId questionId, COUNT(*) count, q.question, q.topic
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

  //echo $sql;
  
  /*

  Sandbox:
  
  $sql = "SELECT r.questionId, COUNT(*), q.question, q.topic
          FROM flashcard_responses r
          LEFT JOIN (SELECT id, question, topic FROM saq_question_bank_3) q
            ON r.questionId = q.id
          GROUP BY r.questionId;

          
         
          ";
         */ 
          


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

function getFlashcardSummaryByQuestion($classid = null, $startDate = null, $endDate = null, $orderByInput = null) {
  /*
  Outputs a list of all flashcard questions created by userid=1. 
    Filter by:
    -classid: gives results for a particular class
    -startDate: sets boundary for earliest recored. Enter in Ymd format e.g. 20221213
    -endDate: sets boundary for most recent record. Default it today's date
    Order by:
    -dontknow
    -wrong
    -correct
      Each changes the filter values to show descending order by number got right.

  */

  global $conn;
  $responses = array();
  $users = "";
  if($classid) {
    $users = getGroupUsers($classid);
  }
  //Set end date to today's date if not declared in function
  if(!$endDate) {
    $endDate = date('Ymd');
  }
  //Set orderBy; default is q.topic:
  if(!$orderByInput) {
    $orderBy = "q.topic";
  } else if ($orderByInput == "dontknow") {
    $orderBy = "dontknow DESC";
  } else if ($orderByInput == "wrong") {
    $orderBy = "wrong DESC";
  } else if ($orderByInput == "correct") {
    $orderBy = "correct DESC";
  } else {
    $orderBy = "q.topic";
  }

  $sql = "SELECT q.id id, q.topic, q.question, COUNT(CASE r.gotRight WHEN 0 THEN 1 ELSE NULL END) dontknow, COUNT(CASE r.gotRight WHEN 1 THEN 1 ELSE NULL END) wrong, COUNT(CASE r.gotRight WHEN 2 THEN 1 ELSE NULL END) correct, q.img
        FROM saq_question_bank_3 q
        JOIN flashcard_responses r
        ON q.id = r.questionId
        WHERE q.userCreate = 1 AND q.type LIKE '%flashCard%'";
  
  //Clause to filter by $classid if set:
  if($classid) {
    $sql .= " AND r.userId IN (";
    foreach ($users as $key=>$array) {
      $sql .= " ".$array['id'];
      if($key < (count($users)-1)) {
        $sql .= ", ";
      }
    }
    $sql .= " ) ";
  }

  //Filter by date, if set
  if($startDate) {
    $sql .= " AND DATE(r.timeSubmit) BETWEEN ? AND ?";
  }
  $sql .= " GROUP BY q.id
            ORDER BY ".$orderBy;

  
  $stmt = $conn->prepare($sql);
  //$stmt->bind_param('',);
  if($startDate) {
    $stmt->bind_param('ss',$startDate, $endDate);
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


function loginLogReturn($limit = null) {
  global $conn;
  $responses = array();
  $sql = "SELECT l.*, u.name_first first, u.name_last last
          FROM login_log l
          LEFT JOIN users u
          ON l.userId = u.id
          ORDER BY dateTime DESC;

          ";

  $stmt=$conn->prepare($sql);
  //$stmt->bind_param("s", $topicSql);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($responses, $row);
    }
  }
return $responses;
}


?>