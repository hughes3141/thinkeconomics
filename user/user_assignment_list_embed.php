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

          <table class=" text-xs lg:text-base">
            <tr>
              <td>Assignment</td>
              <td>Due Date</td>
              <td>Type</td>
              <td>Scores</td>
              <td>Link</td>
            </tr>
            <?php
            foreach ($assignments as $assignment) {
              if($assignment['type'] == 'mcq' || $assignment['type'] == 'saq') {
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
                  <td><?=date("j M y",strtotime($assignment['dateDue']))?></td>
                  <td><?php
                    if($assignment['type'] == 'mcq') {
                      echo "MCQ";
                    } else if($assignment['type'] == 'saq') {
                      echo "Short Answer";
                    }
                  ?></td>
                  <td><?php
                    if($assignment['type'] == "mcq") {
                      $responses = getMCQquizResults2($student['id'],$assignment['id']);
                      //print_r($responses);
                      foreach($responses as $response) {
                        ?>
                        <b><?=$response['percentage']?>&percnt;</b><br>
                        (<?=date("d.m.y",strtotime($response['datetime']))?>)<br>
                        <?=$response['duration']?><br>
                        <?php
                      }
                    }
                    if($assignment['type'] == "saq") {
                      //$responses = 
                    }
                  ?></td>
                  <td>
                    <?php
                    if($assignment['type'] == 'mcq') {
                      ?>
                      <a class="underline text-sky-700" target="blank" href="../mcq/mcq_exercise.php?assignid=<?=$assignment['id']?>">Link to MCQ</a>
                      <?php
                    }
                    ?>
                    
                  </td>
                </tr>
                <?php
              }
            }
            ?>
          </table>