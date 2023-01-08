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

used in: 
- user/user_populate.php

*/


function getGroupsList($userId, $activeReturn = true, $userCreate = null) {
  global $conn;

  $userIdSql = '%\"'.$userId.'\"%';

  $sql = "SELECT * FROM groups WHERE teachers LIKE ? ";

  if($activeReturn == true) {
    $sql .= " AND active = 1 ";
  }

  if($userCreate) {
    $sql .= " AND userCreate = ?";
  }
  
  $stmt=$conn->prepare($sql);

  if($userCreate) {
    $stmt->bind_param("si", $userIdSql, $userCreate);
  } else {
  $stmt->bind_param("s", $userIdSql);
  }
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

//Used in group_manager.php:

function getSchoolUsers($schoolId, $type = "student", $active = true) {
  /*
  Returns array of userIds for which $schoolId is listed as school id
  */

  global $conn;
  $results = array();
  $sql = "SELECT id, name_first, name_last, username, permissions, email, schoolid, groupid_array, active
  FROM users
  WHERE schoolid = ?";

  if($type == "student") {
    $sql .= " AND permissions NOT LIKE '%teacher%' AND permissions NOT LIKE '%admin%' ";
  }

  if($active == true) {
    $sql .= " AND active = 1";
  }

  $sql .= " ORDER BY name_last";

  $stmt =  $conn->prepare($sql);
  $stmt->bind_param("i", $schoolId);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
  }
  return $results;

}


/*
Used in:
-user_manager.php
*/
function getUsercreateUsers($userCreate,  $active = true, $orderBy = "name_last") {

  /*
  Returns array of students for whom $userCreate was the userCreate
  */

  global $conn;
  $results = array();
  $sql = "SELECT id, name_first, name_last, username, permissions, email, schoolid, groupid_array, active, userCreate, password
  FROM users
  WHERE userCreate = ?";

if($active == true) {
  $sql .= " AND active = 1";
}

  if($orderBy == "name_last")  {
    $sql .= " ORDER BY name_last";
  }

  

  $stmt =  $conn->prepare($sql);
  $stmt->bind_param("i", $userCreate);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
  }
  return $results;

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
  $sql = " SELECT u.id, u.name, u.name_first, u.name_last, u.username, u.usertype, u.permissions, u.userInput_userType, u.email, u.schoolid, u.groupid, u.groupid_array, u.active, s.SCHNAME, s.userAdmin, s.permissions school_permissions
          FROM users u
          LEFT JOIN schools_dfe s
          ON u.schoolid = s.id
          WHERE u.id = ? ";
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


function loginLogReturn($limit = null, $likeName = null) {
  global $conn;
  $responses = array();
  $sql = "SELECT l.*, u.name_first first, u.name_last last
          FROM login_log l
          LEFT JOIN users u
          ON l.userId = u.id";

          if($likeName) {
            $sql .= " WHERE
                      u.name_first LIKE ?
                      OR
                      u.name_last LIKE ? ";
          }

  $sql .= "
          ORDER BY dateTime DESC;

          ";

  $stmt=$conn->prepare($sql);
  if($likeName) {
    $likeNameSearch = "%".$likeName."%";
    $stmt->bind_param("ss", $likeNameSearch, $likeNameSearch);
  }
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

//The following are used on school_creator.php:

function createSchool($name, $userAdmin, $postcode, $type, $userCreate) {
  global $conn;
  $date = date("Y-m-d H:i:s");
  $sql = "INSERT INTO schools
          (name, userAdmin, postcode, type, dateCreated, dateUpdate, userCreate)
          VALUES (?,?,?,?,?,?,?)
          ";
  
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("ssssssi", $name, $userAdmin, $postcode, $type, $date, $date, $userCreate);
  $stmt->execute();


}

function listSchools() {
  global $conn;
  $responses = array();
  $sql = "SELECT *
          FROM schools";
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

function editSchool($schoolId, $name, $userAdmin, $postcode, $type) {
  global $conn;
  $date = date("Y-m-d H:i:s");
  $sql = "UPDATE schools
          SET name =?, userAdmin =?, postcode=?, type =?, dateUpdate =?
          WHERE id = ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("sssssi", $name, $userAdmin, $postcode, $type, $date, $schoolId);
  $stmt->execute();

}

//The following is used in user\school_manager.php and takes data. This uses schools_dfe, which is a list of all schools in England.

function listSchoolsDfe($search = null, $schoolId = null) {
  global $conn;
  $responses = array();
  $sql = "SELECT *
          FROM schools_dfe
          WHERE ";
      if($search) {
        $sql .= "  (SCHNAME LIKE ? OR POSTCODE LIKE ?) AND ";
      }
      if($schoolId) {
        $sql .= " id = ? AND ";
      }
  $sql .= "SCHSTATUS = 'Open'
           LIMIT 100";
  $stmt=$conn->prepare($sql);
  if($search) {
    $search = "%".$search."%";
    $stmt->bind_param("ss", $search, $search);
  }
  if($schoolId) {
    $stmt->bind_param("i", $schoolId);
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

function editSchoolDfe($schoolId, $userAdmin) {
  global $conn;
  $date = date("Y-m-d H:i:s");
  $sql = "UPDATE schools_dfe
          SET userAdmin =?, dateUpdate =?
          WHERE id = ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("ssi", $userAdmin, $date, $schoolId);
  $stmt->execute();

}

//The following is used in school_registration.php to update a user profile with a School Id:
// Search register
function linkUserToSchool($userId, $schoolId) {
  global $conn;
  $sql = "UPDATE users
          SET schoolid =?
          WHERE id = ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("ii", $schoolId, $userId);
  $stmt->execute();
}

//Used in class_creator.php:

function createGroup($userCreate, $name, $subjectId, $schoolId, $teachers, $dateFinish, $optionGroup) {
  //Used to create a group or class

  global $conn;
  $date = date("Y-m-d H:i:s");
  $sql = "INSERT INTO groups
          (name, school, teachers, subjectId, optionGroup, dateFinish, active, userCreate, dateCreated)
          VALUES (?,?,?,?,?,?,?,?,?)
          ";
  $teachers = json_encode($teachers);
  $active = 1;
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("sisissiis", $name, $schoolId, $teachers, $subjectId, $optionGroup, $dateFinish, $active, $userCreate, $date);
  $stmt->execute();
  //echo "New record created";


};

function listSubjects() {
  global $conn;
  $responses = array();
  $sql = "SELECT *
          FROM subjects";
  $stmt=$conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($responses, $row);
    }
  }
return $responses;
  

}

function getTeachersBySchoolId($schoolId) {
  global $conn;
  $responses = array();
  $sql = "SELECT id, name, name_first, name_last, username, usertype, permissions, userInput_userType, email, schoolid, groupid, groupid_array, active 
  FROM users 
  WHERE permissions LIKE '%teacher%'
  AND schoolid = ? 
  ORDER BY name_last ASC";

  $stmt=$conn->prepare($sql);
  $stmt->bind_param("i", $schoolId);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($responses, $row);
    }
  }
  return $responses;


}


//The following suite of functions are used in pages that validate new user information


function validateUsername($username, $checkUsed = true) {

  /*
  This function takes as input $username : string and returns array with values:
  ['username_err'] => Message about why there is error with username;
  ['username_avail'] => Message if username is available.
  ['username_validate'] => Bool to show whether this input username is valid as username in app.
  */
  
  global $conn;
  $username_err = $username_avail = "";
  $username_validate =  $user_avail_validate = $user_rule_validate = 0;

  

  //USERNAME  
  //Check if username is already taken
  if(empty(trim($username))) {
    $username_err = "Please enter a username";
  } else {
    $username = trim($username);
    //Control to allow function to work without checking username (e.g. for use in update validations)
    if($checkUsed == true) {
      //Prepare statement to check username:
      $sql = "SELECT LOWER(username) FROM users WHERE username = ?";
      if($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $param_username);
        
        //Set parameters
        $param_username = strtolower($username);
        if($stmt->execute()) {
          $stmt->store_result();
          if ($stmt->num_rows>0) {
            $username_err = "<b>".$username."</b> is registered by another user. Please try another username.";
          } else {
            $username_avail = "Success! <b>".$username."</b> is available!";
            $user_avail_validate = 1;
          }
        }
      }
    } else ($user_avail_validate = 1);
  }

  //Check to see that username fits rules:
  
  /*
  //$regexp = "^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$";

  From: https://stackoverflow.com/questions/12018245/regular-expression-to-validate-username
  //$regexp = "/^[a-zA-Z0-9](_(?!(\.|_))|\.(?!(_|\.))|[a-zA-Z0-9]){6,18}[a-zA-Z0-9]$";
  //The above means it's Only contains alphanumeric characters, underscore and dot, Underscore and dot can't be at the end or start of a username (e.g _username / username_ / .username / username.)., Underscore and dot can't be next to each other (e.g user_.name)., Underscore or dot can't be used multiple times in a row (e.g user__name / user..name)., Number of characters must be between 8 to 20.

  //Follows these rules: Must start with letter, 6-32 characters, Letters and numbers only
  //$regexp = "/^[A-Za-z][A-Za-z0-9]{5,31}$/";
  */
  $regexp = "/^[a-zA-Z0-9](_(?!(\.|_))|\.(?!(_|\.))|[a-zA-Z0-9]){4,18}[a-zA-Z0-9]$/";

  if($username != "") {
    if(!preg_match($regexp, $username)) {
      $username_err = "'<b>$username</b>' is invalid.";
      $username_avail = "";
    } else {
      $user_rule_validate = 1;
    }
  }

  if ($user_avail_validate ==1 and $user_rule_validate ==1) {
    $username_validate = 1;
  }
 
  $results = array(
    'username_err' => $username_err, 
    'username_avail' => $username_avail,
    'username_validate' => $username_validate,
    'username' => $username);

  return $results;


}

function validatePassword($password1, $password2) {

  global $conn;
  $password_err = "";
  $password_validate = $pass_match_validate = $pass_match_validate = $pass_rule_validate = 0;

  //PASSWORD
  //Check to see if password meets criteria:
    if(empty(trim($password1)) and empty(trim($password2))) {
      $password_err = "Please enter a password";
    } else {
      $password1 = trim($password1);
      $password2 = trim($password2);

      if ($password1 != $password2) {
        $password_err = "Passwords to not match";
      }
      else {
        $pass_match_validate = 1;
        /*
        https://stackoverflow.com/questions/19605150/regex-for-password-must-contain-at-least-eight-characters-at-least-one-number-a

        Minimum eight characters, at least one uppercase letter, one lowercase letter and one number:
        "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$"
      
        Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character:
        "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
        
        Modified from previous two:  Minimum six characters, at least one uppercase letter, one lowercase letter and one number, MAY CONTAIN SPECIAL CHARACTERS
        "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,}$/"

        */
      $regexp = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,}$/";


        if(!preg_match($regexp, $password1)) {
          $password_err = "This password does not fit the criteria.";
        } else {
          $pass_rule_validate = 1;
        }
        
      }

    }
    if ($pass_match_validate ==1 and $pass_rule_validate==1) {
      $password_validate = 1;
    }

    $results = array(
      "password_err" => $password_err,
      "password_validate" => $password_validate,
      "password" => $password1
    );

    return $results;

}

function validateEmail($email) {

  global $conn;
  $email_err = "";
  $email_validate = 0;
  $email_name = "";

  //EMAIL
    //check to ensure valid email format:
      if(empty(trim($email))) {
        $email_err = "Please enter an email address";
      } else {
        $email_name = trim($email);

        if (!filter_var($email_name, FILTER_VALIDATE_EMAIL)) {
          $email_err = "<b>".$email_name."</b> is not a valid email address";
        } else {
            //Prepare statement to check email:
            $sql = "SELECT email FROM users WHERE email = ?";
            if($stmt = $conn->prepare($sql)) {
              $stmt->bind_param("s", $param_username);
              
              //Set parameters
              $param_username = $email_name;
              if($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows>0) {
                  $email_err = "This email address is already in use. Please try another.";
                } else {
                  $email_validate =1;
                }
              }
            }
        }
      }

    $results = array(
      "email_err" => $email_err,
      "email_validate" => $email_validate,
      "email"=> $email_name
    );

    return $results;

}

function insertNewUserIntoUsers($firstName, $lastName, $username, $password, $usertype, $email_name, $version, $privacy_bool = 0, $usertype_std = "student", $permissions = "student",  $active = 1, $schoolId = null, $userCreate = null, $groupIdArray = "", $passwordRecord = 0) {

  global $conn;

  //Enter new user information into users table
  $sql = "INSERT INTO users (name_first, name_last, username, password_hash, usertype, permissions, userInput_userType, email, active, time_added, privacy_agree, privacy_date, privacy_vers, schoolid, userCreate, groupid_array, password) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    
  $stmt = $conn->prepare($sql);
  
  $password_hash = password_hash($password, PASSWORD_DEFAULT);
  //$usertype_std =$permissions = "student";
  //$active = 1;
  $datetime = date("Y-m-d H:i:s");

  $passwordEntry = "";

  if($passwordRecord != 0) {
    $passwordEntry = $password;
  }

  $stmt->bind_param("ssssssssisissiiss", $firstName, $lastName, $username, $password_hash, $usertype_std, $permissions, $usertype, $email_name, $active, $datetime, $privacy_bool, $datetime, $version, $schoolId, $userCreate, $groupIdArray, $passwordEntry);
  $stmt->execute();



}


function updateGroupTeachers($groupId, $teacherId, $method = "add") {
  global $conn;
  $sql1 = "SELECT id, teachers
          FROM groups
          WHERE id = ?";
  $stmt=$conn->prepare($sql1);
  $stmt->bind_param("i", $groupId);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    $row1 = $result->fetch_assoc();
  }
  
  $listedTeachers = json_decode($row1['teachers']);

  if($method == "add") {
    if(array_search($teacherId, $listedTeachers) === false) {
      array_push($listedTeachers, $teacherId);
    }
  } 
  if($method == "remove") {
    if (($key = array_search($teacherId, $listedTeachers)) !== false) {
      unset($listedTeachers[$key]);
    }
  }
  $listedTeachers = json_encode($listedTeachers);

  $sql2 = "UPDATE groups
          SET teachers = ?
          WHERE id = ?";
  $stmt=$conn->prepare($sql2);
  $stmt->bind_param("si", $listedTeachers, $groupId);
  $stmt->execute();
  
  
}

function updateStudentGroup($groupId, $studentId, $method = "add") {
  global $conn;
  $sql = "SELECT id, groupid_array
          FROM users
          WHERE id = ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("i", $studentId);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    $row = $result->fetch_assoc();
  }
  $listedGroups = json_decode($row['groupid_array']);

  if($method == "add") {
    if(array_search($groupId, $listedGroups) === false) {
      array_push($listedGroups, $groupId);
    }
  } 
  if($method == "remove") {
    if (($key = array_search($groupId, $listedGroups)) !== false) {
      unset($listedGroups[$key]);
    }
  }
  $listedGroups = json_encode($listedGroups);
  $sql2 = "UPDATE users
          SET groupid_array = ?
          WHERE id = ?";
  $stmt=$conn->prepare($sql2);
  $stmt->bind_param("si", $listedGroups, $studentId);
  $stmt->execute();
  



}

function updateGroupInformation($groupId, $name, $subjectId, $optionGroup, $dateFinish) {

  global $conn;
  $sql = "UPDATE groups
          SET name =?, subjectId = ?, optionGroup =?, dateFinish = ?
          WHERE id = ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("sissi", $name, $subjectId, $optionGroup, $dateFinish, $groupId);
  $stmt->execute();
}

function updateUserInfo($userId, $name_first, $name_last, $username, $password, $active) {
  global $conn;
  $sql = "UPDATE users
  SET name_first =?, name_last = ?, username =?, password = ?, password_hash = ?, active = ?
  WHERE id = ?";

  $password_hash = password_hash($password, PASSWORD_DEFAULT);

  $stmt=$conn->prepare($sql);
  $stmt->bind_param("sssssii", $name_first, $name_last, $username, $password, $password_hash, $active, $userId);
  $stmt->execute();

}


//Used in mcq_review.php

function getMCQquizResults($userId, $responseId = null) {
  global $conn;
  $responses = array();

  //AAAHHH fix the responses table to have quizID, not join on quiz_name!!!
  $sql = "SELECT r.*, a.assignName, a.id assignId, a.dateDue
          FROM responses r
          
          LEFT JOIN assignments a
          ON r.assignID = a.id
          WHERE userID = ?
          ORDER BY r.id";

  if($responseId) {
    $sql = "SELECT r.*, u.name_first, u.name_last
            FROM responses r
            LEFT JOIN users u
            ON r.userID = u.id
            WHERE r.id = ?";
  }

  $stmt= $conn->prepare($sql);
  $stmt->bind_param("i", $userId);
  if($responseId) {
    $stmt->bind_param("i", $responseId);
  }
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($responses, $row);
    }
  }
  if ($responseId) {
    $responses = $responses[0];
    if ($responses['userID'] != $userId) {
      return array();
    }
  }
  return $responses;

}

function getMCQresponseByUsernameTimestart($userId, $timeStart) {
  //returns $responseId: the id of the entry in the response table
  global $conn;
  $responseId = "";
  $sql = "SELECT * FROM responses WHERE userID= ? AND timeStart= ?";
  $stmt = $conn->prepare($sql);
      $stmt->bind_param("is", $userId, $timeStart);
      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows>0) {
        $row = $result->fetch_assoc();
        $responseId = $row;
      }
    return $responseId['id'];


}

?>