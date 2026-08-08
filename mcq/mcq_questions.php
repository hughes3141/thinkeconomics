<?php



$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");

$userInfo = getUserInfo($_SESSION['userid']);
$userId = $_SESSION['userid'];
$permissions = $userInfo['permissions'];
if (!(str_contains($permissions, 'teacher'))) {
  header("location: /index.php");
}
$style_input = "
  th, td {
    border: 1px solid black;
  }

  textarea, input {
    padding-left: 0.25rem;
  }


  ";


include($path."/header_tailwind.php");

$updateQuestionBool = 0;

if($_SERVER['REQUEST_METHOD']==='POST') {

  if(isset($_POST['submit'])) {
    if($_POST['submit'] == 'Update') {

      $updateQuestionBool = 1;
      //Create array for options:
      $options = ['A', 'B', 'C', 'D', 'E'];
      $optionsArray = array();
      $optionsAssetsArray = array();
      for($x=0; $x<$_POST['optionCount']; $x++) {
        $optionsArray[$options[$x]] = trim($_POST['option_'.$x]);
        $optionsAssetsArray[$options[$x]] = trim($_POST['optionAssets_'.$x]);
      }
      $optionsArray = json_encode($optionsArray);
      $optionsAssetsArray = json_encode($optionsAssetsArray);

      updateMCQquestion($_POST['id'], $userId, $_POST['explanation'], $_POST['question'], $optionsArray, $_POST['topic'], $_POST['topics'], $_POST['answer'], $_POST['keywords'], $_POST['textOnly'], $_POST['relevant'], $_POST['similar'], $_POST['noRandom'], $_POST['question2'], $_POST['midImgAssetId'], $_POST['midTableInputArray'], $_POST['optionsTable'], $_POST['optionsTableHeading'], $_POST['midTableHeader'], $optionsAssetsArray);
      ?>
      <?php
    }
  }
}

$get_selectors = array(
  'id' => (isset($_GET['id'])&&$_GET['id']!="") ? $_GET['id'] : null,
  'topic' => (isset($_GET['topic'])&&$_GET['topic']!="") ? $_GET['topic'] : null,
  'questionNo' => (isset($_GET['questionNo'])&&$_GET['questionNo']!="") ? $_GET['questionNo'] : null,
  'examBoard' => (isset($_GET['examBoard'])&&$_GET['examBoard']!="") ? $_GET['examBoard'] : null,
  'year' => (isset($_GET['year'])&&$_GET['year']!="") ? $_GET['year'] : null,
  'component' => (isset($_GET['component'])&&$_GET['component']!="") ? $_GET['component'] : null,
  'qualLevel' => isset($_GET['qualLevel'])&&($_GET['qualLevel'] !="") ? $_GET['qualLevel'] : null,
  'caseStudiesFilter' => (isset($_GET['caseStudiesFilter'])&&$_GET['caseStudiesFilter'] !="") ? $_GET['caseStudiesFilter'] : null,
  'dataFilter' => (isset($_GET['dataFilter'])&&$_GET['dataFilter'] !="") ? $_GET['dataFilter'] : null,
  'keyword' => (isset($_GET['keyword'])&&$_GET['keyword']!="") ? $_GET['keyword'] : null,
  'search' => (isset($_GET['search'])&&$_GET['search']!="") ? $_GET['search'] : null,
  'orderby' => (isset($_GET['orderby'])&&$_GET['orderby']!="") ? $_GET['orderby'] : null,
  'selectedQuestions' => (isset($_GET['selectedQuestions'])&&$_GET['selectedQuestions']!="") ? $_GET['selectedQuestions'] : null,
  'quizid' => (isset($_GET['quizid'])&&$_GET['quizid']!="") ? $_GET['quizid'] : null,
  'showQuizzes' => (isset($_GET['showQuizzes'])&&$_GET['showQuizzes']!="") ? $_GET['showQuizzes'] : null,
  'excludedQuizzes' => (isset($_GET['excludedQuizzes'])&&$_GET['excludedQuizzes']!="") ? $_GET['excludedQuizzes'] : null,
  'component' => (!empty($_GET['component'])) ? $_GET['component'] : null,
  'unitName' => (!empty($_GET['unitName'])) ? $_GET['unitName'] : null



);

$run_questions = 0;

$questions = array();

foreach ($get_selectors as $key => $element) {
  if($key != "showQuizzes" && $key != "orderby") {
    if(!is_null($element)) {
      $run_questions = 1;
    }
  }
}

if($run_questions == 1) {
  $questions = getMCQquestionDetails2($get_selectors['id'], $get_selectors['questionNo'], $get_selectors['topic'], $get_selectors['keyword'], $get_selectors['search'], $get_selectors['orderby'], $get_selectors['examBoard'], $get_selectors['year'], $get_selectors['component'], $get_selectors['unitName']);
}

if(isset($_GET['quizid']) && $_GET['quizid'] != "") {

  $quiz = getMCQquizInfo($_GET['quizid']);
  $quizQuestions = explode(",",$quiz['questions_id']);

  foreach($questions as $key => $question) {
    if(in_array($question['id'], $quizQuestions) == false) {
      unset($questions[$key]);
    }
  }

}




?>

<!--

$_GET controls:
-test => isset = shows print_r for $_POST variables
-quizid => quizid to filter results by questions used in a particular quiz (must be used in conjunction with topic)
-keyword => search by keyword

-->

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">MCQ Questions</h1>
    <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">
      <?php

      if($_SERVER['REQUEST_METHOD']==='POST') {
        if(isset($_GET['test'])) {
          print_r($_POST);
        }
        //print_r($questionsCollect);
        //echo "<br>"; print_r($optionsArray);
        //print_r($_POST);
      }
      echo "<pre>";
      //print_r($questions);
      echo "</pre>";

      ?>

      <p class="mb-3"><a class="underline text-sky-700 hover:bg-sky-100" href="mcq_questions_new.php">+ Add new questions</a></p>

      <!--New selector based on quizcreate.php-->
      <div>
        <form method ="get"  action="" id="selectForm">
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

            <label for="unitName_select">Unit Name:</label>
            <input type="text" id="unitName_select" name="unitName" value="<?=$get_selectors['unitName']?>"</input>

            <label for="search_select">Search:</label>
            <input type="text" id="search_select" name="search" value="<?=isset($_GET['search']) ? $_GET['search'] : "" ?>"</input>

            <label for="orderby_select">Order By:</label>
            <select id="orderby_select" name="orderby">
              <option value=""></option>
              <option value="question" <?=($get_selectors['orderby'] == "question") ? "selected" : ""?>>Question Text</option>
              <option value="year" <?=($get_selectors['orderby'] == "year") ? "selected" : ""?>>Year</option>
            </select>
            <!--
            <label for="search_select">Search:</label>
            <input type="text" id="search_select" name="search" value="<?=isset($_GET['search']) ? $_GET['search'] : "" ?>"</input>
              -->

            <input type="hidden" id="selectedQuestionsSelect" name="selectedQuestions" value="<?=$get_selectors['selectedQuestions']?>">

            <input type="hidden" id="excludedQuizzesSelect" name="excludedQuizzes" value="<?=$get_selectors['excludedQuizzes']?>">

            <label for="showQuizzes_select">Quiz Summary</label>
            <input id="showQuizzes_select" type="checkbox" name="showQuizzes" value="1" <?=($get_selectors['showQuizzes'] == 1) ? "checked" : ""?>>

            <input type="submit"  value="Select">
            <?php
            if($get_selectors['excludedQuizzes']) {
              ?>
              <button type="button" class="border border-black rounded" onclick="clearExcludedQuizzes();">Clear Excluded Quizzes</button>
              <?php
            }
            ?>
          </form>
      </div>
      <!--Old Selector:-->
      <!--
      <div>
        <form method ="get"  action="">
          <label for="topic_select">Topic:</label>
          <input type="text" name="topic" value="<?=isset($_GET['topic']) ? $_GET['topic'] : "" ?>"</input>
          <label for="questionNo_select">Question No:</label>
          <input type="text" name="questionNo" value="<?=isset($_GET['questionNo']) ? $_GET['questionNo'] : "" ?>"</input>

          <input type="submit"  value="Select">
        </form>
      </div>
      -->

      <div>
        <?php
        if(isset($_GET['test'])) {
          print_r($get_selectors);
          }
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
                      <p><?=$question['examBoard']?> <?=$question['unitName']?> <?=$question['qualLevel']?> <?=$question['series']?> <?=$question['year']?> Question <?=$question['questionNo']?></p>
                      <div>
                        <p class="whitespace-pre-line toggleClass_<?=$question['id']?>"><?=$question['question']?></p>
                        <p class="whitespace-pre-line toggleClass_<?=$question['id']?>"><?=$question['question2']?></p>
                        <div class="toggleClass_<?=$question['id']?> hidden">
                          <textarea  name="question" class="resize w-full toggleClass_<?=$question['id']?> hidden" spellcheck="true"><?=$question['question']?></textarea>

                          <label class="" for="<?='midImgAssetId_input_'.$question['id']?>">midImgAssetId: </label>
                          <input id="<?='midImgAssetId_input_'.$question['id']?>" class="" type="text" value="<?=$question['midImgAssetId']?>" name="midImgAssetId">

                          <textarea  name="question2" class="resize w-full " spellcheck="true"><?=$question['question2']?></textarea>

                          <p class="<?=($question['midTableArray'] != "") ? 'hidden' : '' ?>">Table: <input type="number" id="midTableRowsInput_<?=$question['id']?>"> X <input type="number" id="midTableColsInput_<?=$question['id']?>"> <button type="button" class="border rounded border-black bg-pink-200 px-1 mx-1" onclick="createTableInput(<?=$question['id']?>)">Make table</button></p>
                          <div id="midTable_<?=$question['id']?>"></div>

                          <label for="midTableHeaderInput_<?=$question['id']?>">midTable Header:</label>
                          <input type="text" name="midTableHeader" id="midTableHeaderInput_<?=$question['id']?>" value="<?=$question['midTableHeader']?>">
                          <br>

                          <input type="text" name="midTableInputArray" id="midTableInputArray_<?=$question['id']?>" value='<?=$question['midTableArray']?>'>
                        </div>
                      </div>
                      <?php
                        $imgSource = "";
                        $rootImgSource = "https://www.thinkeconomics.co.uk";
                        if($question['path']!="") {
                          //$imgSource = $path.$question['path'];
                          $imgSource = "https://www.thinkeconomics.co.uk".$question['path'];
                        }
                        else {
                          $imgSource = "https://www.thinkeconomics.co.uk/mcq/question_img/".$question['No'].".JPG";
                        }
                      ?>
                      <div class="border border-black p-1 m-1 rounded toggleClass_<?=$question['id']?>">
                        <?php
                        if($question['textOnly']==1) {
                          outputMCQquestion($question['id'], $rootImgSource);
                        } else {
                        ?>
                          <p><img class = "" src = "<?=$imgSource?>"></p>
                        <?php
                        }
                        ?>
                      </div>
                      <div>
                        <h3>Topics:</h3>
                        <div class="toggleClass_<?=$question['id']?>">
                          <p><?=$question['Topic']?> <?=$question['topics']?></p>
                        </div>
                        <div class="toggleClass_<?=$question['id']?> hidden">
                          <label>Primary Topic:</label>
                            <p><input type="text" name = "topic"  value = "<?=$question['Topic']?>"></p>
                          <label>Secondary Topics:</label>
                            <p><input type="text" name = "topics" value = "<?=$question['topics']?>"></p>



                        </div>
                      </div>
                      <div>
                        <h3 class="<?=($question['keywords']=="") ? "toggleClass_".$question['id']." hidden" : ""?>">Key Words:</h3>
                        <p class="toggleClass_<?=$question['id']?>"><?=$question['keywords']?></p>
                        <input type="text" name = "keywords" class="toggleClass_<?=$question['id']?> hidden" value = "<?=$question['keywords']?>">
                      </div>
                      <div>
                        <h3>Answer:</h3>
                        <p class="toggleClass_<?=$question['id']?>"><?=$question['Answer']?></p>
                        <input type="text" name = "answer" class="toggleClass_<?=$question['id']?> hidden" value = "<?=$question['Answer']?>">
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
                            <p><textarea name="explanation" class="resize w-full " spellcheck="true"><?=$userExplanation?></textarea></p>
                          </div>
                        </div>
                      <div>
                        <h3>Options:</h3>
                        <div class="toggleClass_<?=$question['id']?>">
                            <?php
                              $options =(array) json_decode($question['options']);
                              echo "<ul>";
                              $optionsNonStandard = 0;
                              foreach ($options as $key=>$option) {
                                if($key != $option) {
                                  $optionsNonStandard = 1;
                                ?>
                                  <li><?=$key?>: <?=$option?></li>
                                <?php
                                }
                              }
                              echo "</ul>";
                              if($optionsNonStandard == 0) {
                                echo "Standard Options";
                              }
                              //print_r($options);
                            ?>
                        </div>
                        <div class="toggleClass_<?=$question['id']?> hidden">

                        <label for="optionFill_<?=$question['id']?>" ;">Option Filler:</label>
                            <textarea class="w-full border rounded border-pink-300 bg-pink-100" id="optionFill_<?=$question['id']?>" onchange="optionFill(<?=$question['id']?>)"></textarea>
                            <?php

                            echo "<ul>";
                            $optionCount = 0;
                            foreach ($options as $key=>$option) {
                              ?>
                              <li>
                                <label for="option_<?=$optionCount?>_<?=$question['id']?>"><?=$key?></label>: <textarea id="option_<?=$optionCount?>_<?=$question['id']?>" class="w-full" name="option_<?=$optionCount?>" onfocus="this.select()" spellcheck="true"><?=$option?></textarea>
                              </li>
                              <?php
                              $optionCount ++;
                            }
                            echo "</ul>";
                            //echo $optionCount;
                            ?>
                            <input type="hidden" name="optionCount" value="<?=$optionCount?>">
                            <?php

                            //This point deals with optionsAssets:
                            $optionsAssets = new SplFixedArray($optionCount);
                            //print_r($optionsAssets);
                            if($question['optionsAssets'] != "") {
                              $optionsAssets = (array) json_decode($question['optionsAssets']);
                            }
                            $optionCount = 0;
                            //print_r($optionsAssets);
                            echo "<ul>";
                            foreach ($optionsAssets as $key=>$option) {
                              ?>
                              <li>
                                <label for="optionAssets_<?=$optionCount?>_<?=$question['id']?>"><?=$key?> Assets:</label>
                                  <input type="text" id="optionAssets_<?=$optionCount?>_<?=$question['id']?>" name="optionAssets_<?=$optionCount?>" value="<?=$option?>">
                              </li>
                              <?php
                              $optionCount ++;
                            }
                            echo "</ul>";
                            ?>
                        </div>
                      </div>
                      <!-- Text Only Input:-->
                      <div>
                        <div class="toggleClass_<?=$question['id']?>">
                          <p><?=($question['textOnly']==1) ? "Text Only Enabled" : ""?><p>
                        </div>
                        <div class="toggleClass_<?=$question['id']?> hidden">
                          <p>
                            <input id="textOnly_yes_<?=$question['id']?>" name="textOnly" type="radio" value="1" <?=($question['textOnly']==1) ? "checked" : ""?>>
                            <label for="textOnly_yes_<?=$question['id']?>">Text Only</label>
                          </p>
                          <p>
                            <input id="textOnly_no_<?=$question['id']?>" name="textOnly" type="radio" value="0" <?=($question['textOnly']==0) ? "checked" : ""?>>
                            <label for="textOnly_no_<?=$question['id']?>">No Text Only</label>
                          </p>
                        </div>

                      </div>
                      <!-- No Random Order Input-->
                      <div>
                        <div class="toggleClass_<?=$question['id']?>">
                          <p><?=($question['noRandom']==1) ? "No Random Options" : ""?><p>
                        </div>
                        <div class="toggleClass_<?=$question['id']?> hidden">
                          <p>
                            <input id="noRandom_yes_<?=$question['id']?>" name="noRandom" type="radio" value="1" <?=($question['noRandom']==1) ? "checked" : ""?>>
                            <label for="noRandom_yes_<?=$question['id']?>">No Random</label>
                          </p>
                          <p>
                            <input id="noRandom_no_<?=$question['id']?>" name="noRandom" type="radio" value="0" <?=($question['noRandom']==0) ? "checked" : ""?>>
                            <label for="noRandom_no_<?=$question['id']?>">Random Enabled</label>
                          </p>
                        </div>

                      </div>

                      <!-- Input for options table -->
                      <div>
                        <div class="toggleClass_<?=$question['id']?> hidden">
                          <label for="optionsTableHeading_<?=$question['id']?>">Options Table Heading:</label>
                          <input type="text" name="optionsTableHeading" id="optionsTableHeading_<?=$question['id']?>" value="<?=$question['optionsTableHeading']?>">
                        </div>
                        <div class="toggleClass_<?=$question['id']?>">
                          <p><?=($question['optionsTable']==1) ? "Options Table" : ""?><p>
                        </div>
                        <div class="toggleClass_<?=$question['id']?> hidden">
                          <p>
                            <input id="optionsTable_yes_<?=$question['id']?>" name="optionsTable" type="radio" value="1" <?=($question['optionsTable']==1) ? "checked" : ""?>>
                            <label for="optionsTable_yes_<?=$question['id']?>">Options in Table</label>
                          </p>
                          <p>
                            <input id="optionsTable_no_<?=$question['id']?>" name="optionsTable" type="radio" value="0" <?=($question['optionsTable']==0) ? "checked" : ""?>>
                            <label for="optionsTable_no_<?=$question['id']?>">Options as List</label>
                          </p>
                        </div>

                      </div>

                      <!-- Question Relevance and Duplication Inputs-->
                      <div class="toggleClass_<?=$question['id']?> ">
                        <p><span class="<?=($question['relevant'] == 0 ) ? "bg-pink-200" : ""?>"><?=($question['relevant'] == 1) ? "Relevant" : "Not Relevant"?></span></p>
                        <?php
                        if($question['similar'] != "") {
                          ?>
                          <p class="bg-pink-200">Question similar to:
                            <?php
                            $similar = explode(",", $question['similar']);
                            foreach ($similar as $quizid) {
                              ?>
                              <a class="underline text-sky-700" target="blank" href="mcq_preview.php?questions=<?=$quizid?>"><?=$quizid?> </a>
                              <?php
                            }
                            ?>
                          </p>
                          <?php
                        }
                        ?>
                      </div>
                      <div class="toggleClass_<?=$question['id']?> hidden">
                      <!--  Relevance inputs:-->
                        <p>
                          <input id="relevant_yes_<?=$question['id']?>" name="relevant" type="radio" value="1" <?=($question['relevant']==1) ? "checked" : ""?>>
                          <label for="relevant_yes_<?=$question['id']?>">Relevant</label>
                        </p>
                        <p>
                          <input id="relevant_no_<?=$question['id']?>" name="relevant" type="radio" value="0" <?=($question['relevant']==0) ? "checked" : ""?>>
                          <label for="relevant_no_<?=$question['id']?>">Not Relevant</label>
                        </p>

                        <!-- Similar Input-->
                        <p>
                          <label for="similar_<?=$question['id']?>">Similar to:</label>
                          <input id="similar_<?=$question['id']?>" type="text" name="similar" value="<?=$question['similar']?>">
                        </p>

                      </div>
                        <p>
                          <?php
                            if(isset($_GET['test'])) {
                              print_r($question);
                            }
                          ?>
                        </p>
                      <p><button type="button" class="w-full bg-pink-300 rounded border border-black mb-1" onclick='toggleHide(this, "toggleClass_<?=$question['id']?>", "Edit", "Hide Edit", "block"); createTableInput(<?=$question['id']?>, <?=$question['midTableArray']?>)'>Edit</button>
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

function optionFill(questionId) {
  const form = document.getElementById("optionFill_"+questionId);
  //console.log(form);
  var data = form.value;
  data = data.split("\n");
  for(var x=0; x<data.length; x++) {
    data[x] = data[x].substring(2);
    const optionInput = document.getElementById("option_"+x+"_"+questionId);
    optionInput.innerHTML = data[x];
  }
  console.log(data);


}

function createTableInput(questionId = null, preLoad = null) {
  targetDiv = document.getElementById("midTable_"+questionId);
  targetDiv.innerHTML="";
  var rows;
  var cols;
  console.log(preLoad);
  if(preLoad == null) {
    rows = document.getElementById('midTableRowsInput_'+questionId).value;
    cols = document.getElementById('midTableColsInput_'+questionId).value;
  } else {
    rows = preLoad.length;
    cols= preLoad[0].length;
  }
  //console.log(targetDiv);
  const tbl = document.createElement('table');
  for (let i = 0; i < rows; i++) {
    const tr = tbl.insertRow();
    for (let j = 0; j < cols; j++) {
        const td = tr.insertCell();
        const cellText = document.createTextNode(`Cell I${i}/J${j}`);
        const cellInput = document.createElement('INPUT');
        cellInput.setAttribute('type','text');
        cellInput.setAttribute('name','midTableInput_'+i+'_'+j);
        cellInput.setAttribute('class', 'midTableInput_'+questionId);
        if(preLoad != null ) {
          cellInput.setAttribute('value', preLoad[i][j]);

        }
        td.appendChild(cellInput);
        cellInput.setAttribute('onchange', 'compileTableInput(this);')

        //td.innerHTML= '<input name= "midTableInput_'+i+'_'+j+'">';
    }
  }
  targetDiv.appendChild(tbl);


  //const forms = document.querySelectorAll('form');
  //console.log(forms);
}

function compileTableInput(changedInput=null) {
  var id = changedInput.classList[0];
  id = id.replace("midTableInput_", "");
  id = parseInt(id);
  //console.log(id);
  inputTable = changedInput.parentNode.parentNode.parentNode.parentNode;
  //console.log(inputTable);

  var rowCount = inputTable.rows.length;
  var tableArray = [];
  for(var i=0; i<rowCount; i++) {
    var row = inputTable.rows[i];
    //console.log(row);
    var cellCount = row.cells.length;
    var cellArray = [];
    for(var j=0; j<cellCount; j++) {
      var cell = row.cells[j];
      //console.log(cell);
      var input = cell.childNodes[0];
      cellArray.push(input.value);

    }
    tableArray.push(cellArray);
  }

  console.log(tableArray);

  const midTableInput = document.getElementById("midTableInputArray_"+id);
  midTableInput.value = JSON.stringify(tableArray);

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
