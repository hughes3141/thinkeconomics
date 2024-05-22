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
  if (!($userType == "teacher" || $userType =="admin")) {
    header("location: /index.php");
  }
}

$style_input = "";

$get_selectors = array(
  'articleId' => (isset($_GET['articleId']) && $_GET['articleId'] != "") ? $_GET['articleId'] : null,
  'topic' => (isset($_GET['topic']) && $_GET['topic'] != "") ? $_GET['topic'] : null,
  'keyword' => (isset($_GET['keyword']) && $_GET['keyword'] != "") ? $_GET['keyword'] : null,
  'startDate' => (isset($_GET['startDate']) && $_GET['startDate'] != "") ? $_GET['startDate'] : null,
  'endDate' => (isset($_GET['endDate']) && $_GET['endDate'] != "") ? $_GET['endDate'] : null,
  'orderBy' => (isset($_GET['orderBy']) && $_GET['orderBy'] != "") ? $_GET['orderBy'] : null,
  'limit' => (isset($_GET['limit']) && $_GET['limit'] != "") ? $_GET['limit'] : 100,
  'searchFor' => (isset($_GET['searchFor']) && $_GET['searchFor'] != "") ? $_GET['searchFor'] : "",
  'noSearch' => (isset($_GET['noSearch']) ) ? 1 : null,
  'link' => (isset($_GET['link']) && $_GET['link'] != "") ? $_GET['link'] : "",
  'searchBar' => (isset($_GET['searchBar']) ) ? 1 : null,
  'video' => (isset($_GET['video'])) ? 1 : null,
  'audio' => (isset($_GET['audio'])) ? 1 : null

);

$article = array();
if(!is_null($get_selectors['articleId'])) {
  $article = getNewsArticles($get_selectors['articleId'])[0];
}

$questions = array();

include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">News Questions</h1>
  <div class=" container mx-auto px-4 pb-4 mt-2 bg-white text-black mb-5">
    <?php
    print_r($article);
    $imgSource = "https://www.thinkeconomics.co.uk";
    ?>
    <p>Headline: <?=$article['headline']?></p>
    <p>Source: <a class="underline text-sky-700" target="_blank" href="<?=$article['link']?>"><?=$article['link']?></a></p>
    <?php
      $images = array();
      //Get any images that are uploaded in uploads:
      if($article['photoAssets'] != "") {
        $imagesUploads = explode(",",$article['photoAssets']);
        //print_r($imagesUploads);
        foreach ($imagesUploads as $imageId) {
          $imageUpload = getUploadsInfo($imageId)[0];
          //print_r($imageUpload);
          $imageArray = array('path' => $imgSource.$imageUpload['path'], 'altText'=> $imageUpload['altText']);
          array_push($images, $imageArray);
        }
      }
      //Get any images that are linked in database under imageLink:
      if($article['photoLinks'] != "") {
        $imagesLinks = explode(", ",$article['photoLinks']);
        //print_r($imagesUploads);
        foreach ($imagesLinks as $link) {
          $imageArray = array('path' => trim($link), 'altText'=> $link);
          array_push($images, $imageArray);
        }
      }
      //print_r($images);
    ?>
    <img src="<?=$images[0]['path']?>" alt ="<?=$images[0]['altText']?>">
  </div>
</div>

<script></script>

<?php   include($path."/footer_tailwind.php");?>