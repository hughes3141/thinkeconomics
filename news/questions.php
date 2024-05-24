<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");

$downloadPermissions = null;
$userId = null;

if (!isset($_SESSION['userid'])) {
  
  //header("location: /login.php");

}

else {
  $userId = $_SESSION['userid'];
  $userInfo = getUserInfo($_SESSION['userid']);
  $userType = $userInfo['usertype'];
  $permissions = $userInfo['permissions'];
  if((str_contains($permissions, "news_article_download") || str_contains($userInfo['school_permissions'], "news_article_download"))) {
    $downloadPermissions = 1;
  }
  /*
  if (!($userType == "teacher" || $userType =="admin")) {
    header("location: /index.php");
  }
  */
}

/*
Note that the permission "news_article_download" must be present in either permissions for school or for user for article download to be available.


*/

$style_input = "";

$get_selectors = array(
  'articleId' => (isset($_GET['articleId']) && $_GET['articleId'] != "") ? $_GET['articleId'] : null,
  'questionIds' => (isset($_GET['questionIds']) && $_GET['questionIds'] != "") ? $_GET['questionIds'] : null,
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

$article = array(
  'id' => '',
  'headline' => '',
  'link' => '',
  'datePublished' => '',
  'explanation' => '',
  'explanation_long' => '',
  'questions_array' => '',
  'topic' => '',
  'keyWords' => '',
  'dateCreated' => '',
  'user' => '',
  'active' => '',
  'articleAsset' => '',
  'bbcPerennial' => '',
  'photoAssets' => '',
  'photoLinks' => '',
  'video' => '',
  'audio' => '',
  'path' => ''

);
if(!is_null($get_selectors['articleId'])) {
  if(count(getNewsArticles($get_selectors['articleId'])) >0) {
    $article = getNewsArticles($get_selectors['articleId'])[0];
  }
}


$questions = array();

if($article['questions_array'] != "") {
  $questions = explode(",",$article['questions_array']);

  if(!is_null($get_selectors['questionIds'])) {
    $questions = explode(",",$get_selectors['questionIds']);
  }

  foreach ($questions as $key => $question) {
    $questionInfo = getNewsQuestion($question);
    if(count($questionInfo)>0) {
      $questions[$key] = $questionInfo[0];
    } else {
      $questions[$key] = array(
        'question' => '',
        'topic' => '',
        'id' => '',
        'model_answer' => '',
        'answer_img' => '',
        'questionAssetId' => '',
        'answerAssetId' => '',
        'articleId' => ''
      );
    }
  } 
}



include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">News Questions</h1>
  <div class=" container mx-auto px-4 pb-4 mt-2 pt-1 bg-white text-black mb-5">
    <?php
    //print_r($article);
    //print_r($questions);
    $imgSource = "https://www.thinkeconomics.co.uk";

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
    <h2 class="text-xl bg-pink-200 p-1 my-2 rounded">Headline: <?=$article['headline']?></h2>
    <?php

    if(count($images)>0){
      ?>
        <img class="md:w-1/2 md:float-right md:ml-1 mb-1" src="<?=$images[0]['path']?>" alt ="<?=$images[0]['altText']?>">
      <?php
      }
    ?>
    <p class="text-ellipsis overflow-hidden ml-1"><a class="underline text-sky-700" target="_blank" href="<?=$article['link']?>"><?=$article['link']?></a></p>
    <p class="ml-1"><?=date_format(date_create($article['datePublished']), 'd M Y')?></p>

    <?php
      if($article['path'] != "" && $downloadPermissions) {
        ?>
        <a class="bg-sky-100 hover:bg-sky-200 ml-1 rounded whitespace-nowrap" target="_blank" href="<?=$imgSource.$article['path']?>">Download PDF</a>
        <?php
      }


      if($article['explanation'] != "") {
        ?>
        <div>
          <h3 class="md:w-1/3 py-1 rounded bg-pink-100 px-1 my-2">Explanation: </h3>
          <p class="whitespace-pre-wrap ml-1"><?=$article['explanation']?></p>
        </div>
        <?php
      }

      if($article['explanation_long'] != "") {
        ?>
        <div>
          <h3 class="md:w-1/3 py-1 rounded bg-pink-100 px-1 my-2">Long Explanation:</h3>
          <p class="whitespace-pre-wrap ml-1"><?=$article['explanation_long']?></p>
        </div>
        <?php
      }

      if(count($questions) > 0) {
        ?>
        <div>
          <h3 class="md:w-1/3 py-1 rounded bg-pink-100 px-1 my-2 clear-right">Questions:</h3>
          <ol class="list-decimal list-outside ml-4">
            <?php
              foreach($questions as $question) {
                ?>
                <div class="pl-1">
                  <li class="whitespace-pre-wrap mb-1"><?=$question['question']?></li>
                  <?php
                  if($question['model_answer'] != "") {

                  ?>
                  <button class="border border-black rounded bg-pink-200 px-1 mb-1" onclick="toggleHide(this, 'markSchemeToggle_<?=$question['id']?>', 'Show Answer', 'Hide Answer', 'block')">Show Answer</button>
                  <div class=" rounded border-2 border-sky-200 bg-pink-100 mb-1 p-2 hidden markSchemeToggle_<?=$question['id']?>">
                    <p class="whitespace-pre-wrap"><?=$question['model_answer']?></p>
                    <?php
                      $imagesArray = array();
                      if($question['answerAssetId'] != "") {
                        $imagesArray = explode(",",$question['answerAssetId']);
                        //print_r($imagesArray);
                      }
                      foreach ($imagesArray as $imageAsset) {
                        $imageDetails = getUploadsInfo($imageAsset)[0];
                        //print_r($imageDetails);
                        ?>
                        <img src="<?=$imgSource.$imageDetails['path']?>" alt="<?=$imageDetails['altText']?>">
                        <?php
                      }
                    ?>
                  </div>
                  <?php
                  }
                  ?>
                </div>
                <?php
              }
            ?>
          </ol>
        </div>
        <?php
      }
    ?>
    
  </div>
</div>

<script></script>

<?php   include($path."/footer_tailwind.php");?>