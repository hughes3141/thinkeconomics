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
  $userId = $_SESSION['userid'];
  $userInfo = getUserInfo($_SESSION['userid']);
  $userType = $userInfo['usertype'];
  if (!(/*$userType == "teacher" || */ $userType =="admin")) {
    header("location: /index.php");
  }
}

$style_input = "

  .hide {
      display: none;
   }

  th, td {

  border: 1px solid black;
  padding: 5px;

  }

  table {
    
    border-collapse: collapse;
    table-layout: fixed;
    width: 100%;
    
  }
";



if (isset($_POST['submit'])) {

  //Create new topics in topics_general
  
  $count = $_POST['questionsCount'];
  $subjectId = $_POST['subjectId'];

  for($x=0; $x<$count; $x++) {

    $code = $_POST['topicCode_'.$x];
    $name = $_POST['topicName_'.$x];
    //$levelId = $_POST['levelId_'.$x];
    $levelsArray = $_POST['levelsArray_'.$x];
    $examBoardsArray = $_POST['examBoardsArray_'.$x];

    if($_POST['active_entry_'.$x] == "1") {

      //insertTopicsGeneralList($code, $name, $subjectId, $levelId, $levelsArray, $examBoardsArray);

      //echo "Record $question inserted<br>";
    }

    //echo "New records created successfully";

  }

  
 
}


$updateMessage = "";

if(isset($_POST['updateValue'])) {

  $id = $_POST['id'];
  $code = $_POST['code'];
  $name = $_POST['name'];
  $subjectId = $_POST['subjectId'];
  $levelId = $_POST['levelId'];
  $levelsArray = $_POST['levelsArray'];
  $examBoardsArray = $_POST['examBoardsArray'];

  //Update Record:
  $updateMessage = updateTopicsGeneralList($id, $code, $name, $subjectId, $levelId, $levelsArray, $examBoardsArray);


}



//$userPreferredSubject comes from a user's information.
if(isset($userInfo['userPreferredSubjectId'])) {
  $userPreferredSubject = $userInfo['userPreferredSubjectId'];
} else {
  $userPreferredSubject = 1;
}

$topicId = null;
$topicCode = null;
$topicName = null;
$subjectId = null;
$levelId = null;
$levelsArray = array();
$examBoardsArray = array();


if(isset($_GET['subjectId'])) {
  $subjectId = $_GET['subjectId'];
}


$topics = getTopicsGeneralList($topicId, $topicCode, $subjectId, $levelId, $topicName);

$subjects = getOutputFromTable("subjects", null, "name");
$levels =  getOutputFromTable("subjects_level", null, "name");

//$subjectSelector is the subjectId that is either determined by (1) user preference or (2) $subjectId;
$subjectSelector = $userPreferredSubject;
if(!is_null($subjectId)) {
  $subjectSelector = $subjectId;
}



include($path."/header_tailwind.php");
?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  <?php
  echo $updateMessage;
  ?>
<h1 class="font-mono text-2xl bg-pink-400 pl-1">Topics List</h1>
<div class=" container mx-auto px-4 pb-4 mt-2 bg-white text-black mb-5">




<?php



  if(isset($_GET['test'])) {
    

    if($_SERVER['REQUEST_METHOD']==='POST') {
      echo "POST:<br>";
      var_dump($_POST);
    }
  
    echo "<br><br>Subjects:<br>";
    print_r($subjects);
    echo "<br><br>Levels:<br>";
    print_r($levels);
    

    
  }



?>

  <h2 class="bg-pink-300 -ml-4 -mr-4 mb-5 text-xl font-mono pl-4 text-gray-800">Topic Entry</h2>
  <p>Use the form below to enter topics.</p>
  <form method="post" id="new_question_post_form">
    <div class="my-2">
        <label for ="subjectSelect">Subject:</label>
        <select class="inputProperties" id="subjectSelect" name = "subjectId" onchange="changeSubject(this);">
          <?php
            foreach ($subjects as $subject) {
                ?>
                <option value="<?=$subject['id'];?>" <?=($subject['id'] == $subjectSelector) ? "selected" : ""?>> <?=htmlspecialchars($subject['name']);?></option>
            <?php
            }
            ?>
        </select>

    </div>
    <table id="question_input_table" class="input_table w-full table-fixed">
      <tr>
        <th class = "w-1/5">Topic</th>
        <th class = "w-1/5">Level
        </th>
        <th class = "w-1/5">Exam Boards</th>
        
      </tr>
    </table>
    <p>
      <button type="button" class= "w-full rounded bg-sky-300 hover:bg-sky-200 border border-black mb-2 mt-2" onclick="addRow()">Add Row</button>
    </p>
    <p>
      <input class="w-full bg-pink-300 rounded border border-black mb-1" type="submit" name="submit" value="Create Question"></input>
    </p>
    <input type="hidden" name="questionsCount" id="questionsCount">
  </form>
  
  
  <h2 class="bg-pink-300 -ml-4 -mr-4 my-5 text-xl font-mono pl-4 text-gray-800">Database</h2>
  <p>Search for questions by topic:</p>
  <form method="get" id="database_get_form">
    <div class="mb-2">

      <label for ="subjectSelectGet">Subject:</label>
        <select id="subjectSelectGet" name = "subjectId" onchange="this.form.submit();">
          <?php
            foreach ($subjects as $subject) {
                ?>
                <option value="<?=$subject['id'];?>" <?=($subject['id'] == $subjectSelector) ? "selected" : ""?> > <?=htmlspecialchars($subject['name']);?></option>
            <?php
            }
            ?>
        </select>
        <select id="levelSelectGet" name = "levelId">
          <?php
            foreach ($levels as $subject) {
                ?>
                <option value="<?=$subject['id'];?>" <?php
                  if(isset($_POST['levelId'])) {
                    if($subject['id'] == $_POST['levelId']) {
                      echo "selected";
                    }
                    
                  }
                  else if ($subject['id'] == $userPreferredSubject) {
                    echo "selected";
                  }              
                ?> > <?=htmlspecialchars($subject['name']);?></option>
            <?php
            }
            ?>
        </select>

      
      <label for="topicGet">Topic:</label>
      <select id="topicGet" class="w-20" name="topicId">
      <?php
            $topicPostSelect = null;
            if(isset($_POST['topicId'])) {
              $topicPostSelect = $_POST['topicId'];
            }
            if(isset($_GET['topicId'])) {
              $topicPostSelect = $_GET['topicId'];
            }
            foreach ($topics as $topic) {
              $indent = "";
              $disabled = "";
                if($topic['topicLevel'] =="0") {
                  $disabled = 'disabled="disabled"';

                } else if ($topic['topicLevel'] =="1") {
                  $indent = "&nbsp&nbsp";
                  $disabled = 'disabled="disabled"';
                } else if ($topic['topicLevel'] =="2") {
                  $indent = "&nbsp&nbsp&nbsp&nbsp";
                }
              ?>
              <option class="" value="<?=$topic['id']?>" <?=($topicPostSelect == $topic['id']) ? "selected":""?> <?=($topicGet == $topic['code']) ? "selected":""?> <?=$disabled?>><?=$indent.$topic['name']?></option>
              <?php
            }
          ?>
      </select>
      <span class="<?=is_null($showFlashCards)?"hidden":""?>">
        <input id="flashcard_select" type="checkbox" name="flashCard" value="1" <?=(isset($_GET['flashCard'])) ? "checked":""?>>
        <label for="flashcard_select">FlashCards Only</label>
      </span>


      <input class="bg-pink-200 px-2" type="submit" value="Choose Topic">
      <div class="hidden">
        <input type="checkbox" value="1" name="noFlashCard" <?=is_null($showFlashCards)?"checked":""?>>
        <input type="checkbox" value="1" name="noAssetInput" <?=is_null($showAssetId)?"checked":""?>>
      </div>
    </div>

  </form>


  <?php 
  if($topicId) {
    ?>
    
    <table class="input_table table-fixed w-full">
        <tr>
          <th class="w-1/6">Topic</th>	
          <th class="w">Question</th>
          <th class="w">Model Answer/Mark Scheme</th>
          <th class="w-1/6">Edit</th>

        </tr>
      
        <?php
        
      foreach ($questions as $row) {
          ?>
      
        <tr id = 'row_<?=$row['id'];?>'>
          <?php
          $userEdit = false;
          if ($_SESSION['userid'] == $row['userCreate']) {
            $userEdit = true;
          }
          //$userEdit = true;
          if($userEdit) {?>
            <form method="post" action="">
          <?php }?>
        
          <td class="align-top">
            <div class="show_<?=$row['id'];?>">
              <?=htmlspecialchars($row['topicName']);?><br>
              <?=htmlspecialchars($row['userTopicOrder'])?> 
            </div>
            <div class="hide hide_<?=$row['id'];?>">
            <select name="topicId" class='w-full'>
              <?php
                  $topicPostSelect = null;
                  if(isset($_POST['topicId'])) {
                    $topicPostSelect = $_POST['topicId'];
                  }
                  if(isset($_GET['topicId'])) {
                    $topicPostSelect = $_GET['topicId'];
                  }
                  foreach ($topics as $topic) {
                    $indent = "";
                    $disabled = "";
                      if($topic['topicLevel'] =="0") {
                        continue;
                        $disabled = 'disabled="disabled"';

                      } else if ($topic['topicLevel'] =="1") {
                        continue;
                        $indent = "&nbsp&nbsp";
                        $disabled = 'disabled="disabled"';
                      } else if ($topic['topicLevel'] =="2") {
                        //$indent = "&nbsp&nbsp&nbsp&nbsp";
                      }
                    ?>
                    <option class="w-10" value="<?=$topic['id']?>" <?=($topicPostSelect == $topic['id']) ? "selected":""?> <?=($topicGet == $topic['code']) ? "selected":""?> <?=$disabled?>><?=$indent.$topic['name']?></option>
                    <?php
                  }
                ?>
              </select>
              <br>

              <input type="text" name ="topic_order" value ="<?=htmlspecialchars($row['topic_order'])?>" style="width:100px;"></input>
            </div>
            <p>
              <i>id: <?=$row['id'];?></i>
            </p>
          </td>
          <td class="align-top">
            <div class="show_<?=$row['id'];?>">
              <?=htmlspecialchars($row['question']);?>
              <?php
                    if(!is_null($row['q_path'])) {
                      ?>
                      <img class = "mx-auto my-1 max-h-80" src= "<?=htmlspecialchars($row['q_path'])?>" alt = "<?=htmlspecialchars($row['q_alt'])?>">
                      <?php
                    }

                if($row['points'] != "") {
                ?>
              <p>
                Points: <?=$row['points']?>
              </p>
                <?php
                }

              if($row['type'] != "") {
                ?>
              <p>
                Keywords: <?=htmlspecialchars($row['type'])?>
              </p>
              <?php
              }
                ?>
            </div>
            <div class= "hide hide_<?=$row['id'];?>">
              <textarea class="h-44" name ="question"><?=htmlspecialchars($row['question'])?></textarea>
              <br>
              <div class="<?=is_null($showAssetId)?"hidden":""?>">
                <label for="qA_<?=$row['id'];?>">Question Asset Id:</label><br>
                <input id="qA_<?=$row['id'];?>" type="number" name="questionAsset" value="<?=$row['questionAssetId']?>">
                <br>
              </div>
              <label for = "points_<?=$row['id'];?>" >Points:</label><br>
              <input id="points_<?=$row['id'];?>" name ="points" type="number" value="<?=$row['points']?>"</input>
              <br>
              <label for = "keyword<?=$row['id'];?>" >Keywords:</label><br>
              <textarea id="keyword<?=$row['id'];?>" name ="type" type="text" ><?=$row['type']?></textarea>
            </div>
              <div class="<?=is_null($showFlashCards)?"hidden":""?>">
                <input class="w-4" id="flashCard_Update_<?=$row['id'];?>" type="checkbox" name ="flashCard" value="1" <?=($row['flashCard']==1) ? "checked" : ""?> disabled>
                <label for="flashCard_Update_<?=$row['id'];?>">flashCard</label>
              </div>
            <?php
            if(isset($_GET['test'])) {
              print_r($row);
            }
            ?>
          </td>

          <td class="align-top">
            <div class="show_<?=$row['id'];?>" >
              <div style="white-space: pre-line;"><?=htmlspecialchars($row['model_answer']);?>
              </div>
              <?php
                    if(!is_null($row['a_path'])) {
                      ?>
                      <img class = "mx-auto my-1 max-h-80" src= "<?=htmlspecialchars($row['a_path'])?>" alt = "<?=htmlspecialchars($row['a_alt'])?>">
                      <?php
                    }
                    ?>
            </div>
            <div class="hide hide_<?=$row['id'];?>">
              <label class="hide" for = "model_answer<?=$row['id'];?>">Model Answer:</label>
              <textarea class="h-44" id = "model_answer<?=$row['id'];?>" name ="model_answer"><?=htmlspecialchars($row['model_answer'])?></textarea>
              <br>
              <div class="<?=is_null($showAssetId)?"hidden":""?>">
                <label for ="asset_id<?=$row['id'];?>">Asset ID:</label><br>
                <input id="asset_id<?=$row['id'];?>" type="number" name="answerAsset" value="<?=$row['answerAssetId']?>">
              </div>    
            </div>
              
          </td>

          <td class="align-top">
            <?php if($userEdit) {?>
              <div>
                <button type ="button" class= "w-full bg-pink-300 rounded border border-black mb-1" id = "button_<?=$row['id'];?>" onclick = "changeVisibility(this, <?=$row['id'];?>); flashcardButtonToggle(this)">Edit</button>
              </div>
              <div class ="hide hide_<?=$row['id'];?>">
                <input type="hidden" name = "id" value = "<?=$row['id'];?>">
                <input type="hidden" name = "subjectId" value = "<?=$row['subjectId'];?>">
                <input type="hidden" name = "levelId" value = "<?=$row['levelId'];?>">

                <input class="w-full bg-sky-200 rounded border border-black mb-1 toggleClass_35" type="submit" name="updateValue" value = "Update"></input>
              </div>
            <?php }?>
            
          </td>
          
          <?php if($userEdit) {?>
            </form>
          <?php }?>
        <tr>


        <?php
      
      }
      
      ?>

    </table>

    <?php

  }

?>
</div>
</div>

<script>




addRow();


function changeVisibility(button, id) {
  
  if(button.innerHTML =="Edit") {
    button.innerHTML = "Hide Edit";
    var hiddens = document.getElementsByClassName("hide_"+id);
    for (var i=0; i<hiddens.length; i++) {
      hiddens[i].style.display = "block";
    }

    var shows = document.getElementsByClassName("show_"+id);
    //console.log(shows);
    for (var i=0; i<shows.length; i++) {
      
      shows[i].style.display = "none";
    }
  } else {
    button.innerHTML = "Edit";
    var hiddens = document.getElementsByClassName("hide_"+id);
    for (var i=0; i<hiddens.length; i++) {
      hiddens[i].style.display = "none";
    }

    var shows = document.getElementsByClassName("show_"+id);
    //console.log(shows);
    for (var i=0; i<shows.length; i++) {
      
      shows[i].style.display = "block";
    }
  }


}

function flashcardButtonToggle(input) {
  row = input.parentNode.parentNode.parentNode;
  checkbox = row.querySelectorAll('input[type=checkbox]')[0];
  if (checkbox.disabled == true) {
    checkbox.disabled = false;
  } else {
    checkbox.disabled = true;
  }
  //console.log(checkbox);
}



function sourceAmend(i) {
  
  var source = document.getElementById("type_"+i);
  if (i>0) {
    var prevSource = document.getElementById("type_"+(i-1)).value;
    source.value = prevSource;
  }
  
  
  
}

function addRow() {
  
  var table = document.getElementById("question_input_table");
  var tableLength = table.rows.length;
  var row = table.insertRow(tableLength);


  var cell0 = row.insertCell(0);
  var cell1 = row.insertCell(1);
  var cell2 = row.insertCell(2);

  cell0.classList.add("align-top");
  cell1.classList.add("align-top");
  cell2.classList.add("align-top");
  //cell3.classList.add("align-top");

  
  var inst = tableLength -1;


  cell0.innerHTML += '<label for="topicCode_'+inst+'">Code:</label><br><input type="text" id ="topicCode_'+inst+'" name="topicCode_'+inst+'" class="w-full " required><br>';
  
  cell0.innerHTML += '<label for="topicName'+inst+'">Topic Name:</label><br><textarea class="" type="text" id ="topicName'+inst+'" name="topicName_'+inst+'"></textarea><br>';


  cell1.innerHTML += '<div>';

  <?php
  foreach($levels as $key=>$level) {
    ?>
      cell1.innerHTML += '<input class = "w-5 levelSelector_'+inst+'" type="checkbox" id="level_checkbox_'+inst+'_<?=$key?>" value = "<?=$level['id']?>" onchange="levelsAggregate('+inst+');">';
      cell1.innerHTML += '<label for ="level_checkbox_'+inst+'_<?=$key?>"><?=$level['name']?></label><br>';
    <?php
  }

  ?>

  cell1.innerHTML += '</div>';
  cell1.innerHTML += '<input type="text" name="levelsArray_'+inst+'" id="levelSelect_'+inst+'">';
  
 

  cell2.innerHTML = "<button class='w-full bg-pink-300 rounded border border-black mb-1' type ='button' onclick='hideRow(this);'>Remove</button>"
  cell2.innerHTML += "<input name='active_entry_"+inst+"' class='w-full' type='hidden' value='1'>";

  


  
  document.getElementById("questionsCount").value = tableLength;

  questionCount ++;
  


}

function changeOrder(x) {
  questionCount = parseInt((x.value))+1;
}

function hideRow(button) {
  var row = button.parentElement.parentElement;
  var input = button.parentElement.childNodes[1];
  console.log(row);
  console.log(input);
  row.style.display = "none";
  input.value='0';
}

function arrowAdd(inst) {
  var answerBox = document.getElementById("model_answer_"+inst);
  answerBox.value += "→ ";
}

function changeSubject(input) {
  var topicChangeForm = document.getElementById("database_get_form");
  var changeTo = input.value;
  var topicChangeSelect = document.getElementById("subjectSelectGet");
  //console.log(topicChangeSelect);
  //console.log(changeTo);
  topicChangeSelect.value=changeTo;
  topicChangeForm.submit();
}

function changeTopic(input) {
  var topicChangeForm = document.getElementById("database_get_form");
  var changeTo = input.value;
  var topicChangeSelect = document.getElementById("topicGet");
  //console.log(topicChangeSelect);
  //console.log(changeTo);
  topicChangeSelect.value=changeTo;
  topicChangeForm.submit();
}

function disableInputProperties() {
  var inputProperties = document.getElementsByClassName("inputProperties");
  console.log(inputProperties)

  Array.from(inputProperties).forEach((input) => 
  { //input.setAttribute('disabled', 'true')
    input.style.pointerEvents = "none";
    input.style.background = "#F5F5F5";
  })

}

function selectInputs(formId) {
  var form = document.getElementById(formId);
  var allFormControls = form.elements;
  //console.log(allFormControls);
  Array.from(allFormControls).forEach((input) => 
  { if (input.classList.contains('inputProperties') == false) {
    input.setAttribute('onchange', 'disableInputProperties()')
    }
  })


  //allFormControls.setAttribute('onclick', 'disableInputProperties()');


 

}

selectInputs("new_question_post_form");


function levelsAggregate(inst) {

var topicsInput = document.getElementsByClassName("levelSelector_"+inst);
var topicsInputChecked = [];
var topicString = "";
var checkedCount = 0;
const topicSelect = document.getElementById("levelSelect_"+inst);

//console.log(topicsInput);

for (var i=0; i<topicsInput.length; i++) {
  var topic = topicsInput[i];
  if(topic.checked == true) {
    topicsInputChecked.push(topicsInput[i]);
  }
}

//console.log(topicsInputChecked);

for(var i=0; i<topicsInputChecked.length; i++) {
  topic = topicsInputChecked[i];
  topicString += topic.value;
  if(i < (topicsInputChecked.length - 1)) {
    topicString += ",";
  }

}

console.log(topicString);

topicSelect.value = topicString;

console.log(topicString);
console.log(topicSelect);
topicSelect.value = topicString;
}

</script>

<?php   include($path."/footer_tailwind.php");?>