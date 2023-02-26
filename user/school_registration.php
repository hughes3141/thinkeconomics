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
  button, textarea, th, td {
    border: 2px solid black;
  }

  ";





include($path."/header_tailwind.php");

if($_SERVER['REQUEST_METHOD']==='POST') {

  if($_POST['submit'] == "Confirm") {
    linkUserToSchool($userId, $_POST['schoolId']);
    $userInfo  = getUserInfo($_SESSION['userid']);
    echo "<script>window.location = '/user/user3.0.php'</script>";

  }
}

if (count($_GET)>0) {
  if($_GET['submit']=="Search Schools" && $_GET['search']!="" && $_GET['search']!=" " && $_GET['search']!="  ") {
    $searchResults = listSchoolsDfe($_GET['search']);
  }
}

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2 ">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">Link School</h1>
    <div class=" container mx-auto  mt-2 bg-white text-black mb-5 p-4">
      <?php
      //print_r($userInfo);
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //print_r($_POST);


      }
      ?>
      
        <?php 
          if($userInfo['schoolid']=="") {
            ?>
            <h2 class="font-mono text-lg bg-pink-300">Link your account to your school!</h2>
            <p class="mb-1">You have not yet registered your account to a school. You can do that here.</p>
            <form method = "get" action ="">
              <div class="mt-1.5">
                <label class="font-bold">School Name/Postcode:</label>
                <div>
                  <input class ="w-full rounded font-mono border border-black" type="text" name ="search" value="<?= isset($_GET['search']) ? $_GET['search'] :''?>">
                </div>
                <input class= "mx-auto block w-full rounded bg-sky-200 my-2 border border-black hover:bg-pink-300 py-2" type="submit" name="submit" value="Search Schools">
              </div>

            </form>
            <?php
            if(isset($searchResults)) {
          ?>
          <form method ="post" action ="">
          
          <table class="table-fixed w-full">
          <?php if(count($searchResults)>0) {
            ?>
            <tr>
              <th class="p-1.5">School Name</th>
              <th class="p-1.5">Address</th>
              <th class="p-1.5">Select</th>
            </tr>
            <?php 
            }
            ?>
              <?php
              foreach($searchResults as $result) {
              ?>
              <tr>
                <td class="p-1.5">
                  <?=htmlspecialchars($result['SCHNAME'])?>
                </td>
                <td class="p-1.5">
                  <?=htmlspecialchars($result['STREET'])?>
                  <br>
                  <?=($result['LOCALITY'] != "") ? htmlspecialchars($result['LOCALITY'])."<br>" : ""?>
                  <?=($result['ADDRESS3'] != "") ? htmlspecialchars($result['ADDRESS3'])."<br>" : ""?>
                  <?=htmlspecialchars($result['TOWN'])?>
                  <br>
                  <?=htmlspecialchars($result['POSTCODE'])?>
                </td>
                <td class="p-1.5">
                  <!--
                  <input type="radio" name="schoolId" value = "<?=htmlspecialchars($result['id'])?>">
                  -->
                  <button type="button" class="w-full h-full rounded bg-sky-200 hover:bg-pink-300" onclick="fillSchoolConfirm('<?=htmlspecialchars($result['id'])?>','<?=htmlspecialchars($result['SCHNAME'])?>')" >Link to this School</button>
                </td>
              </tr>
              <?php
              }
              ?>
            </table>
            <div style="display:none" id="confirmDiv">
              <input type="hidden" name="schoolId" id="schoolIdFill">
              <h2 class="font-mono text-lg bg-pink-300 mt-3">Confirmation</h2>
              <p class="mb-1">You are about to link your account to <span id="schoolNameSpan" class="font-bold"></span>. You should only do this if you are an active student or teacher of this school.</p>
              <p class="mb-1">Are you happy to proceed?</p>
              <input type="submit" name="submit" class = "border border-black block w-full py-2 bg-sky-200 hover:bg-pink-300" value = "Confirm">
            </div>
            </form>  
        <?php
            }
          }

          else {
            ?>
            <h2 class="font-mono text-lg bg-pink-300 pl-1">Linked Account</h2>
            <p class="mb-1">You have already linked your account to a school.</p>
            <p class="mb-1">Your account is linked to:</p>
              <?php
              $userSchool = $userInfo['schoolid'];
              $schoolInfo = listSchoolsDfe(null, $userSchool);
              $schoolInfo = $schoolInfo[0];
              //print_r($schoolInfo);
              ?>
            <p class="mb-1">
            <b><?=$schoolInfo['SCHNAME']?><br>
            <?=$schoolInfo['POSTCODE']?></b>
            </p>
            <p class="mb-1">Please contact <a class="underline hover:bg-sky-100" href="mailto:support@thinkeconomics.co.uk">support</a> if you would like to deregister your account from this school.</p>

              <?php


          }
        ?>

    </div>
</div>


<script>



  function fillSchoolConfirm(schoolid, schoolname) {
    var idFill = document.getElementById("schoolIdFill");
    idFill.value = schoolid;
    var schoolNameSpan = document.getElementById("schoolNameSpan");
    schoolNameSpan.innerHTML = schoolname;
    let confirmDiv = document.getElementById("confirmDiv");
    confirmDiv.style.display = "block";
    confirmDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });

  }
</script>

<?php   include($path."/footer_tailwind.php");?>

