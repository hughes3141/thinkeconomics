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
  if (!(str_contains($permissions, 'main_admin'))) {
    header("location: /");
  }

}

$style_input = "
  //p { margin-bottom: 0.75rem}

  th, td {
    border: 1px solid black;
  }
";

$updateMessage = "";

$postTopicCount = "";
$postTopic = "";
if($_SERVER['REQUEST_METHOD']==='POST') {

  $postTopicCount = getExerciseListTopicCount($_POST['topic']);
  $postTopic = $_POST['topic'];

  if(isset($_POST['submit'])&&($_POST['submit']=="Submit")) {
    insertExerciseList($_POST['name'], $_POST['link'], $_POST['topic']);
    $updateMessage = "New record created successfully";
    


  }

  if(isset($_POST['submit'])&&($_POST['submit']=="Update")) {
    updateExerciseList($_POST['id'], $_POST['name'], $_POST['link'], $_POST['topic'], $_POST['active'], $_POST['topicOrder']);


  }



}

$exercises = getExerciseList();

include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">Exercise List</h1>
    <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">
      <?php
      if(isset($_GET['test'])) {
        print_r($_POST);
      }
      echo $updateMessage;
      //print_r($exercises);
      echo $postTopicCount;
      ?>
      

      <div>
        <form method="post" action ="">
          <p class="mb-3">
            <label for="nameInput">Exercise Name:</label>
            <input id="nameInput" type="text" name="name">
          </p>
          <p class="mb-3">
            <label for="linkInput">Link:</label>
            <textarea class="w-full" id="linkInput" type="text" name="link"></textarea>
          </p>
          <p class="mb-3">
            <label for="topicInput">Topic:</label>
            <input id="topicInput" type="text" name="topic" value="<?=$postTopic?>">
          </p>

          <p>
            <input type="submit" value="Submit" name="submit">
          </p>
        </form>
        
      </div>

      <div>
        <table>
          <tr></tr>
          <?php
          foreach($exercises as $exercise) {
            ?>
            <form method="post" action ="">
              <tr>
                <td>
                  <?=$exercise['topic']?>
                </td>
                <td>
                  <?php 
                    //print_r($exercise);
                  ?>
                  <div class="toggleClass_<?=$exercise['id']?>">
                    <p>Name: <?=$exercise['name']?></p>
                    <p>Link: <a target="_blank" href="<?=$exercise['link']?>"><?=$exercise['link']?></a></p>
                    <p class="hidden">Topic: <?=$exercise['topic']?></p>
                    <p><?=$exercise['active']==1 ? "Active" : "<span class=/bg-pink-200'> Inactive</span>"?></p>
                  </div>
                  <div class="toggleClass_<?=$exercise['id']?> hidden">
                    <p class="mb-3">
                      <label for="nameInput_<?=$exercise['id']?>">Exercise Name:</label>
                      <input class="w-full" id="nameInput_<?=$exercise['id']?>" type="text" name="name" value="<?=$exercise['name']?>">
                    </p>
                    <p class="mb-3">
                      <label for="linkInput_<?=$exercise['id']?>">Link:</label>
                      <textarea class="w-full" id="linkInput_<?=$exercise['id']?>" type="text" name="link"><?=$exercise['link']?></textarea>
                    </p>
                    <p class="mb-3">
                      <label for="topicInput_<?=$exercise['id']?>">Topic:</label>
                      <input id="topicInput_<?=$exercise['id']?>" type="text" name="topic" value="<?=$exercise['topic']?>">
                    </p>
                    <p>
                      <label for="topicOrder_<?=$exercise['id']?>">Topic Order:</label>
                      <input id="topicOrder_<?=$exercise['id']?>" type="text" name="topicOrder" value="<?=$exercise['topicOrder']?>">
                    </p>
                    <p>
                      <input type="radio" name="active" id="activeSelect_<?=$exercise['id']?>_1" value="1" <?=($exercise['active'] == 1) ? "checked" : ""?>><label for="activeSelect_<?=$exercise['id']?>_1" > Active</label>
                      <input type="radio" name="active" id="activeSelect_<?=$exercise['id']?>_0" value="0" <?=($exercise['active'] == 0) ? "checked" : ""?>><label for="activeSelect_<?=$exercise['id']?>_0"> Inactive</label>

                    </p>
                    <input name="id" type="hidden" value="<?=$exercise['id']?>">
                  </div>
                </td>
                <td>
                  <p><button type="button" class="w-full bg-pink-300 rounded border border-black mb-1" onclick='toggleHide(this, "toggleClass_<?=$exercise['id']?>", "Edit", "Hide Edit", "block");'>Edit</button>
                  <input type="submit" class="w-full bg-sky-200 rounded border border-black mb-1 toggleClass_<?=$exercise['id']?> hidden" name="submit" value= "Update">
                </p>

                </td>
              </tr>
            </form>
            <?php
          }
          ?>

        </table>
      </div>

    </div>
</div>

<script>

</script>

<?php   include($path."/footer_tailwind.php");?>

