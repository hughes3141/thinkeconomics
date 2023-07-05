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
  if (!($userType == "teacher" || $userType =="admin")) {
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

//Controls to remove elements e.g. flashCard controls:
/*
 *Set $showFlashCards to null to treat page as though flashcards to not exist, and all questions are input as a flashcard
 Set $showAssetId to null and user will not have the option of inserting asset Ids (to be used until it is sorted so that users can upload assets easily) 
 */

$showFlashCards = 1;
$showAssetId = 1;

if(isset($_GET['noFlashCard'])) {
  $showFlashCards = null; 
}
if(isset($_GET['noAssetInput'])) {
  $showAssetId = null;
}


//Set img path:

/**
 * images find the path set via $question['q_path'] etc.
 * This is assumed to be in root foler if thinkeonomics
 * If other site: udpate variable $imgSourcePathPrefix to 
 */

 $imgSourcePathPrefix = "";
 //$imgSourcePathPrefix = "https://www.thinkeconomics.co.uk";



//assetSubmit = "";



if (isset($_POST['submit'])) {

  //Create new question in saq_question_bank_3:
  
  $count = $_POST['questionsCount'];

  //$topic = $_POST['topic'];
  $topicId = $_POST['topicId'];

  $topic = getTopicsAllList($topicId)[0]['code'];


  $subjectId = $_POST['subjectId'];
  $levelId = $_POST['levelId'];
  $examBoardId = $_POST['examBoardId'];

  $userCreate = $_SESSION['userid'];
  $timeAdded = date("Y-m-d H:i:s");

  for($x=0; $x<$count; $x++) {

    //$topic = $_POST['topic_'.$x];
    $question = $_POST['question_'.$x];
    $points = $_POST['points_'.$x];
    $type = $_POST['type_'.$x];
    //$image = $_POST['image_'.$x];
    $model_answer = $_POST['model_answer_'.$x];
    //$answer_img = $_POST['image_ans_'.$x];
    //$answer_img_alt = $_POST['image_ans_alt_'.$x];
    $topic_order = $_POST['topic_order_'.$x];

    $questionAsset = $_POST['questionAsset_'.$x];
    $answerAsset = $_POST['answerAsset_'.$x];

    
    $flashCard = 0;
    if(isset($_POST['flashCard_'.$x])) {
      $flashCard = $_POST['flashCard_'.$x];
    }

    if($_POST['active_entry_'.$x] == "1") {

      //insertSAQQuestion($topic, $question, $points, $type, "", $model_answer, $userCreate, $subjectId, "", "", $timeAdded, $questionAsset, $answerAsset, $flashCard, $topic_order, $levelId, $topicId);
      
      //Update topic_order for new Entry:
      //changeOrderNumberWithinTopic(null, $topic, $topic_order, $subjectId, $levelId);

      //echo "Record $question inserted<br>";
    }

    //echo "New records created successfully";

  }

  
 
}


$updateMessage = "";

if(isset($_POST['updateValue'])) {

  $flashCard = 0;
  if(isset($_POST['flashCard'])) {
    $flashCard = $_POST['flashCard'];
  }


  $questionAsset = $_POST['questionAsset'];
  $answerAsset = $_POST['answerAsset'];

  $topicId = $_POST['topicId'];
  $topic = null;
  if(isset($_POST['topic'])) {
    $topic = $_POST['topic'];
  }

  

  //Update Record:
  $updateMessage = updateSAQQuestion($_POST['id'], $userId, $_POST['question'], $topic, $_POST['points'], $_POST['type'], "", $_POST['model_answer'], "", "", $questionAsset, $answerAsset, $flashCard, $topicId);

  //Change order value:
  //changeOrderNumberWithinTopic($_POST['id'], $_POST['topic'], $_POST['topic_order'], $_POST['subjectId'], $_POST['levelId'], $userId);

}






$topicGet = null;
if(isset($_GET['topic'])) {
  $topicGet = $_GET['topic'];
}

$flashCard = null;

$subjectId = null;
$levelId = null;
$examBoardId = null;
$topicId = null;



$userCreate = null;
$type = null;

$root = 1;



//$userPreferredSubject comes from a user's information.
if(isset($userInfo['userPreferredSubjectId'])) {
  $userPreferredSubject = $userInfo['userPreferredSubjectId'];
} else {
  $userPreferredSubject = 1;
}

if(isset($userInfo['userPreferredExamBoardId'])) {
  $userPreferredExamBoard = $userInfo['userPreferredExamBoardId'];
} else {
  $userPreferredExamBoard = 1;
}

$subjectId = $userPreferredSubject;
$examBoardId = $userPreferredExamBoard;

if(isset($_GET['type'])) {
  $type = $_GET['type'];
}
if(isset($_GET['flashCard'])) {
  $flashCard = 1;
}

if(isset($_GET['subjectId'])) {
  $subjectId = $_GET['subjectId'];
}
if(isset($_POST['subjectId'])) {
  $subjectId = $_POST['subjectId'];
}

if(isset($_GET['levelId'])) {
  $levelId = $_GET['levelId'];
}
if(isset($_POST['levelId'])) {
  $levelId = $_POST['levelId'];
}

if(isset($_GET['examBoardId'])) {
  $examBoardId = $_GET['examBoardId'];
  $root = 0;
}
if(isset($_POST['examBoardId'])) {
  $examBoardId = $_POST['examBoardId'];
  $root = 0;
}


if(isset($_GET['topicId'])) {
  $topicId = $_GET['topicId'];
}
if(isset($_POST['topicId'])) {
  $topicId = $_POST['topicId'];
}



if(isset($_GET['userCreate'])) {
  $userCreate = $_GET['userCreate'];
}



if(is_null($showFlashCards)) {
  $flashCard = 1;
}

$questions = getSAQQuestions(null, $topicGet, $flashCard, $subjectId, $userCreate, $type, $userId, $topicId);


//$questions = getSAQQuestions(null, null, null, null, null, null, null, null);

$questionTopicCount = 0;
if(isset($_GET['topic'])) {
  $questionTopicCount = SAQQuestionTopicCount($_GET['topic']);
}

$subjects = getOutputFromTable("subjects", null, "name");
$levels =  getOutputFromTable("subjects_level", null, "name");

$examBoards = getExamBoards();

//$topics = getTopicList("saq_question_bank_3", "topic", null, $flashCard, $userPreferredSubject);

//Use getColumnListFromTable becuase it returns only non-blank values:

//$subjectSelector is the subjectId that is either determined by (1) user preference or (2) $subjectId;

$subjectSelector = $userPreferredSubject;
$examBoardSelector = $userPreferredExamBoard;
$levelSelector = 1;
$topicSelector = null;

if(!is_null($subjectId)) {
  $subjectSelector = $subjectId;
}

if(!is_null($examBoardId)) {
  $examBoardSelector = $examBoardId;
}
if(!is_null($levelId)) {
  $levelSelector = $levelId;
}
if(!is_null($topicId)) {
  $topicSelector = $topicId;
}




//$topics = getColumnListFromTable("saq_question_bank_3", "topic", null, $subjectSelector, null, null, $flashCard);

$topics = getTopicsAllList(null, $root, $examBoardId, $subjectId);


include($path."/header_tailwind.php");
?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  <?php
  echo $updateMessage;
  ?>
<h1 class="font-mono text-2xl bg-pink-400 pl-1">Short Answer Questions List</h1>
<div class=" container mx-auto px-4 pb-4 mt-2 bg-white text-black mb-5">



<?php

  if(isset($_GET['test'])) {
    /*
    $resultsbyTopic = sortWithinTopic("saq_question_bank_3", 77, $_GET['topic'], null);
    echo "<pre>";
    print_r($resultsbyTopic);
    echo "</pre>";
    */

    if($_SERVER['REQUEST_METHOD']==='POST') {
      echo "POST:<br>";
      var_dump($_POST);
    }
    echo "<br><br>User Info:<br>";
    print_r($userInfo);
    echo "<br><br>Subjects:<br>";
    print_r($subjects);
    echo "<br><br>Levels:<br>";
    print_r($levels);
    echo "<br><br>Topics:<br>";
    echo count($topics)."<br>";
    print_r($topics);
    
  }

?>

  <h2 class="bg-pink-300 -ml-4 -mr-4 mb-5 text-xl font-mono pl-4 text-gray-800">Question Entry</h2>
  <p>Use the form below to enter questions.</p>
  <form method="post" id="new_question_post_form">
    <div class="my-2">
        <label for ="subjectSelect">Subject:</label>
        <select class="inputProperties" id="subjectSelect" name = "subjectId" onchange="changeInput(this, 'subjectSelectGet');">
          <?php
            foreach ($subjects as $subject) {
                ?>
                <option value="<?=$subject['id'];?>" <?=($subject['id'] == $subjectSelector) ? "selected" : ""?>> <?=htmlspecialchars($subject['name']);?></option>
            <?php
            }
            ?>
        </select>
        <select class="inputProperties" id="levelSelect" name = "levelId" onchange="changeInput(this, 'levelSelectGet');">
          <?php
            foreach ($levels as $subject) {
                ?>
                <option value="<?=$subject['id'];?>" <?=($subject['id'] == $levelSelector) ? "selected" : ""?> > <?=htmlspecialchars($subject['name']);?></option>
            <?php
            }
            ?>
        </select>


        <select class="inputProperties" id="boardSelect" name = "examBoardId" onchange="changeInput(this, 'examBoardSelectGet');"">
          <?php
            foreach ($examBoards as $subject) {
                ?>
                <option value="<?=$subject['id'];?>" <?=($subject['id'] == $examBoardSelector) ? "selected" : ""?> > <?=htmlspecialchars($subject['name']);?></option>
            <?php
            }
            ?>
        </select>
          <?php
          if(count($topics)>0) {
            ?>
            <label for="topic">Topic:</label>
            <select class="inputProperties w-20 " id ="topic" name="topicId" class="topicSelector" onchange="changeInput(this, 'topicGet');">
              <?php
                foreach ($topics as $topic) {
                  
                  $indent = "";
                  $disabled = "";
                  /*
                    if($topic['topicLevel'] =="0") {
                      //$disabled = 'disabled="disabled"';

                    } else if ($topic['topicLevel'] =="1") {
                      $indent = "&nbsp&nbsp";
                      $disabled = 'disabled="disabled"';
                    } else if ($topic['topicLevel'] =="2") {
                      $indent = "&nbsp&nbsp&nbsp&nbsp";
                    }
                    */
                  ?>
                  <option class="" value="<?=$topic['id']?>" <?=($topicSelector == $topic['id']) ? "selected":""?> <?=($topicGet == $topic['code']) ? "selected":""?> <?=$disabled?>><?=$topic['code']?> <?=$indent.$topic['name']?></option>
                  <?php
                }
              ?>
            </select>
          <?php
          }
          ?>

    </div>
    <table id="question_input_table" class="input_table w-full table-fixed">
      <tr>
        <th class = "w-2/5">Question</th>
        <th class = "w-2/5">Model Answer/Mark Scheme</th>
        <th class = "">Remove</th>
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
                <option value="<?=$subject['id'];?>" <?=($subject['id'] == $levelSelector) ? "selected" : ""?>><?=htmlspecialchars($subject['name']);?></option>
            <?php
            }
            ?>
        </select>

        <select id="examBoardSelectGet" name = "examBoardId">
        <?php
            foreach ($examBoards as $subject) {
                ?>
                <option value="<?=$subject['id'];?>" <?=($subject['id'] == $examBoardSelector) ? "selected" : ""?> > <?=htmlspecialchars($subject['name']);?></option>
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
              /*
                if($topic['topicLevel'] =="0") {
                  $disabled = 'disabled="disabled"';

                } else if ($topic['topicLevel'] =="1") {
                  $indent = "&nbsp&nbsp";
                  $disabled = 'disabled="disabled"';
                } else if ($topic['topicLevel'] =="2") {
                  $indent = "&nbsp&nbsp&nbsp&nbsp";
                }
                */
              ?>
              <option class="" value="<?=$topic['id']?>" <?=($topicPostSelect == $topic['id']) ? "selected":""?> <?=($topicGet == $topic['code']) ? "selected":""?> <?=$disabled?>><?=$topic['code']?> <?=$indent.$topic['name']?></option>
              <?php
            }
          ?>
      </select>
      <div class="<?=is_null($showFlashCards)?"hidden":""?>">
        <input id="flashcard_select" type="checkbox" name="flashCard" value="1" <?=(isset($_GET['flashCard'])) ? "checked":""?>>
        <label for="flashcard_select">FlashCards Only</label>
      </div>


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
                      <img class = "mx-auto my-1 max-h-80" src= "<?=$imgSourcePathPrefix.htmlspecialchars($row['q_path'])?>" alt = "<?=htmlspecialchars($row['q_alt'])?>">
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
                      <img class = "mx-auto my-1 max-h-80" src= "<?=$imgSourcePathPrefix.htmlspecialchars($row['a_path'])?>" alt = "<?=htmlspecialchars($row['a_alt'])?>">
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


var questionCount = <?=$questionTopicCount?>;

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


  cell1.classList.add("align-top");
  cell2.classList.add("align-top");
  //cell3.classList.add("align-top");

  
  var inst = tableLength -1;


  
  
  
  cell0.innerHTML += '<label for="question_'+inst+'">Question:</label><br><textarea type="text" id ="question_'+inst+'" name="question_'+inst+'" class="w-full h-44" required></textarea><br>';
  
  cell0.innerHTML += '<div class="<?=is_null($showAssetId)?"hidden":""?>"><label for="qusetionAsset_'+inst+'">Question Asset:</label><br><input class= "w-1/2"type="number" step="1" id ="qusetionAsset_'+inst+'" name="questionAsset_'+inst+'"><br></div>';

  cell0.innerHTML += '<label for="points_'+inst+'">Points:<br></label><input  type="number" id ="points_'+inst+'" name="points_'+inst+'"></input><br><label for="type_'+inst+'">Keywords/Type:</label><input type="text" id ="type_'+inst+'" name="type_'+inst+'"></input><br>';

  cell0.innerHTML += '<div <?=is_null($showFlashCards)?'class="hidden"':""?>><input class = "w-4" type= "checkbox" id="flashCardInput_'+inst+'" value="1" name = "flashCard_'+inst+'" <?=is_null($showFlashCards)?'checked':""?>><label for="flashCardInput_'+inst+'">flashCard</label><br></div>';

  cell0.innerHTML += '<label for="topic_order_'+inst+'">Topic Order:</label><br><input class=" p-1" type="number" step="1" name="topic_order_'+inst+'" id="topic_order_'+inst+'" value = "'+questionCount+'" onchange="changeOrder(this)"></input>';
  
  cell1.innerHTML = '<label for="model_answer_'+inst+'">Model Answer/Mark Scheme:</label><br><textarea class="h-36" type="text" id ="model_answer_'+inst+'" name="model_answer_'+inst+'"></textarea><br><button class="w-1/4 block rounded border border-black bg-pink-200 mt-2 p-0" type="button" onclick="arrowAdd('+inst+');">→</button>';
  
  cell1.innerHTML += '<div class="<?=is_null($showAssetId)?"hidden":""?>"><label for="answerAsset_'+inst+'">Answer Asset:</label><br><input type="number" id ="answerAsset_'+inst+'" name="answerAsset_'+inst+'"></div>';


  cell2.innerHTML = "<button class='w-full bg-pink-300 rounded border border-black mb-1' type ='button' onclick='hideRow(this);'>Remove</button>"
  cell2.innerHTML += "<input name='active_entry_"+inst+"' class='w-full' type='hidden' value='1'>";

  

  sourceAmend(inst)
  
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

function changeExamBoard(input) {
  var topicChangeForm = document.getElementById("database_get_form");
  var changeTo = input.value;
  var topicChangeSelect = document.getElementById("examBoardSelectGet");
  //console.log(topicChangeSelect);
  //console.log(changeTo);
  topicChangeSelect.value=changeTo;
  topicChangeForm.submit();
}

function changeInput(input, getSelectElement) {
  var topicChangeForm = document.getElementById("database_get_form");
  var changeTo = input.value;
  var topicChangeSelect = document.getElementById(getSelectElement);
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

</script>

<?php   include($path."/footer_tailwind.php");?>