<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");

$userId = null;
$permissions = "";

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


include($path."/header_tailwind.php");



if(str_contains($permissions, "main_admin")) {
?>

<!--
  $_GET[]:

  -testNoDate -> sets $dateBefore to null so that all results are output.

-->
<?php
}

if($_SERVER['REQUEST_METHOD']==='POST') {}

$excludedYear = 2023;

/*

Above variable $excludedYear is the year that will not be returned in any restults.
This is primarly so that most-recnet exam years will not show up in query purposes.

*/

$dateBefore = "2024-02-18";

if(isset($_GET['testNoDate'])) {
  $dateBefore = null;
}

/*
 Above variable $dateBefore sets a date that all entries must have been made before in order to be output to the user.

 This allows for more entries to be entered and then published all at once by chaning $dateBefore.

 Change $dateBefore after entering a new batch of questions into the database

*/

if(str_contains($permissions, "main_admin")) {
  $excludedYear = null;
}


$questions = array();

$get_selectors = array(
  'id' => (isset($_GET['id']) && $_GET['id']!="") ? $_GET['id'] : null,
  'topic' => (isset($_GET['topic']) && $_GET['topic']!="") ? $_GET['topic'] : null,
  'questionNo' => (isset($_GET['questionNo']) && $_GET['questionNo']!="") ? $_GET['questionNo'] : null,
  'examBoard' => (isset($_GET['examBoard']) && $_GET['examBoard']!="") ? $_GET['examBoard'] : null,
  'year' => (isset($_GET['year']) && $_GET['year']!="") ? $_GET['year'] : null,
  'component' => (isset($_GET['component']) && $_GET['component']!="") ? $_GET['component'] : null,
  'qualLevel' => (isset($_GET['qualLevel']) && $_GET['qualLevel']!="") ? $_GET['qualLevel'] : null

);

$controls = getPastPaperCategoryValues($get_selectors['topic'], $get_selectors['examBoard'], $get_selectors['year'], $get_selectors['component'], $get_selectors['qualLevel'], null, $excludedYear, $dateBefore);



  

  $run = 0;
  if(
    $get_selectors['topic'] ||
    $get_selectors['examBoard'] && $get_selectors['year'] ||
    $get_selectors['examBoard'] && $get_selectors['component'] ||
    $get_selectors['id']
  ) {
    $run = 1;
  }

  //var_dump($get_selectors);
  //var_dump($_GET);


  

  if($run == 1) {
    $questions = getPastPaperQuestionDetails($get_selectors['id'], $get_selectors['topic'], $get_selectors['questionNo'], $get_selectors['examBoard'], $get_selectors['year'], $get_selectors['component'], $get_selectors['qualLevel'], 1, 1, $excludedYear, $dateBefore);


  }

  $usedCaseStudies = array();
  


?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">Past Paper Questions Database</h1>
    <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">
          <?php
            if(isset($_GET['test'])) {
              echo "<div><pre>";
              print_r($controls);
              echo "</div></pre>";
            }
          ?>
      <div class="border-2 rounded border-sky-200 p-2 mb-2 pb-3">
        <h2 class="bg-sky-100 -mx-2 -mt-2 pl-2 text-lg font-mono">Search By:</h2>
        <form method ="get"  action="">
          <?php
          /*
          <div class="hidden">
            <label for="id_select">ID:</label><br>
            <input type="text" name="id" value="<?=isset($_GET['id']) ? $_GET['id'] : "" ?>"</input>

            <label for="questionNo_select">Question Code:</label>
            <input type="text" name="questionNo" value="<?=isset($_GET['questionNo']) ? $_GET['questionNo'] : "" ?>"</input>
          </div>
          */
          ?>
          <div>
            <label for="examBoard_select">Exam Board:</label><br>
            <select class="w-full" id="examBoard_select" name="examBoard" value="<?=isset($_GET['examBoard']) ? $_GET['examBoard'] : "" ?>" onchange="this.form.submit();">
              <?php
                $resetCategory = "--Reset Category--";
                //$resetCategory = "";
                $resetCategoryStyle = "class='bg-pink-200'";
                $selectedStyle = 'bg-sky-200';
                $selectedStyle = "";

                $controlName = 'examBoard';
                $controlsIteration = $controls[$controlName];
                
                ?>
                  <option value="" <?=($get_selectors[$controlName]) ? $resetCategoryStyle : ""?> ><?=($get_selectors[$controlName]) ? $resetCategory : ""?></option>
                <?php
                foreach($controlsIteration as $control) {
                  ?>
                  <option class = "<?=($get_selectors[$controlName] == $control) ? $selectedStyle : ""?>" value="<?=$control?>" <?=($get_selectors[$controlName] == $control) ? "selected" : ""?>><?=$control?></option>
                  <?php

                }
              ?>
            </select>
          </div>
          <?php
          if(!is_null($get_selectors['examBoard'])) {
          ?>
          <div class="<?=(is_null($get_selectors['examBoard'])) ? 'hidden' : ''?>">
            <div>
              <label for="qualLevel_select">Qualification:</label><br>
              <select class="w-full" id="qualLevel_select" name="qualLevel" onchange="this.form.submit();">
                <?php
                  $controlName = 'qualLevel';
                  $controlsIteration = $controls[$controlName];
                  ?>
                    <option value="" <?=($get_selectors[$controlName]) ? $resetCategoryStyle : ""?> ><?=($get_selectors[$controlName]) ? $resetCategory : ""?></option>
                  <?php
                  foreach($controlsIteration as $control) {
                    ?>
                    <option  value="<?=$control?>" <?=($get_selectors[$controlName] == $control) ? "selected" : ""?>><?=$control?></option>
                    <?php

                  }
                ?>
              </select>
            </div>
            <div>
              <label for="component_select">Unit/Component:</label><br>
              <select class="w-full" id="component_select" name="component" onchange="this.form.submit();">
                <?php
                  $controlName = 'component';
                  $controlsIteration = $controls[$controlName];
                  ?>
                    <option value="" <?=($get_selectors[$controlName]) ? $resetCategoryStyle : ""?>><?=($get_selectors[$controlName]) ? $resetCategory : ""?></option>
                  <?php
                  foreach($controlsIteration as $control) {
                    ?>
                    <option value="<?=$control?>" <?=($get_selectors[$controlName] == $control) ? "selected" : ""?>><?=$control?></option>
                    <?php
                  }
                ?>
              </select>
            </div>
            <div>
              <label for="year_select">Year:</label><br>
              <select class="w-full" id="year_select" name="year" onchange="this.form.submit();">
                <?php
                  $controlName = 'year';
                  $controlsIteration = $controls[$controlName];
                  ?>
                    <option value="" <?=($get_selectors[$controlName]) ? $resetCategoryStyle : ""?>><?=($get_selectors[$controlName]) ? $resetCategory : ""?></option>
                  <?php
                  foreach($controlsIteration as $control) {
                    ?>
                    <option value="<?=$control?>" <?=($get_selectors[$controlName] == $control) ? "selected" : ""?>><?=$control?></option>
                    <?php

                  }
                ?>
              </select>
            </div>
            
          </div>
          <?php
          }
          ?>
          <div>
            <label for="topic_select">Topic:</label><br>
            <select class="w-full" id="topic_select" name="topic" onchange="this.form.submit();">
            <?php
                $controlName = 'topic';
                $controlsIteration = $controls[$controlName];
                ?>
                  <option value="" <?=($get_selectors[$controlName]) ? $resetCategoryStyle : ""?> ><?=(($get_selectors[$controlName])) ? $resetCategory : ""?></option>
                <?php
                foreach($controlsIteration as $control) {
                  $topicList = explode("###",$control);
                  $topicCode = $topicList[0];
                  $topicName = $topicList[1];
                  if($topicCode != "") {
                    ?>
                    <option value="<?=$topicCode?>" <?=($get_selectors[$controlName] == $topicList[0]) ? "selected" : ""?>>(<?=$topicCode?>) <?=$topicName?></option>
                    <?php
                  }

                }
              ?>
            </select>
          </div>

          <input type="hidden"  value="Select">
          <button type="button" onClick="window.location.href=window.location.href.split('?')[0]" class="bg-pink-200 w-full border border-black rounded mt-3">Reset All Parameters</button>
        </form>
      </div>
      <?php
        if(isset($_GET['test'])) {
          echo "<div><pre>";
          print_r($questions);
          echo "</div></pre>";
        }
      ?>

      <?=(count($questions)>0) ? "<h2 class='text-xl mb-2 bg-pink-300 rounded p-1 font-mono'>Questions</h2>" : ""?>
      <div>
        <?php
          //print_r($questions);
          $imgSource = "https://www.thinkeconomics.co.uk";
          $usedQuestions = array();
          $usedExamInstance =array();
          foreach($questions as $question) {

            $groupQuestions = array();
            
            $caseId = null;
          

            //print_r($question);

            if(!in_array($question['id'], $usedQuestions)) {
              
              $examInstance = $question['examBoard']." ".$question['qualLevel']." "."Unit ".$question['component']." (".$question['unitName'].") ".$question['series']." ".$question['year'];

              if(!in_array($examInstance, $usedExamInstance)) {
                ?>
                <h2 class="text-xl bg-sky-200 mb-2 p-1 rounded sticky top-12 lg:top-20 z-10"><a class="hover:bg-pink-300 hover:text-sky-700 " target="blank" href="questions.php?examBoard=<?=$question['examBoard']?>&qualLevel=<?=$question['qualLevel']?>&component=<?=$question['component']?>&year=<?=$question['year']?>&topic="><?=$examInstance?></a></h2>
                <?php
                array_push($usedExamInstance, $examInstance);

              }
              



              if($question['caseId']) {
                $caseId = $question['caseId'];
                $caseStudy = getPastPaperQuestionDetails($question['caseId'])[0];
                array_push($groupQuestions, $caseStudy);
                foreach($questions as $question2) {
                  if($question2['caseId'] == $caseId) {
                    array_push($groupQuestions, $question2);
                    array_push($usedQuestions, $question2['id']);
                  }
                }
              }
              else {
                array_push($groupQuestions, $question);
              }
              ?>
              <div class="mb-3 border-2 rounded border-pink-300">
                <?php
                foreach($groupQuestions as $key2 => $question2) {
                  ?>
                <!--id: <?=$question2['id']?> topic <?=$question2['topic']?> Code: <?=$question2['No']?>  -->
                
                  <?php
                  if($key2 == 0) {
                    ?>
                    <div class="bg-pink-200 px-1 border-b-2 border-slate-500">
                      <h3 class="text-lg"><?=$question2['examBoard']?> <?=$question2['qualLevel']?> Unit <?=$question2['component']?> (<?=$question['unitName']?>) <?=$question2['series']?> <?=$question2['year']?> Q<?=$question2['questionNo']?></h3>
                      <?php
                      if($question2['topicName'] != "") {
                        echo "<p>Topic: ".$question2['topicName']."</p>";
                      }
                      ?>
                    </div>
                    <?php
                    } else {
                    ?>
                    <div class="lg:w-1/2 lg:rounded-r-lg bg-pink-100 px-1">
                      <h4 class="text-lg">
                        <?php
                        //echo $question2['examBoard']." ";
                        //echo $question2['qualLevel']." ";
                        //echo "Unit ".$question2['component']." ";
                        //echo $question2['series']." ";
                        //echo $question2['year']." ";
                        echo "Q".$question2['questionNo'];
                        ?></h4>
                        <?=($question2['topicName'] != "") ? $question2['topicName'] : ""?>
                    </div>
                    <?php
                    }
                    
                    ?>
                
                <?php

                //Questions:
                $questionAssets = explode(",",$question2['questionAssets']);
                //var_dump($questionAssets);
                if(count($questionAssets) == 1 && $questionAssets[0]=="") {
      
                  $questionArray=explode("\n",$question2['question']);
                  ?>
                  <div class=" p-2 pl-11 relative">
                  <?php
                  //print_r($questionArray);

                  $lastParagraph = count($questionArray) - 1;
                  foreach($questionArray as $key => $newLine) {
                    if($key == 0) {
                      ?>
                      <p class="<?=(($key == $lastParagraph) && $caseId) ? "" : "mb-2"?> <?=($key2!=0) ? "mb-2" : ""?>"><span class="-ml-9 absolute"><?=$question2['questionNo']?>.&nbsp;</span><?=$newLine?></p>
                      <?php
                    }
                    else {
                      ?>
                      <p class=" <?=(($key == $lastParagraph) && $caseId) ? "" : "mb-2"?> <?=($key2!=0) ? "mb-2" : ""?>"><?=$newLine?></p>
                      <?php
                    }
                  }
                  if(!$caseId || $key2 !=0) {
                    ?>
                      <p class="">[<?=$question2['marks']?> marks]<p>
                    <?php
                  }
                  ?>
                  </div>
                  <?php
                }
                else {
                  //Questions Images:
                  echo "<div class='p-2'>";
                  foreach($questionAssets as $asset) {
                    $asset = getUploadsInfo($asset)[0];
                    //print_r($asset);
                    ?>
                      <img class=" object-contain" alt ="<?=$asset['altText']?>" src="<?=$imgSource.$asset['path']?>">
                    <?php
                  }
                  echo "</div>";

                }
                  ?>
                  
                  <?php
                  $markSchemeAssets = explode(",",$question2['markSchemeAssets']);
                  //print_r($questionAssets);

                  //Define what types of assets will be shown:
                  $showMarkScheme = $showGuide = $showModel = null;
                  if($question2['markSchemeAssets']!="") {
                    $showMarkScheme = 1;
                  }
                  if($question2['guide']!="") {
                    $showGuide = 1;
                  }
                  if($question2['modelAnswer']!="") {
                    $showModel = 1;
                  }
                  ?>

                  <div id="second_part_<?=$question['id']?>" class="px-2 pb-2 mt-2">
                    <div class="flex justify-between mb-2 text-xs md:text-base">
                      <?php
                      if($showMarkScheme) {
                        ?>
                        <button class="border rounded bg-pink-200 border-black mb-1 px-1 md:ml-9" type="button" onclick="toggleHide(this, 'markSchemeToggle_<?=$question2['id']?>', 'Show Mark Scheme', 'Hide Mark Scheme', 'block')">Show Mark Scheme</button>
                        <?php
                      }
                      if($showGuide) {
                        ?>
                        <button class="border rounded bg-sky-200 border-black mb-1 px-1 " type="button" onclick="toggleHide(this, 'guideToggle_<?=$question2['id']?>', 'Show Guide', 'Hide Guide', 'block')">Show Guide</button>
                        <?php
                      }
                      if($showModel) {
                        ?>
                        <button class="border rounded bg-sky-300 border-black mb-1 px-1 " type="button" onclick="toggleHide(this, 'modelAnswerToggle_<?=$question2['id']?>', 'Show Model Answer', 'Hide Model Answer', 'block')">Show Model Answer</button>
                        <?php
                      }
                      ?>
                    </div>
                      <?php
                      if($userId) {
                        ?>
                        <div class="flex justify-between mb-2 text-xs md:text-base">
                          <?php
                          if($showMarkScheme) {
                            ?>                       
                            <a class="md:ml-9 underline hover:bg-pink-200 text-sky-700" target ="blank" href="markscheme.php?ids=<?=$question2['id']?>">Mark Scheme Link</a>
                            <?php
                          }
                          if($showGuide) {
                            ?>
                            <a class=" underline hover:bg-pink-200 text-sky-700" target ="blank" href="guide.php?ids=<?=$question2['id']?>">Guide Link</a>
                            <?php
                          }
                          ?>
                        </div>
                        <?php
                      }

                    if($showMarkScheme) {
                    ?>
                      <div class="markSchemeToggle_<?=$question2['id']?> hidden">
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
                    if($showGuide) {
                      ?>
                      <div class="guideToggle_<?=$question2['id']?> hidden mb-2 border-2 border-sky-200 rounded px-1">
                        <h3 class="text-lg bg-sky-200 -mx-1 mb-2">Question Guidance</h3>
                        <?php
                        $guide = $question2['guide'];
                        $guide = explode("\n", $guide);
                        foreach($guide as $p) {
                          ?>
                          <p class="mb-1"><?=$p?></p>
                          <?php
                        }
                        ?>
                      </div>
                      <?php
                    }

                    if($showModel) {
                      ?>
                      <div class="modelAnswerToggle_<?=$question2['id']?> hidden mb-2 border-2 border-sky-300 rounded px-1">
                        <h3 class="text-lg bg-sky-300 -mx-1">Model Answer</h3>
                        <?php
                        $modelAnswer = $question2['modelAnswer'];
                        $modelAnswer = explode("\n", $modelAnswer);
                        foreach($modelAnswer as $p) {
                          ?>
                          <p class="mb-1"><?=$p?></p>
                          <?php
                        }
                        if($question2['modelAnswerAssets'] != "") {
                          $modelAnswerAssets = explode(",",$question2['modelAnswerAssets']);
                          foreach($modelAnswerAssets as $asset) {
                            $asset = getUploadsInfo($asset)[0];
                              //print_r($asset);
                              ?>
                              <img alt ="<?=$asset['altText']?>" src="<?=$imgSource.$asset['path']?>">
                              <?php
                            }
                        }


                        ?>
                      </div>
                      <?php
                    }
                    ?>
                  </div>
                  <?php
                  //}
                  if($question2['userCreate'] == $userId) {
                    ?>
                    <div>
                      <a class="underline text-sky-700 hover:bg-pink-300" target="_blank" href="pastpapers_questions.php?id=<?=$question2['id']?>&topic=&questionNo=&examBoard=&year=&component=">Edit Details</a>
                    </div>
                    <?php
                  }

                }


                ?>
                <div class="px-2 py-2 bg-pink-200 grid lg:grid-cols-2">       
                  <?php
                  if($question['examPaperLink'] != "") {
                    ?>
                    <div class = "text-center">
                      <a class ="hover:bg-sky-200 hover:text-pink-500 w-full block underline rounded" href="<?=$question['examPaperLink']?>" target="_blank">Link to Exam Paper</a>
                    </div>
                    <?php
                  }
                  if($question['markSchemeLink'] != "") {
                    ?>
                    <div class="text-center">
                      <a class ="hover:bg-sky-200 hover:text-pink-500 w-full block underline rounded" href="<?=$question['markSchemeLink']?>" target="_blank">Link to Mark Scheme</a>
                    </div>
                    <?php
                  }
                  ?>
                </div>
              </div>
              <?php
            }
          }
          
          //var_dump($usedExamInstance);
        ?>
      </div>
    </div>
</div>

<script>
</script>
<?php   include($path."/footer_tailwind.php");?>
