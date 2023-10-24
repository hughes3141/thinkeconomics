<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");


if (!isset($_SESSION['userid'])) {
  
  //header("location: /login.php");
  
}
/*
else {
  $userInfo = getUserInfo($_SESSION['userid']);
  $userId = $_SESSION['userid'];
  $permissions = $userInfo['permissions'];
  if (!(str_contains($permissions, 'main_admin'))) {
    header("location: /index.php");
  }

}
*/
$style_input = "

  ";


include($path."/header_tailwind.php");

if($_SERVER['REQUEST_METHOD']==='POST') {}


$controls = getPastPaperCategoryValues();

$questions = array();
if(isset($_GET['topic'])) {
  $get_selectors = array(
    'id' => ($_GET['id']!="") ? $_GET['id'] : null,
    'topic' => ($_GET['topic']!="") ? $_GET['topic'] : null,
    'questionNo' => ($_GET['questionNo']!="") ? $_GET['questionNo'] : null,
    'examBoard' => ($_GET['examBoard']!="") ? $_GET['examBoard'] : null,
    'year' => ($_GET['year']!="") ? $_GET['year'] : null,
    'component' => ($_GET['component']!="") ? $_GET['component'] : null,

  );

  //var_dump($get_selectors);
  //var_dump($_GET);

  $questions = getPastPaperQuestionDetails($get_selectors['id'], $get_selectors['topic'], $get_selectors['questionNo'], $get_selectors['examBoard'], $get_selectors['year'], $get_selectors['component']);
  
}

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">Past Paper Questions</h1>
    <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">
      <div>
        <form method ="get"  action="">
          <label for="id_select">ID:</label>
          <input type="text" name="id" value="<?=isset($_GET['id']) ? $_GET['id'] : "" ?>"</input>
          <label for="_select">Topic:</label>
          <input type="text" name="topic" value="<?=isset($_GET['topic']) ? $_GET['topic'] : "" ?>"</input>
          <label for="questionNo_select">Question Code:</label>
          <input type="text" name="questionNo" value="<?=isset($_GET['questionNo']) ? $_GET['questionNo'] : "" ?>"</input>

          <label for="examBoard_select">Exam Board:</label>
          <input type="text" id="examBoard_select" name="examBoard" value="<?=isset($_GET['examBoard']) ? $_GET['examBoard'] : "" ?>"</input>

          <label for="year_select">Year:</label>
          <input type="text" id="year_select" name="year" value="<?=isset($_GET['year']) ? $_GET['year'] : "" ?>"</input>

          <label for="component_select">Component:</label>
          <input type="text" id="component_select" name="component" value="<?=isset($_GET['examBoard']) ? $_GET['component'] : "" ?>"</input>

          <input type="submit"  value="Select">
        </form>
      </div>
      <div>
        <pre>
          <?php
            //print_r($controls);
          ?>
        </pre>
      </div>
      <div>
        <?php
          //print_r($questions);
          foreach($questions as $question) {
            $questionAssets = explode(",",$question['questionAssets']);
            ?>
            <div class="mb-3 p-1 border rounded border-pink-300">
              <p class="text-lg"><?=$question['examBoard']?> <?=$question['qualLevel']?> Unit <?=$question['component']?> <?=$question['series']?> <?=$question['year']?></p>
              <p><?php
                var_dump($questionAssets);
                if(count($questionAssets) == 1 && $questionAssets[0]=="") {
                  echo $question['question']." (".$question['marks']." marks)";
                }
                
                ?></p>
            </div>
            <?php
          }
        ?>
      </div>
    </div>
</div>

<script>
</script>
<?php   include($path."/footer_tailwind.php");?>