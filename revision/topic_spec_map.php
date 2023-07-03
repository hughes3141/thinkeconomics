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
  $userId = $_SESSION['userid'];
  $userInfo = getUserInfo($_SESSION['userid']);
  $userType = $userInfo['usertype'];
  if (!(/*$userType == "teacher" ||*/ $userType =="admin")) {
    header("location: /index.php");
  }
}

$style_input = "

  .hide {
      display: none;
   }

  th, td {

  border: 1px solid black;
  padding: 5px;

  }

  table {
    
    border-collapse: collapse;
    table-layout: fixed;
    width: 100%;
    
  }
";

$updateMessageArray = array();
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $topicCount = $_POST['topicCount'];

  for($x = 0; $x<$topicCount; $x++) {

    $id = $_POST['id_'.$x];
    $topicId = $_POST['topicId_'.$x];



      if($topicId == "" ) {
        $topicId = null;
      }
      /*
      echo $_POST['id_'.$x];
      echo $_POST['topicId_'.$x];
      echo "<br>";
      */
      
      $updateMessage = updateTopicsSpecList($id, $topicId);
      array_push($updateMessageArray, $updateMessage);
    
  
  }

}

$examBoardId = 4;
$subjectId = 7;
$specTopics = getTopicsSpecList(null, 4,7);
$genTopics = getTopicsGeneralList(null, null, null, 7);

include($path."/header_tailwind.php");
?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  <?php
  //echo $updateMessage;
  ?>
<h1 class="font-mono text-2xl bg-pink-400 pl-1">Topic Spec Map</h1>
<div class=" container mx-auto px-4 pb-4 mt-2 bg-white text-black mb-5">
  <?php
    if(isset($_GET['test'])) {
      //print_r($specTopics);
      if($_SERVER['REQUEST_METHOD'] == 'POST') {
        print_r($_POST);
        echo "<br>Update Message:</br>";
        print_r($updateMessageArray);
      }
    }
  ?>
  <form method ="post" action="">
    <table>
      <?php
      foreach($specTopics as $key=>$topic) {
        ?>
        <tr>
          <td>
            <?=$topic['code']?> <?=$topic['name']?>
            <input type="hidden" name="id_<?=$key?>" value="<?=$topic['id']?>">
          </td>
          <td>
            <select name = "topicId_<?=$key?>">
              <option></option>
              <?php
              foreach($genTopics as $genTopic) {
                $selected = "";
                if($genTopic['id'] == $topic['topicId']) {
                  $selected = " selected ";
                }
                ?>
                <option value = "<?=$genTopic['id']?>" <?=$selected?>><?=$genTopic['code']?> <?=$genTopic['name']?>
                </option>
                <?php
              }
              ?>
            </select>
          </td>
        </tr>
        <?php
      }
      ?>
    </table>
    <input type="text" name="topicCount" value="<?=count($specTopics)?>">
    <input type="submit" value="Submit" name="submit">
  </form>
</div>
</div>



<?php   include($path."/footer_tailwind.php");?>

