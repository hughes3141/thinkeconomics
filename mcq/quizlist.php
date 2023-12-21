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

if($_SERVER['REQUEST_METHOD']==='POST') {
  if(isset($_GET['test'])) {
    print_r($_POST);
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
      //print_r($quizzes);
      print_r($_POST);
      ?>
      <table class="w-full table-fixed mb-2 border border-black">
        <?php
        foreach ($quizzes as $quiz) {
          ?>
          <form method="post" action="">
            <input type="hidden" name="id" value="<?=$quiz['id']?>"> 
            <tr>
              <td>
                <p class=""><?=$quiz['id']?></p>
              </td>
              <td>
                <p class="toggleClass_<?=$quiz['id']?>"><?=$quiz['topic']?></p>
                <input type="text" class="toggleClass_<?=$quiz['id']?> hidden" value="<?=$quiz['topic']?>" name="topic">
              </td>
              <td>
                <p class="toggleClass_<?=$quiz['id']?>"><?=$quiz['quizName']?></p>
              </td>
              <td>
                <p class="toggleClass_<?=$quiz['id']?>"><?=$quiz['questions_id']?></p>
              </td>
              <td>
                <p class="toggleClass_<?=$quiz['id']?>"><?=$quiz['notes']?></p>
              </td>
              <td>
                <p class="toggleClass_<?=$quiz['id']?>"><?=$quiz['active']?></p>
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

</script>

<?php   include($path."/footer_tailwind.php");?>