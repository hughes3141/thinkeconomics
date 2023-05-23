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
  ["AQA", 12],
  ["WJEC", 13],
  ["OCR", array(
    ["AL", 15],
    ["AS", 16]
  )],
  ["Edexcel", array(
    ["AL", 17],
    ["AS", 18]
  )]
);

if($_SERVER['REQUEST_METHOD']==='POST') {

  if(isset($_POST['submit'])&&($_POST['submit']="submit")) {
    $questionsCollect = array();
    $inputCount = $_POST['inputCount'];

    for($x=0; $x<$inputCount; $x++) {
      $options = ['A', 'B', 'C', 'D', 'E'];
      $optionsArray = array();

      for($y=0; $y<$_POST['optionsNumber_'.$x]; $y++) {
        $optionsArray[$options[$y]] = $_POST['option_'.$x."_".$y];
      }
      $optionsArray = json_encode($optionsArray);

      $newQuestion = array(
        'questionNo' => $_POST['questionNo_'.$x],
        'examBoard' => $_POST['examBoard_'.$x],
        'level' => $_POST['level_'.$x],
        'unitNo'=> $_POST['unitNo_'.$x],
        'unitName' => $_POST['unitName_'.$x],
        'year' => $_POST['year_'.$x],
        'questionText' => $_POST['questionText_'.$x],
        'options' => $optionsArray,
        'assetId' => $_POST['assetId_'.$x],
        'answer' => $_POST['answer_'.$x], 
        'topic' => $_POST['topic_'.$x], 
        'topics' => $_POST['topics_'.$x], 
        'keyWords' => $_POST['keyWords_'.$x],
        'active_entry' => $_POST['active_entry_'.$x],
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

  if(isset($_POST['submit'])) {
    if($_POST['submit'] == 'Update') {
      updateMCQquestion($_POST['id'], $userId, $_POST['explanation']);
    }
  }
}

$questions = array();
if(isset($_GET['questionNo']) && $_GET['questionNo'] !="") {
  $result = getMCQquestionDetails(null, $_GET['questionNo']);
  array_push($questions, $result);
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
        print_r($questionsCollect);

      }
      echo "<pre>";
      //print_r($questions);
      //print_r($examBoardCodeKey);
      echo "</pre>";
      

      ?>

      <div>
        <h2>Create New Questions</h2>
        <form method="post" action = "">
          <table id="inputTable" class="w-full table-fixed mb-2 border border-black">
            <thead>
              <tr>
                <th>Question</th>
                <th>Question Text</th>
                <th>Options</th>
                <th>Image Source</th>
                <th>Details</th>
                <th>Remove</th>

              </tr>
            </thead>

          </table>
          <input type = "" id="inputCount" name="inputCount">
          <button class="w-full rounded bg-sky-300 hover:bg-sky-200 border border-black mb-2" type="button" onclick="addInputRow();">Add row</button> 
          <button name="submit" value ="submit">Submit</button>
      </form>
      </div>

      <div>
        <form method ="get"  action="">
          <label for="topic_select">Topic:</label>
          <input type="text" name="topic" value="<?=isset($_GET['topic']) ? $_GET['topic'] : "" ?>"</input>
          <label for="questionNo_select">Question No:</label>
          <input type="text" name="questionNo" value="<?=isset($_GET['questionNo']) ? $_GET['questionNo'] : "" ?>"</input>

          <input type="submit" value="Select">
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
                  <tr>
                    <td><?=$question['id']?></td>
                    <td><?=$question['No']?></td>
                    <td>
                      <p><?=$question['question']?></p>
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
                      <p><?=$question['Topic']?></p>
                      <p>Answer: <?=$question['Answer']?>
                      <p><label for="">Explanation: </label></p>
                      <p><textarea name="explanation" class="resize w-full" spellcheck="true"><?php
                          $explanations = json_decode($question['explanation']);
                          //var_dump($explanations);
                          $explanations = (array) $explanations;
                          if(isset($explanations[$userId])) {
                            echo $explanations[$userId];
                          }
                          //print_r($explanations);
                        ?></textarea></p>
                        <p>
                          <?php print_r($question);?>
                        </p>
                      <p><input type="submit" name="submit" value= "Update"><p>
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

const examBoardNumbers = {Eduqas:5, AQA:4, WJEC:5, Edexcel:4, OCR:4};
//const examBoardNumbers = [['Eduqas',5], ['AQA',4], ['WJEC',5], ['Edexcel',4], ['OCR',4]];
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
  output += "<select name="+label+" id= "+label+" class='w-3/5 rounded'>"+choices+"</select>";

  document.getElementById(targetObj).innerHTML = output;
}



function addInputRow() {
  var table = document.getElementById("inputTable");
  var rowNo = table.rows.length;
  var row = table.insertRow(rowNo);
  var num = (rowNo - 1);
  var examBoards = ['Eduqas', 'AQA', 'WJEC', 'Edexcel', 'OCR'];
  

  //Find the values of last inserted row:

  var lastQuestionNo = document.getElementById("questionNo_"+ (num-1));
  if (lastQuestionNo) {
    lastQuestionNo = lastQuestionNo.value;
  }
  //console.log(lastQuestionNo);

  var lastExamBoard = document.getElementById("examBoard_"+ (num-1));
  if (lastExamBoard) {
    lastExamBoard = lastExamBoard.value;
  }
  //console.log(lastExamBoard);

  var lastUnitNo = document.getElementById("unitNo_"+ (num-1));
  if (lastUnitNo) {
    lastUnitNo = lastUnitNo.value;
  } else {
    lastUnitNo = 1;
  }

  var lastUnitName = document.getElementById("unitName_"+ (num-1));
  if (lastUnitName) {
    lastUnitName = lastUnitName.value;
  } else {
    lastUnitName = "";
  }

  var lastYear = document.getElementById("year_"+ (num-1));
  if (lastYear) {
    lastYear = lastYear.value;
  } else {
    lastYear = "<?=date('Y')?>";
  }

  var lastLevel = document.getElementById("level_"+ (num-1));
  if (lastLevel) {
    lastLevel = lastLevel.value;
  } else {
    lastLevel = "";
  }


  var cells = [];
  for (var i=0; i<6; i++) {
    cells[i] = row.insertCell(i);
    
    switch(i) {
      case 0:
        var label = (rowNo-1);
        var value = num+1;
        if(lastQuestionNo) {
          value = parseInt(lastQuestionNo) + 1;
        }

        //Question Number:
        cells[i].innerHTML = "<label for = 'questionNo_"+num+"'>Question Number:</label><br><input  name='questionNo_"+num+"' id= 'questionNo_"+num+"' class='w-full rounded' value= '"+value+"'>";

        //Compose options for exam board select tag:
        cells[i].innerHTML += "<label for ='examBoard_"+num+"'>Exam Board:</label><br>";
        var options = "";
        for (var j = 0; j<examBoards.length; j++) {
          var selected = "";
          if(examBoards[j] == lastExamBoard) {
            selected = " selected ";
          }
          options += "<option value = '"+examBoards[j]+"' "+selected+">"+examBoards[j]+"</option>"
        }
        cells[i].innerHTML += "<select name = 'examBoard_"+num+"' id= 'examBoard_"+num+"' onchange='addOptions(this.value, "+num+", \"optionsTarget_"+num+"\"); addAnswerSelect(this.value, "+num+", \"dropdownTarget_"+num+"\")'>"+options+"</select>";

        //Level:
        var options = "";
        var levels = ['AL', 'AS'];
        for (var j=0; j<levels.length; j++) {
          var selected = "";
          if(levels[j] == lastLevel) {
            selected = " selected ";
          }
          options += "<option value = '"+levels[j]+"' "+selected+">"+levels[j]+"</option>";
        }
        cells[i].innerHTML += "<br><label for ='level_"+num+"'>Level:</label><br><select name = 'level_"+num+"' id= 'level_"+num+"'>"+options+"</select>";

        //Unit Number:
        cells[i].innerHTML += "<br><label for = 'unitNo_"+num+"'>Unit Number:</label><br><input type='number' min ='1' max = '6' name='unitNo_"+num+"' id= 'unitNo_"+num+"' class='w-full rounded' value= '"+lastUnitNo+"'>";

        //Unit Name:
        cells[i].innerHTML += "<br><label for = 'unitName_"+num+"'>Unit Name:</label><br><input name='unitName_"+num+"' id= 'unitName_"+num+"' class='w-full rounded' value= '"+lastUnitName+"'>";

        //Year:
        cells[i].innerHTML += "<br><label for = 'year_"+num+"'>Year:</label><br><input type = 'number' min = '2000' max = '2050' name='year_"+num+"' id= 'year_"+num+"' class='w-full rounded' value= '"+lastYear+"'>";

        break;
      case 1:
        var label = "questionText_"+(rowNo-1);
        //var value = "value = '"+(rowNo)+"'";
        cells[i].innerHTML = "<textarea name="+label+" id= "+label+" "+"class='w-full rounded p-1'></textarea>";
        break;
      case 2:
        /*
        var label = "options_"+(rowNo-1);
        //var value = "value = '"+(rowNo)+"'";
        cells[i].innerHTML = "<textarea name="+label+" id= "+label+" "+"class='w-full rounded p-1'></textarea>";
        break;
        */
       cells[i].innerHTML = "<div id='optionsTarget_"+num+"'>";
       break;

      case 3:
        var label = "assetId_"+num;
        //var value = "value = '"+(rowNo)+"'";
        cells[i].innerHTML = "<label for = "+label+">Asset  Id: </label><input name="+label+" id= "+label+" class='w-full rounded'>";



        break;

      case 4:
        //Answer:
        //Uses addAnswerSelect
        cells[i].innerHTML = "<div id='dropdownTarget_"+num+"'></div>"

        //Topic:
        var label = 'topic_'+num;
        cells[i].innerHTML += "<label for = "+label+">Topic: </label><input name="+label+" id= "+label+" class='w-full rounded'>";

        //Multiple Topics:
        var label = 'topics_'+num;
        cells[i].innerHTML += "<label for = "+label+">Topics: </label><input name="+label+" id= "+label+" class='w-full rounded'>";

        //Key Words:
        var label = 'keyWords_'+num;
        cells[i].innerHTML += "<label for = "+label+">Key Words: </label><input name="+label+" id= "+label+" class='w-full rounded'>";

        break;
      case 5:
        cells[i].innerHTML = "<button class='w-full bg-pink-300 rounded border border-black mb-1' type ='button' onclick='hideRow(this);'>Remove</button>"
        cells[i].innerHTML += "<input name='active_entry_"+num+"' class='w-full' type='hidden' value='1'>";
        break;
    }
  }

  //Update option values:
  var thisExamBoard = document.getElementById("examBoard_"+num).value;
  console.log(thisExamBoard);
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



</script>

<?php   include($path."/footer_tailwind.php");?>