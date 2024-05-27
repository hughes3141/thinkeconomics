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
    updateMCQquizDetails($_POST['id'],$_POST['topic'],$_POST['quizName'],$_POST['notes'],$_POST['description'],$_POST['active'], $_POST['topicQuiz'], $_POST['mcqHomePage'], $_POST['topicOrder'], $_POST['pastPaper'], $_POST['ppYear'], $_POST['ppExamBoard']);
    $updateQuestionBool = 1;
    
  }


}

$get_selectors = array(
  'id' => (isset($_GET['id'])&&$_GET['id']!="") ? $_GET['id'] : null,
  'topic' => (isset($_GET['topic'])&&$_GET['topic']!="") ? $_GET['topic'] : null,
  'search' => (isset($_GET['search'])&&$_GET['search']!="") ? $_GET['search'] : null,
  'questionId' => (isset($_GET['questionId'])&&$_GET['questionId']!="") ? $_GET['questionId'] : null,
  'active' => (isset($_GET['inactive'])&&$_GET['inactive']=="1") ? 0 : 1,
  'inactive' => (isset($_GET['inactive'])&&$_GET['inactive']!="") ? $_GET['inactive'] : null,
  'orderBy' => (isset($_GET['orderBy'])&&$_GET['orderBy']!="") ? $_GET['orderBy'] : null,
  'pastPaperOnly' => (isset($_GET['pastPaperOnly'])&&$_GET['pastPaperOnly']!="") ? $_GET['pastPaperOnly'] : null


);

$quizzes = getMCQquizDetails($get_selectors['id'], $get_selectors['topic'], $get_selectors['questionId'], $userId, $get_selectors['active'], null, $get_selectors['orderBy'],null, $get_selectors['pastPaperOnly']);

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

        <label for="orderByInput">Order By: </label>
        <select name="orderBy" id="orderByInput">
        <option value=""></option>
          <option value="topic" <?=$get_selectors['orderBy'] == 'topic' ? 'selected' : ''?>>Topic</option>
          <option value="examBoard" <?=$get_selectors['orderBy'] == 'examBoard' ? 'selected' : ''?>>examBoard</option>
        </select>

        <input type="checkbox" name="inactive" value= "1" id="active_select" <?=($get_selectors['inactive']==1 ) ? "checked" : ""?>>
        <label for="active_select">Show Inactive</label>

        <input type="checkbox" name="pastPaperOnly" value= "1" id="pastPaperOnly_select" <?=($get_selectors['pastPaperOnly']==1 ) ? "checked" : ""?>>
        <label for="pastPaperOnly_select">Past Papers Only</label>

        <input type="submit"  value="Select">
      </form>
    </div>
      <?php
      if(isset($_GET['test'])) {
        //print_r($quizzes);
        print_r($_POST);
      }
      print_r($_POST);
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
                <p class="font-bold toggleClass_<?=$quiz['id']?>"><?=date('d/m/Y h:ia', strtotime($quiz['dateCreated']))?></p>
                <p class="toggleClass_<?=$quiz['id']?>"><?=$quiz['notes']?></p>
                <p  class="toggleClass_<?=$quiz['id']?>">Count: <?=count($questions)?></p>
                
                <textarea class="toggleClass_<?=$quiz['id']?> hidden p-1" name="notes"><?=$quiz['notes']?></textarea>
              </td>
              <td>
                <p class="toggleClass_<?=$quiz['id']?>"><?=$quiz['description']?></p>
                <textarea class="toggleClass_<?=$quiz['id']?> hidden p-1" name="description"><?=$quiz['description']?></textarea>
              </td>
              <td>
                <p class="toggleClass_<?=$quiz['id']?> <?=($quiz['active']==0) ? "bg-pink-200" : ""?>"><?=($quiz['active']==1) ? "Active" : "Inactive"?></p>
                <p class="toggleClass_<?=$quiz['id']?> <?=($quiz['topicQuiz']==0) ? "bg-sky-200" : ""?>"><?=($quiz['topicQuiz']==1) ? "Topic Quiz" : "Not Topic Quiz"?></p>
                <p class="toggleClass_<?=$quiz['id']?> <?=($quiz['mcqHomePage']==1) ? "bg-pink-200" : ""?>"><?=($quiz['mcqHomePage']==1) ? "MCQ Home Page" : "Not MCQ Home Page"?></p>
                <p class="toggleClass_<?=$quiz['id']?> <?=($quiz['pastPaper']==1) ? "bg-pink-300" : ""?>"><?=($quiz['pastPaper']==1) ? "Past Paper ".$quiz['ppExamBoard']." ".$quiz['ppYear'] : "Not MCQ Home Page"?></p>

                <div class="toggleClass_<?=$quiz['id']?> hidden">
                  <label for="topicOrderSelect_<?=$quiz['id']?>">Topic Order: </label><br>
                  <input id="topicOrderSelect_<?=$quiz['id']?>" class="w-full" name="topicOrder" value="<?=$quiz['topicOrder']?>"></input><br>

                  <input type="radio" id="active_select_<?=$quiz['id']?>" name="active" value="1" <?=($quiz['active']==1) ? "checked" : ""?>>
                  <label for="active_select_<?=$quiz['id']?>">Active</label><br>
                  <input type="radio" id="inactive_select_<?=$quiz['id']?>" name="active" value="0" <?=($quiz['active']==0) ? "checked" : ""?>>
                  <label for="inactive_select_<?=$quiz['id']?>">Inactive</label><br>

                  <input type="radio" id="topicQuiz_select_<?=$quiz['id']?>" name="topicQuiz" value="1" <?=($quiz['topicQuiz']==1) ? "checked" : ""?>>
                  <label for="topicQuiz_select_<?=$quiz['id']?>">Topic Quiz</label><br>
                  <input type="radio" id="notopicQuiz_select_<?=$quiz['id']?>" name="topicQuiz" value="0" <?=($quiz['topicQuiz']==0) ? "checked" : ""?>>
                  <label for="notopicQuiz_select_<?=$quiz['id']?>">Not Topic Quiz</label><br>

                  <input type="radio" id="mcqHomePage_select_<?=$quiz['id']?>" name="mcqHomePage" value="1" <?=($quiz['mcqHomePage']==1) ? "checked" : ""?>>
                  <label for="mcqHomePage_select_<?=$quiz['id']?>">MCQ Home Page</label><br>
                  <input type="radio" id="nomcqHomePage_select_<?=$quiz['id']?>" name="mcqHomePage" value="0" <?=($quiz['mcqHomePage']==0) ? "checked" : ""?>>
                  <label for="nomcqHomePage_select_<?=$quiz['id']?>">Not MCQ Home Page</label><br>

                  <input type="radio" id="pastPaper_select_<?=$quiz['id']?>" name="pastPaper" value="1" <?=($quiz['pastPaper']==1) ? "checked" : ""?>>
                  <label for="pastPaper_select_<?=$quiz['id']?>">Past Paper</label><br>
                  <input type="radio" id="nopastPaper_select_<?=$quiz['id']?>" name="pastPaper" value="0" <?=($quiz['pastPaper']==0) ? "checked" : ""?>>
                  <label for="nopastPaper_select_<?=$quiz['id']?>">Not Past Paper</label>

                  <div class="<?=$quiz['pastPaper'] == 0 ? 'hidden' : ''?>">
                    <p>
                      <label for="pastPaperYearInput_<?=$quiz['id']?>">Past Paper Year:</label>
                      <input id="pastPaperYearInput_<?=$quiz['id']?>" class="w-full" name="ppYear" type="number" value="<?=$quiz['ppYear']?>">
                    </p>
                    <p>
                      <label for="pastPaperExamBoardInput_<?=$quiz['id']?>">Past Paper Exam Board:</label>
                      <select id="pastPaperExamBoardInput_<?=$quiz['id']?>" name="ppExamBoard">
                        <option value=""></option>
                        <option value="AQA" <?=$quiz['ppExamBoard'] == "AQA" ? 'selected' : ''?>>AQA</option>
                        <option value="Eduqas" <?=$quiz['ppExamBoard'] == "Eduqas" ? 'selected' : ''?>>Eduqas</option>
                        <option value="WJEC" <?=$quiz['ppExamBoard'] == "WJEC" ? 'selected' : ''?>>WJEC</option>
                      </select>
                    </p>
                  </div>



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
