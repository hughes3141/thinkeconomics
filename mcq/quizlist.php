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
    header("location: /index.php");
  }

}

$style_input = "
  th, td {
    border: 1px solid black;
  }

  
  ";

$updateQuestionBool = 0;

if($_SERVER['REQUEST_METHOD']==='POST') {


  if(isset($_POST['submit']) && $_POST['submit'] == "Update") {
    updateMCQquizDetails($_POST['id'],$_POST['topic'],$_POST['quizName'],$_POST['notes'],$_POST['description'],$_POST['active']);
    $updateQuestionBool = 1;
    
  }


}

$get_selectors = array(
  'id' => (isset($_GET['id'])&&$_GET['id']!="") ? $_GET['id'] : null,
  'topic' => (isset($_GET['topic'])&&$_GET['topic']!="") ? $_GET['topic'] : null,
  'search' => (isset($_GET['search'])&&$_GET['search']!="") ? $_GET['search'] : null,
  'questionId' => (isset($_GET['questionId'])&&$_GET['questionId']!="") ? $_GET['questionId'] : null,
  'active' => (isset($_GET['active'])&&$_GET['active']!="") ? $_GET['active'] : null


);

$quizzes = getMCQquizDetails($get_selectors['id'], $get_selectors['topic'], $get_selectors['questionId'], $userId, $get_selectors['active']);

include($path."/header_tailwind.php");

?>

<div class=" mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-full">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">MCQ Quiz List</h1>
  <div class="  mx-auto p-4 mt-2 bg-white text-black mb-5">
    <div>
      <form method ="get"  action="">
        <label for="id_select">ID:</label>
        <input type="text" name="id" value="<?=$get_selectors['id']?>"</input>

        <label for="_select">Topic:</label>
        <input type="text" name="topic" value="<?=$get_selectors['topic']?>"</input>

        

        <label for="search_select">Search:</label>
        <input type="text" id="search_select" name="search" value="<?=$get_selectors['search']?>"</input>

        <label for="questionId_select">Question Id:</label>
        <input type="text" id="questionId_select" name="questionId" value="<?=$get_selectors['questionId']?>"</input>

        <input type="checkbox" name="active" value= "1" id="active_select" <?=($get_selectors['active']==1 ) ? "checked" : ""?>>
        <label for="active_select">Active Only</label>

        <input type="submit"  value="Select">
      </form>
    </div>
      <?php
      if(isset($_GET['test'])) {
        //print_r($quizzes);
        print_r($_POST);
      }
      ?>
      <table class="w-full table-fixed mb-2 border border-black">
        <tr class="sticky top-16 bg-white">
          <th class="w-8">Id</th>
          <th class="">Topics</th>
          <th class="">Name</th>
          <th class="">Questions</th>
          <th class="">Notes</th>
          <th class="">Description</th>
          <th class="">Active</th>
          <th class="">Edit</th>
        </tr>
        <?php
        foreach ($quizzes as $quiz) {
          if(isset($_GET['test'])) {
            ?>
            <tr>
              <td colspan="8"><?php
                print_r($quiz);
              ?></td>
            </tr>
            <?php
          }
          ?>
          <form method="post" action="">
            <input type="hidden" name="id" value="<?=$quiz['id']?>"> 
            <tr id="<?=$quiz['id']?>">
              <td>
                <p class="text-center"><?=$quiz['id']?></p>
              </td>
              <td>
                <p class="toggleClass_<?=$quiz['id']?>"><?=$quiz['topic']?></p>
                <input type="text" class="toggleClass_<?=$quiz['id']?> hidden" value="<?=$quiz['topic']?>" name="topic">
              </td>
              <td>
                <p class="toggleClass_<?=$quiz['id']?>"><a class="underline text-sky-700 hover:bg-sky-100"target="_blank" href="mcq_preview.php?quizid=<?=$quiz['id']?>"><?=$quiz['quizName']?></a></p>
                <input type="text" class="toggleClass_<?=$quiz['id']?> hidden" value="<?=$quiz['quizName']?>" name="quizName">
              </td>
              <td class="">
                <div class="overflow-x-auto">
                  <?php
                    $questions = explode(",",$quiz['questions_id']);
                    foreach ($questions as $key2 => $question) {
                      echo $question;
                      echo ($key2 < count($questions)-1) ? ", " : "";
                    }
                  ?>
                  <!--
                  <p class="toggleClass_<?=$quiz['id']?> "><?=$quiz['questions_id']?></p> -->
                </div>
              </td>
              <td>
                <p class="toggleClass_<?=$quiz['id']?>"><?=$quiz['notes']?></p>
                <p class="toggleClass_<?=$quiz['id']?>"><?=date('d/m/Y h:ia', strtotime($quiz['dateCreated']))?></p>
                <textarea class="toggleClass_<?=$quiz['id']?> hidden" name="notes"><?=$quiz['notes']?></textarea>
              </td>
              <td>
                <p class="toggleClass_<?=$quiz['id']?>"><?=$quiz['description']?></p>
                <textarea class="toggleClass_<?=$quiz['id']?> hidden" name="description"><?=$quiz['description']?></textarea>
              </td>
              <td>
                <p class="toggleClass_<?=$quiz['id']?>"><?=($quiz['active']==1) ? "Active" : "Inactive"?></p>
                <div class="toggleClass_<?=$quiz['id']?> hidden">
                  <input type="radio" id="active_select_<?=$quiz['id']?>" name="active" value="1" <?=($quiz['active']==1) ? "checked" : ""?>>
                  <label for="active_select_<?=$quiz['id']?>">Active</label><br>
                  <input type="radio" id="inactive_select_<?=$quiz['id']?>" name="active" value="0" <?=($quiz['active']==0) ? "checked" : ""?>>
                  <label for="inactive_select_<?=$quiz['id']?>">Inactive</label>
                </div>
              </td>
              <td>
                <button type="button" class="w-full border border-black rounded bg-pink-200 mb-1 p-1" onclick='toggleHide(this, "toggleClass_<?=$quiz['id']?>", "Edit", "Hide Edit", "block");'>Edit</button>
                <input type="submit" class="w-full bg-sky-200 rounded border border-black mb-1 toggleClass_<?=$quiz['id']?> hidden" name="submit" value= "Update">
              </td>
            </tr>
          </form>
          <?php
        }
        ?>
      </table>


    </div>
</div>

<script>

<?php
if($updateQuestionBool == 1) {
    ?>
      //console.log(document.getElementById('<?=$_POST['id']?>'));
      document.getElementById('<?=$_POST['id']?>').scrollIntoView();
    <?php
  
}
?>

</script>

<?php   include($path."/footer_tailwind.php");?>