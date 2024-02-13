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

  textarea {
    padding: 0.25rem;
  }

  
  ";


include($path."/header_tailwind.php");

//Exam board code key. A legacy item from when these were coded in excel.

$examBoardCodeKey = array(
  ["Original", 10],
  ["Eduqas", array(
    ["AL", 11],
    ["AS", 21]
  )],
  ["AQA", array(
    ["AL", 12],
    ["AS", 14]
  )],
  ["WJEC", 13],
  ["OCR", array(
    ["AL", 15],
    ["AS", 16]
  )],
  ["Edexcel", array(
    ["AL", 17],
    ["AS", 18]
  )],
  ["CIE", 19]
);

$updateBool = 0;
$updateQuestionBool = 0;

if($_SERVER['REQUEST_METHOD']==='POST') {

  if(isset($_POST['submit'])&&($_POST['submit']=="submit")) {
    $updateBool = 1;
    $questionsCollect = array();
    $inputCount = $_POST['inputCount'];

    for($x=0; $x<$inputCount; $x++) {
      
      

      $specPaper = "";
      if(isset($_POST['specPaper'])) {
        $specPaper = $_POST['specPaper'];
        //Putting this in here just as a default for specification year publication:
        $_POST['year'] = "Specimen Assessment Materials";
      }
      
      $newQuestion = array(
        'questionNo' => $_POST['questionNo_'.$x],
        'examBoard' => $_POST['examBoard'],
        'level' => $_POST['level'],
        'unitNo'=> $_POST['unitNo'],
        'unitName' => $_POST['unitName'],
        'year' => $_POST['year'],
        'questionText' => $_POST['questionText_'.$x],
        'answerText' => $_POST['answerText_'.$x],
        //'options' => $optionsArray,
        'assetId' => $_POST['assetId_'.$x],
        'markScheme_assetId' => $_POST['markScheme_assetId_'.$x],
        'examReport_assetId' => $_POST['examReport_assetId_'.$x],
        //'answer' => $_POST['answer_'.$x], 
        'topic' => $_POST['topic_'.$x], 
        //'topics' => $_POST['topics_'.$x], 
        'keyWords' => $_POST['keyWords_'.$x],
        'active_entry' => $_POST['active_entry_'.$x],
        'specPaper' => $specPaper,
        'marks' => $_POST['marks_'.$x],
        'caseStudyBool' => (isset($_POST['caseStudy_'.$x]) && $_POST['caseStudy_'.$x] == 1 ) ? 1 : null,
        'caseStudyId' => $_POST['caseStudyId_'.$x],
        'dataBool' => (isset($_POST['dataBool_'.$x]) && $_POST['dataBool_'.$x] == 1 ) ? 1 : null,
        'examPaperLink' => $_POST['examPaperLink_'.$x],
        'markSchemeLink' => $_POST['markSchemeLink_'.$x],
        'examReportLink' => $_POST['examReportLink_'.$x]
      );
      array_push($questionsCollect, $newQuestion);
    }

    foreach($questionsCollect as $question) {
      //Filter for those entires that are active entries (i.e. not from hidden rows)

      if($question['active_entry'] == "1") {
        //print_r($question);
        $questionCode = "Q";
        
        //Complete exam board question code:
        foreach($examBoardCodeKey as $examBoard) {
          if($examBoard[0] == $question['examBoard']) {
            if(is_array($examBoard[1])) {
              foreach($examBoard[1] as $level) {
                if($level[0] == $question['level']) {
                  $questionCode .= $level[1];
                }
              }
            }
            else {
              $questionCode .= $examBoard[1];
            }           
          }
        }
        
        //Add Unit Number:
        $questionCode .= "0".$question['unitNo'].".";

        //Add year
        $year = $question['year'];
        $year = trim($year);
        if(strlen($year)>2) {
          $year = substr($year, -2);
        }
        $questionCode .= $year;



        //Add month of june (change later if necessary to enter january exams):
        $questionCode .= "06";

        //Substitute for '0000' code if spec paper:
        if($question['specPaper'] == 1) {
          $questionCode = substr($questionCode, 0, -4);
          $questionCode .= "0000";
        }

        //Add question number
        $questionNo = $question['questionNo'];
        /*
        if($questionNo<10) {
          $questionNo = "0".$questionNo;
        }
        */
        $questionCode .=".".$questionNo;

        if(isset($_GET['test'])) {
          var_dump($question);
        }
        else {

        insertPastPaperQuestion($userId, $questionCode, $question['questionNo'], $question['examBoard'], $question['level'], $question['unitNo'], $question['unitName'], $question['year'], $question['questionText'], $question['answerText'], $question['assetId'], $question['markScheme_assetId'], $question['examReport_assetId'], $question['topic'], $question['keyWords'], $question['marks'], $question['caseStudyId'], $question['caseStudyBool'], $question['dataBool'], $question['examPaperLink'], $question['markSchemeLink'], $question['examReportLink']);

        }

        
        
      }
    }

    

  }

  
  if(isset($_POST['submit'])) {
    if($_POST['submit'] == 'Update') {

      $updateQuestionBool = 1;
      $caseBool = (isset($_POST['caseBool']) && $_POST['caseBool'] == 1) ? 1 : null;
      $caseId = ($_POST['caseId'] != "") ? $_POST['caseId'] : null;
      
      
      updatePastPaperQuestionDetails($_POST['id'], $_POST['question'], $_POST['answer'], $_POST['questionAssets'], $_POST['markSchemeAssets'], $_POST['examreportAssets'], $_POST['topic'], $_POST['keywords'], $_POST['explanation'], $_POST['marks'], $caseId, $caseBool, $_POST['examPaperLink'], $_POST['markSchemeLink'], $_POST['examReportLink'], $_POST['guide'], $_POST['modelAnswer'], $_POST['modelAnswerAssets']);
      ?>
      <?php
    }
  }
}

$questions = array();
if(isset($_GET['topic'])) {
  $get_selectors = array(
    'id' => ($_GET['id']!="") ? $_GET['id'] : null,
    'topic' => ($_GET['topic']!="") ? $_GET['topic'] : null,
    'questionNo' => ($_GET['questionNo']!="") ? $_GET['questionNo'] : null,
    'examBoard' => ($_GET['examBoard']!="") ? $_GET['examBoard'] : null,
    'year' => ($_GET['year']!="") ? $_GET['year'] : null,
    'component' => ($_GET['component']!="") ? $_GET['component'] : null,
    'qualLevel' => isset($_GET['qualLevel'])&&($_GET['qualLevel'] !="") ? $_GET['qualLevel'] : null,
    'caseStudiesFilter' => (isset($_GET['caseStudiesFilter'])&&$_GET['caseStudiesFilter'] !="") ? $_GET['caseStudiesFilter'] : null,
    'dataFilter' => (isset($_GET['dataFilter'])&&$_GET['dataFilter'] !="") ? $_GET['dataFilter'] : null


  );

  //var_dump($get_selectors);
  //var_dump($_GET);

  $questions = getPastPaperQuestionDetails($get_selectors['id'], $get_selectors['topic'], $get_selectors['questionNo'], $get_selectors['examBoard'], $get_selectors['year'], $get_selectors['component'], $get_selectors['qualLevel'], $get_selectors['caseStudiesFilter'], $get_selectors['dataFilter']);
}




?>

<!-- 

$_GET controls:
-test => isset = shows print_r for $_POST variables

-->

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">Past Paper Questions</h1>
    <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">
      <?php
      if($_SERVER['REQUEST_METHOD']==='POST') {
        if(isset($_GET['test'])) {        
          print_r($_POST);
        }
        //print_r($questionsCollect);
        //echo "<br>"; print_r($optionsArray);
      


      }
      echo "<pre>";
      //print_r($questions);
      //print_r($examBoardCodeKey);
      echo "</pre>";
      

      ?>

      <div>
        <h2>Create New Questions</h2>
        <form method="post" action = "">
          <table id="inputControl" class="w-full table-fixed mb-2 border border-black">
            <thead>
              <tr>
                <th><label for="examBoard">Exam Board</label></th>
                <th><label for="level">Level</label></th>
                <th><label for="unitNo">Unit Number</label></th>
                <th><label for="unitName">Unit Name</label></th>
                <th><label for="year">Year</label></th>
              </tr>
              <tr>
                <td>
                  <select class="w-full h-16" name="examBoard" id="examBoard" onchange="changeDropdowns();"></select>
                </td>
                <td>
                  <select class="w-full h-16" name="level" id="level"></select>
                </td>
                <td>
                  <input type='number' min ='1' max = '6' name='unitNo' id= 'unitNo' class='w-full h-16 rounded' value= '<?=$updateBool ==1 ? $_POST['unitNo'] : ""?>'>
                </td>
                <td>
                  <input name='unitName' id= 'unitName' class='w-full rounded h-16 border border-black' value= '<?=$updateBool ==1 ? $_POST['unitName'] : ""?>'>
                </td>
                <td>
                  <input type = 'number' min = '2000' max = '2050' name='year' id= 'year' class='w-full rounded' value= '<?=$updateBool ==1 ? $_POST['year'] : date('Y')?>'>
                  <p>
                    <input type='checkbox' id = 'specPaper' name = 'specPaper' value = '1' onchange="yearDisable();"><label for = 'specPaper'> Spec Paper</label>
                  </p>
                </td>
              </tr>
            </thead>
          </table>
          <table id="inputTable" class="w-full table-fixed mb-2 border border-black">
            <thead>
              <tr>
                <th>Question</th>
                <th class="w-1/2">Text</th>
                <th>Details</th>
                <th>Remove</th>

              </tr>
            </thead>

          </table>
          <input type = "hidden" id="inputCount" name="inputCount">
          <button class="w-full rounded bg-sky-300 hover:bg-sky-200 border border-black mb-2" type="button" onclick="addInputRow();">Add row</button> 
          <button name="submit" class= "w-full bg-pink-300 rounded border border-black mb-1" value ="submit">Submit</button>
      </form>
      </div>

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

      <?php
      //print_r(getPastPaperQuestionDetails(1));
      ?>
      
      <div>
        <?php
        if(count($questions)>0) {
          ?>
          <table>
            <tr>
              <th>id</th>
              <th>No</th>
              <th>Question</th>


            </tr>
            <?php
              foreach($questions as $question) {
                ?>
                <form method="post"  action="">
                  <input type="hidden" name="id" value="<?=$question['id']?>">
                  <tr id="<?=$question['id']?>">
                    <td ><?=$question['id']?></td>
                    <td>
                      <?=$question['No']?>
                    </td>
                    <td>
                      <p><?=$question['examBoard']?> <?=$question['unitName']?> <?=$question['qualLevel']?> <?=$question['series']?> <?=$question['year']?> Question <?=$question['questionNo']?> </p>
                      <div>
                        <p class="whitespace-pre-line toggleClass_<?=$question['id']?>"><?=$question['question']?></p>
                        <textarea  name="question" class="resize w-full toggleClass_<?=$question['id']?> hidden" spellcheck="true"><?=$question['question']?></textarea>
                      </div>
                      <div>
                        <h3>Answer:</h3>
                        <p class="toggleClass_<?=$question['id']?>"><?=$question['answer']?></p>
                        <input type="text" name = "answer" class="toggleClass_<?=$question['id']?> hidden" value = "<?=$question['answer']?>">
                      </div>
                      <div>
                        <h3>Marks:</h3>
                        <p class="toggleClass_<?=$question['id']?>"><?=$question['marks']?></p>
                        <input type="text" name = "marks" class="toggleClass_<?=$question['id']?> hidden" value = "<?=$question['marks']?>">
                      </div>
                      <div>
                        <h3>Assets:</h3>
                        <div class="toggleClass_<?=$question['id']?>">
                          <p><?=$question['questionAssets']?></p>
                          <?php
                          $imgSource = "https://www.thinkeconomics.co.uk";


                          //Case Study:
                          if($question['caseId']) {
                            $caseStudy = getPastPaperQuestionDetails($question['caseId'])[0];

                            $questionAssets = explode(",",$caseStudy['questionAssets']);
                            
                            // Following script commented out only so that all case study images do not come up in manager page. Un-comment to see case study for each question.
                            /*
                            foreach($questionAssets as $asset) {
                              $asset = getUploadsInfo($asset)[0];
                              //print_r($asset);
                              
                              ?>
                              <img alt ="<?=$asset['altText']?>" src="<?=$imgSource.$asset['path']?>">
                              <?php
                            }
                            */
                            
                          }

                          //Questions:

                          $questionAssets = explode(",",$question['questionAssets']);
                          //print_r($questionAssets);

                          foreach($questionAssets as $asset) {
                            $asset = getUploadsInfo($asset)[0];
                            //print_r($asset);
                            
                            ?>
                            <img alt ="<?=$asset['altText']?>" src="<?=$imgSource.$asset['path']?>">
                            <?php
                          }

                          $markSchemeAssets = explode(",",$question['markSchemeAssets']);
                          //print_r($questionAssets);

                          if($question['markSchemeAssets']!="") {
                            

                          ?>
                          <button class="border rounded bg-pink-300 border-black mb-1 p-1" type="button" onclick="toggleHide(this, 'markSchemeToggle_<?=$question['id']?>', 'Show Mark Scheme', 'Hide Mark Scheme', 'block')">Show Mark Scheme</button>
                          <div class="markSchemeToggle_<?=$question['id']?> hidden">
                          <?php

                            

                       


                            foreach($markSchemeAssets as $asset) {
                              $asset = getUploadsInfo($asset)[0];
                              //print_r($asset);
                              $imgSource = "https://www.thinkeconomics.co.uk";
                              ?>
                              <img alt ="<?=$asset['altText']?>" src="<?=$imgSource.$asset['path']?>">
                              <?php
                            }
                          ?>
                          </div>
                          <?php
                          }

                          if($question['modelAnswer'] != "" || $question['guide'] != "") {
                            ?>
                            <button class="border rounded bg-sky-300 border-black mb-1 p-1" type="button" onclick="toggleHide(this, 'modelAnswerToggle_<?=$question['id']?>', 'Show Guidance and Model', 'Hide Guidance and Model', 'block')">Show Guidance and Model</button>
                            <div class="modelAnswerToggle_<?=$question['id']?> hidden">
                              <?php
                              if($question['guide'] != "") {
                                ?>
                                <p class="whitespace-pre-line"><?=$question['guide']?></p>
                                <?php
                              }
                              ?>
                              <?php
                              if($question['modelAnswer'] != "") {
                                ?>
                                <p class="whitespace-pre-line"><?=$question['modelAnswer']?></p>
                                <?php
                              }
                              if($question['modelAnswerAssets'] != "") {
                                $modelAnswerAssets = explode(",",$question['modelAnswerAssets']);
                                //print_r($modelAnswerAssets);
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

                        <div class="toggleClass_<?=$question['id']?> hidden">
                          <label for="question_assets_<?=$question['id']?>">Question Assets:</label>
                            <p><input  id= "question_assets_<?=$question['id']?>" type="text" name = "questionAssets"  value = "<?=$question['questionAssets']?>"></p>

                            <label for="markScheme_assets_<?=$question['id']?>">Mark Scheme Assets:</label>
                            <p><input  id= "markScheme_assets_<?=$question['id']?>" type="text" name = "markSchemeAssets"  value = "<?=$question['markSchemeAssets']?>"></p>

                            <label for="examReport_assets_<?=$question['id']?>">Exam Report Assets:</label>
                            <p><input  id= "examReport_assets_<?=$question['id']?>" type="text" name = "examreportAssets"  value = "<?=$question['examReportAssets']?>"></p>
                        </div>


                      </div>

                      <?php
                      /*
                        $imgSource = "";
                        if($question['path']!="") {
                          //$imgSource = $path.$question['path'];
                          $imgSource = "https://www.thinkeconomics.co.uk".$question['path'];
                        }
                        else {
                          $imgSource = "question_img/".$question['No'].".JPG";
                        }
                        */
                      ?>
                      <!--
                      <p><img class = "w-3/4" src = "<?=$imgSource?>"></p>
                      -->
                      <div>
                        <h3>Topics:</h3>
                        <div class="toggleClass_<?=$question['id']?>">
                          <p><?=$question['topic']?></p>
                        </div>
                        <div class="toggleClass_<?=$question['id']?> hidden">
                          <label>Topic:</label>
                            <p><input type="text" name = "topic"  value = "<?=$question['topic']?>"></p>
                          


                        </div>
                      </div>
                      <div>
                        <h3 class="<?=($question['keywords']=="") ? "toggleClass_".$question['id']." hidden" : ""?>">Key Words:</h3>
                        <p class="toggleClass_<?=$question['id']?>"><?=$question['keywords']?></p>
                        <input type="text" name = "keywords" class="toggleClass_<?=$question['id']?> hidden" value = "<?=$question['keywords']?>">
                      </div>

                      <div>
                          <?php
                            $explanations = json_decode($question['explanation']);
                            $userExplanation = "";
                            //var_dump($explanations);
                            $explanations = (array) $explanations;
                            //var_dump($explanations);
                            if(count($explanations)>0) {
                              ?>
                              <h3>Explanation<?=(count($explanations)>1) ? "s" : ""?>: </h3>
                              <?php
                            }
                            if(isset($explanations[$userId])) {
                              $userExplanation = $explanations[$userId];
                            }
                            //print_r($explanations);
                            foreach ($explanations as $key => $explanation) {
                              ?>
                              <div class="toggleClass_<?=$question['id']?> ml-3 border border-pink-300">
                                <p class="whitespace-pre-line"><?=getUserInfo($key)['username']?>:</p>
                                <p class="whitespace-pre-line"><?=$explanation?><p>
                              </div>
                              <?php

                            }
                          ?>
                          <div class="toggleClass_<?=$question['id']?> hidden">
                            <h3>Explanation:</h3>
                            <p><textarea name="explanation" class="resize w-full " spellcheck="true"><?=$question['explanation']?></textarea></p>
                          </div>
                        </div>
                        <div class="toggleClass_<?=$question['id']?> hidden">
                            <label for="guide_<?=$question['id']?>">Guidance:</label>
                            <p>
                              <textarea class="resize w-full" spellcheck="true" name = "guide" id="guide_<?=$question['id']?>"><?=$question['guide']?></textarea>
                            </p>
                            <label for="modelAnswer<?=$question['id']?>">Model Answer:</label>
                            <p>
                              <textarea class="resize w-full" spellcheck="true" name = "modelAnswer" id="modelAnswer<?=$question['id']?>"><?=$question['modelAnswer']?></textarea>
                            </p>

                            <label for="modelAnswerAssets_<?=$question['id']?>">Model Answer Assets: </label>
                            <p><input id="modelAnswerAssets_<?=$question['id']?>" type="text" name= "modelAnswerAssets" value="<?=$question['modelAnswerAssets']?>"><p>

                            <label for="caseId_<?=$question['id']?>">Case Id: </label>
                            <p><input id="caseId_<?=$question['id']?>" type="number" name= "caseId" value="<?=$question['caseId']?>"><p>
                            <label for="caseBool_<?=$question['id']?>">Case Study</label>
                            <input id = "caseBool_<?=$question['id']?>" name = "caseBool" type="checkbox" value="1" <?=($question['caseBool'] == 1) ? "checked" : ""?>>

                        </div>
                        <?php
                        if($question['dataBool'] != "") {
                          ?>
                          <div class="toggleClass_<?=$question['id']?>">
                            <p>Exam Paper: <a target="_blank" href="<?=$question['examPaperLink']?>"><?=$question['examPaperLink']?></a></p>
                            <p>Mark Scheme: <a target="_blank" href="<?=$question['markSchemeLink']?>"><?=$question['markSchemeLink']?></a></p>
                            <p>Examiner Report: <a target="_blank" href="<?=$question['examReportLink']?>"><?=$question['examReportLink']?></a></p>
                          </div>
                          
                          <?php
                        }
                        
                        ?>
                        <div class="<?=($question['dataBool'] == "") ? "hidden" : ""?>">
                          <div class=" toggleClass_<?=$question['id']?> hidden">
                            <label for="examPaperLink_<?=$question['id']?>">Exam Paper Link: </label>
                            <p><input class="w-full" id="examPaperLink_<?=$question['id']?>" type="text" name= "examPaperLink" value="<?=$question['examPaperLink']?>"></p>

                            <label for="markSchemeLink<?=$question['id']?>">Mark Scheme Link: </label>
                            <p><input class="w-full" id="markSchemeLink<?=$question['id']?>" type="text" name= "markSchemeLink" value="<?=$question['markSchemeLink']?>"></p>

                            <label for="examReportLink<?=$question['id']?>">Exam Report Link: </label>
                            <p><input class="w-full" id="examReportLink<?=$question['id']?>" type="text" name= "examReportLink" value="<?=$question['examReportLink']?>"></p>
                          </div>
                        </div>


                        <p>
                          <?php 
                            if(isset($_GET['test'])) {
                              //var_dump($question);
                              print_r($question);
                            }
                          ?>
                        </p>
                      <p><button type="button" class="w-full bg-pink-300 rounded border border-black mb-1" onclick='toggleHide(this, "toggleClass_<?=$question['id']?>", "Edit", "Hide Edit", "block");'>Edit</button>
                      <input type="submit" class="w-full bg-sky-200 rounded border border-black mb-1 toggleClass_<?=$question['id']?> hidden" name="submit" value= "Update">
                      <p>
                    </td>
                  </tr>
                </form>
                <?php
              }
            ?>
          </table>
          <?php
        }
        ?>
      </div>



    </div>
</div>


<script>

const examBoardNumbers = {Eduqas:5, AQA:4, WJEC:5, Edexcel:4, OCR:4, CIE:4};
//const examBoardNumbers = [['Eduqas',5], ['AQA',4], ['WJEC',5], ['Edexcel',4], ['OCR',4]];

var examBoards = ['Eduqas', 'AQA', 'WJEC', 'Edexcel', 'OCR', 'CIE'];
var levels = ['AL', 'AS'];
var options = ['A', 'B', 'C', 'D', 'E'];

function addOptions(examBoard, num, targetObj) {
  
  var output = "";
  //console.log(examBoardNumbers);
  var optionsNumber = examBoardNumbers[examBoard];
  //console.log(output);
  for(var i=0; i<optionsNumber; i++) {
    output += "<label for = 'option_"+num+"_"+options[i]+"'>"+options[i]+": </label><textarea name='option_"+num+"_"+i+"' id= 'option_"+num+"_"+options[i]+"' class='resize w-3/5 p-0 h-6 rounded' value= '"+options[i]+"'>"+options[i]+"</textarea><br>"
  }
  output += "<input type='hidden' name = 'optionsNumber_"+num+"' value='"+optionsNumber+"'></input>";

  document.getElementById(targetObj).innerHTML = output;
  //console.log(document.getElementById(targetObj));
  
}

function addAnswerSelect(examBoard, num, targetObj) {
  var label = 'answer_'+num;
  var output = "";
  var optionsNumber = examBoardNumbers[examBoard];
  var options = ['', 'A', 'B', 'C', 'D', 'E'];
  output += "<label for = "+label+">Answer: </label>";
  var choices = "";
  for(var j=0; j<(optionsNumber+1); j++) {
    choices += "<option value = '"+options[j]+"'>"+options[j]+"</option>";
  }
  output += "<select name="+label+" id= "+label+" class='w-full rounded'>"+choices+"</select>";

  document.getElementById(targetObj).innerHTML = output;
}

function changeDropdowns() {
  var thisExamBoard = document.getElementById("examBoard").value;
  var optionsTarget = document.getElementsByClassName("optionsTarget");
  for(var i=0; i<optionsTarget.length; i++) {
    //console.log(optionsTarget[i]);
    addOptions(thisExamBoard, i, 'optionsTarget_'+i);
  }

  var dropdownTarget = document.getElementsByClassName("dropdownTarget");
  for(var i=0; i<dropdownTarget.length; i++) {
    //console.log(optionsTarget[i]);
    addAnswerSelect(thisExamBoard, i, 'dropdownTarget_'+i);
  }

}

//Populate examboard select:
var examBoardSelect = document.getElementById("examBoard");
for(var i=0; i<examBoards.length; i++) {
  var option = document.createElement("option");
  if(examBoards[i] == "<?=$updateBool ==1 ? $_POST['examBoard'] : ""?>") {
    option.selected = true;
  }
  option.text = examBoards[i];
  option.value = examBoards[i];
  examBoardSelect.add(option);
}

//Populate level select
var levelSelect = document.getElementById("level");
for(var i=0; i<levels.length; i++) {
  var option = document.createElement("option");
  if(levels[i] == "<?=$updateBool ==1 ? $_POST['level'] : ""?>") {
    option.selected = true;
  }
  option.text = levels[i];
  option.value = levels[i];
  levelSelect.add(option);
}

function yearDisable() {
  var yearInput = document.getElementById("year");
  var specInput = document.getElementById("specPaper")

  if(specInput.checked == true) {
    //yearInput.disabled = true;
    yearInput.value = 2015;
    yearInput.classList.add("text-slate-200");
  } else {
    //yearInput.disabled = false;
    yearInput.classList.remove("text-slate-200");
  }
}



function addInputRow() {
  var table = document.getElementById("inputTable");
  var rowNo = table.rows.length;
  var row = table.insertRow(rowNo);
  var num = (rowNo - 1);
  var examBoards = ['Eduqas', 'AQA', 'WJEC', 'Edexcel', 'OCR', 'CIE'];
  

  //Find the values of last inserted row:

  var lastQuestionNo = document.getElementById("questionNo_"+ (num-1));
  if (lastQuestionNo) {
    lastQuestionNo = lastQuestionNo.value;
  }
  //console.log(lastQuestionNo);

  var cells = [];
  for (var i=0; i<4; i++) {
    cells[i] = row.insertCell(i);
    cells[i].classList.add('align-top')
    
    switch(i) {
      case 0:
        var label = (rowNo-1);
        var value = num+1;
        if(lastQuestionNo) {
          value = parseInt(lastQuestionNo) + 1;
        }

        //Question Number:
        cells[i].innerHTML = "<p><label for = 'questionNo_"+num+"'>No.</label></p><p><input name='questionNo_"+num+"' id= 'questionNo_"+num+"' class='p-2 w-full rounded border border-black text-center' value= '"+value+"'><p>";

        break;
      case 1:
        var label = "questionText_"+(rowNo-1);
        var label2 = "answerText_"+(rowNo-1);
        
        //var value = "value = '"+(rowNo)+"'";
        cells[i].innerHTML = "<p>Question Text:</p>";
        cells[i].innerHTML += "<textarea required name="+label+" id= "+label+" "+"class='w-full rounded p-1 h-30'></textarea>";
        
        cells[i].innerHTML += "<p>Answer Text:</p>";
        cells[i].innerHTML += "<textarea name="+label2+" id= "+label2+" "+"class='w-full rounded p-1 h-30'></textarea>";

        


        break;


      case 2:

        //Marks:
        var label3 = "marks_"+(rowNo-1);
        cells[i].innerHTML += "<p>Marks:</p>";
        cells[i].innerHTML += "<input type ='number' name="+label3+" id= "+label3+" "+"class=' rounded w-full '></input>";


        //Topic:
        var label = 'topic_'+num;
        cells[i].innerHTML += "<label for = "+label+">Topic: </label><input name="+label+" id= "+label+" class='w-full rounded'>";


        //Key Words:
        var label = 'keyWords_'+num;
        cells[i].innerHTML += "<label for = "+label+">Key Words: </label><input name="+label+" id= "+label+" class='w-full rounded'>";

        //Quesiton Asset ID:
        var label = "assetId_"+num;
        //var value = "value = '"+(rowNo)+"'";
        cells[i].innerHTML += "<label for = "+label+">Question Asset  Id: </label><input name="+label+" id= "+label+" class='w-full rounded'>";

        //Answer Asset ID:
        var label = "markScheme_assetId_"+num;
        //var value = "value = '"+(rowNo)+"'";
        cells[i].innerHTML += "<label for = "+label+">Mark Scheme Asset  Id: </label><input name="+label+" id= "+label+" class='w-full rounded'>";

        //Exam Report Asset ID:
        var label = "examReport_assetId_"+num;
        //var value = "value = '"+(rowNo)+"'";
        cells[i].innerHTML += "<label for = "+label+">Exam Report Asset  Id: </label><input name="+label+" id= "+label+" class='w-full rounded'>";

        //Case Study 
        var label = "caseStudyId_"+num;
        cells[i].innerHTML += "<label for = "+label+">Case Study Id: </label><input type = 'number' name="+label+" id= "+label+" class=' rounded w-full'>";

        //Case Study Bool
        var label = "caseStudy_"+num;
        cells[i].innerHTML += "<label for = "+label+">Case Study: </label><input type = 'checkbox' value = '1' name="+label+" id= "+label+" class=' rounded'>";

        //Data Bool:
        var label = "dataBool_"+num;
        cells[i].innerHTML += "<br><label for = "+label+">Data (MetaData) Entry: </label><input type = 'checkbox' value = '1' name="+label+" id= "+label+" class=' rounded'>";

        //Data elements
        cells[i].innerHTML += "<br>";
        var label = "examPaperLink_"+num;
        cells[i].innerHTML += "<label for = "+label+">Exam Link: </label><input type = 'text' name="+label+" id= "+label+" class=' rounded w-full'>";

        var label = "markSchemeLink_"+num;
        cells[i].innerHTML += "<label for = "+label+">Mark Scheme Link: </label><input type = 'text' name="+label+" id= "+label+" class=' rounded w-full'>";

        var label = "examReportLink_"+num;
        cells[i].innerHTML += "<label for = "+label+">Exam Report Link: </label><input type = 'text' name="+label+" id= "+label+" class=' rounded w-full'>";


        break;
      case 3:
        cells[i].innerHTML = "<button class='w-full bg-pink-300 rounded border border-black mb-1' type ='button' onclick='hideRow(this);'>Remove</button>"
        cells[i].innerHTML += "<input name='active_entry_"+num+"' class='w-full' type='hidden' value='1'>";
        cells[i].classList.add('align-middle')
        break;
    }
  }

  //Update option values:
  var thisExamBoard = document.getElementById("examBoard").value;
  //console.log(thisExamBoard);



  //Update input number
  var inputCount = document.getElementById("inputCount").value ++;
}

addInputRow();

function hideRow(button) {
  var row = button.parentElement.parentElement;
  var input = button.parentElement.childNodes[1];
  console.log(row);
  console.log(input);
  var textarea = row.childNodes[1].childNodes[1];
  textarea.required = false;
  console.log(textarea);
  row.style.display = "none";
  input.value='0';
}

<?php
if($updateQuestionBool == 1) {
    ?>
      //console.log(document.getElementById('<?=$_POST['id']?>'));
      document.getElementById('<?=$_POST['id']?>').scrollIntoView();
    <?php
  
}
?>





</script>

<?php   include($path."/footer_tailwind.php");?>
