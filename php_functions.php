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
-user/group_manager.php
-assign_create1.0.php
-assignment_list.php
-mcq_assignment_review.php

*/


function getGroupsList($userId, $activeReturn = true, $userCreate = null) {
  global $conn;

  $userIdSql = '%\"'.$userId.'\"%';

  $sql = "SELECT * 
          FROM groups 
          WHERE teachers LIKE ? ";

  if($activeReturn == true) {
    $sql .= " AND active = 1 ";
  }

  if($userCreate) {
    $sql .= " AND userCreate = ?";
  }

  $sql .= " ORDER BY dateFinish";
  
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
  -mcq_assignment_review.php 
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

function getAssignmentsListByTeacher($teacherId, $limit = 1000, $classId = null) {
  /*
  This function is distinct from getAssignmentsList because it filters by teachers associatd with the class rather than the userCreate.
  */
  global $conn;
  $teacherIdSql = "%\"".$teacherId."\"%";

  $sql = "SELECT a.*, g.teachers
          FROM assignments a
          LEFT JOIN groups g
          ON a.groupid = g.id
          WHERE g.teachers LIKE ? ";

  if($classId) {
    $sql .= " AND a.groupid = ? ";
  }

  $sql .= " ORDER BY dateCreated desc
          LIMIT ?";

  $stmt=$conn->prepare($sql);
  if(!$classId) {
    $stmt->bind_param("si", $teacherIdSql, $limit);
  } else {
    $stmt->bind_param("sii", $teacherIdSql, $classId, $limit);
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
  $sql = " SELECT u.id, u.name, u.name_first, u.name_last, u.username, u.usertype, u.permissions, u.userInput_userType, u.email, u.schoolid, u.groupid, u.groupid_array, u.active, s.SCHNAME, s.userAdmin, s.permissions school_permissions, u.userPreferredSubjectId
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
  
  $sql .= ") AND dateDue > CURRENT_TIMESTAMP()
  ORDER BY dateDue ASC";

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


function getAssignmentsArray($groupIdArray, $startDate = null, $markBookShow = 1) {

  /*
  This function generates an array of assigned work. Input is an array (in JSON form) of the groups that a studnet is listed in.
  $startDate is the first date when results are to be output by. format is e.g. 20221203
  */

  global $conn;

  $groupIdSql = array();

  $list = array();
  $paramType = "";

  $sql = "SELECT * FROM assignments 
          WHERE true = true ";

  if(count($groupIdArray) > 0) {
  
  $sql .= " AND (";

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
  }

  

  if($startDate) {
    $sql .= " AND dateDue > ? ";
    array_push($groupIdSql, $startDate);
    $paramType .= "s";
  }

  if($markBookShow == 1) {
    $sql .= " AND markBookShow = 1 ";
  }

  $sql .= " ORDER BY dateDue ";




  //echo $sql."<br>".$paramType;
  $stmt = $conn->prepare($sql);
  if(count($groupIdSql) > 0) {
    $stmt->bind_param($paramType, ...$groupIdSql);
  }
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      array_push($list, $row);
    }
  }

  if(count($groupIdArray) == 0) {
    $list = array();
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


function getMCQquizzesByTopic($topic = null) {
  /*
  This function returns an array of all entries from mcq_quizzes table that match a $topic category

  Used in:
  -assign_create1.0
  */

  global $conn;
  $quizzes = array();
  $sql = "SELECT * FROM mcq_quizzes ";
  if($topic != null) {
    $sql .= " WHERE topic LIKE ?";
  }
  $stmt=$conn->prepare($sql);
  if($topic != null) {
    $stmt->bind_param("s", $topic);
  }
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    
    while($row = $result->fetch_assoc()){
      array_push($quizzes, $row);
      
    }
    return $quizzes;
  }
  

}

function getMCQquizDetails($id=null, $topic = null, $questionId = null, $userCreate = null, $active = null, $topicQuiz = null) {
  /*
  This function is updated from previous two, used to pull information for MCQ quizzes
  */
  
  global $conn;

  $results = array();

  $params = "";
  $bindArray = array();
  $conjoiner = 0;

  $sql = " SELECT * 
          FROM mcq_quizzes ";

  if($id) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " id = ? ";
    $params .= "i";
    array_push($bindArray, $id);
  }

  if($topic) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " topic LIKE ? ";
    $topic = "%".$topic."%";
    $params .= "s";
    array_push($bindArray, $topic);
  }

  if($questionId) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " questions_array LIKE ? ";
    $questionId = "%\"".$questionId."\"%";
    $params .= "s";
    array_push($bindArray, $questionId);
  }

  if($userCreate) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " userCreate = ? ";
    $params .= "i";
    array_push($bindArray, $userCreate);
  }

  if($active) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " active = ? ";
    $params .= "i";
    array_push($bindArray, $active);
  }

  if($topicQuiz) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " topicQuiz = ? ";
    $params .= "i";
    array_push($bindArray, $topicQuiz);
  }

  $stmt = $conn->prepare($sql);
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
  }

  return $results;

}

function updateMCQquizDetails($id, $topic, $quizName, $notes, $description, $active, $topicQuiz) {
  /*
  A function to update values in mcq_quizzes table
  Used in:
  -quizlist.php
  */

  global $conn;

  $sql = " UPDATE mcq_quizzes 
          SET topic = ?, quizName = ?, notes = ?, description = ?, active = ?, topicQuiz = ?
          WHERE id = ?";
          $stmt=$conn->prepare($sql);
  $stmt->bind_param("ssssiii", $topic, $quizName, $notes, $description, $active, $topicQuiz, $id);
  $stmt->execute();


  


}

function createMCQquiz($userCreate, $questions_id, $quizName, $topic, $notes, $description) {
  /*
  This function creates new MCQ quiz in table mcq_quizzes
  Used in:
  -mcq/quizcreate.php
  */
  global $conn;

  $datetime = date("Y-m-d H:i:s");
  $active = 1;
  $questions_nos = array();
  $questions_id = explode(",", $questions_id);

  foreach($questions_id as $question) {
    $questionNo = getMCQquestionDetails2($question)[0]['No'];
    array_push($questions_nos, $questionNo);
  }
  $questions_nos = implode(", ",$questions_nos);

  $questions_array = json_encode($questions_id);

  $questions_id = implode(",", $questions_id);


  $sql = "INSERT INTO mcq_quizzes
          (userCreate, questions_id, quizName, topic, notes, description, questions, questions_array, dateCreated, active)
          VALUES (?,?,?,?,?,?,?,?,?,?)";
  
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("issssssssi", $userCreate, $questions_id, $quizName, $topic, $notes, $description, $questions_nos, $questions_array, $datetime, $active);
   $stmt->execute();

   return "New quiz created successfully";
   


}

function getMCQquestionDetails($id = null, $questionNo = null, $topic = null, $keyword = null, $search = null) {

  /*
  This function will call details for individual MCQ questions.
  
  Used in:
  -mcq_questions.php
  -user_mcq_review.php
  -mcq_assignment_review.php
  */

  global $conn;
  $results = array();

  $params = "";
  $bindArray = array();
  $conjoiner = 0;

  $sql ="SELECT q.id, q.No, q.Answer, q.Topic, q.topics, q.keywords, q.question, q.options, q.explanation, q.examBoard, q.component, q.assetId, q.unitName, q.qualLevel, q.textOnly, q.topicsAQA, q.topicsEdexcel, q.topicsOCR, q.topicsCIE, a.path
        FROM question_bank_3 q
        LEFT JOIN upload_record a
          ON a.id = q.assetId";

  

  if($id) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " q.id = ?";
    $params .= "i";
    array_push($bindArray, $id);
  }

  if($questionNo) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= "  No LIKE ?";
    $quesitonNo = $questionNo."%";
    $params .= "s";
    array_push($bindArray, $quesitonNo);

  }

  if($topic) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " topic = ?";
    $params .= "s";
    array_push($bindArray, $topic);
  }

  if($keyword) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " keywords LIKE ?";
    $params .= "s";
    $keyword = "%".$keyword."%";
    array_push($bindArray, $keyword);
  }

  if($search) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $search = "%".$search."%";
    $sql .= " ( keywords LIKE ?";
    $params .= "s";
    array_push($bindArray, $search);
    $sql .= " OR question LIKE ?";
    $params .= "s";
    array_push($bindArray, $search);
    $sql .= " OR options LIKE ? ) ";
    $params .= "s";
    array_push($bindArray, $search);

  }



  //echo $sql;
  //echo "<br>";
  //print_r($bindArray);

  $stmt=$conn->prepare($sql);
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }
  
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
  }
  
  if (!$topic && count($results) == 1) {
    $results = $results[0];
  }
  
  return $results;



}

function getMCQquestionDetails2($id = null, $questionNo = null, $topic = null, $keyword = null, $search = null, $orderBy = null, $examBoard = null, $year = null) {

  /*
  This function will call details for individual MCQ questions.

  This is the improved version, copied from getMCQauestionDetails() on 29.11.2023. This improved version does not replace single-array output as a single array.
  
  Used in:
  -quizcreate.php
  */

  global $conn;
  $results = array();

  $params = "";
  $bindArray = array();
  $conjoiner = 0;

  $sql ="SELECT q.id, q.No, q.Answer, q.Topic, q.topics, q.keywords, q.question, q.options, q.explanation, q.examBoard, q.component, q.assetId, q.unitName, q.qualLevel, q.textOnly, q.topicsAQA, q.topicsEdexcel, q.topicsOCR, q.topicsCIE, q.series, q.year, q.questionNo, q.noRandom, q.similar, q.relevant, a.path
        FROM question_bank_3 q
        LEFT JOIN upload_record a
          ON a.id = q.assetId";

  

  if($id) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " q.id = ?";
    $params .= "i";
    array_push($bindArray, $id);
  }

  if($questionNo) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= "  No LIKE ?";
    $quesitonNo = $questionNo."%";
    $params .= "s";
    array_push($bindArray, $quesitonNo);

  }

  if($topic) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " topic = ?";
    $params .= "s";
    array_push($bindArray, $topic);
  }

  if($keyword) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " keywords LIKE ?";
    $params .= "s";
    $keyword = "%".$keyword."%";
    array_push($bindArray, $keyword);
  }

  if($search) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $search = "%".$search."%";
    $sql .= " ( keywords LIKE ?";
    $params .= "s";
    array_push($bindArray, $search);
    $sql .= " OR question LIKE ?";
    $params .= "s";
    array_push($bindArray, $search);
    $sql .= " OR options LIKE ? ) ";
    $params .= "s";
    array_push($bindArray, $search);

  }

  if($examBoard) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " examBoard = ?";
    $params .= "s";
    array_push($bindArray, $examBoard);
  }

  if($year) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " year = ?";
    $params .= "s";
    array_push($bindArray, $year);
  }

  if($orderBy) {
    if($orderBy == "question") {
      $sql .= " ORDER BY TRIM(question) ";
    }
  }

  //echo $sql;
  //echo "<br>";
  //print_r($bindArray);

  $stmt=$conn->prepare($sql);
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }
  
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
  }
  
  
  return $results;

}

function updateMCQquestionExplanation($id, $explanation) {
  /*
  Designed soley to update MCQ Question Explanation
  */

  global $conn;
  $sql = "UPDATE question_bank_3
  SET explanation = ?
  WHERE id = ?";

  $stmt=$conn->prepare($sql);
  $stmt->bind_param("si", $explanation, $id);
  $stmt->execute();

}

function updateMCQquestion($id, $userId, $explanation, $question, $optionsJSON, $topic, $topics, $answer, $keywords, $textOnly, $relevant, $similar) {
  /*
  Used to update MCQ question information with id = $id

  Used in: mcq_questions.php
  */

  global $conn;

  $currentExplanation = "";

  $sql = "SELECT explanation
          FROM question_bank_3
          WHERE id = ?";
  
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    $row = $result->fetch_assoc();
    $currentExplanation = $row['explanation'];
  }

  $currentExplanation = json_decode($currentExplanation);
  $currentExplanation = (array) $currentExplanation;
  if($explanation == "") {
    unset($currentExplanation[$userId]);
  } else {
    $currentExplanation[$userId] = $explanation;
  }
  //print_r($currentExplanation);
  $currentExplanation = json_encode($currentExplanation);
  updateMCQquestionExplanation($id, $currentExplanation);

  $similar_array = explode(",",$similar);
  $similar_array = json_encode($similar_array);

  
  //Update other values that are not explanation:
  $sql = "UPDATE question_bank_3
          SET question = ?, options = ?, Topic = ?, topics = ?, Answer = ?, keywords = ?, textOnly = ?, relevant = ?, similar = ?, similar_array = ?
          WHERE id = ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("ssssssiissi", $question, $optionsJSON, $topic, $topics, $answer, $keywords, $textOnly, $relevant, $similar, $similar_array, $id);
  $stmt->execute();

}

function insertMCQquestion($userCreate, $questionCode, $questionNo, $examBoard, $level, $unitNo, $unitName, $year, $questionText, $options, $answer, $assetId, $topic, $topics, $keyWords) {
  /*
  This function inserts a new MCQ question.
  Used in:
  -mcq/mcq_questions.php
  */

  global $conn;
  date_default_timezone_set('Europe/London');
  $datetime = date("Y-m-d H:i:s");
  $active = 1;

  $sql = "INSERT INTO question_bank_3
          (userCreate, No, questionNo, examBoard, qualLevel, component, unitName, year, question, options, Answer, assetId, Topic, topics, keywords, dateCreate, active)
          VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("issssssssssissssi", $userCreate, $questionCode, $questionNo, $examBoard, $level, $unitNo, $unitName, $year, $questionText, $options, $answer, $assetId, $topic, $topics, $keyWords, $datetime, $active);
  $stmt->execute();


}

function markMCQquestion($questionId, $response) {

  /*
  This function will mark an MCQ question with $questionId and given $response
  */

  $questionDetails=getMCQquestionDetails2($questionId)[0];
  $correctAnswer = $questionDetails['Answer'];
  $correctAnswer = strtolower($correctAnswer);
  $response = strtolower($response);

  if(str_contains($correctAnswer, $response)) {
    return 1;
  } else {
    return 0;
  }
}

function insertMCQRecord($record, $userid, $startTime, $quizid, $assignid) {
  /*
  This function will insert a new record from a completed MCQ quiz

  Used in:
  - mcq_exercise.php
  */

  global $conn;

  //print_r($record);
  $record2 = array();
  $score = 0;

  $quiz = getMCQquizInfo($quizid);
  $quizname = $quiz['quizName'];

  $timeStart = $startTime;
  $timeEnd = date("Y-m-d H:i:s");

  foreach($record as $key => $response) {
    $questionRecord = array();
    $question = getMCQquestionDetails($key);
    //print_r($question);
    array_push($questionRecord, $question['No']);
    array_push($questionRecord, $response);
    array_push($questionRecord, $question['Answer']);
    $bool = false;
    if($response == $question['Answer']) {
      $bool = true;
      $score ++;
    }
    array_push($questionRecord, $bool);
    array_push($questionRecord, $key);
    array_push($record2, $questionRecord);

  }
  $record2 = json_encode($record2);
  //echo $record2;

  $percentage = round(($score/count($record))*100, 2);

  $sql = "INSERT INTO `responses` (`answers`, `mark`, `percentage`, `quiz_name`, `timeStart`, `datetime`, `assignID`, `userID`, `quizId`) VALUES (?,?,?,?,?,?,?,?,?)";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssssiii", $record2, $score, $percentage, $quizname, $timeStart, $timeEnd, $assignid, $userid, $quizid);

  // This element is added to ensure that  the same completed assignment is not submitted twice

  $sql2 = "SELECT * FROM responses WHERE userID= ? AND timeStart= ?";

  $stmt2 = $conn->prepare($sql2);
  $stmt2->bind_param("is", $userid, $timeStart);
  $stmt2->execute();
  $result2 = $stmt2->get_result();

  if($result2->num_rows == 0) {
    $stmt->execute();
  }

  //echo "Record entered successfully";

  $responseId= getMCQresponseByUsernameTimestart($userid, $timeStart);


  return $responseId;
  
  

}

function insertMCQquestionResponse($userid, $questionid, $response, $startTime, $endTime, $submitTime, $quizid, $assignid, $instanceOrder = 0) {
  /*
  This function will insert individual question responses to mcq_responses_questions table
  */

  global $conn;

  $recordTime = date("Y-m-d H:i:s");

  if($submitTime == null) {
    $submitTime = date("Y-m-d H:i:s");
  }

  $sql = "INSERT INTO mcq_responses_questions (userId, questionId, answer, startTime, endTime, submitTime, correct, quizId, assignId, instance_order, recordTime) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

  $correct = markMCQquestion($questionid, $response);

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iissssiiiis", $userid, $questionid, $response, $startTime, $endTime, $submitTime, $correct, $quizid, $assignid, $instanceOrder, $recordTime);

  $stmt->execute();  

}

//SAQ Question handling

function getExercises($table, $topic = null, $userCreate = null) {
  /*
  This function gets information on all SAQ or NDE excercises

  Used in: 
  -saq_list1.1.php
  */
  global $conn;
  $results = array();
  $sql = "SELECT * FROM ".$table;
  $switchVar = "";
  
  if($topic || $userCreate) {
    $sql .= " WHERE ";
  }
  if($topic) {
    $sql .= " topic = ? ";
    $switchVar .= "topic";
  }

  if($topic && $userCreate) {
    $sql .= " AND ";
  }

  if($userCreate) {
    $sql .= " userCreate = ?";
    $switchVar .= "userCreate";
  }

  $stmt=$conn->prepare($sql);
  
  switch ($switchVar) {
    case "topic":
      $stmt->bind_param("s", $topic);
      break;
    case "userCreate":
      $stmt->bind_param("i", $userCreate);
      break;
    case "topicuserCreate":
      $stmt->bind_param("si", $topic, $userCreate);
      break;
  }
  
  //$stmt->bind_param("s", $topic);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    
    while($row = $result->fetch_assoc()){
      array_push($results, $row);
      
    }
    return $results;
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

  

  /*
  Used in: 
  -saq/saq2.0.php

  Depricated as now there is getSAQQsuestions()
  */


  global $conn;
  $sql = "SELECT * 
          FROM saq_question_bank_3
          WHERE id = ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("i", $questionId);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    
    $row = $result->fetch_assoc();
    return $row;
  }


}

function getQuestionInfo($questionId = null) {
  /*
  Updated version of above function, geteQuestionById

  Used to find details of SAQ questions by given parameters
  Used in:
  -


  Depricated as now there is getSAQQsuestions()
  */

  global $conn;
  $params="";
  $bindArray = array();
  $results = array();

  $sql = "SELECT *
          FROM saq_question_bank_3";

  if($questionId) {
    $sql .= " WHERE id = ? ";
    $params .= "i";
    array_push($bindArray, $questionId);
  }

  $stmt=$conn->prepare($sql);
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }

  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
  }
  return $results;


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

function getNewsArticles($id =null, $keyword=null, $topic=null, $startDate=null, $endDate=null, $orderBy = null, $userCreate = null, $limit = null, $searchFor = null, $link = null, $bbcPerennial = null, $active = null, $withImages = null, $video = null, $audio = null) {
  global $conn;
  $articles = array();

  $bindArray = array();
  $params = "";
  $conjoiner = 0;

  $tableAlias = "";


  $sql = "SELECT d.*, u.path FROM news_data d
          LEFT JOIN upload_record u
          ON d.articleAsset = u.id ";


  if($id) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= $tableAlias;
    $sql .= "d.id = ? ";
    array_push($bindArray, $id);
    $params .= "i";
  }

  if($keyword) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " keyWords LIKE ? ";
    $keyword = "%".$keyword."%";
    array_push($bindArray, $keyword);
    $params .= "s";
  }

  if($topic) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " topic LIKE ? ";
    $topic = "%".$topic."%";
    array_push($bindArray, $topic);
    $params .= "s";
  }

  if($startDate) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " datePublished > ? ";
    //$keyword = "%".$keyword."%";
    array_push($bindArray, $startDate);
    $params .= "s";
  }

  if($endDate) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " datePublished < ? ";
    //$keyword = "%".$keyword."%";
    array_push($bindArray, $endDate);
    $params .= "s";
  }

  if($userCreate) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= $tableAlias;
    $sql .= "user = ? ";
    array_push($bindArray, $userCreate);
    $params .= "i";
  }

  if($searchFor) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= $tableAlias;
    //$searchFor = strtolower($searchFor);
    $searchFor = "%".$searchFor."%";
    $sql .= " ( explanation LIKE ? OR explanation_long LIKE ? OR keyWords LIKE ? OR headline LIKE ?) ";
    array_push($bindArray, $searchFor);
    array_push($bindArray, $searchFor);
    array_push($bindArray, $searchFor);
    array_push($bindArray, $searchFor);
    $params .= "ssss";
  }

  if($link) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoin = 1;
    $sql .= " link LIKE ? ";
    $link = "%".$link."%";
    array_push($bindArray, $link);
    $params .= "s";
    $conjoiner = 1;
  }

  if($bbcPerennial) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoin = 1;
    $sql .= " bbcPerennial LIKE ? ";
    array_push($bindArray, $bbcPerennial);
    $params .= "i";
    $conjoiner = 1;
  }

  if($active) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " active = 1 ";
  }

  if($withImages) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " photoAssets <> '' OR photoLinks <> '' ";
  }

  if($video) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " video = 1 ";
  }

  if($audio) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " audio = 1 ";
  }

  



  if(is_null($orderBy)) {
    $sql .= " ORDER BY datePublished DESC";
  }
  else {
    if($orderBy == "dateCreated") {
      $sql .= "ORDER BY dateCreated DESC";
    }
  }

  if($limit) {
    $limit = intval($limit);
    $sql .= " LIMIT ".$limit." ";
  }

  
  //echo $params;
  //print_r($bindArray);
  //echo $sql;
  

  $stmt=$conn->prepare($sql);
  if(count($bindArray) > 0) {
    $stmt->bind_param($params, ...$bindArray);
  }
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($articles, $row);
    }
  }

  

  return $articles;


}

function insertNewsArticle($headline, $hyperlink, $datePublished, $explanation, $explanation_long, $topic, $datetime, $keyWords, $userid, $active) {
  global $conn;

  $sql = "INSERT INTO news_data (headline, link, datePublished, explanation, explanation_long, topic, keyWords, dateCreated, user, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssssssii", $headline, $hyperlink, $datePublished, $explanation, $explanation_long, $topic, $keyWords, $datetime, $userid, $active);
  $stmt->execute();
  return "New record created successfully";

}

function updateNewsArticle($id, $headline = null, $datePublished = null, $explanation = null, $explanation_long = null, $keyWords = null, $link = null, $articleAsset =null, $active = null, $bbcPerennial = null, $photoAssets = null, $topic = null, $video = null, $audio = null, $photoLinks = null, $questions_array = null) {
  /*
  Function to update news_data with new values for given id
  Used in:
  -news_input.php
  */

  global $conn;
  $params = "";
  $bindArray = array();
  $conjoiner = 0;

  $sql = "UPDATE news_data
          SET ";

  if(!is_null($headline)) {
    $sql .= " headline = ? ";
    $params .= "s";
    array_push($bindArray, $headline);
    $conjoiner = 1;
  }

  if(!is_null($datePublished)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " datePublished = ? ";
    $params .= "s";
    array_push($bindArray, $datePublished);
    $conjoiner = 1;
  }

  if(!is_null($explanation)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " explanation = ? ";
    $params .= "s";
    array_push($bindArray, $explanation);
    $conjoiner = 1;
  }

  if(!is_null($explanation_long)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " explanation_long = ? ";
    $params .= "s";
    array_push($bindArray, $explanation_long);
    $conjoiner = 1;
  }

  if(!is_null($keyWords)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " keyWords = ? ";
    $params .= "s";
    array_push($bindArray, $keyWords);
    $conjoiner = 1;
  }

  if(!is_null($link)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " link = ? ";
    $params .= "s";
    array_push($bindArray, $link);
    $conjoiner = 1;
  }

  if(!is_null($articleAsset)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " articleAsset = ? ";
    $params .= "i";
    array_push($bindArray, $articleAsset);
    $conjoiner = 1;
  }

  if(!is_null($active)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " active = ? ";
    $params .= "i";
    array_push($bindArray, $active);
    $conjoiner = 1;
  }

  if(!is_null($bbcPerennial)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " bbcPerennial = ? ";
    $params .= "i";
    array_push($bindArray, $bbcPerennial);
    $conjoiner = 1;
  }

  if(!is_null($photoAssets)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " photoAssets = ? ";
    $params .= "s";
    array_push($bindArray, $photoAssets);
    $conjoiner = 1;
  }

  if(!is_null($topic)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " topic = ? ";
    $params .= "s";
    array_push($bindArray, $topic);
    $conjoiner = 1;
  }

  if(!is_null($video)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " video = ? ";
    $params .= "i";
    array_push($bindArray, $video);
    $conjoiner = 1;
  }

  if(!is_null($audio)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " audio = ? ";
    $params .= "i";
    array_push($bindArray, $audio);
    $conjoiner = 1;
  }

  if(!is_null($photoLinks)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " photoLinks = ? ";
    $params .= "s";
    array_push($bindArray, $photoLinks);
    $conjoiner = 1;
  }

  if(!is_null($questions_array)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " questions_array = ? ";
    $params .= "s";
    array_push($bindArray, $questions_array);
    $conjoiner = 1;
  }

  $sql .= " WHERE id = ? ";
  $params .= "i";
  array_push($bindArray, $id);

  //echo $sql;
  //echo $params;
  //print_r($bindArray);

  $stmt=$conn->prepare($sql);
  //Note that this only runs if $bindArray is greater than 1 because 'WHERE id = ?' is not dependent on input. Usually '  if(count($bindArray)>0) '
  if(count($bindArray)>1) {
    $stmt->bind_param($params, ...$bindArray);
    $stmt->execute();
  }

  

  return $sql;




}

function insertNewsQuestion($question, $questionId, $answer, $answerId, $userId, $topic, $articleId) {
  /*
  Used in:
  -newsQuestionsList.php
  */

  global $conn;
  
  $sql = "INSERT INTO news_questions
          (question, model_answer, questionAssetId, answerAssetId, userCreate, topic, articleId)VALUES (?,?,?,?,?,?,?)";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("ssssisi", $question, $answer, $questionId, $answerId, $userId, $topic, $articleId);
   $stmt->execute();
   return "New record created successfully";



}

function updateNewsQuestion($id, $userId, $question = null, $questionId = null, $answer = null, $answerId = null, $topic = null, $articleId = null) {
  /*
  Function to update news_questions with new value for given id
  Used in:
  -newsQuestionsList.php
  */

  global $conn;
  $params = "";
  $bindArray = array();
  $conjoiner = 0;

  $sql = "UPDATE news_questions
          SET ";

  if(!is_null($question)) {
    $sql .= " question = ? ";
    $params .= "s";
    array_push($bindArray, $question);
    $conjoiner = 1;
  }

  if(!is_null($questionId)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " questionAssetId = ? ";
    $params .= "s";
    array_push($bindArray, $questionId);
    $conjoiner = 1;
  }

  if(!is_null($answer)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " model_answer = ? ";
    $params .= "s";
    array_push($bindArray, $answer);
    $conjoiner = 1;
  }

  if(!is_null($answerId)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " answerAssetId = ? ";
    $params .= "s";
    array_push($bindArray, $answerId);
    $conjoiner = 1;
  }

  if(!is_null($topic)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " topic = ? ";
    $params .= "s";
    array_push($bindArray, $topic);
    $conjoiner = 1;
  }

  if(!is_null($articleId)) {
    $sql .= ($conjoiner ==1) ? ", " : "";
    $sql .= " articleId = ? ";
    $params .= "i";
    array_push($bindArray, $articleId);
    $conjoiner = 1;
  }

  $sql .= " WHERE id = ? ";
  $params .= "i";
  array_push($bindArray, $id);

  //echo $sql;
  //echo $params;
  //print_r($bindArray);

  $stmt=$conn->prepare($sql);
  //Note that this only runs if $bindArray is greater than 1 because 'WHERE id = ?' is not dependent on input. Usually '  if(count($bindArray)>0) '
  if(count($bindArray)>1) {
    $stmt->bind_param($params, ...$bindArray);
    $stmt->execute();
    return $sql;
  }

  //Check to see that the user has the right to update:

  $newsQuestion = getNewsQuestion($id)[0];
  $newsQuestionOwner = $newsQuestion['userCreate'];
  

  if($newsQuestionOwner == $userId) {
    //$stmt->execute();
    return "Record ".$newsQuestion['id']." updated successfully";
  } else {
    return "Error: User does not have editing permissions.".$newsQuestionOwner." ".$userId;

  }
  
  return $newsQuestion;



  
  

}

function getNewsQuestion($id=null) {
  global $conn;
  $results = array();

  $bindArray = array();
  $params = "";
  $conjoiner = 0;

  $sql = "SELECT * from news_questions ";

  if(!is_null($id)) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $conjoiner = 1;
    $sql .= " id = ? ";
    array_push($bindArray, $id);
    $params .= "i";

  }

  $stmt=$conn->prepare($sql);
  if(count($bindArray) > 0) {
    $stmt->bind_param($params, ...$bindArray);
  }
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
  }

  return $results;

}

function login_log($userid) {
  //Very simple: this function logs when a user has logged in. Used primarily wiht login.php. Also used in newuser upon first registration.
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
    -startDate: sets boundary for earliest recored. Enter in Y-m-d format e.g. 2022-12-13
    -endDate: sets boundary for most recent record. Default it today's date
    Order by:
    -dontknow
    -wrong
    -correct
      Each changes the filter values to show descending order by number got right.

  */

  global $conn;

  //Set end date to today's date if not declared in function
  if(is_null($endDate) or $endDate == "") {
    $endDate = date('Ymd');
  } else {
    $endDate = date('Ymd', strtotime($endDate));
  }
  if($startDate == "") {
    $startDate = null;
  }
  if(!is_null($startDate)) {
    $startDate = date('Ymd', strtotime($startDate));
  }


  $responses = array();
  $users = "";
  if($classid) {
    $users = getGroupUsers($classid);
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
        WHERE ";
        /*q.userCreate = 1 AND */
        
        $sql .= " q.flashCard = 1";
  
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

  //echo $sql;

  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($responses, $row);
    }
  }

  
  return $responses;

}

function getFlashcardSummaryByStudent($userId, $startDate = null, $endDate = null) {
  /*
  Returns
  */

}

function getFlashcardsQuestions($topics = null, $userId, $subjectId = null, $topicIds = null) {
  /*
  This function returns Flashcard quesiton information that will then be used in flashcards.php. This will return information on all flashcard questions in a the database given the filter, plus information on the last time a given $userId has attempted the question. Returns a ranked array of questions that can then be used to generate flashcards.php

  used in: 
  -flashcards.php
  */
  global $conn;
  $results = array();
  $params = "ii";
  $bindArray = array($userId, $userId);
  $conjoiner = 0;
  


  $sql = "SELECT q.id qId, r.id rId, q.question, q.topic, q.img, q.model_answer, q.answer_img, q.answer_img_alt, q.flashCard, q.subjectId, q.topicId topicId, r.userId, r.gotRight, r.dontKnow, r.correct, r.timeStart, r.timeSubmit, r.most_recent, r.cardCategory, q.questionAssetId, aq.path q_path, aq.altText q_alt, aa.path a_path, aa.altText a_alt
          FROM saq_question_bank_3 q
          LEFT JOIN (
            SELECT rr.id, rr.questionId, rr.userId, rr.timeSubmit, rr.gotRight, rr.dontKnow, rr.correct, rr.cardCategory, t.most_recent, rr.timeStart
            FROM flashcard_responses rr
            INNER JOIN (
              SELECT questionId, MAX(timeSubmit) as most_recent
              FROM flashcard_responses
              WHERE userId = ?
              GROUP BY questionId
            ) t
            ON rr.questionId = t.questionId AND rr.timeSubmit = t.most_recent
            WHERE rr.userId = ?
            ) r
          ON q.id = r.questionId
          LEFT JOIN upload_record aq
          ON q.questionAssetId = aq.id
          LEFT JOIN upload_record aa
          ON q.answerAssetId = aa.id
          LEFT JOIN topics_all topic
          ON topic.id = q.topicId

          WHERE ";

  if($topics) {
    $topics = explode(",", $topics);
    $conjoiner = 1;
    $numTopics = count($topics);
    $placeholder = str_repeat("?, ", $numTopics -1)." ?";
    $sql .= " ( ";
    foreach ($topics as $key=>$topic) {
      $params .= "s";
      $topic = $topic."%";
      array_push($bindArray, $topic);
      $sql .= "q.topic LIKE ? ";
      if($key < ($numTopics -1)) {
        $sql .= " OR ";
      }
      
    }
    $sql .= " ) ";
    //echo $topicParams;

  }

  if(!is_null($subjectId)) {
    if($conjoiner == 1) {
      $sql .= " AND ";
    }
    $conjoiner = 1;
    $sql .= " q.subjectId = ? ";
    $params .= "i";
    array_push($bindArray, $subjectId);
  }

  if(!is_null($topicIds)) {
    if($conjoiner == 1) {
      $sql .= " AND ";
    }
    $conjoiner = 1;
    $topicIdsArray = array();
    $topicIdsArray = explode(",",$topicIds);

    

    $sql .= " topicId IN ( ";
    foreach($topicIdsArray as $key => $array) {
      if($key < (count($topicIdsArray)-1)) {
        $comma = ", ";
      } else {
        $comma = " ";
      }
      $sql .= " ?".$comma;
      $params .= "i";
      array_push($bindArray, $topicIdsArray[$key]);

    }
    $sql .= " )";

    
    /*
    $sql .= " topicId = ? ";
    $params .= "i";     
    */

  }
  
  if($conjoiner == 1) {
    $sql .= " AND ";
  }
  $sql .= "(q.type LIKE '%flashCard%' OR q.flashCard = 1)
          
          ORDER BY q.topic, r.questionId, r.timeSubmit
          
  ";

  //echo $sql;

  $stmt = $conn->prepare($sql);
  $stmt->bind_param($params, ...$bindArray);

  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row=$result->fetch_assoc()) {
                    //Change those entries that use 'img' for 'q_path' to new standard of 'q_path' and 'q_alt'
                    if($row['img'] != '' && $row['q_path'] == '') {
                      $row['q_path'] = $row['img'];
                      $row['q_alt'] = $row['img'];
                    }
                    //Change those entries that use 'answer_img' and 'answer_img_alt' for 'a_path' and 'a_alt' to new standard of 'a_path' and 'a_alt'
                    if($row['answer_img'] != '' && $row['a_path'] == '') {
                      $row['a_path'] = $row['answer_img'];
                      $row['a_alt'] = $row['answer_img_alt'];
                    }

      if($row['timeSubmit']=="") {
        $row['rank'] =1;
      }
      else {
        $submit_timeStamp = strtotime($row['timeSubmit']);
        $current_timeStamp = time();
        $seconds = $current_timeStamp - $submit_timeStamp;
        $row['seconds'] = $seconds;
        $row['rank'] = 1+(24*3600)/($seconds+1);
        if($row['cardCategory'] == "1") {
          $row['rank'] += 1;
        } elseif ($row['cardCategory']>=2) {
          $row['rank'] +=2;
        }
      }
      array_push($results, $row);
    }
  }
  array_multisort(array_column($results, 'rank'), SORT_ASC, $results);
  return $results;
  
}

function getColumnListFromTable($tableName, $column, $topic = null, $subjectId = null, $userCreate = null, $levelId = null, $flashCard = null) {
  /*
  Used to generate list of distinct $collumn information from $tableName.
  e.g. to generate a table of topics that a user can select

  Used in:
  -flashcards.php
  */
  global $conn;
  $params = "";
  $bindArray = array();
  $results = array();

  $sql =  "SELECT DISTINCT ".$column." ";
  $sql .= "FROM ".$tableName." ";

  if(!is_null($topic)) {
    $sql .= sql_conjoin($params);
    $sql .= " topic LIKE ? ";
    $params .= "s";
    array_push($bindArray, $topic."%");
  }

  if(!is_null($subjectId)) {
    $sql .= sql_conjoin($params);
    $sql .= " subjectId = ? ";
    $params .= "i";
    array_push($bindArray, $subjectId);
  }

  if(!is_null($userCreate)) {
    $sql .= sql_conjoin($params);
    $sql .= " userCreate = ? ";
    $params .= "i";
    array_push($bindArray, $userCreate);
  }

  if(!is_null($levelId)) {
    $sql .= sql_conjoin($params);
    $sql .= " levelId = ? ";
    $params .= "i";
    array_push($bindArray, $levelId);
  }

  $sql .= sql_conjoin($params);
  $sql .= " ".$column." <> '' ";
  
  if(!is_null($flashCard)) {
    $sql .= " AND flashCard = 1 ";
  }

  $sql .= " ORDER BY ".$column." ";

  //echo $sql;


  

  $stmt=$conn->prepare($sql);
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }

  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      $rowTopic = $row[$column];
      array_push($results, $rowTopic);
    }
  }
  return $results;
  


}

function getOutputFromTable($table, $id = null, $orderByColumn = null) {
  /*
  This function will output information from $table
  e.g. to get:
    -All levels from subjects_level table
    -All subjects from subjects table

  Used in -
  flashcards.php
  */

  global $conn;

  $sql = "SELECT * FROM ".$table." ";
  if(!is_null($orderByColumn)) {
    $sql .= " ORDER BY ".$orderByColumn." ";
  }
  $results = array();

  $stmt=$conn->prepare($sql);
  //$stmt->bind_param($params, ...$bindArray);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
  }
  return $results;



}

function startsWithAny($topic, $topics) {
  /*
  Used in flashcards.php
  */
  foreach ($topics as $item) {
      if (strpos($topic, $item) === 0) {
          return true;
      }
  }
  return false;
}

function getDistinctFlashcardSubjectLevels() {
  /*
  Used to get distinct information on subjectId and levelId from table saq_question_bank_3

  Used in: flashcards.php

  */

  global $conn;
  $params = "";
  $bindArray = array();
  $results = array();

  $sql = "SELECT DISTINCT CONCAT(qb.subjectId, '_', qb.levelId) AS combination, s.id sId, s.name subject, l.id lId, l.name level
          FROM saq_question_bank_3 qb
          LEFT JOIN subjects s ON s.id = SUBSTRING_INDEX(CONCAT(qb.subjectId, '_', qb.levelId), '_', 1)
          LEFT JOIN subjects_level l ON l.id = SUBSTRING_INDEX(CONCAT(qb.subjectId, '_', qb.levelId), '_', -1)
          
          ORDER BY level, subject";

  $stmt=$conn->prepare($sql);
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }

  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
  }
  return $results;


}


function sql_conjoin($x, $startParams ="") {
  /*
   Used  to join up different optional elemlents in sql query.
   Used in: 
   - getSAQQuestions()
   - getColumnListFromTable()

   */
  
  $y = "";
  if($x != $startParams) {
    $y = " AND ";
  } else {
    $y = " WHERE ";
  }
  return $y;
  
/*
  if($x == $startParams) {
    return " WHERE ";
  }
  else {
    return " AND ";
  }
  */
}

function getSAQQuestions($questionId = null, $topics = null, $flashCard = null, $subjectId = null, $userCreate = null, $type = null, $userIdOrder = null, $topicId = null) {
  /*
  Used to find information about questions in saq_question_bank_3 for a given number of parameters

  $topics = string of commma-separated topics to be queried

  Used in:
  -quick_quiz.php
  -knowledge_organiser.php
  -saq_list1.1.php
  */
  global $conn;
  $params="";
  $paramsExpected = "";
  $bindArray = array();
  $results = array();

  $sql = "SELECT q.*, aq.path q_path, aq.altText q_alt, aa.path a_path, aa.altText a_alt, topic.code, topic.name topicName, topic.subjectId subjectId, topic.levelId levelId, topic.levelsArray, topic.examBoardId, topic.root, topic.parentId, topic.general ";
  
  if(!is_null($userIdOrder)) {
    $sql .= ", ld.topicOrder userTopicOrder, ld.isActive, ld.comments userComments, ld.extraTopics, ld.studentHide ";
    }

    $sql .= "FROM saq_question_bank_3 q
          LEFT JOIN upload_record aq
          ON aq.id = q.questionAssetId
          LEFT JOIN upload_record aa
          ON aa.id = q.answerAssetId
          LEFT JOIN topics_all topic
          ON topic.id = q.topicId";

  if(!is_null($userIdOrder)) {
    $params .= "i";
    $paramsExpected = "i";
    array_push($bindArray, $userIdOrder);

    $sql .= " LEFT JOIN (
                SELECT *
                FROM user_list_data
                WHERE userCreate = ? 
                AND dataSource = 'saq_question_bank_3'
                ) ld
              ON ld.dataId = q.id ";

  }


  if($questionId) {
    $sql .= sql_conjoin($params, $paramsExpected);
    $sql .= "  q.id = ? ";
    $params .= "i";
    array_push($bindArray, $questionId);
  }

  if($topics) {
    $topics = explode(",", $topics);
    $numTopics = count($topics);
    //$placeholder = str_repeat("?, ", $numTopics -1)." ?";


    $sql .= sql_conjoin($params, $paramsExpected);

    foreach($topics as $key=>$topic) {
      if($key == 0) {
        $sql .= " ( ";
      }
      $sql .= "q.topic LIKE ? ";
      if($key < ($numTopics-1)) {
        $sql .= " OR ";
      }
      $topic = $topic."%";
      
      $params .= "s";
      $paramsExpected = "";
      array_push($bindArray, $topic);
    }

    $sql .= " ) ";
  }

  if($subjectId) {
    $sql .= sql_conjoin($params, $paramsExpected);
    $sql .= " q.subjectId = ? ";
    $params .= "i";
    array_push($bindArray, $subjectId);
  }

  if($userCreate) {
    $sql .= sql_conjoin($params, $paramsExpected);
    $sql .= " q.userCreate = ? ";
    $params .= "i";
    array_push($bindArray, $userCreate);

  }

  if($flashCard) {
    $sql .= sql_conjoin($params, $paramsExpected);
    $sql .= " ( q.flashCard = 1 OR q.type LIKE '%flashCard%' )";
    $paramsExpected = "x";
  }

  if($type) {
    $sql .= sql_conjoin($params, $paramsExpected);
    $sql .= " q.type LIKE ? ";
    $params .= "s";
    $paramsExpected = "";
    $type = "%".$type."%";
    array_push($bindArray, $type);
  }

  if(!is_null($topicId)) {

    $sql .= sql_conjoin($params, $paramsExpected);

    $topicIdsArray = array();
    $topicIdsArray = explode(",",$topicId);

    

    $sql .= " topicId IN ( ";
    foreach($topicIdsArray as $key => $array) {
      if($key < (count($topicIdsArray)-1)) {
        $comma = ", ";
      } else {
        $comma = " ";
      }
      $sql .= " ?".$comma;
      $params .= "i";
      array_push($bindArray, $topicIdsArray[$key]);

    }
    $sql .= " )";

  }

  $sql .= " ORDER BY topic";



  if(!is_null($userIdOrder)) {
    $sql .= ", userTopicOrder";
  }

  else {
    $sql .=", topic_order";
  }

  //echo $sql;

  $stmt=$conn->prepare($sql);
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }

  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      //Change those entries that use 'img' for 'q_path' to new standard of 'q_path' and 'q_alt'
      if($row['img'] != '' && $row['q_path'] == '') {
        $row['q_path'] = $row['img'];
        $row['q_alt'] = $row['img'];
      }
      //Change those entries that use 'answer_img' and 'answer_img_alt' for 'a_path' and 'a_alt' to new standard of 'a_path' and 'a_alt'
      if($row['answer_img'] != '' && $row['a_path'] == '') {
        $row['a_path'] = $row['answer_img'];
        $row['a_alt'] = $row['answer_img_alt'];
      }
      array_push($results, $row);
    }
  }

  
  return $results;

}

function insertSAQQuestion($topic, $question, $points, $type, $image, $model_answer, $userCreate, $subjectId, $answer_img, $answer_img_alt, $timeAdded, $questionAsset, $answerAsset, $flashCard, $topic_order, $levelId, $topicId) {
  /**
   * This function inserts a new question into saq_question_bank_3
   * 
   * 
   * Used in:
   * -saq_list1.1.php
   */
  global $conn;

  $sql = "INSERT INTO saq_question_bank_3 
        (topic, question, points, type, img, model_answer, userCreate, subjectId, answer_img, answer_img_alt, time_added, questionAssetId, answerAssetId, flashCard, topic_order, levelId, topicId) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);

  $stmt->bind_param("ssisssissssiiiiii", $topic, $question, $points, $type, $image, $model_answer, $userCreate, $subjectId, $answer_img, $answer_img_alt, $timeAdded, $questionAsset, $answerAsset, $flashCard, $topic_order, $levelId, $topicId);

  $stmt->execute();

}

function updateSAQQuestion($questionId, $userId, $question, $topic, $points, $type, $model_answer, $questionAsset, $answerAsset, $flashCard=0, $topicId) {
  /**
   * This function updates entries in saq_question_bank_3
   * 
   * Used in :
   * -saq_list1.1.php
   */

   global $conn;

   $sql = " UPDATE saq_question_bank_3 
            SET question = ?, topic = ?, points = ?, type = ?, model_answer= ?, questionAssetId =?, answerAssetId = ?, flashCard = ?, topicId = ?
            WHERE id = ?";

  //Set values to null if left blank:
  if($questionAsset == "") {
    $questionAsset = null;
  }
  if($answerAsset == "") {
    $answerAsset = null;
  }

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssssiiiii", $question, $topic, $points, $type, $model_answer, $questionAsset, $answerAsset, $flashCard, $topicId, $questionId);

  $questionUserCreator = getSAQQuestions($questionId)[0]['userCreate'];
  

  if($questionUserCreator == $userId) {
    $stmt->execute();
    return "Record $questionId updated successfully.";
  } else {
    return "Error: User is not question owner.";
  }
  

}

function SAQQuestionTopicCount($topic) {
  /**
   * Returns the count of questions in saq_question_bank_3 that have $topic as topic
   */

  global $conn;
  $sql = "SELECT COUNT(*) count
          FROM saq_question_bank_3 
          WHERE Topic= ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $topic);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    $row = $result->fetch_assoc();
    return $row['count'];
    }

}

function getSAQTopics($topicId = null, $subjectId=null, $flashCard = null, $examBoardId = null) {
  /**
   * Returns a distinct list of topics in saq_question_bank_3 given parameters
   */

  global $conn;
  $params = "";
  $bindArray = array();
  $results = array();

  
  $sql = "SELECT DISTINCT q.topicId, t.*
          FROM saq_question_bank_3 q
          LEFT JOIN topics_all t
          ON t.id = q.topicId ";
          

  if($topicId) {
    $sql .= sql_conjoin($params);
    $sql .= " t.id = ? ";
    $params .= "i";
    array_push($bindArray, $topicId);

  }
  
  if($subjectId) {
    $sql .= sql_conjoin($params);
    $sql .= " q.subjectId = ? ";
    $params .= "i";
    array_push($bindArray, $subjectId);
  }

  if($flashCard) {
    $sql .= sql_conjoin($params);
    $sql .= " ( q.flashCard = 1 )";
  }

  if($examBoardId) {
    $sql .= sql_conjoin($params);
    $sql .= " ( t.examBoardId = ? )";
    $params .= "i";
    array_push($bindArray, $examBoardId);
  }

  $sql .= "ORDER BY t.code";

  //echo $sql;

  $stmt=$conn->prepare($sql);
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }

  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
  }
  return $results;



}

function getSAQresults($userId = null, $assignId = null, $submit = null) {
  /*

  Retrieves result from saq_saved_work

  Used in:
  -user_assignment_list_embed.php

  */

  global $conn;
  $results = array();

  $params = "";
  $bindArray = array();
  $conjoiner = 0;
  $tableAlias = "";

  $sql = " SELECT * FROM saq_saved_work ";

  if($userId) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $sql .= $tableAlias;
    $sql .= " userID = ? ";
    $params .= "i";
    array_push($bindArray, $userId);
    $conjoiner = 1;
  }

  if($assignId) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $sql .= $tableAlias;
    $sql .= " assignID = ? ";
    $params .= "i";
    array_push($bindArray, $assignId);
    $conjoiner = 1;
  }

  if($submit) {
    $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
    $sql .= $tableAlias;
    $sql .= " submit = 1 ";
    $conjoiner = 1;
  }

  $stmt = $conn->prepare($sql);
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
  }

  return $results;

}

function getSAQExamBoards($subjectId = null) {
  /**
   * Returns a distinct list of topics in saq_question_bank_3 given parameters
   * 
   * Used in:
   * -flashcards.php
   */

  global $conn;
  $params = "";
  $bindArray = array();
  $results = array();

  $sql = "SELECT DISTINCT t.examBoardId
          FROM topics_all t
          INNER JOIN saq_question_bank_3 q
          ON t.id = q.topicId ";


  if(!is_null($subjectId)) {
    $sql .= " WHERE t.subjectId = ? ";
    $params .= "i";
    array_push($bindArray, $subjectId);

  }

  $stmt=$conn->prepare($sql);
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }

  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
  }
  return $results;


}


function lastFlashcardResponse($questionId, $userId, $timeStart) {
  /*
  Function designed to get a record from flashcard_responses with a gven $questionId, $userId, and $timeStart. Used specifically to check that information given from $_POST is not alreayd contained as a record with these data values (i.e. a browser refresh)

  Used soley in insertFlashcardResponse() below:
  */
  global $conn;
  $sql = "SELECT *
          FROM flashcard_responses 
          WHERE userId = ? AND questionId = ? AND timeStart = ? ";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iis", $userId, $questionId, $timeStart);
  $stmt->execute();
  $result = $stmt->get_result();

  $row =$result->fetch_assoc();
  return $row;

}

function insertFlashcardResponse($questionId, $userId, $gotRight, $timeStart, $timeSubmit, $cardCategory) {
  /*
  This function inserts a new record when a flashcard question has been completed by a student.
  
  Used in:
  -flaschards.php
  */

  global $conn;

  

  $stmt = $conn->prepare("INSERT INTO flashcard_responses (questionId,  userId, gotRight, timeStart, timeSubmit, cardCategory, timeDuration, dateSubmit, dontKnow, correct) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)");


  $seconds = strtotime($timeSubmit) - strtotime($timeStart);
  $date = date("Y-m-d", strtotime($timeSubmit));

  $dontKnow = 0;
  $correct = 0;

  if($gotRight == 1) {
    $dontKnow = 1;
  }

  else if ($gotRight == 2) {
    $correct = 1;
  }

  if($gotRight === "0" || $gotRight === "1") {
    $cardCategory = 0;
  }
  else if ($gotRight = 2) {
    if ($cardCategory == "0" || $cardCategory == "") {
      $cardCategory = 1;
    } else if ($cardCategory == "1") {
      $cardCategory = 2;
    } else if ($cardCategory == "2") {
      $cardCategory = 2;
    }
  }

  $stmt->bind_param("iiissiisii", $questionId, $userId, $gotRight, $timeStart, $timeSubmit, $cardCategory, $seconds, $date, $dontKnow, $correct);

  $lastResponse = lastFlashcardResponse($questionId, $userId, $timeStart);
  //var_dump($lastResponse);
  if (is_null($lastResponse)) {
    $stmt->execute();
    return "Response successfully saved";
  } else {
    return "This is a duplicate and will not be entered";
  }




  
}

function updateTopicOrder($id, $newPlace, $table) {
  /*
  A function to update the topic_order column of saq_question_bank_3

  Soley used as supporting function for changeOrderNumberWithinTopic() below;
  */

  global $conn;
  $sql = "UPDATE ".$table;
  $sql .= " SET topic_order = ?
          WHERE id = ?";

  //echo $sql; 
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $newPlace, $id);
  $stmt->execute();
  //echo $id;
}

function getInfoFromUserListData($dataId, $userCreate, $dataSource) {
  /**
   * This funciton extracts information from user_list_data for the purposes of finding:
   *  -Which record is in the table and needs updating
   *  -When there is no record in the table and needs creating
   * 
   * Used as support to functions below
   */

   global $conn;
   $results = array();
   $sql = " SELECT *
            FROM user_list_data
            WHERE dataId = ? 
            AND userCreate = ?
            AND dataSource = ? ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $dataId, $userCreate, $dataSource);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows>0) {
      while($row = $result->fetch_assoc()) {
        array_push($results, $row);
      }
    }

    if(count($results) ==0 ) {
      return null;
    } else if(count($results)> 1) {
      return "error";
    } else {
      return $results[0]['id'];
    }

    

}

function updateTopicOrder2($id, $newPlace, $userCreate) {
  /*
  A function to update the topicOrder column of user_list_data

  Soley used as supporting function for changeOrderNumberWithinTopic() below;
  */

  global $conn;
  $sql =    " UPDATE user_list_data
              SET topicOrder = ?
              WHERE dataId = ?
              AND userCreate = ?";

  //echo $sql; 
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iii", $newPlace, $id, $userCreate);
  $stmt->execute();

}

function createInfoToUserListData($dataId, $newPlace, $userCreate) {
  /**
   * A function to insert topoicOrder information into user_list_data
   * 
   * Soley used as supporting function for changeOrderNumberWithinTopic() below;
   */

   global $conn;
   $source = "saq_question_bank_3";
   $active = 1;

   $sql =    "  INSERT INTO user_list_data 
                (dataId, topicOrder, userCreate, dataSource, isActive)
                VALUES (?,?,?,?,?)";
 
   //echo $sql; 
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("iiisi", $dataId, $newPlace, $userCreate, $source, $active);
   $stmt->execute();


}


function changeOrderNumberWithinTopic($id, $topic, $newPlace, $subjectId, $levelId, $userId) {

  /*
  This function is used to take all questions from table $table with $topic, give entry with $id a $newPlace in the order, then update all other values with the same topic category.

  When inputting new records set $id to null. Then the $newPlace of the new row becomes the new topic_order for that row and other rows behind it are updated accordingly.

  Used in :
  -saq_list1.1.php
  */
  global $conn;
  $bindArray = array($userId, $topic, $subjectId, $levelId );
  $params = "isii";

  $sql = "SELECT q.id, q.topic_order, q.question, ld.topicOrder userTopicOrder
          FROM saq_question_bank_3 q ";

  $sql .= " LEFT JOIN 
            (SELECT * FROM user_list_data 
            WHERE userCreate = ? 
            AND dataSource = 'saq_question_bank_3') ld
            ON ld.dataId = q.id ";
  $sql .= " WHERE q.topic = ?
            AND q.subjectId = ?
            AND q.levelId = ? ";
  if(!is_null($id)) {
    $sql .= " AND q.id <> ? ";
    array_push($bindArray, $id);
    $params .= "i";
  }
  $sql .= "ORDER BY topic_order";

  if(is_null($id)) {
    $sql .= " , id DESC"; 
  }
  

  $stmt = $conn->prepare($sql);
  $stmt->bind_param($params, ...$bindArray);
  $stmt->execute();
  $result = $stmt->get_result();

  $questions = array();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($questions, $row);
    }
  }


  //When updating a current record $id will not be null so:

  if(!is_null($id)) {

    //(This will need to be fixed in order to update table):
    //Change 7th parameter to $userId when updating for ordering by user topic order
    $questionSelect = getSAQQuestions($id,null, null, null, null, null, null )[0];

    $questions = array_merge(array_slice($questions, 0, $newPlace), array($questionSelect), array_slice($questions, $newPlace));
    $index = 0;
  } else {
    
  //When inserting a new record $id will be null so:

    $questionCount = count($questions);
    if ($newPlace > $questionCount) {
      $newPlace = $questionCount;
    }
    $index = $newPlace -1;
  }
  /*
  echo "<pre>";
  print_r($questions);
  echo "</pre>";
  */

  for($x=$index; $x<count($questions); $x++) {
    updateTopicOrder($questions[$x]['id'], $index, "saq_question_bank_3");
    /*
    if($questions[$x]['userTopicOrder'] =="") {
      createInfoToUserListData($questions[$x]['id'], $index, $userId);
    }
    if($questions[$x]['userTopicOrder'] !="") {
      updateTopicOrder2($questions[$x]['id'], $index, $userId);
    }
    */
    $index ++;
  }

}

function getTopicList($tableName, $topicColumn, $topics = null, $flashCard = null, $subjectId = null, $userCreate = null, $blanks = null) {

  /*
  This function will return a unique list of topics from $topicColumn and table $tableName, subjec to criteria of having LIKE $topic%, created by $userCreate, or having $subjectId

  */
  global $conn;
  $params="";
  $bindArray = array();
  $results = array();

  $sql =  "SELECT DISTINCT q.".$topicColumn." ";
  $sql .= "FROM ".$tableName." q ";

  if($topics) {
    $topics = explode(",", $topics);
    $numTopics = count($topics);

    $sql .= " WHERE ";

    foreach($topics as $key=>$topic) {
      if($key == 0) {
        $sql .= " ( ";
      }
      $sql .= "q.topic LIKE ? ";
      if($key < ($numTopics-1)) {
        $sql .= " OR ";
      }
      $topic = $topic."%";
      
      $params .= "s";
      array_push($bindArray, $topic);
    }
    $sql .= " ) ";
  }

  if($userCreate) {
    $sql .= sql_conjoin($params);
    $sql .= " q.userCreate = ? ";
    $params .= "i";
    array_push($bindArray, $userCreate);

  }

  if($subjectId) {
    $sql .= sql_conjoin($params);

    $sql .= " q.subjectId = ? ";
    $params .= "i";
    array_push($bindArray, $subjectId);
  }

  if($flashCard) {
    $sql .= sql_conjoin($params);
    $sql .= " ( q.flashCard = 1 OR q.type LIKE '%flashCard%' )";
  }

  $sql .= " ORDER BY q.".$topicColumn;

  $stmt=$conn->prepare($sql);
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }

  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row['topic']);
    }
  }
  return $results;

}

// topics_all:

function getTopicsAllList($topicId = null, $root = null, $examBoardId = null, $subjectId = null,  $code = null, $parentId = null, $parentCode = null,  $levelId = null, $topicName = null,  $general = null, $userCreate = null) {
  /**
   * This function returns information from topics_all table given input paramters
   * 
   * Used in:
   * -topic_spec_map.php
   */

  global $conn;

  $params="";
  $bindArray = array();
  $results = array();


  $sql = "SELECT c.*, LEFT(c.code, 1) code_first, s.name subjectName, s.sort_order,
          IF(c.root = 1, c.id, p.id) AS par_id,
          IF(c.root = 1, c.code, p.code) AS par_code,
          IF(c.root = 1, c.name, p.name) AS par_name, 
          LENGTH(c.code) - LENGTH(REPLACE(c.code, '.', '')) AS topicLevel
          FROM topics_all c
          LEFT JOIN (
              SELECT code, name, id
              FROM topics_all
            ) p
            ON (c.parentId = p.id OR (c.root = 1 AND c.id = p.id))
          LEFT JOIN subjects s
            ON c.subjectId = s.id";

  if(!is_null($topicId)) {
    $sql .= sql_conjoin($params);
    $sql .= " c.id = ? ";
    $params .= "i";
    array_push($bindArray, $topicId);
  }

  if(!is_null($root)) {
    $sql .= sql_conjoin($params);
    $sql .= " c.root = ? ";
    $params .= "i";
    array_push($bindArray, $root);
  }

  if(!is_null($examBoardId)) {
    $sql .= sql_conjoin($params);
    $sql .= " c.examBoardId = ? ";
    $params .= "i";
    array_push($bindArray, $examBoardId);
  }

  if(!is_null($subjectId)) {
    $sql .= sql_conjoin($params);
    $sql .= " c.subjectId = ? ";
    $params .= "i";
    array_push($bindArray, $subjectId);
  }

  if(!is_null($code)) {
    $sql .= sql_conjoin($params);
    $code = $code."%";
    $sql .= " c.code LIKE ? ";
    $params .= "s";
    array_push($bindArray, $code);
  }

  if(!is_null($parentId)) {
    $sql .= sql_conjoin($params);
    $sql .= " p.id = ? ";
    $params .= "i";
    array_push($bindArray, $parentId);
  }


  if(!is_null($parentCode)) {
    $sql .= sql_conjoin($params);
    $parentCode = $parentCode."%";
    $sql .= " p.code LIKE ? ";
    $params .= "s";
    array_push($bindArray, $parentCode);
  }


  if(!is_null($levelId)) {
    $sql .= sql_conjoin($params);
    $sql .= " c.levelId = ? ";
    $params .= "i";
    array_push($bindArray, $levelId);
  }

  if(!is_null($topicName)) {
    $sql .= sql_conjoin($params);
    $topicName = "&".$topicName."%";
    $sql .= " c.name LIKE ? ";
    $params .= "s";
    array_push($bindArray, $topicName);
  }

  if(!is_null($general)) {
    $sql .= sql_conjoin($params);
    $sql .= " c.general = ? ";
    $params .= "i";
    array_push($bindArray, $general);
  }

  if(!is_null($userCreate)) {
    $sql .= sql_conjoin($params);
    $sql .= " c.userCreate = ? ";
    $params .= "i";
    array_push($bindArray, $userCreate);
  }

  $sql .= " ORDER BY c.code, c.deliveryYear";

  //echo $sql;

  $stmt=$conn->prepare($sql);
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }

  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      if(!empty($row['deliveryYear'])) {
        $row['name'] .= " (Y".$row['deliveryYear'].")";
      }
      array_push($results, $row);
    }
  }
  $sortOrder = null;
  if(!empty($results)) {
    $sortOrder = $results[0]['sort_order'];
    $sortOrder = strtoupper($sortOrder);
    $customOrder = explode(",",$sortOrder);
  }
  if(!empty($sortOrder)) {

    

    usort($results, function ($a, $b) use ($customOrder) {
      $deliveryYearA = $a['deliveryYear'];
      $deliveryYearB = $b['deliveryYear'];
  
      if ($deliveryYearA !== $deliveryYearB) {
          return $deliveryYearA - $deliveryYearB;
      }
  
      $prefixA = substr($a['code'], 0, 1);
      $prefixB = substr($b['code'], 0, 1);
  
      $indexA = array_search($prefixA, $customOrder);
      $indexB = array_search($prefixB, $customOrder);
  
      if ($indexA === $indexB) {
          $codePartsA = explode('.', substr($a['code'], 1));
          $codePartsB = explode('.', substr($b['code'], 1));
  
          // Compare each part of the code
          foreach ($codePartsA as $key => $partA) {
              $partB = $codePartsB[$key];
  
              if ($partA !== $partB) {
                  // Check if the parts are numeric
                  if (is_numeric($partA) && is_numeric($partB)) {
                      return $partA - $partB;
                  } else {
                      return strcmp($partA, $partB);
                  }
              }
          }
      }
  
      return $indexA - $indexB;
    });
  
  }


  return $results;




}

function insertTopicsAllList($code, $name, $subjectId, $examBoardId, $root, $parentId, $general, $levelId, $levelsArray, $userCreate, $deliveryYear) {
  /*
   * This funciton enters new entries into topics_all table
   * 
   * Used in:
   * -
   */

   global $conn;

   $dateTime = date("Y-m-d H:i:s");

   $sql = "INSERT INTO topics_all
          (code, name, subjectId, examBoardId, root, parentId, general, levelId, levelsArray, userCreate, dateCreate, deliveryYear) 
          VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);
    
    $levelId = strval($levelId);
    $levelsArray = array($levelId);
    $levelsArray = json_encode($levelsArray);
  
    $params = "ssiiiiiisisi";
    $bindArray = array($code, $name, $subjectId, $examBoardId, $root, $parentId, $general, $levelId, $levelsArray, $userCreate, $dateTime, $deliveryYear);

    $stmt=$conn->prepare($sql);
    $stmt->bind_param($params, ...$bindArray);
    /*
    var_dump($bindArray);
    echo $sql;
    */
    if($stmt->execute()) {
      return "Question \"$name\" inserted successfully.";
    }
    


    


}

function getTopicsGeneralList($topicId = null, $code = null, $examBoardId = null, $subjectId = null, $levelId = null, $topicName = null) {
  /**
   * This function returns information from topics_general table given input paramters
   * 
   * Used in:
   * -saq_list1.1.php
   */

  global $conn;

  $params="";
  $bindArray = array();
  $results = array();


  $sql = "SELECT *, 
          LENGTH(code) - LENGTH(REPLACE(code, '.', '')) AS topicLevel
          FROM topics_general ";

  if(!is_null($topicId)) {
    $sql .= sql_conjoin($params);
    $sql .= " id = ? ";
    $params .= "i";
    array_push($bindArray, $topicId);
  }

  if(!is_null($code)) {
    $sql .= sql_conjoin($params);
    $code = $code."%";
    $sql .= " code LIKE ? ";
    $params .= "s";
    array_push($bindArray, $code);
  }

  if(!is_null($subjectId)) {
    $sql .= sql_conjoin($params);
    $sql .= " subjectId = ? ";
    $params .= "i";
    array_push($bindArray, $subjectId);
  }

  if(!is_null($levelId)) {
    $sql .= sql_conjoin($params);
    $sql .= " levelId = ? ";
    $params .= "i";
    array_push($bindArray, $levelId);
  }

  if(!is_null($topicName)) {
    $sql .= sql_conjoin($params);
    $topicName = "&".$topicName."%";
    $sql .= " name LIKE ? ";
    $params .= "s";
    array_push($bindArray, $topicName);
  }

  

  $sql .= " ORDER BY code";

  $stmt=$conn->prepare($sql);
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }

  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
  }
  return $results;




}

function updateTopicsAllList($id, $parentId) {
  /**
   * Used to update topics_all
   * Currently only used to update parentId value but can be expanded
   * 
   * Used in:
   * -topic_spec_map.php
   */

    global $conn;
    $sql = "UPDATE topics_all
            SET parentId = ?
            WHERE id = ? ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $parentId, $id);
    $stmt->execute();

    return "Record $id updated with value $parentId";
}

// topics_spec:

function getTopicsSpecList($id = null, $examBoardId = null, $subjectId = null,$topicId = null, $specCode = null, $topicName=null,  $levelId = null) {
  /**
   * This function gets topics from topics_spec table
   * The idea is that a user can call on a topic from this list which then maps onto a topic from topic_general using $topicId varaible
   * 
   * Used in:
   * -topic_spec_map.php
   */

   global $conn;

   $params="";
   $bindArray = array();
   $results = array();

   $sql = "SELECT *, 
          LENGTH(code) - LENGTH(REPLACE(code, '.', '')) AS topicLevel
          FROM topics_spec ";

    if(!is_null($topicId)) {
      $sql .= sql_conjoin($params);
      $sql .= " id = ? ";
      $params .= "i";
      array_push($bindArray, $topicId);
    }

    if(!is_null($specCode)) {
      $sql .= sql_conjoin($params);
      $sql .= " code = ? ";
      $params .= "s";
      array_push($bindArray, $code);
    }

    if(!is_null($examBoardId)) {
      $sql .= sql_conjoin($params);
      $sql .= " examBoardId = ? ";
      $params .= "i";
      array_push($bindArray, $examBoardId);
    }

    if(!is_null($subjectId)) {
      $sql .= sql_conjoin($params);
      $sql .= " subjectId = ? ";
      $params .= "i";
      array_push($bindArray, $subjectId);
    }

    if(!is_null($levelId)) {
      $sql .= sql_conjoin($params);
      $sql .= " levelId = ? ";
      $params .= "i";
      array_push($bindArray, $levelId);
    }

    if(!is_null($topicName)) {
      $sql .= sql_conjoin($params);
      $topicName = '%'.$topicName.'%';
      $sql .= " name LIKE ? ";
      $params .= "s";
      array_push($bindArray, $topicName);
    }

    $sql .= " ORDER BY code";


    $stmt=$conn->prepare($sql);
    if(count($bindArray)>0) {
      $stmt->bind_param($params, ...$bindArray);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows>0) {
      while($row = $result->fetch_assoc()) {
        array_push($results, $row);
      }
    }

    
    return $results;



}

function updateTopicsSpecList($id, $topicId) {
  /**
   * Used in: $topic_spec_map.php
   */

  global $conn;

  $sql = "UPDATE topics_spec
            SET topicId = ?
            WHERE id = ? ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $topicId, $id);
    $stmt->execute();

    return "Record $id updated";


}

// topics_general:

function insertTopicsGeneralList($code, $name, $subjectId, $levelId, $levelsArray, $examBoardsArray, $userCreate) {
  /*
   * This funciton enters new entries into topics_general table
   * 
   * Used in:
   * -revision/topic_list.php
   */

   global $conn;

   $sql = "INSERT INTO topics_general
          (code, name, subjectId, levelId, levelsArray, examBoardsArray, userCreate) 
          VALUES (?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);

    $params = "ssiissi";
    $bindArray = array();

    $levelsArray = explode(",",$levelsArray);
    $levelsArray = json_encode($levelsArray);

    $examBoardsArray = explode(",",$examBoardsArray);
    $examBoardsArray = json_encode($examBoardsArray);

    $stmt=$conn->prepare($sql);
    $stmt->bind_param($params, $code, $name, $subjectId, $levelId, $levelsArray, $examBoardsArray, $userCreate);

    $stmt->execute();

    return "Record \"$name\" inserted<br>";




}


function updateTopicsGeneralList($id, $code, $name, $subjectId, $levelsArray) {
  /**
   * Used to update topics_general
   * 
   * Used in:
   * -topic_list.php
   */

    global $conn;

    $levelsArray = explode(",", $levelsArray);
    foreach ($levelsArray as &$item) {
      $item = trim($item);
    }
    $levelsArray = json_encode($levelsArray);
    $sql = "UPDATE topics_general
            SET code =?, name =?, subjectId =?, levelsArray =?
            WHERE id = ? ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $code, $name, $subjectId, $levelsArray, $id);
    $stmt->execute();

    return "Record $id updated";
}



function getExamBoards($id = null) {

  global $conn;
  $results = array();
  $params = "";
  $bindArray = array();

  $sql = "SELECT *
          FROM exam_boards";

  if(!is_null($id)) {
    $sql .= sql_conjoin($params);
    $sql .= " id = ? ";
    $params .= "i";
    array_push($bindArray, $id);
  }

  $stmt=$conn->prepare($sql);
  
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }
  

  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
  }
  return $results;

}

function getSubjects_Level($id = null) {
  global $conn;
  $results = array();
  $params = "";
  $bindArray = array();

  $sql = "SELECT *
          FROM subjects_level";

  if(!is_null($id)) {
    $sql .= sql_conjoin($params);
    $sql .= " id = ? ";
    $params .= "i";
    array_push($bindArray, $id);
  }

  $stmt=$conn->prepare($sql);
  
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }
  

  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
  }
  return $results;

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


function getSubjectInfo($subjectId) {
  global $conn;
  $sql = "SELECT *
          FROM subjects
          WHERE id = ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("i", $subjectId);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    $row = $result->fetch_assoc();
    $row['subjectName'] = $row['name'];
    unset($row['name']);
    return $row;
  }
}


//Used in class_creator.php:

function createGroup($userCreate, $name, $subjectId, $schoolId, $teachers, $dateFinish, $optionGroup, $examBoard) {
  //Used to create a group or class

  global $conn;
  $date = date("Y-m-d H:i:s");
  $sql = "INSERT INTO groups
          (name, school, teachers, subjectId, optionGroup, dateFinish, active, userCreate, dateCreated, examBoard, subject, qualType)
          VALUES (?,?,?,?,?,?,?,?,?,?,?,?)
          ";
  $teachers = json_encode($teachers);
  $active = 1;
  $subjectInfo = getSubjectInfo($subjectId);
  $level = "";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("sisissiissss", $name, $schoolId, $teachers, $subjectId, $optionGroup, $dateFinish, $active, $userCreate, $date, $examBoard, $subjectInfo['subjectName'], $level);
  $stmt->execute();
  //echo "New record created";


};

function listSubjects() {
  global $conn;
  $responses = array();
  $sql = "SELECT *
          FROM subjects
          ORDER BY name";
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


function validateUsername($username, $checkUsed = true, $idException = null) {

  /*
  This function takes as input $username : string and returns array with values:
  ['username_err'] => Message about why there is error with username;
  ['username_avail'] => Message if username is available.
  ['username_validate'] => Bool to show whether this input username is valid as username in app.

  $checkUsed = false will turn off validation to see if it is already in use
  $idException = id of user you are checking to ensure that, when updating a record, it does not validate against its own name inthe database.
  */
  
  global $conn;
  $username_err = $username_avail = "";
  $username_validate =  $user_avail_validate = $user_rule_validate = 0;

  

  //USERNAME  
  //Check if username is already taken
  if(empty(trim($username))) {
    $username_err = "Please enter a username";

    //Check to see whether blank username is already entered
    if(isset($idException)) {
      $usernameById = getUserInfo($idException)['username'];
      if($username == $usernameById) {
        $username_err = "";
        $username_validate = 1;
      }
      

    }  
  } else {
    $username = trim($username);
    
    //Control to allow function to work without checking username (e.g. for use in update validations)
    if($checkUsed == true) {
      //Prepare statement to check username:
      $sql = "SELECT LOWER(username), id FROM users WHERE username = ?";
      if($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $param_username);
        
        //Set parameters
        $param_username = strtolower($username);
        if($stmt->execute()) {
          $stmt->store_result();

          if ($stmt->num_rows>0) {
            $username_err = $username." is registered by another user. Please try another username.";
            $stmt->bind_result($col1, $col2);
            $stmt->fetch();
            
            //Allow validation if the id with the username is the same as the usernameException variable (to allow validation of itsself when updating a form)
            if($col2 == $idException) {
              $username_err = "";
              $user_avail_validate = 1;

            }

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

    //Temporary code to bypass password validation if required:

      $password_err = "";
      $password_validate = 1;

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

  //Ensure that empty groupIdArray is entered as blank not [""];

  if($groupIdArray == '[""]') {
    $groupIdArray = "";
  }

  $stmt->bind_param("ssssssssisissiiss", $firstName, $lastName, $username, $password_hash, $usertype_std, $permissions, $usertype, $email_name, $active, $datetime, $privacy_bool, $datetime, $version, $schoolId, $userCreate, $groupIdArray, $passwordEntry);
  
  $stmt->execute();

  $results = ['username'=>$username, 'datetime'=>$datetime];

  return $results;



}

/*
Used in: 
-newuser.php
*/

function getUserByUsernameDatetime($entry) {
  //This function is designed for the specific use of retrieving id from table users in the immediate afterward of a new account being registered
  //$entry is an array with ('username'=> , 'datetime'=> )

  global $conn;
  $return = "";
  $sql = "SELECT id
          FROM users
          WHERE username = ? AND time_added = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $entry['username'], $entry['datetime']);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result ->num_rows>0) {
    $row = $result->fetch_assoc();
    $return = $row['id'];
  }
  
  return $return;

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
  
  $listedTeachers = (array) json_decode($row1['teachers']);

  if($method == "add") {
    if(array_search($teacherId, $listedTeachers) === false) {
      array_push($listedTeachers, $teacherId);
    }
  } 
  if($method == "remove") {
    if (($key = array_search($teacherId, $listedTeachers)) !== false) {
      unset($listedTeachers[$key]);
      //Ensure that unset array values are re-ordered
      $listedTeachers = array_values($listedTeachers);
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
  
  //Ensure that it will work even if user is not in a class
  if ($row['groupid_array'] !="") {
    $listedGroups = json_decode($row['groupid_array']);
  }
  else {
    $listedGroups = array();
  }
  if($method == "add") {
    if(array_search($groupId, $listedGroups) === false) {
      array_push($listedGroups, $groupId);
    }
  } 
  if($method == "remove") {
    if (($key = array_search($groupId, $listedGroups)) !== false) {
      unset($listedGroups[$key]);
      //Ensure that unset array values are re-ordered
      $listedGroups = array_values($listedGroups);
    }
  }
  //print_r($listedGroups);
  $listedGroups = json_encode($listedGroups);
  
  //Ensure empty arrays are entered as blank, not [""]
  if ($listedGroups =='[""]') {
    $listedGroups = "";
  }
  //echo $listedGroups;
  $sql2 = "UPDATE users
          SET groupid_array = ?
          WHERE id = ?";
  $stmt=$conn->prepare($sql2);
  $stmt->bind_param("si", $listedGroups, $studentId);
  $stmt->execute();
  



}

function updateGroupInformation($groupId, $name, $subjectId, $optionGroup, $dateFinish, $examBoard) {

  global $conn;
  $sql = "UPDATE groups
          SET name =?, subjectId = ?, optionGroup =?, dateFinish = ?, examBoard = ?, subject = ?, qualType = ?
          WHERE id = ?";
  $subjectInfo = getSubjectInfo($subjectId);
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("sisssssi", $name, $subjectId, $optionGroup, $dateFinish, $examBoard, $subjectInfo['subjectName'], $subjectInfo['level'], $groupId);
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

  $sql = "SELECT r.*, ROUND(TIMESTAMPDIFF(SECOND, r.timeStart, r.datetime)/60,2) duration, u.name_first, u.name_last, q.quizName quizNamefromDB, a.assignName, a.id assignId, a.dateDue
          FROM responses r
          
          LEFT JOIN users u
          ON r.userID = u.id

          LEFT JOIN mcq_quizzes q
          ON r.quizID = q.id
          
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

function getMCQquizResults2($userId = null, $assignId = null) {
  /*
  Updated version of getMCQquizResults() to use up-to-date standard with bindArray etc.

  used in:
  -user_work_review.php
  */
  global $conn;
  $results = array();

  $params = "";
  $bindArray = array();
  $conjoiner = 0;
  $tableAlias = "";

  $sql = "SELECT r.*, ROUND(TIMESTAMPDIFF(SECOND, r.timeStart, r.datetime)/60,2) duration, u.name_first, u.name_last, q.quizName quizNamefromDB, q.topic, a.assignName, a.id assignId, a.dateDue
    FROM responses r
    
    LEFT JOIN users u
    ON r.userID = u.id

    LEFT JOIN mcq_quizzes q
    ON r.quizID = q.id
    
    LEFT JOIN assignments a
    ON r.assignID = a.id ";

  if($userId) {
    $conjoin = ($conjoiner == 0) ? " WHERE " : " AND ";
    $sql .= $conjoin;
    $sql .= $tableAlias;
    $sql .= "userID = ? ";
    $params .= "i";
    array_push($bindArray, $userId);
    $conjoiner = 1;
  }

  if(!is_null($assignId)) {
    $conjoin = ($conjoiner == 0) ? " WHERE " : " AND ";
    $sql .= $conjoin;
    $sql .= $tableAlias;
    $sql .= "assignId = ? ";
    $params .= "i";
    array_push($bindArray, $assignId);
    $conjoiner = 1;
  }

   // WHERE userID = ?
  
  
  $sql .=  "ORDER BY r.id";

  $stmt = $conn->prepare($sql);
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
  }

  return $results;


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

function getMCQquizResultsByAssignment($assignId) {
  /*
  Returns an array of MCQ quiz results given assignment ID.

  Used in:
  -mcq_assignment_review.php
  */
  global $conn;
  $data = array();
  $sql = "SELECT r.id, r.mark, r.percentage, r.answers, r.timeStart, r.datetime, d.maxdatetime, d.mindatetime, ROUND(TIMESTAMPDIFF(SECOND, r.timeStart, r.datetime)/60,2) duration, r.assignID, r.userID, u.name_first, u.name_last, a.assignName, a.dateDue
          FROM responses r
          LEFT JOIN (
            SELECT userID, MAX(datetime) AS maxdatetime, MIN(datetime) AS mindatetime
            FROM responses
            WHERE assignID = ?
            GROUP BY userID
          ) d ON r.userID = d.userID
          LEFT JOIN users u
          ON r.userID = u.id
          LEFT JOIN assignments a
          ON r.assignID = a.id
          WHERE assignId = ?
          ORDER BY r.datetime
          "; 
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $assignId, $assignId);
  $stmt->execute();
  $result=$stmt->get_result();

  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $row['answers'] = json_decode($row['answers']);
      array_push($data, $row);
    }
  }

  return $data;

}



function getMCQindividualQuestionResponse($question, $results_array) {
  /*
  This function will take a given $results_array and find the results for a given $question and return
  $results_array is the json_decode output that we get from responses table that looks like this:
  Array ( [0] => Array ( [0] => 1202.100116 [1] => C [2] => B [3] => ) 
          [1] => Array ( [0] => 1101.170609 [1] => C [2] => C [3] => 1 ) . . . etc
  */
  foreach ($results_array as $result) {
    if ($result[0] == $question) {
      $output = array('question'=>$result[0], 'answer'=>$result[1], 'correct_answer'=>$result[2], "correct"=>$result[3]);
      //print_r($output);
      return $output;
    }
  }
}


function createAssignment($teacherid, $assignName, $quizID, $notes, $dueDate, $type, $classID, $return = 1, $active = 1, $randomQuestions = 0, $randomOptions = 0, $markBookShow = 1) {
  /*
  Used in:
  -assign_create1.0.php

  */
  global $conn;

  $classID_array = array($classID);
  $classID_array = json_encode($classID_array);

  $datetime = date("Y-m-d H:i:s");

  $sql = "INSERT INTO assignments (assignName, quizid, groupid, notes, dateCreated, type, dateDue, groupid_array, userCreate, assignReturn, active, randomQuestions, randomOptions, markBookShow) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("siisssssiiiiii", $assignName, $quizID, $classID, $notes, $datetime, $type, $dueDate, $classID_array, $teacherid, $return, $active, $randomQuestions, $randomOptions, $markBookShow);

  $stmt->execute();

}

function getAssignmentData($assignId) {
  /*
  Used in:
  -assign_create1.0
  */

  global $conn;
  $sql = "SELECT * FROM assignments WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $assignId);
  $stmt->execute();
  $result=$stmt->get_result();
  if($result->num_rows>0) {
    $row = $result->fetch_assoc();
    return $row;
  }
  

}

function updateAssignment($userId, $assignId, $assignName, $quizID, $notes, $dueDate, $type, $classID, $return, $review, $multi, $active, $randomQuestions, $randomOptions, $markBookShow) {
  global $conn;

  $classID_array = array($classID);
  $classID_array = json_encode($classID_array);

  $sql = "UPDATE assignments SET assignReturn = ?, dateDue = ?, notes = ?, assignName =?, groupid_array =?, groupid = ?, reviewQs = ?, multiSubmit = ?, active = ? , randomQuestions = ?, randomOptions = ?, markBookShow = ? WHERE id = ?";
  $stmt = $conn->prepare($sql);

  $stmt->bind_param("issssiiiiiiii", $return, $dueDate, $notes, $assignName, $classID_array, $classID, $review, $multi, $active, $randomQuestions, $randomOptions, $markBookShow, $assignId);

  //The following script validates to ensure that the user updating the assignment is hte assignment author:

  $assignmentData = getAssignmentData($assignId);
  $assignmentDataUser = $assignmentData['userCreate'];

  if($assignmentDataUser == $userId) {
    $stmt->execute();
    //header("Refresh:0");
    return "Record ".$assignId." updated successfully.";
  }
  else {
    return "Value not updated: userid does not match userCreate";
  }


}

function getAssignmentsByGroup($groupId, $limit = 1000, $type = null, $ascdsc = 'desc') {
  /*
  Used in:
  -mcq_assignment_review.php

  */
  global $conn;

  $responses = array();

  $sql = "SELECT * 
  FROM assignments 
  WHERE groupid = ? ";

  if($type) {
    $sql .= " AND type = ? ";
  }

  $sql .= " ORDER BY dateDue ".$ascdsc." 
   LIMIT ?";

  $stmt=$conn->prepare($sql);
  
  if($type) {
    $stmt->bind_param("isi", $groupId, $type, $limit);
  } else {

  $stmt->bind_param("ii", $groupId, $limit);
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

function newUploadsRecord($userid, $path, $altText = "", $root, $notes) {
  /*
  Update upload_record table with new records

  used in:
  -upload/form.php
  */

  global $conn;
  $datetime = date("Y-m-d H:i:s");
  $sql = "INSERT INTO upload_record
          (userCreate, dateTime, path, altText, uploadRoot, notes)
          VALUES (?,?,?,?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("isssss", $userid, $datetime, $path, $altText, $root, $notes);
  $stmt->execute();

  //echo $altText." is this as in the function.";


}

function getUploadsInfo($assetId = null) {
  /*
  Used to retrieve inforation on assets contained in upload_record

  Used in:
  -asset_list.php
  */

  global $conn;
  $params="";
  $bindArray = array();
  $results = array();

  $sql=   "SELECT *
          FROM upload_record";
  
  if($assetId) {
    $sql .= " WHERE id = ? ";
    $params .= "i";
    array_push($bindArray, $assetId);

  }

  $sql .= " ORDER BY id DESC ";

  $stmt=$conn->prepare($sql);
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }

  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
  }
  return $results;

}

function jsonEncoder($string) {
  $string = explode(",",$string);
  return json_encode($string);
}
function jsonDecoder($string) {
  if($string) {
    $string = json_decode($string);
    //print_r($string);
    //var_dump($string);
    $string2 = "";
    foreach ($string as $key=>$value) {
      $string2 .= $value;
      if($key<(count($string)-1)) {
        $string2 .= ",";
      }

    }
    //return implode($string,",");
    return $string2;
  }
}

function insertPastPaperQuestion($userCreate, $questionCode, $quesitonNo, $examBoard, $level, $unitNo, $unitName, $year, $quesitonText, $answerText, $questionAssets, $markSchemeAssets, $examReportAssets, $topic, $keywords, $marks, $caseId, $caseBool, $dataBool, $examPaperLink, $markSchemeLink, $examReportLink) {

  /*
  This function inserts new Past Paper Question into pastpaper_question_bank
  Used in:
  -pastpapers_questions.php
  */

  global $conn;
  date_default_timezone_set('Europe/London');
  $datetime = date("Y-m-d H:i:s");
  $active = 1;
  $series = "June";
  $specYear = 2015;

  $questionAssets_array = jsonEncoder($questionAssets);
  $markSchemeAssets_array = jsonEncoder($markSchemeAssets);
  $examReportAssets_array = jsonEncoder($examReportAssets);

  $sql = "INSERT INTO pastpaper_question_bank
          (userCreate, No, questionNo, examBoard, qualLevel, component, unitName, year, question, answer, questionAssets, markSchemeAssets, examReportAssets, topic, keywords, dateCreate, active, series, marks, questionAssets_array, markSchemeAssets_array, examReportAssets_array, caseId, caseBool, specYear, dataBool, examPaperLink, markSchemeLink, examReportLink)
          VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("isssssssssssssssisisssiiiisss", $userCreate, $questionCode, $quesitonNo, $examBoard, $level, $unitNo, $unitName, $year, $quesitonText, $answerText, $questionAssets, $markSchemeAssets, $examReportAssets, $topic, $keywords, $datetime, $active, $series, $marks, $questionAssets_array, $markSchemeAssets_array, $examReportAssets_array, $caseId, $caseBool, $specYear, $dataBool, $examPaperLink, $markSchemeLink, $examReportLink);
  $stmt->execute();

}

function getPastPaperQuestionDetails($id=null, $topic=null, $questionCode=null, $examBoard = null, $year = null, $component = null, $qualLevel = null, $caseStudiesFilter = null, $dataFilter = null, $excludedYear=null, $dateBefore = null) {
  /**
   * This function retrieves information on past paper questions from pastpaper_question_bank
   *
   * 
   * Controls:
   * -$caseStudiesFilter: if set as anything then all values with caseStudyBool are filtered out; if set to '2' then only case studies are returned
   * - $dataFilter: if set as anything then all value with dataBool are filtered out; if set to '2' then only dataBool values are returned.
   * 
   * - $dateBefore: sets a date after which no values are returned from database. Allows changes to allow new uploads to be completed before put onto production site


   * Used in:
   * -pastpapers_questions.php
   */

   global $conn;
   $results = array();

   $params = "";
   $bindArray = array();
   $conjoiner = 0;
   $tableAlias ="q.";

   $sql = " SELECT q.*, t.topicName, d.examPaperLink, d.markSchemeLink, d.examReportLink
            FROM pastpaper_question_bank q 
            LEFT JOIN topics t
            ON q.topic = t.topicCode ";

    $sql .= "
            LEFT JOIN (
              SELECT examPaperLink, markSchemeLink, examReportLink, unitName, year
              FROM pastpaper_question_bank
              WHERE dataBool = 1
            ) d
            ON (q.unitName = d.unitName AND q.year = d.year) ";

    
    if($id) {
      $conjoin = ($conjoiner == 0) ? " WHERE " : " AND ";
      $sql .= $conjoin;
      $sql .= $tableAlias;
      $sql .= "id = ? ";
      $params .= "i";
      array_push($bindArray, $id);
      $conjoiner = 1;
    }

    if($topic) {
      $conjoin = ($conjoiner == 0) ? " WHERE " : " AND ";
      $sql .= $conjoin;
      $sql .= $tableAlias;
      $sql .= "topic LIKE ? ";
      $topic = $topic."%";
      $params .= "s";
      array_push($bindArray, $topic);
      $conjoiner = 1;
    }

    if($questionCode) {
      $conjoin = ($conjoiner == 0) ? " WHERE " : " AND ";
      $sql .= $conjoin;
      $sql .= $tableAlias;
      $sql .= "No LIKE ? ";
      $questionCode = $questionCode."%";
      $params .= "s";
      array_push($bindArray, $questionCode);
      $conjoiner = 1;
    }

    if($examBoard) {
      $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
      $sql .= $tableAlias;
      $sql .= "examBoard = ? ";
      $params .= "s";
      array_push($bindArray, $examBoard);
      $conjoiner = 1;
    }

    if($year) {
      $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
      $sql .= $tableAlias;
      $sql .= "year = ? ";
      $params .= "s";
      array_push($bindArray, $year);
      $conjoiner = 1;
    }

    if($component) {
      $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
      $sql .= $tableAlias;
      $sql .= "component = ? ";
      $params .= "i";
      array_push($bindArray, $component);
      $conjoiner = 1;
    }

    if($qualLevel) {
      $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
      $conjoiner = 1;
      $sql .= $tableAlias;
      $sql .= "qualLevel = ? ";
      $params .= "s";
      array_push($bindArray, $qualLevel);
    }

    if($caseStudiesFilter) {
      $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
      $notSelector = ($caseStudiesFilter == 2) ? " NOT " : "";
      $conjoiner = 1;
      $sql .= "caseBool IS ".$notSelector." NULL ";
    }

    if($dataFilter) {
      $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
      $notSelector = ($dataFilter == 2) ? " NOT " : "";
      $conjoiner = 1;
      $sql .= "dataBool IS ".$notSelector." NULL ";
    }

    if($excludedYear) {
      $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
      $conjoiner = 1;
      $sql .= $tableAlias;
      $sql .= "year <>  ? ";
      $params .= "s";
      array_push($bindArray, $excludedYear);
    }

    if($dateBefore) {
      $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
      $conjoiner = 1;
      $sql .= $tableAlias;
      $sql .= "dateCreate < ? ";
      $params .= "s";
      array_push($bindArray, $dateBefore);
    }



  $sql .= " ORDER BY component, qualLevel, year, unitName, questionNo";

  //echo $sql;

  $stmt = $conn->prepare($sql);
  if(count($bindArray)>0) {
    $stmt->bind_param($params, ...$bindArray);
  }
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      /*
      $row['questionAssets'] = jsonDecoder($row['questionAssets']);
      $row['markSchemeAssets'] = jsonDecoder($row['markSchemeAssets']);
      $row['examReportAssets'] = jsonDecoder($row['examReportAssets']);
      */
      array_push($results, $row);
    }
  }

  return $results;


}

function updatePastPaperQuestionDetails($id, $question, $answer, $questionAssets, $markSchemeAssets, $examReportAssets, $topic, $keywords, $explanation, $marks, $caseId, $caseBool, $examPaperLink, $markSchemeLink, $examReportLink, $guide, $modelAnswer, $modelAnswerAssets) {
  /**
   * Used to update pastpaper_question_bank
   * Used in:
   * -pastpapers_questions.php
   */

  $questionAssets_array = jsonEncoder($questionAssets);
  $markSchemeAssets_array = jsonEncoder($markSchemeAssets);
  $examReportAssets_array = jsonEncoder($examReportAssets);
  $modelAnswerAssets_array = jsonEncoder($modelAnswerAssets);

   global $conn;
   $sql = " UPDATE pastpaper_question_bank
            SET question = ?, answer = ?,  questionAssets = ?, markSchemeAssets = ?, examReportAssets =?, topic = ?, keywords = ?, explanation = ?, marks = ?, questionAssets_array = ?, markSchemeAssets_array = ?, examReportAssets_array = ?, caseId = ?, caseBool = ?, examPaperLink=?, markSchemeLink=?, examReportLink = ?, guide = ?, modelAnswer = ?, modelAnswerAssets =?, modelAnswerAssets_array = ?
   WHERE id = ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("ssssssssisssiisssssssi", $question, $answer, $questionAssets, $markSchemeAssets, $examReportAssets, $topic, $keywords, $explanation, $marks, $questionAssets_array, $markSchemeAssets_array, $examReportAssets_array, $caseId, $caseBool, $examPaperLink, $markSchemeLink, $examReportLink, $guide, $modelAnswer, $modelAnswerAssets, $modelAnswerAssets_array, $id);
  $stmt->execute();

}

function getPastPaperCategoryValues($topic=null, $examBoard = null, $year = null, $component = null, $qualLevel = null, $unitName = null, $excludedYear = null, $dateBefore = null) {
  /**
   * This function returns unique category values from pastpaper_question_bank for purposes of updating input drop-downs etc.
   * 
   * Used in:
   * -pastpapers/questions.php
   */

   global $conn;
   

   $categories = array('topic', 'examBoard', 'qualLevel', 'component', 'unitName', 'year');
   $categoryResults = array();

   $calledVariable = "";


   foreach($categories as $category) {

      $results = array();
      $params = "";
      $bindArray = array();
      $conjoiner = "";
      $tableAlias = "";

      /*
      for($x=0; $x<count($categories); $x++) {
        if ($category == $categories[$x]) {
          $calledVariable = $category;
        }
      }
      */

      switch($category) {
        case 'topic':
          $calledVariable = $topic;
          break;
        case 'examBoard':
          $calledVariable = $examBoard;
          break;
        case 'qualLevel':
          $calledVariable = $qualLevel;
          break;
        case 'component':
          $calledVariable = $component;
          break;
        case 'unitName':
          $calledVariable = $unitName;
          break;
        case 'year':
          $calledVariable = $year;
          break;


      }

      $sql = " SELECT DISTINCT ".$category;
      $sql .= " FROM pastpaper_question_bank";
      //echo $sql;

      if($category == 'topic') {
        $sql = "SELECT DISTINCT q.topic, t.topicName
            FROM pastpaper_question_bank q 
            LEFT JOIN topics t
            ON q.topic = t.topicCode ";
            $tableAlias = "q.";
        //$category = "topic";
      }
      //var_dump($calledVariable);
      //if(!$calledVariable) {
        

        if($topic) {
          $conjoin = ($conjoiner == 0) ? " WHERE " : " AND ";
          $sql .= $conjoin;
          $sql .= $tableAlias;
          $sql .= "topic LIKE ? ";
          $topic = $topic."%";
          $params .= "s";
          array_push($bindArray, $topic);
          $conjoiner = 1;
        }

        if($examBoard) {
          $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
          $sql .= $tableAlias;
          $sql .= "examBoard = ? ";
          $params .= "s";
          array_push($bindArray, $examBoard);
          $conjoiner = 1;
        }
    
        if($year) {
          $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
          $sql .= $tableAlias;
          $sql .= "year = ? ";
          $params .= "s";
          array_push($bindArray, $year);
          $conjoiner = 1;
        }
    
        if($component) {
          $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
          $sql .= $tableAlias;
          $sql .= "component = ? ";
          $params .= "i";
          array_push($bindArray, $component);
          $conjoiner = 1;
        }
    
        if($qualLevel) {
          $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
          $conjoiner = 1;
          $sql .= $tableAlias;
          $sql .= "qualLevel = ? ";
          $params .= "s";
          array_push($bindArray, $qualLevel);
        }

        if($excludedYear) {
          $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
          $conjoiner = 1;
          $sql .= $tableAlias;
          $sql .= "year <>  ? ";
          $params .= "s";
          array_push($bindArray, $excludedYear);
        }

        if($dateBefore) {
          $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
          $conjoiner = 1;
          $sql .= $tableAlias;
          $sql .= "dateCreate < ? ";
          $params .= "s";
          array_push($bindArray, $dateBefore);
        }

      //}

      $sql .= ($conjoiner == 0) ? " WHERE " : " AND ";
      $sql .= "caseBool IS NULL AND dataBool IS NULL ";
      $sql .= " ORDER BY ".$category;

      //echo $sql;

      $stmt = $conn->prepare($sql);
      if(count($bindArray)>0) {
        $stmt->bind_param($params, ...$bindArray);
      }
      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows>0) {
        while($row = $result->fetch_assoc()) {
          
          if($category == 'topic') {
            $row[$category] = $row['topic']."###".$row['topicName'];
          }
          
          array_push($results, $row[$category]);
          //$results = $row[$category];
        }
      }
      $categoryResults[$category] = $results;
    }

    return $categoryResults;

  
}

function shuffle_assoc($list) { 
  if (!is_array($list)) return $list; 

  $keys = array_keys($list); 
  shuffle($keys); 
  $random = array(); 
  foreach ($keys as $key) { 
    $random[$key] = $list[$key]; 
  }
  return $random; 
}


?>
