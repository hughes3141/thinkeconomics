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
  if (!(str_contains($permissions, 'teacher'))) {
    header("location: /index.php");
  }

}

$style_input = "
  th, td {
    border: 1px solid black;
  }

  
  ";


include($path."/header_tailwind.php");

//Exam board code key. A legacy item from when these were coded in excel.

$examBoardCodeKey = array(
  ["Original", 10],
  ["Eduqas", 11],
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

if($_SERVER['REQUEST_METHOD']==='POST') {

  if(isset($_POST['submit'])&&($_POST['submit']=="submit")) {
    $updateBool = 1;
    $questionsCollect = array();
    $inputCount = $_POST['inputCount'];

    for($x=0; $x<$inputCount; $x++) {
      
      //Create array for options
      $options = ['A', 'B', 'C', 'D', 'E'];
      $optionsArray = array();

      for($y=0; $y<$_POST['optionsNumber_'.$x]; $y++) {
        $optionsArray[$options[$y]] = $_POST['option_'.$x."_".$y];
      }
      $optionsArray = json_encode($optionsArray);

      $specPaper = "";
      if(isset($_POST['specPaper'])) {
        $specPaper = $_POST['specPaper'];
        //Putting this in here just as a default for specification year publication:
        //$_POST['year'] = "2015";
      }

      $newQuestion = array(
        'questionNo' => $_POST['questionNo_'.$x],
        'examBoard' => $_POST['examBoard'],
        'level' => $_POST['level'],
        'unitNo'=> $_POST['unitNo'],
        'unitName' => $_POST['unitName'],
        'year' => $_POST['year'],
        'questionText' => $_POST['questionText_'.$x],
        'options' => $optionsArray,
        'assetId' => $_POST['assetId_'.$x],
        'answer' => $_POST['answer_'.$x], 
        'topic' => $_POST['topic_'.$x], 
        'topics' => $_POST['topics_'.$x], 
        'keyWords' => $_POST['keyWords_'.$x],
        'active_entry' => $_POST['active_entry_'.$x],
        'specPaper' => $specPaper
      );
      array_push($questionsCollect, $newQuestion);
    }

    foreach($questionsCollect as $question) {
      //Filter for those entires that are active entries (i.e. not from hidden rows)

      if($question['active_entry'] == "1") {
        //print_r($question);
        $questionCode = "";
        
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
        if($questionNo<10) {
          $questionNo = "0".$questionNo;
        }
        $questionCode .=$questionNo;

        //print_r($question);

        insertMCQquestion($userId, $questionCode, $question['questionNo'], $question['examBoard'], $question['level'], $question['unitNo'], $question['unitName'], $question['year'], $question['questionText'], $question['options'], $question['answer'], $question['assetId'], $question['topic'], $question['topics'], $question['keyWords']);

        
        
      }
    }

    

  }

  $updateQuestionBool = 0;
  if(isset($_POST['submit'])) {
    if($_POST['submit'] == 'Update') {

      $updateQuestionBool = 1;
      //Create array for options:
      $options = ['A', 'B', 'C', 'D', 'E'];
      $optionsArray = array();
      for($x=0; $x<$_POST['optionCount']; $x++) {
        $optionsArray[$options[$x]] = $_POST['option_'.$x];
      }
      $optionsArray = json_encode($optionsArray);
      
      updateMCQquestion($_POST['id'], $userId, $_POST['explanation'], $_POST['question'], $optionsArray, $_POST['topic'], $_POST['topics'], $_POST['answer'], $_POST['keywords']);
      ?>
      <?php
    }
  }
}

$questions = array();
if(isset($_GET['questionNo']) && $_GET['questionNo'] !="") {
  
  $result = getMCQquestionDetails(null, $_GET['questionNo']);
  //There's a bit of formatting that has to happen here to filter out a poor design in the original function, which outputs a single array result rather than an array wiht a single result array[0]. If the result is singular, make a new array with this output as its [0]:
  if(isset($result['id'])) {
    array_push($questions, $result);
    //Or else just return the array wiht many different sub-arrays:
  } else {
    $questions = $result;
  }



}
if(isset($_GET['topic']) && $_GET['topic'] !="") {
  $questions = getMCQquestionDetails(null, null, $_GET['topic']);
}




?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">MCQ Questions</h1>
    <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">
      <?php
      if($_SERVER['REQUEST_METHOD']==='POST') {
        //print_r($_POST);
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
                <th class="w-1/2">Question Text</th>
                <th>Options</th>
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
          <label for="topic_select">Topic:</label>
          <input type="text" name="topic" value="<?=isset($_GET['topic']) ? $_GET['topic'] : "" ?>"</input>
          <label for="questionNo_select">Question No:</label>
          <input type="text" name="questionNo" value="<?=isset($_GET['questionNo']) ? $_GET['questionNo'] : "" ?>"</input>

          <input type="submit"  value="Select">
        </form>
      </div>
      
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
                      <p><?=$question['examBoard']?> <?=$question['unitName']?> <?=$question['qualLevel']?></p>
                      <div>
                        <p class="whitespace-pre-line toggleClass_<?=$question['id']?>"><?=$question['question']?></p>
                        <textarea  name="question" class="resize w-full toggleClass_<?=$question['id']?> hidden" spellcheck="true"><?=$question['question']?></textarea>
                      </div>
                      <?php
                        $imgSource = "";
                        if($question['path']!="") {
                          //$imgSource = $path.$question['path'];
                          $imgSource = "https://www.thinkeconomics.co.uk".$question['path'];
                        }
                        else {
                          $imgSource = "question_img/".$question['No'].".JPG";
                        }
                      ?>
                      <p><img class = "w-3/4" src = "<?=$imgSource?>"></p>
                      <div>
                        <h3>Topic:</h3>
                        <p class="toggleClass_<?=$question['id']?>"><?=$question['Topic']?></p>
                        <p class="toggleClass_<?=$question['id']?>"><?=$question['topics']?></p>
                        <div class="toggleClass_<?=$question['id']?> hidden">
                          <p>Primary Topic: <input type="text" name = "topic"  value = "<?=$question['Topic']?>"></p>
                          <p>Secondary Topics: <input type="text" name = "topics" value = "<?=$question['topics']?>"></p>
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
                              foreach ($options as $key=>$option) {
                                ?>
                                <li><?=$key?>: <?=$option?></li>

                                <?php
                              }
                              echo "</ul>";
                              //print_r($options);
                            ?>
                        </div>
                        <div class="toggleClass_<?=$question['id']?> hidden">
                            <?php
                            echo "<ul>";
                            $optionCount = 0;
                            foreach ($options as $key=>$option) {
                              
                              ?>
                              <li><label for="option_<?=$optionCount?>"><?=$key?></label>: <textarea id="option_<?=$optionCount?>" class="w-full"name="option_<?=$optionCount?>" onfocus="this.select()" spellcheck="true"><?=$option?></textarea></li>
                              <?php
                              $optionCount ++;
                              
                            }
                            echo "</ul>";
                            //echo $optionCount;
                            ?>
                            <input type="hidden" name="optionCount" value="<?=$optionCount?>">
                        </div>


                      </div>
                        <p>
                          <?php //print_r($question);?>
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
  for (var i=0; i<5; i++) {
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
        cells[i].innerHTML = "<p><label for = 'questionNo_"+num+"'>No.</label></p><p><input  name='questionNo_"+num+"' id= 'questionNo_"+num+"' class='p-2 w-full rounded border border-black text-center' value= '"+value+"'><p>";

        //Answer:
        //Uses addAnswerSelect
        cells[i].innerHTML += "<p><div id='dropdownTarget_"+num+"' class='dropdownTarget'></div></p>"

        break;
      case 1:
        var label = "questionText_"+(rowNo-1);
        //var value = "value = '"+(rowNo)+"'";
        cells[i].innerHTML = "<textarea name="+label+" id= "+label+" "+"class='w-full rounded p-1 h-60'></textarea>";
        break;
      case 2:
        /*
        var label = "options_"+(rowNo-1);
        //var value = "value = '"+(rowNo)+"'";
        cells[i].innerHTML = "<textarea name="+label+" id= "+label+" "+"class='w-full rounded p-1'></textarea>";
        break;
        */
       cells[i].innerHTML = "<div id='optionsTarget_"+num+"' class='optionsTarget'>";
       break;

      case 3:


        //Topic:
        var label = 'topic_'+num;
        cells[i].innerHTML += "<label for = "+label+">Topic: </label><input name="+label+" id= "+label+" class='w-full rounded'>";

        //Multiple Topics:
        var label = 'topics_'+num;
        cells[i].innerHTML += "<label for = "+label+">Topics: </label><input name="+label+" id= "+label+" class='w-full rounded'>";

        //Key Words:
        var label = 'keyWords_'+num;
        cells[i].innerHTML += "<label for = "+label+">Key Words: </label><input name="+label+" id= "+label+" class='w-full rounded'>";

        //Asset ID:
        var label = "assetId_"+num;
        //var value = "value = '"+(rowNo)+"'";
        cells[i].innerHTML += "<label for = "+label+">Asset  Id: </label><input name="+label+" id= "+label+" class='w-full rounded'>";

        break;
      case 4:
        cells[i].innerHTML = "<button class='w-full bg-pink-300 rounded border border-black mb-1' type ='button' onclick='hideRow(this);'>Remove</button>"
        cells[i].innerHTML += "<input name='active_entry_"+num+"' class='w-full' type='hidden' value='1'>";
        cells[i].classList.add('align-middle')
        break;
    }
  }

  //Update option values:
  var thisExamBoard = document.getElementById("examBoard").value;
  //console.log(thisExamBoard);
  addOptions(thisExamBoard, num, "optionsTarget_"+num);

  //Update Answer Values:
  addAnswerSelect(thisExamBoard, num, "dropdownTarget_"+num);

  //Update input number
  var inputCount = document.getElementById("inputCount").value ++;
}

addInputRow();

function hideRow(button) {
  var row = button.parentElement.parentElement;
  var input = button.parentElement.childNodes[1];
  console.log(row);
  console.log(input);
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