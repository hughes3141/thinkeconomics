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

if($_SERVER['REQUEST_METHOD']==='POST') {
  if(isset($_POST['submit'])&&($_POST['submit']=="Submit")) {
    insertExerciseList($_POST['name'], $_POST['link'], $_POST['topic']);
    $updateMessage = "New record created successfully";


  }

}

$exercises = getExerciseList();

include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">Exercise List</h1>
    <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">
      <?php
      print_r($_POST);
      echo $updateMessage;
      print_r($exercises);
      ?>
      

      <div>
        <form method="post" action ="">
          <p class="mb-3">
            <label for="nameInput">Exercise Name:</label>
            <input id="nameInput" type="text" name="name">
          </p>
          <p class="mb-3">
            <label for="linkInput">Link:</label>
            <textarea id="linkInput" type="text" name="link"></textarea>
          </p>
          <p class="mb-3">
            <label for="topicInput">Topic:</label>
            <input id="topicInput" type="text" name="topic">
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
            <tr>
              <td>
                <?php print_r($exercise); ?>
                <p>Name: <?=$exercise['name']?></p>
                <p>Link: <a target="_blank" href="<?=$exercise['link']?>"><?=$exercise['link']?></a></p>
                <p>Topic: <?=$exercise['topic']?></p>
              </td>
            </tr>
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

