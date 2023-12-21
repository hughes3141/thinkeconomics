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
  'search' => (isset($_GET['search'])&&$_GET['search']!="") ? $_GET['search'] : null

);

$quizzes = getMCQquizDetails();

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

        <input type="submit"  value="Select">
      </form>
    </div>
      <?php
      //print_r($quizzes);
      ?>
      <table>
        <?php
        foreach ($quizzes as $quiz) {
          ?>
          <tr>
            <td><?=$quiz['id']?></td>
            <td><?=$quiz['topic']?></td>
            <td><?=$quiz['quizName']?></td>
            <td><?=$quiz['questions_id']?></td>
            <td><?=$quiz['notes']?></td>
            <td><?=$quiz['active']?></td>
          </tr>
          <?php
        }
        ?>
      </table>


    </div>
</div>

<script>

</script>

<?php   include($path."/footer_tailwind.php");?>