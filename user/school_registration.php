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
  /*
  $permissions = $userInfo['permissions'];
  if (!(str_contains($permissions, 'teacher'))) {
    header("location: /index.php");
  }
  */
}

$style_input = ".hide {
  display: none;
  }
  input, button, textarea, th, td {
    border: 1px solid black;
  }
  td, th {
    padding: 5px;
  
  ";





include($path."/header_tailwind.php");

if($_SERVER['REQUEST_METHOD']==='POST') {

  if($_POST['submit'] = "Link to this School") {
    linkUserToSchool($userId, $_POST['schoolId']);
    $userInfo  = getUserInfo($_SESSION['userid']);
    echo "<script>window.location = '/user/user3.0.php'</script>";

  }
}

if (count($_GET)>0) {
  if($_GET['submit']=="Search Schools") {
    $searchResults = listSchoolsDfe($_GET['search']);
  }
}

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">Link to A School</h1>
    <div class="font-mono container mx-auto px-0 mt-2 bg-white text-black mb-5">
      <?php
      //print_r($userInfo);
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //print_r($_POST);


      }
      ?>
      
        <?php 
          if($userInfo['schoolid']=="") {
            ?>
            <h2>Link your account to your school</h2>
            <p> You have not yet registered your account to a school. You can do that here.</p>
            <form method = "get" action ="">
              <label>School Name/Postcode:</label>
              <input type="text" name ="search">
              <input type="submit" name="submit" value="Search Schools">


            </form>
            <?php
            if(isset($searchResults)) {
          ?>
          <form method ="post" action ="">
          <table class="">
            <tr>
              <th>School Name</th>
              <th>Address</th>
              <th>Select</th>
            </tr>
              <?php
              foreach($searchResults as $result) {
              ?>
              <tr>
                <td>
                  <?=htmlspecialchars($result['SCHNAME'])?>
                </td>
                <td>
                  <?=htmlspecialchars($result['STREET'])?>
                  <br>
                  <?=($result['LOCALITY'] != "") ? htmlspecialchars($result['LOCALITY'])."<br>" : ""?>
                  <?=($result['ADDRESS3'] != "") ? htmlspecialchars($result['ADDRESS3'])."<br>" : ""?>
                  <?=htmlspecialchars($result['TOWN'])?>
                  <br>
                  <?=htmlspecialchars($result['POSTCODE'])?>
                </td>
                <td>
                  <input type="radio" name="schoolId" value = "<?=htmlspecialchars($result['id'])?>">
                </td>
              </tr>
              <?php
              }
              ?>
            </table>
            <input type="submit" name="submit" value = "Link to this School">
            </form>  
        <?php
            }
          }

          else {
            ?>
            <h2>Linked Account</h2>
            <p>You have already linked your account to a school.</p>
            <p>Your account is linked to:</p>
              <?php
              $userSchool = $userInfo['schoolid'];
              $schoolInfo = listSchoolsDfe(null, $userSchool);
              $schoolInfo = $schoolInfo[0];
              //print_r($schoolInfo);
              ?>
            <p>
            <b><?=$schoolInfo['SCHNAME']?><br>
            <?=$schoolInfo['POSTCODE']?></b>
            </p>
            <p>Please contact <a href="mailto:support@thinkeconomics.co.uk">support</a> if you would like to deregister your account from this school.</p>

              <?php


          }
        ?>

    </div>
</div>




<?php   include($path."/footer_tailwind.php");?>

