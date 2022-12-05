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



$userId = $_SESSION['userid'];

$userInfo = getUserInfo($userId);

print_r($_POST);

$userid_selected = 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $userid_selected = $_POST['user_select'];
}

//($userInfo);

echo "<br>";



$groupList = getGroupsList($userId);

echo "<pre>";
//print_r($groupList);
echo "</pre>";

foreach($groupList as $array) {
  $classId = $array['id'];
  $classList = getGroupUsers($classId);
  echo "<h2>".$array['name']."</h2>";
  
  echo "<pre>";
  //print_r($classList);
  echo "</pre>";

  echo "<form method='post' action = ''>";
  
  //echo "<form method = 'post' acton = ''>";
  echo "<select name='user_select'>";

  foreach($classList as $val=>$user) {
    //echo $user['name'];
    //echo "<br>";
    //$groupIdArray = json_decode($user['groupid_array']);
    //$userAssignments = getAssignmentsArray($groupIdArray);
    //print_r($userAssignments);
    //echo "<br>";
    //$userid = $user['id'];

 

    echo "<option value = ".$user['id'];
    
    if(isset($_POST['user_select']) && $_POST['user_select'] == $user['id']) {
      echo " selected ";
    }
    
    echo ">".$user['name']."</option>";

?>


<?php
    /*
    echo "<input type='checkbox' name = 'user_".$user['id']."' value = '".$user['id']."'>".$user['name_first']." ".$user['name_last']."</input><br>";
    
    echo "<form method='post' action = ''>";
    
    echo "<input name='userid_select' type ='hidden' value = '".$user['name']."'>";
    echo "<button onclick = 'this.form.submit()'>".$user['name']."</button>";

    echo "</form>";
    */

  }

  echo "</select>";
  echo "<br>";
  echo "<input type = 'submit'>";
  echo "</form>";


}

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">

    <!--

    $_GET variables:
      startDate: set in 20221203 format; sets date that assignment list starts. Otherwise default as below

      <?php

      $startDate = "20220901";

      if(isset($_GET['startDate'])) {
        $startDate = $_GET['startDate'];
      }



      ?>


-->
    <head>

              <style>

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

              </style>

  </head>
  <body>









                <?php
                $user_info = getUserInfo($userid_selected);

                echo "<h2>".$user_info['name']."</h2>";


                ?>

                <table class = "copyTo" id="summaryTable">
                  <tr>
                    <td>
                    <?php echo $user_info['name'];?>
                  </td>
                  </tr>
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

                $user_selected = $userid_selected;

                $user = $user_info;
                //print_r($user);

                $groupid_array = json_decode($user['groupid_array']);

                //print_r($groupid_array);

                $userAssignments = getAssignmentsArray($groupid_array, $startDate);

                

                $assignments = $userAssignments;
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
                      
                      $query = "SELECT * FROM responses WHERE userID = ".$user_selected." AND assignID =".$value['id'];
                
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
                
                      echo "<a href = '../mcq/login.php?assignid=".$value['id']."'>Link to MCQ</a>";
                      echo "</td>";
                      
                      
                    }
                    
                    if ($value['type'] == "saq") {
                      
                      echo "<td>";
                      
                      
                      $query = "SELECT * FROM saq_saved_work WHERE userID = '".$user_selected."' AND submit=1 AND assignID = '".$value['id'  ]."'";
                
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
                      
                        $query = "SELECT * FROM saq_saved_work WHERE userID = '".$user_selected."' AND submit=1 AND assignID = '".$value['id']."'";
                
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
                
                ?>

              <tr>
                <td colspan=4>
                  Flashcard Summary <br>
                  <?php
                      $flashcards = flashCardSummary($userid_selected, "count");
                      //print_r($flashcards);
                      echo "Total Completed: ".$flashcards[0]['count'];

                      $flashcards = flashCardSummary($userid_selected, "count_category");
                      //print_r($flashcards);
                      echo "<br>";
                      echo "Categories: <br>";
                      foreach($flashcards as $array) {
                        //print_r($array);
                        if ($array['gotRight']==0) {
                          echo "Didn't Know: ";
                        } elseif ($array['gotRight']==1) {
                          echo "Incorrect : ";
                        } elseif ($array['gotRight']==2) {
                          echo "Correct: ";
                        }
                        echo $array['count'];
                        echo "<br>";
                        
                      }


                        $flashcards = flashCardSummary($userid_selected, "average");
                        //print_r($flashcards);
                        echo "Average time taken: ".$flashcards[0]['avg']." seconds<br>";

                        $flashcards = flashCardSummary($userid_selected, "count_by_date");
                        //print_r($flashcards);
                        echo "Dates Completed: ";
                        foreach($flashcards as $array) {
                          echo $array['date'].": ".$array['count']." || ";
                        }


                      
                  


                  ?>
               </td>
              </tr>
                
                </table>


<script>

function copyToClipboard() {
  // Get the text field
  var copyTo = document.getElementsByClassName("copyTo");

  var copyText = "";

  for(var i=0; i<copyTo.length; i++) {
    copyText += copyTo[i];
  }

  console.log(copyText);

  // Select the text field
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile devices


   // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);

  // Alert the copied text
  alert("Copied the text: " + copyText.value);
}

//copyToClipboard();


function copytable(el) {
    var urlField = document.getElementById(el)   
    var range = document.createRange()
    range.selectNode(urlField)
    window.getSelection().addRange(range) 
    document.execCommand('copy')
    console.log("this worked");
}

copytable("summaryTable");

  </script>

    
</body>
</html>