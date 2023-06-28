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

?>

<!DOCTYPE html>

<html>

<head>

<?php include "../header.php";


?>

<style>

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



</style>

</head>


<body>

<?php include "../navbar.php"; ?>


<?php 



if (isset($_POST['submit'])) {

  //Create new question in saq_question_bank_3:
  
  $count = $_POST['questionsCount'];
  for($x=0; $x<$count; $x++) {

    $topic = $_POST['topic_'.$x];
    $question = $_POST['question_'.$x];
    $points = $_POST['points_'.$x];
    $type = $_POST['type_'.$x];
    //$image = $_POST['image_'.$x];
    $model_answer = $_POST['model_answer_'.$x];
    $userCreate = $_SESSION['userid'];
    $subjectId = $_POST['subjectId'];
    $levelId = 1;
    //$answer_img = $_POST['image_ans_'.$x];
    //$answer_img_alt = $_POST['image_ans_alt_'.$x];
    $topic_order = $_POST['topic_order_'.$x];
    $timeAdded = date("Y-m-d H:i:s");
    $questionAsset = $_POST['questionAsset_'.$x];

    if($_POST['questionAsset_'.$x] == "") {
      $questionAsset = null;
    }
    $answerAsset = $_POST['answerAsset_'.$x];
    if($_POST['answerAsset_'.$x] == "") {
      $answerAsset = null;
    }
    $flashCard = 0;
    if(isset($_POST['flashCard_'.$x])) {
      $flashCard = $_POST['flashCard_'.$x];
    }

    if($_POST['active_entry_'.$x] == "1") {

      insertSAQQuestion($topic, $question, $points, $type, "", $model_answer, $userCreate, $subjectId, "", "", $timeAdded, $questionAsset, $answerAsset, $flashCard, $topic_order, $levelId);
      
      //Update topic_order for new Entry:
      changeOrderNumberWithinTopic("saq_question_bank_3", null, $topic, $topic_order);

      echo "Record $question inserted<br>";
    }

    //echo "New records created successfully";

  }

  
 
}

if(isset($_POST['updateValue'])) {

  $flashCard = 0;
  if(isset($_POST['flashCard'])) {
    $flashCard = $_POST['flashCard'];
  }

  //Update Record:
  updateSAQQuestion($_POST['id'], $userId, $_POST['question'], $_POST['topic'], $_POST['points'], $_POST['type'], "", $_POST['model_answer'], "", "", $_POST['questionAsset'], $_POST['answerAsset'], $flashCard);

  //Change order value:
  changeOrderNumberWithinTopic("saq_question_bank_3", $_POST['id'], $_POST['topic'], $_POST['topic_order']);

}


$topicGet = $_GET['topic'];
$flashCard = null;
$subjectId = null;
$userCreate = null;
$type = null;

if(isset($_GET['type'])) {
  $type = $_GET['type'];
}
if(isset($_GET['flashCard'])) {
  $flashCard = 1;
}

$questions = getSAQQuestions(null, $topicGet, $flashCard, $subjectId, $userCreate, $type);

$questionTopicCount = 0;
if(isset($_GET['topic'])) {
  $questionTopicCount = SAQQuestionTopicCount($_GET['topic']);
}

$subjects = getOutputFromTable("subjects", null, "name");


$levels =  getOutputFromTable("subjects_level", null, "name");


?>




<h1>Short Answer Question List</h1>

<?php

  if(isset($_GET['test'])) {
    /*
    $resultsbyTopic = sortWithinTopic("saq_question_bank_3", 77, $_GET['topic'], null);
    echo "<pre>";
    print_r($resultsbyTopic);
    echo "</pre>";
    */

    if($_SERVER['REQUEST_METHOD']==='POST') {
      var_dump($_POST);
    }

    echo "<br>Subjects: ";
    print_r($subjects);
    echo "<br>Levels: ";
    print_r($levels);
    
  }

?>

  <h2>Question Entry</h2>
  <p>Use the form below to enter questions.</p>
  <form method="post">
    <table id="question_input_table">
      <tr>
        <th>Topic</th>
        <th>Question</th>
        <th>Model Answer/Mark Scheme</th>
        <th>Remove</th>
      </tr>
    </table>

    <p>
      <label for ="subjectSelect">Subject Select:</label>

      <select id="subjectSelect" name = "subjectId">
        <?php
          foreach ($subjects as $subject) {
              ?>
              <option value="<?=$subject['id'];?>" <?php
                if(isset($_POST['subjectId'])) {
                  if($subject['id'] == $_POST['subjectId']) {
                    echo "selected";
                  }
                  
                }
                //Until userpreferences are updated, use  Economics as default:
                else if ($subject['id'] == 1) {
                  echo "selected";
                }              
              ?> > <?=htmlspecialchars($subject['name']);?></option>
          <?php
          }
          ?>
      </select>
      <select id="levelSelect" name = "levelId">
        <?php
          foreach ($levels as $subject) {
              ?>
              <option value="<?=$subject['id'];?>" <?php
                if(isset($_POST['levelId'])) {
                  if($subject['id'] == $_POST['levelId']) {
                    echo "selected";
                  }
                  
                }
                //Until userpreferences are updated, use  AL as default:
                else if ($subject['id'] == 1) {
                  echo "selected";
                }              
              ?> > <?=htmlspecialchars($subject['name']);?></option>
          <?php
          }
          ?>
      </select>
    </p>
    <p>
      <button type="button" onclick="addRow()">Add Row</button>
    </p>
    <p>
      <input type="submit" name="submit" value="Create Question"></input>
    </p>
    <input type="hidden" name="questionsCount" id="questionsCount">
  </form>
  
  
  <h2>Database</h2>
  <p>Search for questions by topic:</p>
  <form method="get">
    <p>
      <select id="select" name="topic" ></select>
      <input type="submit" value="Choose Topic">
    </p>
  </form>
  <p>
  <?php 
  if(isset($_GET['topic'])) {
    ?>
    
    <table>
        <tr>
          <th>Topic</th>	
          <th>Question</th>
          <th>Model Answer/Mark Scheme</th>
          <th>Edit</th>
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
        
          <td class="col2">
            <div class="show_<?=$row['id'];?>">
              <?=htmlspecialchars($row['topic']);?><br>
              <?= (/*$row['topic_order']  != "0" ? */htmlspecialchars($row['topic_order']) /*: ""*/)?>
              <?//=htmlspecialchars($row['topic_order'])?>
            </div>
            <div class="hide hide_<?=$row['id'];?>">
              <input type="text" name ="topic" value ="<?=htmlspecialchars($row['topic'])?>" style="width:100px;"></input>
              <input type="text" name ="topic_order" value ="<?=htmlspecialchars($row['topic_order'])?>" style="width:100px;"></input>
            </div>
            <p>
              <i>id: <?=$row['id'];?></i>
            </p>
          </td>
          <td class="col3">
            <div class="show_<?=$row['id'];?>">
              <?=htmlspecialchars($row['question']);?>
              <?php
                    if(!is_null($row['q_path'])) {
                      ?>
                      <img class = "mx-auto my-1 max-h-80" src= "<?=htmlspecialchars($row['q_path'])?>" alt = "<?=htmlspecialchars($row['q_alt'])?>">
                      <?php
                    }
                    ?>
              <p>
                Points: <?=$row['points']?>
              </p>
              <?php
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
              <textarea name ="question"><?=htmlspecialchars($row['question'])?></textarea>
              <br>
              <label for="qA_<?=$row['id'];?>">Question Asset Id:</label><br>
              <input id="qA_<?=$row['id'];?>" type="number" name="questionAsset" value="<?=$row['questionAssetId']?>">
              <br>
              <label for = "points_<?=$row['id'];?>" >Points:</label>
              <input id="points_<?=$row['id'];?>" name ="points" type="number" value="<?=$row['points']?>"</input>
              <br>
              <label for = "keyword<?=$row['id'];?>" >Keywords:</label>
              <textarea id="keyword<?=$row['id'];?>" name ="type" type="text" ><?=$row['type']?></textarea>
            </div>
            <input id="flashCard_Update_<?=$row['id'];?>" type="checkbox" name ="flashCard" value="1" <?=($row['flashCard']==1) ? "checked" : ""?> disabled>
              <label for="flashCard_Update_<?=$row['id'];?>">flashCard</label>
          </td>

          <td class="col7">
            <div class="show_<?=$row['id'];?>" >
              <div style="white-space: pre-line;">
                <?=htmlspecialchars($row['model_answer']);?>
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
              <label for = "model_answer<?=$row['id'];?>">Model Answer:</label>
              <textarea id = "model_answer<?=$row['id'];?>" name ="model_answer"><?=htmlspecialchars($row['model_answer'])?></textarea>
              <br>
              <label for ="asset_id<?=$row['id'];?>">Asset ID:</label>
              <input id="asset_id<?=$row['id'];?>" type="number" name="answerAsset" value="<?=$row['answerAssetId']?>">
            </div>
              
          </td>

          <td>
            <?php if($userEdit) {?>
              <div>
                <button type ="button" id = "button_<?=$row['id'];?>" onclick = "changeVisibility(this, <?=$row['id'];?>); flashcardButtonToggle(this)">Edit</button>
              </div>
              <div class ="hide hide_<?=$row['id'];?>">
                <input type="hidden" name = "id" value = "<?=$row['id'];?>">

                <input type="submit" name="updateValue" value = "Update"></input>
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


include "../footer.php";
?>

<script>

var topics = ["1.1.1","1.1.2","1.1.3","1.2.1","1.2.2","1.2.3","1.2.4","1.3.1","1.3.2","1.4.1","1.5.1","1.5.2","1.5.3","1.6.1","1.6.2","1.6.3","1.6.4","1.6.5","1.6.6","1.6.7","1.6.8","1.7.1","1.7.2","1.7.3","2.1.1","2.1.2","2.1.3","2.1.4","2.1.5","2.1.6","2.1.7","2.1.8","2.1.9","2.2.1","2.2.2","2.2.3","2.2.4","2.2.5","2.2.6","2.3.1","2.3.2","2.3.3","2.3.4","2.3.5","3.1.1","3.2.1","3.3.1","3.3.2","3.3.3"];

var questionCount = <?=$questionTopicCount?>;

addRow();
topicList();
//topicList2();

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
  console.log(checkbox);
}

function topicList() {
	var select = document.getElementById("select");
	
	for(var i=0; i<topics.length; i++) {
		
		var option = document.createElement("option");
		option.setAttribute("value", topics[i]);
		option.innerHTML = topics[i];
		
		if (option.innerHTML == "<?php if(isset($_GET['topic'])) { echo $_GET['topic']; }?>") {
			option.selected = true;
			
		} 
		select.appendChild(option);
		
		
	}
	
}

function topicList2() {
	var select = document.getElementById("topic");
	
	for(var i=0; i<topics.length; i++) {
		
		var option = document.createElement("option");
		option.setAttribute("value", topics[i]);
		option.innerHTML = topics[i];
		
		if (option.innerHTML == "<?php if(isset($_GET['topic'])) { echo $_GET['topic']; }?>") {
			option.selected = true;
			
		} 
		select.appendChild(option);
		
		
	}
	
}


function topicListAmend(i) {
  
  var select = document.getElementById("topic_"+i);
  

  for(var j=0; j<topics.length; j++) {
		
		var option = document.createElement("option");
		option.setAttribute("value", topics[j]);
		option.innerHTML = topics[j];
		
    if(i==0) {
      if (option.innerHTML == "<?php if(isset($_GET['topic'])) { echo $_GET['topic']; }?>") {
        option.selected = true;
      }
    } else {
      var prevSelect = document.getElementById("topic_"+(i-1)).value;
      console.log(prevSelect);
      if (option.innerHTML == prevSelect) {
        option.selected = true;
      }
    }
    

		select.appendChild(option);
		
		
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
  var cell3 = row.insertCell(3);

  
  var inst = tableLength -1;

  cell0.innerHTML = '<label for="topic_'+inst+'">Topic:</label><select id ="topic_'+inst+'" name="topic_'+inst+'" class="topicSelector"></select><br><label for="topic_order_'+inst+'">Topic Order:</label><input style="width:50px" type="number" step="1" name="topic_order_'+inst+'" id="topic_order_'+inst+'" value = "'+questionCount+'" onchange="changeOrder(this)"></input>';
  
  cell1.innerHTML = '<label for="question_'+inst+'">Question:</label><br><textarea type="text" id ="question_'+inst+'" name="question_'+inst+'" ></textarea><br><label for="qusetionAsset_'+inst+'">Question Asset:</label><br><input type="number" step="1" id ="qusetionAsset_'+inst+'" name="questionAsset_'+inst+'"><br><label for="points_'+inst+'">Points:</label><input type="number" id ="points_'+inst+'" name="points_'+inst+'"></input><br><label for="type_'+inst+'">Keywords/Type:</label><input type="text" id ="type_'+inst+'" name="type_'+inst+'"></input><br><input type= "checkbox" id="flashCardInput_'+inst+'" value="1" name = "flashCard_'+inst+'"><label for="flashCardInput_'+inst+'">flashCard</label>';
  
  cell2.innerHTML = '<p>→</p><label for="model_answer_'+inst+'">Model Answer/Mark Scheme:</label><br><textarea type="text" id ="model_answer_'+inst+'" name="model_answer_'+inst+'"></textarea><br><label for="answerAsset_'+inst+'">Answer Asset:</label><br><input type="text" id ="answerAsset_'+inst+'" name="answerAsset_'+inst+'">';

  

  cell3.innerHTML = "<button class='w-full bg-pink-300 rounded border border-black mb-1' type ='button' onclick='hideRow(this);'>Remove</button>"
  cell3.innerHTML += "<input name='active_entry_"+inst+"' class='w-full' type='hidden' value='1'>";

  
  topicListAmend(inst);
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

</script>

</body>




</html>