<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");

$userId = null;
$permissions ="";

if (!isset($_SESSION['userid'])) {
  
  //header("location: /login.php");
  
}

else {
  $userInfo = getUserInfo($_SESSION['userid']);
  $userId = $_SESSION['userid'];
  $permissions = $userInfo['permissions'];
  /*
  if (!(str_contains($permissions, 'main_admin'))) {
    header("location: /index.php");
  }
  */

}





$style_input = "

  ";


$get_selectors = array(
  'simple' => (isset($_GET['simple']) ) ? 1 : null,
  'id' => (isset($_GET['id']) && $_GET['id']!="") ? $_GET['id'] : null,
  'topic' => (isset($_GET['topic']) && $_GET['topic']!="") ? $_GET['topic'] : null,
  'questionNo' => (isset($_GET['questionNo']) && $_GET['questionNo']!="") ? $_GET['questionNo'] : null,
  'examBoard' => (isset($_GET['examBoard']) && $_GET['examBoard']!="") ? $_GET['examBoard'] : null,
  'year' => (isset($_GET['year']) && $_GET['year']!="") ? $_GET['year'] : null,
  'component' => (isset($_GET['component']) && $_GET['component']!="") ? $_GET['component'] : null,
  'qualLevel' => (isset($_GET['qualLevel']) && $_GET['qualLevel']!="") ? $_GET['qualLevel'] : null

);

$questionIds = (isset($_GET['ids'])) ? $_GET['ids'] : null;
$questions = array();

if($questionIds) {
  $questionIds = explode(",", $questionIds);
  foreach($questionIds as $question) {
    array_push($questions, getPastPaperQuestionDetails($question)[0]);
  }
}

$simple = isset($_GET['simple'])  ? 1 : null;

if(!$simple) {
include($path."/header_tailwind.php");
} else {

  ?>
  <!DOCTYPE html>
  <html lang="en">
    <head>
      <style>
        img {width: 100%}
        
      </style>
    </head>
    <body>
  <?php
}

if(str_contains($permissions, "main_admin")) {
  ?>
  
  <!--
    $_GET[]:

    'simple' => if isset then simple version of page displayed
  
    
  
  -->
  <?php
  }


?>


<?php if(!$simple) {
  ?>
<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  <?php
}
  ?>
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Mark Scheme</h1>
  <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">
    <?php
    //var_dump($simple);
    /*
    var_dump($questionIds);
    echo "<br><pre>";
    print_r($questions);
    echo "</pre>";
    */

    $imgSource = "https://www.thinkeconomics.co.uk";

    foreach($questions as $question) {
      ?>
      <h2><?=$question['examBoard']?> <?=$question['qualLevel']?> Unit <?=$question['component']?> <?=$question['series']?> <?=$question['year']?> Q<?=$question['questionNo']?></h2>
      <?php
      $markScheme = explode(",", $question['markSchemeAssets']);
      //print_r($markScheme);
      foreach($markScheme as $asset) {
        $asset = getUploadsInfo($asset)[0];
        //print_r($asset);
        ?>
        <div class="flex justify-center">
        <img class="" alt ="<?=$asset['altText']?>" src="<?=$imgSource.$asset['path']?>">
        </div>
        <?php
      }
    }
    ?>
  </div>
<?php
if(!$simple) {
?>
</div>
<?php
}
?>

<?php
if(!$get_selectors['simple']) {
    include($path."/footer_tailwind.php");
}
?>
