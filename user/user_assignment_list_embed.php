<?php
/*

This embed is designed to output a standard table showing all assignments given to a given user ($userId) for each of their group lists ($groupid_array)

Before using the following must be defined:

  $groupid_array

    e.g. :
        if($student['groupid_array'] != "") {
          $groupid_array = json_decode($student['groupid_array']);
        }

  $assignments
  
    e.g. $assignments = getAssignmentsArray($groupid_array, $get_selectors['startDate'], 1);

  $student

    e.g. $student = $userInfo

Used in:

-user_work_review.php
-user_assign_review.php


*/

?>

          <table class=" text-xs lg:text-base  mx-auto">
            <tr>
              <td>Assignment</td>
              <td>Due Date</td>
              <td>Type</td>
              <td>Scores</td>
              <td>Link</td>
            </tr>
            <?php
            foreach ($assignments as $assignment) {
              if($assignment['type'] == 'mcq')
              //if($assignment['type'] == 'mcq' || $assignment['type'] == 'saq') 
            {
                ?>
                <tr>
                  <td><?=$assignment['assignName']?>
                  <?php
                    //print_r($assignment);
                    if(count($groupid_array)>1) {
                      $group = getGroupInfoById($assignment['groupid']);
                      ?>
                      <br>
                      <?php
                        //print_r($group);
                        echo $group['name'];
                        ?>
                      <?php
                    }
                  ?>
                  </td>
                  <td><?=date("j M y",strtotime($assignment['dateDue']))?>
                    <!--<br><?=$assignment['dateDue']?>-->
                  </td>

                  <?php
                  if($assignment['type'] == "mcq") {
                    $responses = getMCQquizResults2($student['id'],$assignment['id']);
                    ?>
                    <td>MCQ</td>
                    <td>
                      <?php
                     
                      foreach($responses as $key=> $response) {
                        $duration = $response['duration'];
                        $seconds = $duration * 60;
                        $minutes = floor($duration);
                        $seconds -= $minutes * 60;
                        $seconds = round($seconds,0);

                        $late = null;
                        if($response['datetime'] > $assignment['dateDue'] && $key == 0) {
                          $late = 1;
                        }


                        ?>
                        <b><?=$response['percentage']?>&percnt;</b><br>
                        <span class="<?=$late ? "bg-pink-200": ""?>">(<?=date("d.m.y",strtotime($response['datetime']))?>)</span><br>
                        <!--<?=$response['datetime']?><br>-->
                        <?=$minutes?>m:<?=$seconds?>s<br>
                        <?php
                      }
                      ?>
                    </td>
                    <td><a class="underline text-sky-700" target="blank" href="../mcq/mcq_exercise.php?assignid=<?=$assignment['id']?>">Link to MCQ</a></td>

                    <?php
                  }

                  if($assignment['type'] == "saq") {
                    $responses = getSAQresults($student['id'],$assignment['id'],1);

                    $late = null;
                    if($response['datetime'] > $assignment['dateDue']) {
                      $late = 1;
                    }

                    ?>
                    <td><span class="hidden lg:inline">Short Answer</span><span class="lg:hidden">SA</span></td>
                    <td>
                      <?php
                      if(count($responses) == 0) {
                        ?>
                        <span class = 'noComplete'>Not yet submitted</span>
                        <?php
                      } else {
                        foreach ($responses as $response) {
                          ?>
                          <div class="<?=$late ? "bg-pink-200": ""?>">Submit: <?=date("d.m.y",strtotime($response['datetime']))?></div>
                          <?php
                          if($response['returned'] == 1) {
                            ?>
                            <div>Score: <?=$response['percentage']?>&percnt;</div>
                            <?php
                          } else {
                            ?>
                            <div class='noReturn'>Not Yet Returned</div>
                            <?php
                          }
                        }
                      }
                      ?>
                    </td>
                    <td>
                      <?php
                      if(count($responses)==0) {
                        ?>
                        <span><a class="underline text-sky-700 " href = '../saq/saq1.7.php?assignid=".$assignment['id']."'>Complete Assignment</a></span>
                        <?php
                      } else {
                        ?>
                        <span><a class = "underline text-sky-700" href = 'user_saq_review2.0.php'>Review Assignments</a></span>
                        <?php
                      }
                      ?>
                    </td>
                    <?php

                  }
                  ?>
                  
                </tr>
                <?php
              }
            }
            ?>
          </table>