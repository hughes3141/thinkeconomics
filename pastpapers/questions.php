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

$get_selectors = array(
  'id' => (isset($_GET['id']) && $_GET['id']!="") ? $_GET['id'] : null,
  'topic' => (isset($_GET['topic']) && $_GET['topic']!="") ? $_GET['topic'] : null,
  'questionNo' => (isset($_GET['questionNo']) && $_GET['questionNo']!="") ? $_GET['questionNo'] : null,
  'examBoard' => (isset($_GET['examBoard']) && $_GET['examBoard']!="") ? $_GET['examBoard'] : null,
  'year' => (isset($_GET['year']) && $_GET['year']!="") ? $_GET['year'] : null,
  'component' => (isset($_GET['component']) && $_GET['component']!="") ? $_GET['component'] : null,
  'qualLevel' => (isset($_GET['qualLevel']) && $_GET['qualLevel']!="") ? $_GET['qualLevel'] : null

);

$controls = getPastPaperCategoryValues($get_selectors['topic'], $get_selectors['examBoard'], $get_selectors['year'], $get_selectors['component'], $get_selectors['qualLevel']);



  

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
    $questions = getPastPaperQuestionDetails($get_selectors['id'], $get_selectors['topic'], $get_selectors['questionNo'], $get_selectors['examBoard'], $get_selectors['year'], $get_selectors['component'], $get_selectors['qualLevel'], 1, 1);


  }

  $usedCaseStudies = array();
  


?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
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
                    <option value="<?=$topicCode?>" <?=($get_selectors[$controlName] == $topicList[0]) ? "selected" : ""?>><?=$topicName?></option>
                    <?php
                  }

                }
              ?>
            </select>
          </div>

          <input type="hidden"  value="Select">
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
              
              $examInstance = $question['examBoard']." ".$question['qualLevel']." "."Unit ".$question['component']." ".$question['series']." ".$question['year'];

              if(!in_array($examInstance, $usedExamInstance)) {
                ?>
                <h2 class="text-xl bg-sky-200 mb-2 p-1 rounded"><?=$examInstance?></h2>
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
                      <h3 class="text-lg"><?=$question2['examBoard']?> <?=$question2['qualLevel']?> Unit <?=$question2['component']?> <?=$question2['series']?> <?=$question2['year']?> Q<?=$question2['questionNo']?></h3>
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
                      <h3 class="text-lg">
                        <?php
                        //echo $question2['examBoard']." ";
                        //echo $question2['qualLevel']." ";
                        //echo "Unit ".$question2['component']." ";
                        //echo $question2['series']." ";
                        //echo $question2['year']." ";
                        echo "Q".$question2['questionNo'];
                        ?></h3>
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
                  $questionNo = $question2['questionNo'];
                  $questionNoLength = strlen($questionNo);
                  $indentOffset = "";
                  if($questionNoLength == 1) {
                    $indentOffset = "&nbsp&nbsp";
                  } 
                  if($questionNoLength == 2) {
                    $indentOffset = "&nbsp";
                  }
                  $questionArray=explode("\n",$question2['question']);
                  ?>
                  <div class=" -mx-0  p-2 pl-11 ">
                  <?php
                  //print_r($questionArray);
                  foreach($questionArray as $key => $newLine) {
                    if($key == 0) {
                      ?>
                      <p class="-indent-9 mb-2"><span class='font-medium font-mono'><?=$question2['questionNo']?>.<?=$indentOffset?></span><?=$newLine?></p>
                      <?php //echo $questionNoLength; ?>
                      <?php
                    }
                    else {
                      ?>
                      <p class=" mb-2"><?=$newLine?></p>
                      <?php
                    }
                  }
                  if(!$caseId || $key2 !=0) {
                    ?>
                      <p>[<?=$question2['marks']?> marks]<p>
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
                <div id="second_part_<?=$question['id']?>" class="px-2 pb-2">
                <?php
                  $markSchemeAssets = explode(",",$question2['markSchemeAssets']);
                  //print_r($questionAssets);

                  if($question2['markSchemeAssets']!="") {
                    ?>
                  <button class="border rounded bg-pink-200 border-black mb-1 px-1 ml-9" type="button" onclick="toggleHide(this, 'markSchemeToggle_<?=$question2['id']?>', 'Show Mark Scheme', 'Hide Mark Scheme', 'block')">Show Mark Scheme</button>

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
                  ?>


                </div>
                <?php
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

            /*

            //print_r($question);

            //Case Study:
            if($question['caseId']) {
              $caseId = $question['caseId'];
              if(!in_array($caseId, $usedCaseStudies))
              {
                array_push($usedCaseStudies, $caseId);
                $caseStudy = getPastPaperQuestionDetails($question['caseId'])[0];
                $questionAssets = explode(",",$caseStudy['questionAssets']);
                $questionElements = $caseStudy;

                ?>
                <div class="mb-3 border-2 rounded border-pink-300">
                  <!--id: <?=$questionElements['id']?> topic <?=$questionElements['topic']?> Code: <?=$question['No']?>  -->
                  <div class="bg-pink-200 px-1 ">
                    <h3 class="text-lg"><?=$questionElements['examBoard']?> <?=$questionElements['qualLevel']?> Unit <?=$questionElements['component']?> <?=$questionElements['series']?> <?=$questionElements['year']?> Q<?=$questionElements['questionNo']?></h3>
                  </div>
                  <?php
                    if(count($questionAssets) == 1 && $questionAssets[0]=="") {
                      $questionNo = $questionElements['questionNo'];
                      $questionNoLength = strlen($questionNo);
                      $indentOffset = "";
                      if($questionNoLength == 1) {
                        $indentOffset = "&nbsp&nbsp";
                      } 
                      if($questionNoLength == 2) {
                        $indentOffset = "&nbsp";
                      }
    
                      $questionArray=explode("\n",$questionElements['question']);
                      ?>
                      <div class="border-t-2 border-slate-500 -mx-0  p-2 pl-11 ">
                        <?php
                        //print_r($questionArray);
                        foreach($questionArray as $key => $newLine) {
                          if($key == 0) {
                            ?>
                            <p class="-indent-9 mb-2"><span class='font-medium font-mono'><?=$questionElements['questionNo']?>.<?=$indentOffset?></span><?=$newLine?></p>
                            <?php
                          }
                          else {
                            ?>
                            <p class=" mb-2"><?=$newLine?></p>
                            <?php
                          }
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
                </div>
                <?php 
              }              
            }
            
            //Question:
            ?>
            <div class="mb-3 border-2 rounded border-pink-300">
              <!--id: <?=$question['id']?> topic <?=$question['topic']?> Code: <?=$question['No']?>  -->
              <div class="bg-pink-200 px-1 ">
                <h3 class="text-lg"><?=$question['examBoard']?> <?=$question['qualLevel']?> Unit <?=$question['component']?> <?=$question['series']?> <?=$question['year']?> Q<?=$question['questionNo']?></h3>
                <?php
                if($question['topicName'] != "") {
                  echo "<p>Topic: ".$question['topicName']."</p>";
                }
                ?>
              </div>
              <?php
                //Questions:
                $questionAssets = explode(",",$question['questionAssets']);
                //var_dump($questionAssets);
                if(count($questionAssets) == 1 && $questionAssets[0]=="") {
                  $questionNo = $question['questionNo'];
                  $questionNoLength = strlen($questionNo);
                  $indentOffset = "";
                  if($questionNoLength == 1) {
                    $indentOffset = "&nbsp&nbsp";
                  } 
                  if($questionNoLength == 2) {
                    $indentOffset = "&nbsp";
                  }

                  $questionArray=explode("\n",$question['question']);
                  

                  ?>
                  <div class="border-t-2 border-slate-500 -mx-0  p-2 pl-11 ">
                  <?php
                  //print_r($questionArray);
                  foreach($questionArray as $key => $newLine) {
                    if($key == 0) {
                      ?>
                      <p class="-indent-9 mb-2"><span class='font-medium font-mono'><?=$question['questionNo']?>.<?=$indentOffset?></span><?=$newLine?></p>
                      <?php //echo $questionNoLength; ?>
                      <?php
                    }
                    else {
                      ?>
                      <p class=" mb-2"><?=$newLine?></p>
                      <?php
                    }
                  }
                  ?>
                    <p>[<?=$question['marks']?> marks]<p>
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
                <div id="second_part_<?=$question['id']?>" class="px-2 pb-2">
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
                <p>
                <?php
                }
                if($question['examPaperLink'] != "") {
                  ?>
                  <a class ="hover:bg-pink-200" href="<?=$question['examPaperLink']?>" target="_blank">Link to Exam Paper</a><span>  </span>
                  <?php
                }
                if($question['markSchemeLink'] != "") {
                  ?>
                  <a class ="hover:bg-sky-200" href="<?=$question['markSchemeLink']?>" target="_blank">Link to Mark Scheme</a>
                  <?php
                }
                ?>
                </p>
              </div>
            </div>
            <?php
            */
          }
          
        ?>
      </div>
    </div>
</div>

<script>
</script>
<?php   include($path."/footer_tailwind.php");?>
