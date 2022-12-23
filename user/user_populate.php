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
  $inputCount = $_POST['inputCount'];
  
  for($x=0; $x<$inputCount; $x++) {
    $newUser=array(
      'first' => $_POST['firstName_'.$x],
      'last' => $_POST['lastName_'.$x],
      'username' => $_POST['username_'.$x],
      'password' => $_POST['password_'.$x],
      'email' => $_POST['email_'.$x],
      'schoolId' => $schoolId,
      'userCreate' => $userId,
      'userType' => 'student',
      'permissions' => 'student',
      'groupid_array' => '["'.$_POST['groupId'].'"]');

    array_push($userCollect, $newUser);

  }




  
  }

?>


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">User Populate</h1>
    <div class="font-mono container mx-auto px-0 mt-2 bg-white text-black mb-5">
    <?php
      //print_r($userInfo);
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        print_r($_POST);
        echo "<pre>";
        print_r($userCollect);
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
            <th>Email Address</th>
          </tr>
        </table>
        <input type = "text" id="inputCount" name="inputCount">
        <button type="button" onclick="addInputRow();">Add row</button> 
        <input type="submit" name="submit" value ="Create New Users">
      </form>
    </div>
</div>


<script>

  var schoolId = <?=$schoolId ?>
  
  function addInputRow() {
    var table = document.getElementById("inputTable");
    var rowNo = table.rows.length;
    var row = table.insertRow(rowNo);
    var cells = [];
    for (var i=0; i<5; i++) {
      cells[i] = row.insertCell(i);
      switch(i) {
        case 0:
          var label = "firstName_"+(rowNo-1);
          cells[i].innerHTML = "<input name="+label+" id = "+label+" onchange= 'usernameSuggest(this)'>"
          break;
        case 1:
          var label = "lastName_"+(rowNo-1);
          cells[i].innerHTML = "<input name="+label+" id = "+label+" onchange= 'usernameSuggest(this)'>"
          break;
        case 2:
          var label = "username_"+(rowNo-1);
          //cells[i].innerHTML = "<input name='username_"+(rowNo-1)+"'>";
          break;
        case 3:
          var label = "password_"+(rowNo-1);
          //cells[i].innerHTML = "<input name='password_"+(rowNo-1)+"'>";
          break;
        case 4:
          var label = "email_"+(rowNo-1);
          //cells[i].innerHTML = "<input name='email_"+(rowNo-1)+"'>";
          break;
      }
      if(i>1) {
        cells[i].innerHTML = "<input name="+label+" id = "+label+">";
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
      var suggest = firstName.value.toLowerCase().replace(/\s|'/g, "").substring(0,1)+lastName.value.toLowerCase().replace(/\s|'/g, "")/*.substring(0,5)*/;
      username.value = suggest/*+schoolId*/;

    }



  }
  

  //addInputRow();

</script>

<?php   include($path."/footer_tailwind.php");?>