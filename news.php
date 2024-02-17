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
  
} else {
  $userId = $_SESSION['userid'];
  $userInfo = getUserInfo($userId);
  $permissions = $userInfo['permissions'];
  if((str_contains($permissions, "news_article_download") || str_contains($userInfo['school_permissions'], "news_article_download"))) {
    $downloadPermissions = 1;
  }

}

/*
Note that the permission "news_article_download" must be present in either permissions for school or for user for article download to be available.


*/





error_reporting(0);
$style_input = <<<END

th, td {
  
  border: 1px solid black;
  padding: 5px;
  word-wrap:break-word;
}

table {
  
  border-collapse: collapse;
  table-layout: fixed;
  width: 100%;

}

.col1, .col3 {
  width: 10%;
}

.col2 {
  width: 80%;
}

@media only screen and (max-width: 600px) {
  .col1, .col3 {
    width: 25%;
  }

  .col2 {
    width: 50%;
}
}

td p {
  margin-top: 0px;
}

END;

$get_selectors = array(
  'id' => (isset($_GET['id']) && $_GET['id'] != "") ? $_GET['id'] : null,
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
  'bbcPerennial' => (isset($_GET['bbcPerennial']) ) ? 1 : null,
  'withImages' => (isset($_GET['withImages']) ) ? 1 : null
);

$newsArticles = getNewsArticles($get_selectors['id'], $get_selectors['keyword'], $get_selectors['topic'], $get_selectors['startDate'], $get_selectors['endDate'], $get_selectors['orderBy'], null, $get_selectors['limit'], $get_selectors['searchFor'], $get_selectors['link'], $get_selectors['bbcPerennial'], 1, $get_selectors['withImages']);
?>

<?php include "header_tailwind.php"; 

//print_r($_POST);
/*
if (isset($_SESSION['userid'])==false) {

  $_SESSION['name'] = $_POST['name'];
  $_SESSION['userid'] = $_POST['userid'];
  $_SESSION['usertype'] = $_POST['usertype'];
  $_SESSION['groupid'] = $_POST['groupid'];

}
*/
//print_r($_SESSION);

?>

<!--

GET variables:
  'id'
  'topic'
  'keyword' 
  'startDate' 
  'endDate'
  'orderBy' 
  'limit' => default 100
  'searchFor'
  'noSearch' => if this is set then the extended search bar does not come up
  'link'
  'searchBar' => if this is set then extended search bar will be open on load


-->
<div class="container mx-auto px-4 pt-20 lg:pt-32 xl:pt-20">
<h1 class="font-mono text-2xl bg-pink-400 pl-1 mb-2">News List</h1>

<?php 

//print_r($newsArticles);
//var_dump($get_selectors);

//var_dump($permissions);
//print_r($userInfo);

?>

  <div class="container mx-auto px-0 mt-2 bg-white text-black">
    <?php
    if(is_null($get_selectors['noSearch']))
    {
      $showSearch = ($get_selectors['searchFor'] || $get_selectors['keyword'] || $get_selectors['startDate'] || $get_selectors['endDate'] || $get_selectors['link'] || $get_selectors['searchBar']) ? 1 : null;
      ?>
      <div id="accordion-collapse" data-accordion="collapse">
        <h2 id="accordion-collapse-heading-1">
          <button type="button" class="flex items-center justify-between w-full p-2 font-medium text-gray-500 border border-gray-200 hover:bg-gray-100  gap-3s font-mono" data-accordion-target="#accordion-collapse-body-1" aria-expanded="<?=($showSearch) ? "true" : "false"?>" aria-controls="accordion-collapse-body-1">
            <span>Search Controls</span>
            <svg data-accordion-icon class="w-3 h-3  shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1 5 5 1 1"/>
            </svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
          <div class="p-3 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
            <form type="get" action="">
              <p class="mb-2 text-gray-500">
                <label for="searchForInput">Headline, Keywords, Explanation:</label>
                <input class="px-1 w-full" id="searchForInput" name="searchFor" value="<?=$get_selectors['searchFor']?>" type="text">
              </p>
              <p class="mb-2 text-gray-500">
                <label for="keyWordInput">Keyword:</label>
                <input class="px-1 w-full" id="keyWordInput" name="keyword" value="<?=$get_selectors['keyword']?>" type="text">
              </p>
              <p class="mb-2 text-gray-500">
                <label for="linkInput">Link:</label>
                <input class="px-1 w-full" id="linkInput" name="link" value="<?=$get_selectors['link']?>" type="text">
              </p>
              <p class="mb-2 text-gray-500">
                <label for="topicInput">Topic:</label>
                <input class="px-1 w-full" id="topicInput" name="topic" value="<?=$get_selectors['topic']?>" type="text">
              </p>
              <div class="mb-2 text-gray-500 grid grid-cols-2 gap-2">
                <div>
                  <label for="startDateInput">Start Date:</label>
                  <input class="px-1 w-full" id="startDateInput" name="startDate" value="<?=$get_selectors['startDate']?>" type="date">
                </div>

                <div>
                  <label for="endDateInput">End Date:</label>
                  <input class="px-1 w-full" id="endDateInput" name="endDate" value="<?=$get_selectors['endDate']?>" type="date">
                </div>

              </div>
              <div class="mb-2 text-gray-500 flex gap-1 justify-around">
                <div class="">
                  <input type="checkbox" name="bbcPerennial" id="bbcPerennialInput" value="1" <?=(!is_null($get_selectors['bbcPerennial'])) ? "checked" : ""?>><label for="bbcPerennialInput"> BBC Explainer</label>
                </div>
                <div class="">
                  <input type="checkbox" name="withImages" id="withImagesInput" value="1" <?=(!is_null($get_selectors['withImages'])) ? "checked" : ""?>><label for="withImagesInput"> Articles with Images</label>
                </div>

              </div>
              <input class="w-full bg-pink-300" type="submit" value="Search"</input>
              <input type="hidden" value="<?=$get_selectors['topic']?>">
            </form>
          </div>
        </div>   
      </div> 
      <?php
    }
    ?>
    <table class="bg-white text-black">
      <tr>
        <th class='col1'>
          <form method = "get">
            <select class="text-black"style="width: 100%;" onchange="this.form.submit()" name="topic">
              <option value="">Topic</option>
                <?php
                $sql = "SELECT * FROM topics";
                $result = $conn->query($sql);
                if($result) {
                  while ($row = $result->fetch_assoc()) {
                    echo "<option value = '".$row['topicCode']."'";
                    if($_GET['topic']==$row['topicCode']) {
                      echo " selected ";
                    }
                    echo ">";
                    echo "(".$row['topicCode'].") ".$row['topicName'];
                    ?>
                  
              </option>
                      <?php
                    }
                  }
                ?>
            </select>
          </form>
        </th>
        <th class='col2'>Article</th><th class='col3'>Date Published</th>
      </tr>
      <?php


      $imgSource = "https://www.thinkeconomics.co.uk";

      foreach ($newsArticles as $row) {
          echo "<tr>";
        
          //print_r($row);
          //echo "<td>".$row['id']."</td>";
          echo "<td>".$row['topic']."</td>";
          echo "<td><p><strong>Headline: </strong>".$row['headline'];
          
          echo "</p><p><strong>Link: </strong><a class = 'hover:bg-sky-100 underline text-sky-700' target ='_blank' href='".$row['link']."'>".$row['link']."</a>";

          if($row['path'] != "" && $downloadPermissions) {
            ?>
            <a class="bg-sky-100 hover:bg-sky-200  rounded whitespace-nowrap" target="_blank" href="<?=$imgSource.$row['path']?>">Download PDF</a>
            <?php
          }
          echo "</p>";

          if ($row['explanation']!="") {
            echo "<p><strong>Explanation: </strong>".$row['explanation']."</p>";
          }

          if($row['explanation_long']!="") {
            ?>
            <button class="underline text-sky-700" type="button" onclick="toggleHide(this, 'longExplanationToggle_<?=$row['id']?>','Show Long Explanation', 'Hide Long Explanation')">Show Long Explanation</button>
            <div class="longExplanationToggle_<?=$row['id']?> hidden">
              <p><strong>Long Explanation: </strong></p>
              <p class="whitespace-pre-wrap"><?=$row['explanation_long']?></p>

            </div>
            <?php
          }

          if($row['photoAssets']!="") {
            ?>
            <button class="underline text-sky-700" type="button" onclick="toggleHide(this, 'photoAssetsToggle_<?=$row['id']?>','Show Images', 'Hide Images')">Show Images</button>
            <div class="photoAssetsToggle_<?=$row['id']?> hidden">
              <?php
                $photoAssets = explode(",", $row['photoAssets']);
                //print_r($photoAssets);
                foreach ($photoAssets as $asset) {
                  $asset = getUploadsInfo($asset)[0];
                  //print_r($asset);
                  ?>
                  <img alt ="<?=$asset['altText']?>" src="<?=$imgSource.$asset['path']?>">
                  <?php
                  }
                
              ?>

            </div>
            <?php
          }

          if($row['user'] == $userId) {
            ?>
            <p>
              <a class="underline text-pink-900" target="_blank" href="news/news_list.php?id=<?=$row['id']?>">Edit Details</a>
            </p>
            <?php
          }

          

          

          echo "</td>";

          $date = strtotime($row['datePublished']);
          $formatDate = date( 'd M Y', $date );
          echo "<td class='text-center'>".$formatDate."</td>";
          

        }

      ?>
    </table>
  </div>
</div>

<?php
  include "footer_tailwind.php";
?>
