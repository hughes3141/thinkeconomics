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

$newRecordMessage = "";

if (isset($_POST['submit'])) {

  //Create new topics in topics_general
  
  $count = $_POST['questionsCount'];

  $subjectId = $_POST['subjectId'];
  $levelId = $_POST['levelId'];
  $levelsArray = json_encode($levelId);
  $examBoardId   = $_POST['examBoardId'];
  $rootTopic = $generalTopic = null;
  if(isset($_POST['rootTopic'])) {
    $rootTopic = $_POST['rootTopic'];
  } else {
    $rootTopic = 0;
  }
  if(isset($_POST['generalTopic'])) {
  $generalTopic = $_POST['generalTopic'];
  } else {
    $generalTopic = 0;
  }

  $parentId = null;
  if($rootTopic == 1) {
    $examBoardId = null;

  }
  
  $userCreate = $userId;
  

  for($x=0; $x<$count; $x++) {

    $code = $_POST['topicCode_'.$x];
    $name = $_POST['topicName_'.$x];

    if($_POST['active_entry_'.$x] == "1") {

      $newRecordMessage = insertTopicsAllList($code, $name, $subjectId, $examBoardId, $rootTopic, $parentId, $generalTopic, $levelId, null, $userCreate);

      //var_dump($code, $name, $subjectId, $examBoardId, $rootTopic, $parentId, $generalTopic, $levelId, $levelsArray, $userCreate);


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
  //$levelId = $_POST['levelId'];
  //$levelsArray = $_POST['levelsArray'];
  //$examBoardsArray = $_POST['examBoardsArray'];

  //Update Record:
  //$updateMessage = updateTopicsGeneralList($id, $code, $name, $subjectId, $levelsArray);

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
$examBoardId = null;
$root = null;
$rootTopic = $generalTopic = 0;
$code = null;
$parentId = null;
$parentCode = $general = $userCreate = null;

if(isset($_GET['subjectId'])) {
  $subjectId = $_GET['subjectId'];
}
if(isset($_GET['levelId'])) {
  $levelId = $_GET['levelId'];
}
if(isset($_POST['levelId'])) {
  $levelId = $_POST['levelId'];
}
if(!empty($_POST['examBoardId'])){
  $examBoardId = $_POST['examBoardId'];
}

if(!empty($_GET['rootTopic'])) {
  $rootTopic = $_GET['rootTopic'];
}
if(!empty($_GET['generalTopic'])) {
  $generalTopic = $_GET['generalTopic'];
}


$topics = getTopicsAllList($topicId, $rootTopic, $examBoardId, $subjectId, $code, $parentId, $parentCode, $levelId, $topicName, $generalTopic, $userCreate);

$subjects = getOutputFromTable("subjects", null, "name");
$levels =  getOutputFromTable("subjects_level", null, "name");
$examBoards = getOutputFromTable("exam_boards", null, "name");

$levelsFilter = array();

foreach ($levels as $level) {
  $levelsFilter[$level['id']] = $level['name']; 
}

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
    if($newRecordMessage != "") {
      echo "<br><br>New Record:<br>";
      echo $newRecordMessage;
    }

    if($updateMessage != "") {
      echo "<br><br>Update:<br>";
      echo $updateMessage;
    }
    echo "<br><br>Subjects:<br>";
    print_r($subjects);
    echo "<br><br>Levels:<br>";
    print_r($levels);
    echo "<br><br>Exam Boards:<br>";
    print_r($examBoards);
    

    
  }
  echo count($topics);
  echo "<br>";
  //print_r($topics);




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
        <br>
        <label for = "levelId">Level: </label>
        <select id = "levelId" name="levelId">
        <?php
          foreach($levels as $key=>$level) {
            ?>
              <option value = "<?=$level['id']?>" <?=($level['id']==$levelId) ? "selected" : ""?>><?=$level['name']?></option>
            <?php
          }
          ?>
        </select>
        <br>
        <label for = "examBoardId">Exam Board: </label>
        <select id = "examBoardId" name="examBoardId">
        <?php
          foreach($examBoards as $key=>$level) {
            ?>
              <option value = "<?=$level['id']?>" <?=($level['id']==$examBoardId) ? "selected" : ""?>><?=$level['name']?></option>
            <?php
          }
          ?>
        </select>
        <br>
        <label for="rootTopic">Root Topic: </label>
        <input id = "rootTopic" type="checkbox" name = "rootTopic" value ="1">
        <br>
        <label for="generalTopic">General Topic: </label>
        <input id = "generalTopic" type="checkbox" name = "generalTopic" value ="1">


    </div>
    <table id="question_input_table" class="input_table w-full table-fixed">
      <tr>
        <th class = "w-1/5">Topic Code</th>
        <th class = "w-1/5">Topic Name</th>
        <th class = "w-1/5">Remove</th>
        
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
        <br>
        <label for="rootTopicGet">Root Topic: </label>
        <input id = "rootTopicGet" type="checkbox" name = "rootTopic" value ="1" <?=($rootTopic == 1) ? "checked" : ""?>>
        <br>
        <label for="generalTopicGet">General Topic: </label>
        <input id = "generalTopicGet" type="checkbox" name = "generalTopic" value ="1" <?=($generalTopic == 1) ? "checked" : ""?>>

      
      
      <span class="<?=is_null($showFlashCards)?"hidden":""?>">
        <input id="flashcard_select" type="checkbox" name="flashCard" value="1" <?=(isset($_GET['flashCard'])) ? "checked":""?>>
        <label for="flashcard_select">FlashCards Only</label>
      </span>

      <br>
      <input class="bg-pink-200 px-2" type="submit" value="Choose Topic">
      <div class="hidden">
        <input type="checkbox" value="1" name="noFlashCard" <?=is_null($showFlashCards)?"checked":""?>>
        <input type="checkbox" value="1" name="noAssetInput" <?=is_null($showAssetId)?"checked":""?>>
      </div>
      
    </div>

  </form>


  <?php 

  $subjectsLevel = getSubjects_Level();
  $subjectsLevelKey = array();
  foreach ($subjectsLevel as $level) {
    $subjectsLevelKey[$level['id']] = $level['name'];
  }

  
  if(isset($subjectId)) {
    ?>
    
    <table class="input_table table-fixed w-full">
        <tr>
          <th class="w-1/6">Topic</th>	
          <th class="w-1/6">Level</th>
          <th class="w-1/6">Edit</th>

        </tr>
      
        <?php
        
      foreach ($topics as $row) {
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
              <?=htmlspecialchars($row['code']);?> 
              <?=htmlspecialchars($row['name'])?> 
            </div>
            <div class="hide hide_<?=$row['id'];?>">

              <input type="text" name ="code" value ="<?=htmlspecialchars($row['code'])?>"></input>
              <textarea name="name"><?=$row['name']?></textarea>
            </div>
            <p>
              <i>id: <?=$row['id'];?></i>
            </p>
          </td>

          <td class="align-top">
            <div class="show_<?=$row['id'];?>">
              <p>
                <?php
                  echo $subjectsLevelKey[$row['levelId']];
                ?>
              </p>
              <p>
                <?php
                  echo getSubjectInfo($row['subjectId'])['subjectName'];
                ?>
              </p>
            </div>
            <div class= "hide hide_<?=$row['id'];?>">
              <select name="levelId">
                <?php
                foreach ($levels as $subject) {
                  ?>
                  <option value ="<?=$subject['id']?>" <?=($subject['id'] == $row['subjectId']) ? "selected" : ""?>><?=$subject['name']?></option>
                  <?php
                }

                ?>
              </select>

            </div>
              
            <?php
            if(isset($_GET['test'])) {
              print_r($row);
            }
            ?>
          </td>


          <td class="align-top">
            <?php if($userEdit) {?>
              <div>
                <button type ="button" class= "w-full bg-pink-300 rounded border border-black mb-1" id = "button_<?=$row['id'];?>" onclick = "changeVisibility(this, <?=$row['id'];?>); levelsAggregate('<?=$row['id']?>')">Edit</button>
              </div>
              <div class ="hidden hide_<?=$row['id'];?>">
                <input type="hidden" name = "id" value = "<?=$row['id'];?>">
                <br><label>SubjectId:</label><br>
                <input type="" name = "subjectId" value = "<?=$row['subjectId'];?>">


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
  //var cell3 = row.insertCell(3);

  cell0.classList.add("align-top");
  cell1.classList.add("align-top");
  cell2.classList.add("align-top");
  //cell3.classList.add("align-top");

  
  var inst = tableLength -1;


  cell0.innerHTML += '<label for="topicCode_'+inst+'">Code:</label><br><input type="text" id ="topicCode_'+inst+'" name="topicCode_'+inst+'" class="w-full " required><br>';
  
  cell1.innerHTML += '<label for="topicName'+inst+'">Topic Name:</label><br><textarea class="" type="text" id ="topicName'+inst+'" name="topicName_'+inst+'"></textarea><br>';


  

  cell2.innerHTML = "<button class='w-full bg-pink-300 rounded border border-black mb-1' type ='button' onclick='hideRow(this);'>Remove</button>"
  cell2.innerHTML += "<input name='active_entry_"+inst+"' class='w-full' type='hidden' value='1'>";

  


  
  document.getElementById("questionsCount").value = tableLength;


  


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
/*
function disableInputProperties() {
  var inputProperties = document.getElementsByClassName("inputProperties");
  console.log(inputProperties)

  Array.from(inputProperties).forEach((input) => 
  { //input.setAttribute('disabled', 'true')
    input.style.pointerEvents = "none";
    input.style.background = "#F5F5F5";
  })

}
*/
/*
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
*/
selectInputs("new_question_post_form");


function levelsAggregate(inst) {

  var topicsInput = document.getElementsByClassName("levelSelector_"+inst);
  var topicsInputChecked = [];
  var topicString = "";
  var checkedCount = 0;
  const topicSelect = document.getElementById("levelSelect_"+inst);

  console.clear();
  console.log(topicsInput);

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

function boardsAggregate(inst) {

  var topicsInput = document.getElementsByClassName("boardSelector_"+inst);
  var topicsInputChecked = [];
  var topicString = "";
  var checkedCount = 0;
  const topicSelect = document.getElementById("boardSelect_"+inst);

  console.clear();
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