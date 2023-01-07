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
  if (!(str_contains($permissions, 'teacher'))) {
    header("location: /index.php");
  }
}

$style_input = "
.hide {
  display: none;
  }
  input, button, textarea, th, td, select {
    border: 1px solid black;
  }
  td, th {
    padding: 5px;
  }";





include($path."/header_tailwind.php");



if($_SERVER['REQUEST_METHOD']==='POST') {
  if($_POST['submit'] == "Update") {

      //Process validation and enter into users database:

      $firstName = $lastName = $username= $email_name = "";
      $username_err =  $password_err = $email_err = $name_err="";
      $name_validate = $username_validate = $password_validate = $email_validate = 0;
      $fn_validate = $ln_validate = $user_avail_validate = $user_rule_validate = $pass_match_validate = $pass_rule_validate = $privacy_validate = $usertype_validate = 0;

      //First Name and Last Name
      //Check to see that first and last names are entered in
      if(empty(trim($_POST['name_first']))) {
        $name_err = "Please enter a name";
      } else {
        $firstName = trim($_POST['name_first']);
        $fn_validate = 1;
      }

      if(empty(trim($_POST['name_last']))) {
        $name_err = "Please enter a name";
      } else {
        $lastName = trim($_POST['name_last']);
        $ln_validate = 1;
      }

      if($fn_validate ==1 AND $ln_validate ==1) {
        $name_validate = 1;
      } 

      //USERNAME  

      $results = validateUsername($_POST['username']);
      $username_err = $results['username_err'];
      $username_avail = $results['username_avail'];
      $username_validate = $results['username_validate'];
      $username = $results['username'];


      //PASSWORD

      $results = validatePassword($_POST['password'], $_POST['password']);
      $password_err = $results['password_err'];
      $password_validate = $results['password_validate'];
      $password1 = $results['password'];



      //PROCESS VALIDATED INFORMATION


      if($name_validate ==1 AND $username_validate==1 AND $password_validate == 1 /* EMAIL DISABLE AND $email_validate == 1 */) {
        }

        //UPdate user information into users table

  }
}

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">User Manager</h1>
    <div class="font-mono container mx-auto px-0 mt-2 bg-white text-black mb-5">
      <?php
          if($_SERVER['REQUEST_METHOD']==='POST') {
            print_r($_POST);
            echo $username_err;
          }
          $students= getUsercreateUsers($userId, false);
          if(count($students)>0){

            ?>
            <table class="w-full table-fixed ">
              <tr>
                <th>First</th>
                <th>Last</th>
                <th>Username</th>
                <th>Password</th>
                <th>Groups</th>
                <!--
                <th>School</th>
          -->
                <th>Active</th>
                <th>Edit</th>
              </tr>
              <?php
                foreach($students as $row) {
                  ?>
                  <form method = "post" action ="">
                    <tr>
                      <td>
                        <div class="show_<?=$row['id'];?>">
                          <?=htmlspecialchars($row['name_first'])?>
                        </div>
                        <div class="hide hide_<?=$row['id'];?>">
                          <input type="text" name="name_first" value = "<?=htmlspecialchars($row['name_first'])?>">
                        </div>
                      </td>

                      <td>
                        <div class="show_<?=$row['id'];?>">
                          <?=htmlspecialchars($row['name_last'])?>
                        </div>
                        <div class="hide hide_<?=$row['id'];?>">
                          <input type="text" name="name_last" value = "<?=htmlspecialchars($row['name_last'])?>">
                        </div>
                      </td>
                                            
                      <td>
                        <div class="show_<?=$row['id'];?>">
                          <?=htmlspecialchars($row['username'])?>
                        </div>
                        <div class="hide hide_<?=$row['id'];?>">
                          <input type="text" name="username" value = "<?=htmlspecialchars($row['username'])?>">
                        </div>
                      </td>

                                            
                      <td>
                        <div class="show_<?=$row['id'];?>">
                          <?=htmlspecialchars($row['password'])?>
                        </div>
                        <div class="hide hide_<?=$row['id'];?>">
                          <input type="text" name="password" value = "<?=htmlspecialchars($row['password'])?>">
                        </div>
                      </td>

                      <td>
                        <div class="show_<?=$row['id'];?>">
                        <?php
                        $groups = json_decode($row['groupid_array']);
                        //print_r($groups);
                        if($groups[0]!="0") {
                          foreach($groups as $group) {
                            $groupInfo = getGroupInfoById($group);
                            //print_r($groupInfo);
                            echo $groupInfo['name'];
                          }
                        }
                        ?>
                        </div>
                        <div class="hide hide_<?=$row['id'];?>">
                          <a class="hover:underline" href="group_manager.php">Link to Edit Groups</a>
                        </div>
                      </td>

                      <td>
                      <?php
                      /*
                        $school = listSchoolsDfe(null, $row['schoolid']);
                        $school = $school[0];
                        echo $school['SCHNAME'];
                        */
                        ?>

                        <div class="show_<?=$row['id'];?>">
                          <?php
                            if($row['active']=="1") {
                              echo "Active";
                            }
                            else {
                              echo "Inactive";
                            }
                          ?>
                        </div>
                        <div class="hide hide_<?=$row['id'];?>">
                          <input type= "radio" name="active" id="active_<?=$row['id'];?>" value="1" <?=($row['active']=="1")? "checked": ""?>>
                          <label for ="active_<?=$row['id'];?>">Active</label>
                          <br>
                          <input type= "radio" name="active" id="inactive_<?=$row['id'];?>" value="0" <?=($row['active']=="0")? "checked": ""?>>
                          <label for ="inactive_<?=$row['id'];?>">Inactive</label>
                        </div>
                      </td>

                      <td>
                      <?php if($_SESSION['userid'] == $row['userCreate']) {?>
                        <div>
                          <button type ="button" id = "button_<?=$row['id'];?>" onclick = "changeVisibility(this, <?=$row['id'];?>)"">Edit</button>
                        </div>
                        <div class ="hide hide_<?=$row['id'];?>">
                          <input type="hidden" name = "id" value = "<?=$row['id'];?>">

                          <input type="submit" name="submit" value = "Update"></input>
                        </div>
                      <?php }?>
                      </td>

                    </tr>
                  </form>

                  <?php
                }
              ?>
            </table>
            <?php


          }
      ?>

    </div>
</div>


<?php   include($path."/footer_tailwind.php");?>