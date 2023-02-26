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
  $groupsList = getGroupsList($userId, true, $userId);
  //print_r($groupsList);
  $hasGroups = 0;
  if(count($groupsList)>0) {
    $hasGroups = 1;
  }
}

$style_input = ".hide {
  display: none;
  }
  input, button, textarea, th, td, select {
    border: 1px solid black;
  }
  td, th {
    padding: 5px;
  }

  
  ";





include($path."/header_tailwind.php");

$schoolId = $userInfo['schoolid'];

if($_SERVER['REQUEST_METHOD']==='POST') {
  $userCollect = array();
  $return= array();
  $inputCount = $_POST['inputCount'];

  
  for($x=0; $x<$inputCount; $x++) {
    $newUser=array(
      'inputId' => $_POST['inputId_'.$x],
      'first' => $_POST['firstName_'.$x],
      'last' => $_POST['lastName_'.$x],
      'username' => $_POST['username_'.$x],
      'password' => $_POST['password_'.$x],
      // EMAIL DISABLE
      //'email' => $_POST['email_'.$x],
      'schoolId' => $schoolId,
      'userCreate' => $userId,
      'userType' => 'student',
      'permissions' => 'student',
      'groupid_array' => '["'.$_POST['groupId'].'"]',
      'active_entry' => $_POST['active_entry_'.$x]);

    array_push($userCollect, $newUser);

  }

  foreach($userCollect as $user) {
    //Filter for those entires that are active entries (i.e. not from hidden rows)

    if($user['active_entry'] == "1") {

    

    //Process validation and enter into users database:

    $firstName = $lastName = $username= $email_name = "";
    $username_err =  $password_err = $email_err = $name_err="";
    $name_validate = $username_validate = $password_validate = $email_validate = 0;
    $fn_validate = $ln_validate = $user_avail_validate = $user_rule_validate = $pass_match_validate = $pass_rule_validate = $privacy_validate = $usertype_validate = 0;

    //First Name and Last Name
    //Check to see that first and last names are entered in
    if(empty(trim($user['first']))) {
      $name_err = "Please enter a name";
    } else {
      $firstName = trim($user['first']);
      $fn_validate = 1;
    }

    if(empty(trim($user['last']))) {
      $name_err = "Please enter a name";
    } else {
      $lastName = trim($user['last']);
      $ln_validate = 1;
    }

    if($fn_validate ==1 AND $ln_validate ==1) {
      $name_validate = 1;
    } 

    //USERNAME  

    $results = validateUsername($user['username']);
    $username_err = $results['username_err'];
    $username_avail = $results['username_avail'];
    $username_validate = $results['username_validate'];
    $username = $results['username'];


    //PASSWORD

    $results = validatePassword($user['password'], $user['password']);
    $password_err = $results['password_err'];
    $password_validate = $results['password_validate'];
    $password1 = $results['password'];




    //EMAIL
    /*
    EMAIL DISABLE
    $results=validateEmail($user['email']);
    $email_err = $results['email_err'];
    $email_validate = $results['email_validate'];
    $email_name = $results['email'];
    */

    //PROCESS VALIDATED INFORMATION


    if($name_validate ==1 AND $username_validate==1 AND $password_validate == 1 /* EMAIL DISABLE AND $email_validate == 1 */) {

      //Enter new user information into users table
      insertNewUserIntoUsers($firstName, $lastName, $username, $password1, $user['userType'], $email_name, "", 0, $user['userType'], $user['permissions'], 1, $user['schoolId'], $user['userCreate'], $user['groupid_array'], 1);

      } else {

      




        $return[$user['inputId']] = $user;
        unset($return[$user['inputId']]['schoolId']);
        unset($return[$user['inputId']]['userCreate']);
        unset($return[$user['inputId']]['userType']);
        unset($return[$user['inputId']]['permissions']);
        unset($return[$user['inputId']]['groupid_array']);
        
        $return[$user['inputId']]['name_err'] = $name_err;
        $return[$user['inputId']]['username_err'] = $username_err;
        $return[$user['inputId']]['password_err'] = $password_err;
        $return[$user['inputId']]['email_err'] = $email_err;
      }

    }
    
  }

  $_POST['return'] = $return;




  
  }

?>


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">Create New Users</h1>
    <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">
    <?php
      //print_r($userInfo);
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //echo "<pre>";
        //print_r($_POST);
        //echo "</pre>";
        echo "<pre>";
        //print_r($_POST['return']);
        //print_r($userCollect);
        echo "</pre>";
      }
      //echo $hasGroups;
      if ($hasGroups == 1)
      {
        ?>
        <p class="mb-1.5">Use this page to add new users to your school and classes.</p>
        <p class="mb-1.5">You will have admin prviliges for the users you create here, but other teachers from your school will be able to put them into their groups too.</p>
        <form method="post" action = "" >
          <label>Class:</label>
          <div class="w-full mb-1.5">
            <select class="w-full rounded border border-black" name="groupId">
              <option value=""></option>
              <?php
                $results = getGroupsList($userId, true, $userId);
                foreach($results as $result) {
                  ?>
                    <option value="<?=$result['id']?>" <?=(($_SERVER['REQUEST_METHOD']==='POST')&&($result['id'] == $_POST['groupId'])) ? "selected" : ""?>><?=$result['name']?></option>
                  
                  <?php
                }
              ?>
            </select>
          </div>
          <table id="inputTable" class="w-full table-fixed mb-2">
            <thead>
              <tr>
                <th class="">First Name</th>
                <th class="">Last Name</th>
                <th class="">Username</th>
                <th class="">Password</th>
                <!--<th>Email Address</th>-->
                <th class="md:w-1/6 xl:w-1/12">Remove</th>
              </tr>
            </thead>
          </table>
          <input type = "hidden" id="inputCount" name="inputCount">
          <button class="w-full rounded bg-sky-300 hover:bg-sky-200 border border-black mb-2" type="button" onclick="addInputRow();">Add row</button> 
          <input class="w-full rounded bg-pink-300 hover:bg-pink-200 border border-black" type="submit" name="submit" value ="Create New Users">
        </form>
        <?php
      }

      if ($hasGroups == 0) {
        ?>
        <p>You need to make some classes before you can populate them with students!</p>
        <p>Go to <a href="class_creator.php" class="text-cyan-700 underline hover:bg-sky-300">Class Creator</a> to make some new classes.</p>
        <?php
      }

      ?>

      
    </div>
</div>




<script>

  var schoolId = <?=$schoolId ?>;
  var schoolName = <?php

            $schoolInfo = listSchoolsDfe(null, $schoolId);
            
            echo "'".$schoolInfo[0]['SCHNAME'];
            echo "';";

  ?>

  
  function addInputRow(firstName = "", lastName = "", username = "", password="", email="", name_err = "", username_err = "", password_err = "", email_err = "") {
    var table = document.getElementById("inputTable");
    var rowNo = table.rows.length;
    var row = table.insertRow(rowNo);
    var cells = [];
    //Email has been taken out. To restore, iterate over loop with i<5
    for (var i=0; i<5; i++) {
      cells[i] = row.insertCell(i);
      switch(i) {
        case 0:
          var label = "firstName_"+(rowNo-1);
          var value = "value = '"+firstName+"'";
          var label2 = "inputId_"+(rowNo-1);
          var value2 = "value = '"+(rowNo-1)+"'";
          cells[i].innerHTML = "<input name="+label+" id = "+label+" onchange= 'usernameSuggest(this); passwordSuggest(this)' "+value+" class='w-full rounded'><input type='hidden' name="+label2+" id = "+label2+" "+value2+"><p class='mx-1 mt-1 py-0 text-red-600 bg-lime-300'>"+name_err+"</p>"
          break;
        case 1:
          var label = "lastName_"+(rowNo-1);
          var value = "value = '"+lastName+"'";
          cells[i].innerHTML = "<input name="+label+" id = "+label+" onchange= 'usernameSuggest(this); passwordSuggest(this)' "+value+" class='w-full rounded'><p class='mx-1 mt-1 py-0 text-red-600 bg-lime-300'>"+name_err+"</p>"
          break;
        case 2:
          var label = "username_"+(rowNo-1);
          var value = "value = '"+username+"'";
          error = username_err;
          //cells[i].innerHTML = "<input name='username_"+(rowNo-1)+"'>";
          break;
        case 3:
          var label = "password_"+(rowNo-1);
          var value = "value = '"+password+"'";
          error = password_err;
          //cells[i].innerHTML = "<input name='password_"+(rowNo-1)+"'>";
          break;
        case 4:
          cells[i].innerHTML = "<button class='w-full bg-pink-300 rounded border border-black mb-1' type ='button' onclick='hideRow(this);'>Remove</button><input name='active_entry_"+(rowNo-1)+"' class='w-full' type='hidden' value='1'>";
          //cells[i].classList.add('w-1')

          break;
          /*
        case 4:
          var label = "email_"+(rowNo-1);
          var value = "value = '"+email+"'";
          error = email_err;
          //cells[i].innerHTML = "<input name='email_"+(rowNo-1)+"'>";
          break;
          */
      }
      if((i>1)&&(i<4)) {
        cells[i].innerHTML = "<input name="+label+" id = "+label+" "+value+" class='w-full rounded'><p class='mx-1 mt-1 py-0 text-red-600 bg-lime-300'>"+error+"</p>";
      }
    }
    
    var countInput = document.getElementById("inputCount");
    countInput.value = rowNo;
  }

  function usernameSuggest(inputElement) {

    var rowNum = inputElement.parentElement.parentElement.rowIndex -1;
    var firstName = document.getElementById('firstName_'+rowNum);
    var lastName = document.getElementById('lastName_'+rowNum);
    var username = document.getElementById('username_'+rowNum);

    if((firstName.value != "") && (lastName.value != "")) {
      var suggest = firstName.value.toLowerCase().replace(/\s|'/g, "").substring(0,1)+lastName.value.toLowerCase().replace(/\s|'/g, "").replace(/-/g, '_')/*.substring(0,5)*/;
      suggest = suggest.substring(0,16);
      suggest = suggest+"_"+schoolName.toLowerCase().substring(0,3);
      username.value = suggest;

    }



  }

  function passwordSuggest(inputElement) {
    var rowNum = inputElement.parentElement.parentElement.rowIndex -1;
    var school = schoolName.toLowerCase().replaceAll(' ', '').substring(0,8);
    var firstName = document.getElementById('firstName_'+rowNum);
    var lastName = document.getElementById('lastName_'+rowNum);
    var password = document.getElementById('password_'+rowNum);

    if((firstName.value != "") && (lastName.value != "")) {

      var initials = firstName.value.toUpperCase().substring(0,1) + lastName.value.toUpperCase().substring(0,1);
      var random =  Math.floor(Math.random() * (1000 - 101 + 1) + 101);
      var password_suggest = school+initials+random;



      password.value = password_suggest;
    }

  }
  

  <?php
  if(!isset($_POST['return'])) {
    echo "addInputRow();
    ";
  }
  
  ?>

  
  <?php
  //For each returned user registration that did not meet validation, create a new row in input table with previously entered indformation:
            
            if(isset($_POST['return'])) {
              if(count($_POST['return'])>0) {
                foreach($_POST['return'] as $array) {
                  foreach($array as $key => &$array_element) {
                    if(!str_contains($key, "err")) {
                    $array_element = htmlspecialchars($array_element);
                    }
                  }
                  //Define users as JSON arrays in Javascript:
                  echo "var user".$array['inputId']." = ".json_encode($array);
                  echo "
";
                  //Create new row using this JSON information
                  echo "addInputRow(user".$array['inputId']."['first'], user".$array['inputId']."['last'], user".$array['inputId']."['username'], user".$array['inputId']."['password'], user".$array['inputId']."['email'], user".$array['inputId']."['name_err'], user".$array['inputId']."['username_err'], user".$array['inputId']."['password_err'], user".$array['inputId']."['email_err'])";
                  echo "
";


                }
              
            }
            else {
              echo "addInputRow();";
            }
          }

      ?>


function hideRow(button) {
  var row = button.parentElement.parentElement;
  var input = button.parentElement.childNodes[1];
  console.log(input);
  row.style.display = "none";
  input.value='0';
}
</script>



<?php   include($path."/footer_tailwind.php");?>