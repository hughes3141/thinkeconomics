<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");

$userId = null;

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

  ";

include($path."/header_tailwind.php");


if(str_contains($permissions, "main_admin")) {
?>

<!--
  $_GET[]:


-->
<?php
}

if($_SERVER['REQUEST_METHOD']==='POST') {}

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">News Article Editor</h1>
  <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">

  </div>
</div>

<script>
</script>
<?php   include($path."/footer_tailwind.php");?>