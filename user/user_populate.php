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
      'groupid_array' => '["'.$_POST['groupId'].'"]');

    array_push($userCollect, $newUser);

  }

  foreach($userCollect as $user) {
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
      insertNewUserIntoUsers($firstName, $lastName, $username, $password1, $user['userType'], $email_name, "", 0, $user['userType'], $user['permissions'], 1, $user['schoolId'], $user['userCreate'], $user['groupid_array'] );

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

  $_POST['return'] = $return;




  
  }

?>


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">User Populate</h1>
    <div class="font-mono container mx-auto px-0 mt-2 bg-white text-black mb-5">
    <?php
      //print_r($userInfo);
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //print_r($_POST);
        echo "<pre>";
        //print_r($_POST['return']);
        //print_r($userCollect);
        echo "</pre>";
      }
      ?>
      <p>Create new users</p>
      <form method="post" action = "">
        <label>Class:</label>
        
        <select name="groupId">
          <?php
            $results = getGroupsList($userId, true, $userId);
            foreach($results as $result) {
              ?>
                 <option value="<?=$result['id']?>"><?=$result['name']?></option>
              
              <?php
            }
          ?>
        </select>
        
        <table id="inputTable" class="w-full table-fixed">
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Password</th>
            <!--<th>Email Address</th>-->
          </tr>
        </table>
        <input type = "hidden" id="inputCount" name="inputCount">
        <button type="button" onclick="addInputRow();">Add row</button> 
        <input type="submit" name="submit" value ="Create New Users">
      </form>

      
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
    for (var i=0; i<4; i++) {
      cells[i] = row.insertCell(i);
      switch(i) {
        case 0:
          var label = "firstName_"+(rowNo-1);
          var value = "value = '"+firstName+"'";
          var label2 = "inputId_"+(rowNo-1);
          var value2 = "value = '"+(rowNo-1)+"'";
          cells[i].innerHTML = "<input name="+label+" id = "+label+" onchange= 'usernameSuggest(this); passwordSuggest(this)' "+value+"><input type='hidden' name="+label2+" id = "+label2+" "+value2+"><p class='ml-3 mt-1 py-0 text-red-600 bg-lime-300'>"+name_err+"</p>"
          break;
        case 1:
          var label = "lastName_"+(rowNo-1);
          var value = "value = '"+lastName+"'";
          cells[i].innerHTML = "<input name="+label+" id = "+label+" onchange= 'usernameSuggest(this); passwordSuggest(this)' "+value+"><p class='ml-3 mt-1 py-0 text-red-600 bg-lime-300'>"+name_err+"</p>"
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
          var label = "email_"+(rowNo-1);
          var value = "value = '"+email+"'";
          error = email_err;
          //cells[i].innerHTML = "<input name='email_"+(rowNo-1)+"'>";
          break;
      }
      if(i>1) {
        cells[i].innerHTML = "<input name="+label+" id = "+label+" "+value+"><p class='ml-3 mt-1 py-0 text-red-600 bg-lime-300'>"+error+"</p>";
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
    var school = schoolName.toLowerCase().substring(0,8);
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

      ?>
</script>



<?php   include($path."/footer_tailwind.php");?>