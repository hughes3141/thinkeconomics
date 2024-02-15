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

  @media (min-width: 640px) {
    #phone_entry_div {
      display: none;
    }
  }

  textarea, input {
    padding: 0.25rem
  }


  
  ";

$confirmArticleEntry = "";
$previousLinkStatus = 0;

if($_SERVER['REQUEST_METHOD']==='POST') {
  if(isset($_POST['submit']) && $_POST['submit'] == "Click to Submit") {
    $insertRecord = 0;

    $headline = $_POST['headline'];
    $hyperlink =  $_POST['link'];
    $datePublished = $_POST['datePublished'];
    $explanation =  $_POST['explanation'];
    $explanation_long = $_POST['explanation_long'];
    $topic =  $_POST['topic'];

    $datetime = date("Y-m-d H:i:s");
    $keyWords = $_POST['keyWords'];
    $userid = $userId;
    $active = $_POST['active'];

    $previousLink = getNewsArticles(null, null, null, null, null, null, null, null, null, $hyperlink);

    //print_r($previousLink);

    if(count($previousLink)==0) {
      $insertRecord = 1;
    } else {
      $confirmArticleEntry = "Not entered- article previously exists in database";
      $previousLinkStatus = 1;
    }



    if($insertRecord == 1) {
      $confirmArticleEntry = insertNewsArticle($headline, $hyperlink, $datePublished, $explanation, $explanation_long, $topic, $datetime, $keyWords, $userid, $active);
    }
  }
  if(isset($_POST['submit']) && $_POST['submit'] == "Click to Update") {
    //$previousLinkStatus = 1;
    $previousLink = getNewsArticles($_POST['id']);

    $selectors = array(
    'headline' => ($_POST['headlineSelect']==1) ? $_POST['headline'] : null,
    'datePublished' => ($_POST['datePublishedSelect']==1) ? $_POST['datePublished'] : null,
    'explanation' => ($_POST['explanationSelect']==1) ? $_POST['explanation'] : null,
    'explanation_long' => ($_POST['explanation_longSelect']==1) ? $_POST['explanation_long'] : null,
    'keyWords' => ($_POST['keyWordsSelect']==1) ? $_POST['keyWords'] : null
    );

    //var_dump($selectors);

    //echo "<br><br><br><br>";

    $updateSQL = updateNewsArticle($_POST['id'], $selectors['headline'], $selectors['datePublished'], $selectors['explanation'], $selectors['explanation_long'], $selectors['keyWords']);

    $confirmArticleEntry = "Record ".$_POST['id']." updated successfully";

  }
}

include($path."/header_tailwind.php");

?>


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">News Input</h1>
  <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">
    <?php
      if(isset($_GET['test'])) {
        print_r($_POST);
      }
    ?>
    <p><?=$confirmArticleEntry?></p>
    <?php
      if($previousLinkStatus==0) {
    ?>
    
    <div id="phone_entry_div">
      <label for="phone_entry_input">Phone Optimised Entry:</label><br>
      <input class="w-full" type = "text" id ="phone_entry_input" onchange="phone_fill();"></input><br>
    
    </div>
    <form method="post">
      <div class="grid lg:grid-cols-2 gap-2 mb-2">
        <div>
          <label for="headline">Headline:</label><br>
          <input class="w-full" type="text" name="headline" id="headline" required>
        </div>
        <div>
          <label for="link">Link:</label><br>
          <input class="w-full" type ="text" name="link" id="link" required><br>
        </div>
        <div class="lg:col-span-2">
          <label for="datePublished">Date Published:</label><br>
          <input class="w-full" type ="date" name="datePublished" id="datePublished" required value="<?= date('Y-m-d'); ?>" ><br>
        </div>
        
        <div>
          <label for="explanation">Explanation:</label><br>
          <textarea class="w-full" name="explanation" id="explanation"></textarea><br>
        </div>
        <div>
          <label for="explanation_long">Long Explanation:</label><br>
          <textarea class="w-full" name="explanation_long" id="explanation_long"></textarea><br>
        </div>
        <div>
          <label for="topic">Topic:</label><br>
          <input class="w-full" type ="text" name="topic" id ="topic"><br>
        </div>
        <div>
          <label for="keyWords">Key Words:</label><br>
          <input class="w-full" type ="text" name="keyWords" id ="keyWords"><br>
        </div>
        <div>        
          <input type="radio" id="active_yes" name="active" value="1" checked>
          <label for="active_yes">Active</label><br>
          <input type="radio" id="active_no" name="active" value="0">
          <label for="active_no">Inactive</label><br>
        </div>
      </div>

      <input class="bg-pink-300 w-full border rounded" type ="submit" name="submit" value="Click to Submit">



    </form>

    <?php
    } else {
      $originalArticle = $previousLink[0];
      echo "<p>";
      print_r($previousLink);
      echo "</p>";

      ?>
      <div>
        <p>Your entry already has a match in the database. Do you want to update it?</p>
        <form method="post" action = "">
          <div>
            <h3 class="underline">Headlne:</h3>
            <p>
              <input id="headlineSelect_0" type='radio' name='headlineSelect' value="0" checked> <label for="headlineSelect_0" >Original:</label>
            </p>
            <div class="border border-black rounded p-1 bg-sky-100"><?=$originalArticle['headline']?></div>
            <p>
              <input id="headlineSelect_1" type='radio' name='headlineSelect' value="1"> <label for="headlineSelect_1">New:</label>
            </p>
            <textarea class="w-full" name="headline"><?=($_POST['headline']) ? $_POST['headline'] : ""?></textarea>
          </div>

          <div>
            <h3 class="underline">Date Published:</h3>
            <p>
              <input id="datePublishedSelect_0" type='radio' name='datePublishedSelect' value="0" checked> <label for="datePublishedSelect_0" >Original:</label>
            </p>
            <div class="border border-black rounded p-1 bg-sky-100"><?=date("d/m/Y",strtotime($originalArticle['datePublished']))?></div>
            <p>
              <input id="datePublishedSelect_1" type='radio' name='datePublishedSelect' value="1"> <label for="datePublishedSelect_1">New:</label>
            </p>
            <input class="w-full "type="date" name="datePublished" value="<?=($_POST['datePublished']) ? $_POST['datePublished'] : ""?>">
          </div>

          <div>
            <h3 class="underline">Explanation:</h3>
            <p>
              <input id="explanationSelect_0" type='radio' name='explanationSelect' value="0" checked> <label for="datePublishedSelect_0" >Original:</label>
            </p>
            <div class="border border-black rounded p-1 bg-sky-100"><?=$originalArticle['explanation']?></div>
            <p>
              <input id="explanationSelect_1" type='radio' name='explanationSelect' value="1"> <label for="explanationSelect_1">New:</label>
            </p>
            <textarea class="w-full" name="explanation"><?=($_POST['explanation']) ? $_POST['explanation'] : ""?></textarea>
          </div>

          <div>
            <h3 class="underline">Long Explanation:</h3>
            <p>
              <input id="explanation_longSelect_0" type='radio' name='explanation_longSelect' value="0" checked> <label for="datePublished_longSelect_0" >Original:</label>
            </p>
            <div class="border border-black rounded p-1 bg-sky-100"><?=$originalArticle['explanation']?></div>
            <p>
              <input id="explanation_longSelect_1" type='radio' name='explanation_longSelect' value="1"> <label for="explanation_longSelect_1">New:</label>
            </p>
            <textarea class="w-full" name="explanation_long"><?=($_POST['explanation_long']) ? $_POST['explanation_long'] : ""?></textarea>
          </div>

          <div>
            <h3 class="underline">Key Words:</h3>
            <p>
              <input id="keyWordsSelect_0" type='radio' name='keyWordsSelect' value="0" checked> <label for="keyWordsSelect_0" >Original:</label>
            </p>
            <div class="border border-black rounded p-1 bg-sky-100"><?=$originalArticle['keyWords']?></div>
            <p>
              <input id="keyWordsSelect_1" type='radio' name='keyWordsSelect' value="1"> <label for="keyWordsSelect_1">New:</label>
            </p>
            <input class="w-full "type="text" name="keyWords" value="<?=($_POST['keyWords']) ? $_POST['keyWords'] : ""?>">
          </div>

          <input class="w-full bg-sky-100" type="submit" value="Click to Update" name="submit">
          <input class="w-full bg-pink-100 hidden" type="submit" value = "Click to Create New Entry">

          <input type="hidden" name="link" value="<?=($_POST['link']) ? $_POST['link'] : ""?>">
          <input type="hidden" name="topic" value="<?=($_POST['topic']) ? $_POST['topic'] : ""?>">
          <input type="hidden" name="active" value="<?=($_POST['active']) ? $_POST['active'] : ""?>">
          <input type="hidden" name="id" value="<?=$originalArticle['id']?>">

        </form>
      </div>
      <?php
    } 
    ?>


  </div>
</div>

<script>
  function phone_fill() {
    var phone_fill_entry = document.getElementById("phone_entry_input").value;
    var entries = phone_fill_entry.split("https://");
    
    entries[1] = "https://"+entries[1];
    //console.log(entries);
    document.getElementById("headline").value = entries[0];
    document.getElementById("link").value = entries[1];
    
  }
</script>

<?php   include($path."/footer_tailwind.php");?>