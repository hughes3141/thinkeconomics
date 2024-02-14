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


  
  ";

$confirmArticleEntry = "";

if($_SERVER['REQUEST_METHOD']==='POST') {
  $insertRecord = 0;

  $insertRecord = 1;

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

  if($insertRecord == 1) {
    $confirmArticleEntry = insertNewsArticle($headline, $hyperlink, $datePublished, $explanation, $explanation_long, $topic, $datetime, $keyWords, $userid, $active);
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