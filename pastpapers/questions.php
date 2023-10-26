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




$questions = array();
if(isset($_GET['topic'])) {
  $get_selectors = array(
    'id' => ($_GET['id']!="") ? $_GET['id'] : null,
    'topic' => ($_GET['topic']!="") ? $_GET['topic'] : null,
    'questionNo' => ($_GET['questionNo']!="") ? $_GET['questionNo'] : null,
    'examBoard' => ($_GET['examBoard']!="") ? $_GET['examBoard'] : null,
    'year' => ($_GET['year']!="") ? $_GET['year'] : null,
    'component' => ($_GET['component']!="") ? $_GET['component'] : null,
    'qualLevel' => ($_GET['qualLevel']!="") ? $_GET['qualLevel'] : null

  );

  $run = 0;
  if(
    $get_selectors['topic'] ||
    $get_selectors['examBoard'] && $get_selectors['year'] ||
    $get_selectors['examBoard'] && $get_selectors['component']
  ) {
    $run = 1;
  }

  //var_dump($get_selectors);
  //var_dump($_GET);

  $controls = getPastPaperCategoryValues(/*$get_selectors['topic']*/ null, /*$get_selectors['examBoard']*/ null, $get_selectors['year'], $get_selectors['component'], $get_selectors['qualLevel']);

  if($run == 1) {
    $questions = getPastPaperQuestionDetails($get_selectors['id'], $get_selectors['topic'], $get_selectors['questionNo'], $get_selectors['examBoard'], $get_selectors['year'], $get_selectors['component'], $get_selectors['qualLevel'], 1);


  }

  $usedCaseStudies = array();
  
}

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">Past Paper Questions</h1>
    <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">
      <div>
        <h2 class="text-lg bg-pink-300 mb-3 font-mono p-2">Select Exam:</h2>
        <form method ="get"  action="">
          <div class="hidden">
            <label for="id_select">ID:</label>
            <input type="text" name="id" value="<?=isset($_GET['id']) ? $_GET['id'] : "" ?>"</input>

            <label for="questionNo_select">Question Code:</label>
            <input type="text" name="questionNo" value="<?=isset($_GET['questionNo']) ? $_GET['questionNo'] : "" ?>"</input>
          </div>
          <div>
            <label for="examBoard_select">Exam Board:</label>
            <select id="examBoard_select" name="examBoard" value="<?=isset($_GET['examBoard']) ? $_GET['examBoard'] : "" ?>" onchange="this.form.submit();">
              <?php
                $resetCategory = "--Reset Category--";

                $controlName = 'examBoard';
                $controlsIteration = $controls[$controlName];
                ?>
                  <option value=""><?=(($_GET[$controlName])) ? $resetCategory : ""?></option>
                <?php
                foreach($controlsIteration as $control) {
                  ?>
                  <option value="<?=$control?>" <?=(isset($_GET[$controlName]) && $control == $_GET[$controlName]) ? "selected" : ""?>><?=$control?></option>
                  <?php

                }
              ?>
            </select>
          </div>
          <div class="<?=(!$_GET['examBoard'] OR $_GET['examBoard']=="") ? 'hidden' : ''?>">
            <label for="qualLevel_select">Qualification:</label>
            <select id="qualLevel_select" name="qualLevel" onchange="this.form.submit();">
              <?php
                $controlName = 'qualLevel';
                $controlsIteration = $controls[$controlName];
                ?>
                  <option value=""><?=(($_GET[$controlName])) ? $resetCategory : ""?></option>
                <?php
                foreach($controlsIteration as $control) {
                  ?>
                  <option value="<?=$control?>" <?=(isset($_GET[$controlName]) && $control == $_GET[$controlName]) ? "selected" : ""?>><?=$control?></option>
                  <?php

                }
              ?>
            </select>

            <label for="year_select">Year:</label>
            <select id="year_select" name="year" onchange="this.form.submit();">
              <?php
                $controlName = 'year';
                $controlsIteration = $controls[$controlName];
                ?>
                  <option value=""><?=(($_GET[$controlName])) ? $resetCategory : ""?></option>
                <?php
                foreach($controlsIteration as $control) {
                  ?>
                  <option value="<?=$control?>" <?=(isset($_GET[$controlName]) && $control == $_GET[$controlName]) ? "selected" : ""?>><?=$control?></option>
                  <?php

                }
              ?>
            </select>

            <label for="component_select">Component:</label>
            <select id="component_select" name="component" onchange="this.form.submit();">
              <?php
                $controlName = 'component';
                $controlsIteration = $controls[$controlName];
                ?>
                  <option value=""><?=(($_GET[$controlName])) ? $resetCategory : ""?></option>
                <?php
                foreach($controlsIteration as $control) {
                  ?>
                  <option value=<?=$control?> <?=(isset($_GET[$controlName]) && $control == $_GET[$controlName]) ? "selected" : ""?>><?=$control?></option>
                  <?php

                }
              ?>
            </select>

          </div>
          <div>
            <label for="topic_select">Topic:</label>
            <select id="topic_select" name="topic" onchange="this.form.submit();">
            <?php
                $controlName = 'topic';
                $controlsIteration = $controls[$controlName];
                ?>
                  <option value=""><?=(($_GET[$controlName])) ? $resetCategory : ""?></option>
                <?php
                foreach($controlsIteration as $control) {
                  $topicList = explode("###",$control);
                  $topicCode = $topicList[0];
                  $topicName = $topicList[1];
                  ?>
                  <option value=<?=$topicCode?> <?=(isset($_GET[$controlName]) && $topicCode == $_GET[$controlName]) ? "selected" : ""?>><?=$topicName?></option>
                  <?php

                }
              ?>
            </select>
          </div>
          

          



          

          <input type="submit"  value="Select">
        </form>
      </div>
      <div>
        <pre>
          <?php
            if(isset($_GET['test'])) {
              print_r($controls);
            }
          ?>
        </pre>
      </div>
      <div>
        <?php
          //print_r($questions);
          $imgSource = "https://www.thinkeconomics.co.uk";
          foreach($questions as $question) {
            //print_r($question);
            ?>
            <div class="mb-3 p-1 border rounded border-pink-300">
              <!--id: <?=$question['id']?> topic <?=$question['topic']?>-->
              <p class="text-lg"><?=$question['examBoard']?> <?=$question['qualLevel']?> Unit <?=$question['component']?> <?=$question['series']?> <?=$question['year']?> Q<?=$question['questionNo']?></p>
              <?php
              if($question['topicName'] != "") {
                echo "<p>Topic: ".$question['topicName']."</p>";
              }
              ?>
              <p><?php
                //Case Study:
                if($question['caseId']) {
                  $caseId = $question['caseId'];
                  if(!in_array($caseId, $usedCaseStudies))
                  {
                    array_push($usedCaseStudies, $caseId);
                    $caseStudy = getPastPaperQuestionDetails($question['caseId'])[0];
                    

                    $questionAssets = explode(",",$caseStudy['questionAssets']);

                    foreach($questionAssets as $asset) {
                      $asset = getUploadsInfo($asset)[0];
                      //print_r($asset);
                      
                      ?>
                      <img alt ="<?=$asset['altText']?>" src="<?=$imgSource.$asset['path']?>">
                      <?php
                    }
                  }
                  
                }
              
              ?></p>
              <p class="whitespace-pre-line"><?php
                //Questions:
                $questionAssets = explode(",",$question['questionAssets']);
                //var_dump($questionAssets);
                if(count($questionAssets) == 1 && $questionAssets[0]=="") {
                  echo $question['question']." [".$question['marks']." marks]";
                }
                else {
                  //Questions Images:
                  foreach($questionAssets as $asset) {
                    $asset = getUploadsInfo($asset)[0];
                    //print_r($asset);
                    
                    ?>
                    <img alt ="<?=$asset['altText']?>" src="<?=$imgSource.$asset['path']?>">
                    <?php
                  }

                }
                
                ?></p>
                <?php

                $markSchemeAssets = explode(",",$question['markSchemeAssets']);
                //print_r($questionAssets);

                if($question['markSchemeAssets']!="") {
                  ?>
                <button class="border rounded bg-pink-300 border-black mb-1 p-1" type="button" onclick="toggleHide(this, 'markSchemeToggle_<?=$asset['id']?>', 'Show Mark Scheme', 'Hide Mark Scheme', 'block')">Show Mark Scheme</button>

                <div class="markSchemeToggle_<?=$asset['id']?> hidden">
                <?php
                  //Mark Scheme:
                  foreach($markSchemeAssets as $asset) {
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
                ?>
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