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
  input, button, textarea, th, td {
    border: 1px solid black;
  }
  td, th {
    padding: 5px;
  
  ";





include($path."/header_tailwind.php");

if($_SERVER['REQUEST_METHOD']==='POST') {

}

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">New Class Creator</h1>
    <div class="font-mono container mx-auto px-0 mt-2 bg-white text-black mb-5">
      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        print_r($_POST);
      }
      ?>
      <h2>Create a New Class</h2>
        <form method="post" action="">
          <label>Class Name:<label>
          <input type="text" name="name">
          <br>
          <label>Subject:<label>
          <select>

          </select>
          <br>
          <label>Option Group:<label>
          <input type="text" name="optionGroup">
          <br>
          <label>Qualification Type:<label>
          <input type="text" name="qualType">
          <br>
          <label>Finish Date:<label>
          <input type="date" name="dateFinish">
          <br>
          <input type="submit" name="submit" value="Create New Class">
        </form>

    </div>
</div>




<?php   include($path."/footer_tailwind.php");?>

