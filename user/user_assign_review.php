<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");


if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");
  
}

else {
  $userInfo = getUserInfo($_SESSION['userid']);
  $userId = $_SESSION['userid'];
  $permissions = $userInfo['permissions'];

  /*
  $groupid = array();
  if($userInfo['groupid_array'] != "") {
    $groupid = json_decode($userInfo['groupid_array']);
  }
  */

  $groupid_array = array();
  if($userInfo['groupid_array'] != "") {
    $groupid_array = json_decode($userInfo['groupid_array']);
  }


}



$style_input = "

td, th {
	
	border: 1px solid black;
	padding: 5px;
}

table {
	
	border-collapse: collapse;
}

h2 {
	//border-top: 1px solid black;
}

.noReturn	{
	
	
	background-color: #FFFF00;
}

.noComplete {
	
	color: red;
}

";

$startDate = "20200901";  

$get_selectors = array(
  'groupid' => (isset($_GET['groupid']) && $_GET['groupid']!="") ? $_GET['groupid'] : null,
  'studentid' => (isset($_GET['studentid']) && $_GET['studentid']!="") ? $_GET['studentid'] : null,
  'allstudents' => (isset($_GET['allstudents']) && $_GET['allstudents']!="") ? $_GET['allstudents'] : null,
  'startDate' => (isset($_GET['startDate']) && $_GET['startDate']!="") ? $_GET['startDate'] : $startDate

);


include($path."/header_tailwind.php");

?>


<div class=" mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">All Assignments Review</h1>
  <div class="  mx-auto p-4 mt-2 bg-white text-black mb-5">
    <p>Name: <?=$userInfo['name_first']?> <?=$userInfo['name_last']?></p>
    <p>This page contains all the assignments that have been given to you or your class.</p>
    <p>You can use this page to ensure you are up to date with your work, or re-submit assignments. This is the same information your teacher sees when processing report data.</p>




    <?php

    $assignments = getAssignmentsArray($groupid_array, $get_selectors['startDate'], 1);

    //Use below to negate $startDate variable:
    $assignments = getAssignmentsArray($groupid_array, null, 1);

    if(isset($_GET['test'])) {
      echo "<pre>";
      print_r($groupid_array);
      print_r($assignments);
      echo "</pre>";
    }

    //Use $userInfo array for $student variable in user_assignment_list_embed.php

    $student = $userInfo;

    if(count($assignments)>0) {

    ?>

    
      <h2 class="bg-sky-200 pl-1 my-2 rounded-r-lg">Assignment Summary</h2>

      <?php
        include("user_assignment_list_embed.php");
      ?>

    <?php
    }


    $userid = $userId;
    if(count($groupid_array) > 0) {
      ?>
      
      <table style="display:none">
        <tr>
        <th>ID
        </th>
        <th>Assignment Name
        </th>
        <!--
        <th>quizid
        </th>
        <th>groupid
        </th>
        <th>notes
        </th>
        -->
        <th>Date Assigned
        </th>

        <th>Due Date
        </th>
        <th>Type
        </th>
        <th>
        Your Score(s)
        </th>

        <th>
        Assignment Link
        </th>
        </tr>

        <?php
        }




          $assignments = getAssignmentsArray($groupid_array, null, 1);
          //print_r($assignments);



          foreach($assignments as $value) {
            echo "<tr>";
              echo "<td>".$value['id']."</td>";
              echo "<td>".$value['assignName']."</td>";
              echo "<td>".date("Y-m-d",strtotime($value['dateCreated']))."</td>";
              echo "<td>".$value['dateDue']."</td>";
              if($value['type'] == 'mcq') {
                echo "<td>MCQ</td>";
              }
              else if($value['type'] == 'sqa') {
                echo "<td>Short Answer</td>";
              }
              else {
                echo "<td>".$value['type']."</td>";
              }
              
              if ($value['type'] == "mcq") {
                
                echo "<td>";
                
                $query = "SELECT * FROM responses WHERE userID = ".$userid." AND assignID =".$value['id'];

                $result = $conn->query($query);
                
                
                      $query2 = "SELECT assignReturn FROM assignments WHERE id = ".$value['id'];
                      $result2 = $conn->query($query2);
                      if ($result2->num_rows>0) {
                        
                      $row2 = $result2 -> fetch_assoc();
                      //mysqli_fetch_array($result2, MYSQLI_ASSOC);
                          
                      if ($row2['assignReturn'] == 1 or $row2['assignReturn'] == null) {
                          
                          
                          $assignReturn = 1;
                        }
                        
                      else {
                          
                          $assignReturn = 0;
                        }
                        
                        //$assignReturn = $row2[assignReturn];
                          
                        
                        
                        
                        
                      }
                
                
                  if ($assignReturn == 0) {
                    
                    echo "<span class='noReturn'>Not Yet Returned</span>";
                    
                  }
                
                  else {
                
                  if ($result->num_rows>0 ) {


                    
                    while ($row = $result->fetch_assoc()) {
                      
                      //print_r($row);
                      
                      
                      $s = $row['datetime'];
                      $dt = new DateTime($s);

                      $date = $dt->format('d.m.y');
                      //$time = $dt->format('H:i:s');

                      //echo $date, ' | ', $time;
                      
                      
                      echo $row['percentage']."&percnt; (".$date.")";
                      echo "<br>";
                      
                      
                    
                      }
                  
                  }
                  }
                echo "</td>";
                echo "<td>";

          // THIS IS WHERE TO CHANGE THE LINK AFTER MAKING CHANGES TO MCQ PAGE

                echo "<a href = '../mcq/mcq_exercise.php?assignid=".$value['id']."'>Link to MCQ</a>";
                echo "</td>";
                
                
              }
              
              if ($value['type'] == "saq") {
                
                echo "<td>";
                
                
                $query = "SELECT * FROM saq_saved_work WHERE userID = '".$userid."' AND submit=1 AND assignID = '".$value['id'  ]."'";

                $result = $conn->query($query);
                
                if ($result) {
                  
                  if ($result->num_rows==0) {
                      
                      echo "<span class = 'noComplete'>Not yet submitted</span>";
                    }

                  
                  while ($row = $result->fetch_assoc()) {
                  $s = $row['datetime'];
                  $dt = new DateTime($s);
                  $date = $dt->format('d.m.y');
                  echo "Submitted: ".$date."<br>";
                  //echo "Submitted: ".$row[datetime]."<br>";
                  
                  if ($row['returned'] == 1) {
                  //echo "Returned<br>";
                  echo "Score: ".$row['percentage']."&percnt;<br>";
                  }
                  else {
                  echo "<span class='noReturn'>Not Yet Returned</span><br>";
                  }
                  /*
                  echo $row[assignID];
                  echo $row[exerciseName];
                  echo $row[mark];
                  echo $row[percentage];
                  echo $row[datetime];
                  echo $row[submit];
                  echo $row[returned];
                  //echo "<form method = 'post'><input type='hidden' name = 'responseid' value = '".$row[id]."'><input type='hidden' name = 'userid' value = '".$row[userID]."'><input type='submit' value = 'Review'></form>";
                  //print_r($row);
                  
                  */
              
                  }
                }
                
                echo "</td>";
                echo "<td>";
                
                  $query = "SELECT * FROM saq_saved_work WHERE userID = '".$userid."' AND submit=1 AND assignID = '".$value['id']."'";

                  $result = $conn->query($query);
                  
                  if ($result) {

                    if ($result->num_rows== 0) {


          // THIS IS WHERE TO CHANGE THE LINK AFTER MAKING CHANGES TO SAQ PAGE
                      
                      echo "<a href = '../saq/saq1.7.php?assignid=".$value['id']."'>Complete Assignment</a>";
                    }
                    
                    else {
                      
                      echo "<a href = 'user_saq_review2.0.php'>Review Assignments</a>";
                      
                    }
                  }
                
                
                echo "</td>";
                
                
                
              }
              
              if ($value['type'] == "exercise") {
                
                
                echo "<td><em>Not yet entered</em>";
                echo "</td>";
                echo "<td>";
                echo "</td>";
                
              }
              
              
          echo "</tr>";
          }


        if(count($groupid_array) > 0) {
          ?>

      </table>
      

        <?php
        }

      ?>





    </div>
    </div>

  </div>
</div>

<?php   include($path."/footer_tailwind.php");?>