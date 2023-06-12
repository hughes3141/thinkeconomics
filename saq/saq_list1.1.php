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
  $userType = $userInfo['usertype'];
  if (!($userType == "teacher" || $userType =="admin")) {
    header("location: /index.php");
  }
}



function getQuestionData($questionId) {
  global $conn;
  $stmt = $conn->prepare("SELECT * FROM saq_question_bank_3 WHERE id = ?");
  $stmt->bind_param("i", $questionId);
  $stmt->execute();
  $result=$stmt->get_result();
  if($result->num_rows>0) {
    $row = $result->fetch_assoc();
    return $row;
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



//print_r($_SESSION);
print_r($_POST);
//print_r($_GET);
echo date("Y-m-d H:i:s");

$sql = "INSERT INTO saq_question_bank_3 
        (topic, question, points, type, img, model_answer, userCreate, subjectId, answer_img, answer_img_alt, topic_order, time_added, questionAssetId, answerAssetId) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param("ssisssisssssii", $topic, $question, $points, $type, $image, $model_answer, $userCreate, $subjectId, $answer_img, $answer_img_alt, $topic_order, $timeAdded, $questionAsset, $answerAsset);



if (isset($_POST['submit'])) {
  
  $count = $_POST['questionsCount'];
  for($x=0; $x<$count; $x++) {
    $topic = $_POST['topic_'.$x];
    $question = $_POST['question_'.$x];
    $points = $_POST['points_'.$x];
    $type = $_POST['type_'.$x];
    $image = $_POST['image_'.$x];
    $model_answer = $_POST['model_answer_'.$x];
    $userCreate = $_SESSION['userid'];
    $subjectId = $_POST['subjectId'];
    $answer_img = $_POST['image_ans_'.$x];
    $answer_img_alt = $_POST['image_ans_alt_'.$x];
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
  
    $stmt->execute();
    
    echo "New records created successfully";

  }
 
}

if(isset($_POST['updateValue'])) {

  sortWithinTopic("saq_question_bank_3", $_POST['id'], $_POST['topic'], $_POST['topic_order']);

  $sql = "UPDATE saq_question_bank_3 SET question = ?, topic = ?, points = ?, type = ?, img = ?, model_answer= ?, answer_img = ?, answer_img_alt = ?,  questionAssetId =?, answerAssetId = ? WHERE id = ?";
  
  $stmt = $conn->prepare($sql);
  //print_r($_POST);

  $questionAsset = $_POST['questionAsset'];
  if($_POST['questionAsset'] == "") {
    $questionAsset = null;
  }
  $answerAsset = $_POST['answerAsset'];
  if($_POST['answerAsset'] == "") {
    $answerAsset = null;
  }
  
  $stmt->bind_param("ssssssssiii", $_POST['question'], $_POST['topic'], $_POST['points'], $_POST['type'], $_POST['img'], $_POST['model_answer'], $_POST['answer_img'], $_POST['answer_img_alt'], $questionAsset, $answerAsset, $_POST['id']);

  $questionData = getQuestionData($_POST['id']);
  $questionDataUser = $questionData['userCreate'];

  if($questionDataUser == $_SESSION['userid']) {
    $stmt->execute();
    //header("Refresh:0");
    echo "Record ".$_POST['id']." updated successfully.";
  }
  else {
    echo "Value not updated: userid does not match userCreate";
  }
}

?>




<h1>Short Answer Question List</h1>

<?php
if($_SERVER['REQUEST_METHOD']==='POST') {
  print_r($_POST);
}

if(isset($_GET['test'])) {
  /*
  $resultsbyTopic = sortWithinTopic("saq_question_bank_3", 77, $_GET['topic'], null);
  echo "<pre>";
  print_r($resultsbyTopic);
  echo "</pre>";
  */
  
}

?>





  
  <h2>Question Entry</h2>
  <p>Use the form below to enter questions.</p>
  <form method="post">
    <table id="question_input_table">
    <tr>
      <th>Topic</th>

      <th>img src</th>
      <th>Points</th>
      <th>Type</th>
      <th>Model Answer/Mark Scheme</th>
    
    </tr>

    </table>

    <p>
      <label for ="subjectSelect">Subject Select:</label>
      <select id="subjectSelect" name = "subjectId">
        <?php
        
          $sql = "SELECT * FROM subjects";
          $stmt=$conn->prepare($sql);
          //$stmt->bind_param();
          $stmt->execute();
          $result = $stmt->get_result();

          if($result->num_rows>0) {
            while($row = $result->fetch_assoc()) {
              ?>
              <option value="<?=$row['id'];?>" <?php
                if(isset($_POST['subjectId'])) {
                  if($row['id'] == $_POST['subjectId']) {
                    echo "selected";
                  }
                }              
              ?> ><?=htmlspecialchars($row['level']);?> <?=htmlspecialchars($row['name']);?></option>
              <?php
            }
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
    <select id="select" name="topic" >
    </select>
    
    <input type="submit" value="Choose Topic">
  </p>
  </form>
  
  
  <p>
  <?php 
  if(isset($_GET['topic'])) {
    
    ?>
    
    <table>
    <tr>
    <th>ID</th>
    <th>Topic<br>Topic Order</th>	

    <th>Question</th>
    <th>img src</th>
    <th>Points</th>
    <th>Type</th>
    <th>Model Answer/Mark Scheme</th>

    </tr>

    <?php
    
  


  $topicGet = $_GET['topic'];
  $sql = "SELECT * FROM saq_question_bank_3 WHERE Topic= ? ORDER BY case when topic_order = 0 then 1 else 0 end, topic_order ASC";

  $sql = "SELECT * 
          FROM saq_question_bank_3 
          WHERE Topic= ? 
          ORDER BY topic_order";


  $stmt = $conn->prepare($sql);

  $stmt->bind_param("s", $topicGet);

  if(isset($_GET['type'])) {
    $sql = "SELECT * FROM saq_question_bank_3 WHERE Topic= ? AND type LIKE ? ORDER BY case when topic_order is null then 1 else 0 end, topic_order ASC";
    $sql = "SELECT * FROM saq_question_bank_3
            WHERE Topic= ? 
            AND type LIKE ? 
            ORDER BY topic_order";
    $stmt = $conn->prepare($sql);
    $typeSql = "%".$_GET['type']."%";
    $stmt->bind_param("ss", $topicGet, $typeSql);

  }

  $stmt -> execute();
  $result = $stmt->get_result();

  //$_SESSION['userid'] = 2;

  if ($result) {
    
    while ($row = $result->fetch_assoc()) {

      //print_r($row);

      ?>
      
      <tr id = 'row_<?=$row['id'];?>'>
    <?php if($_SESSION['userid'] == $row['userCreate']) {?>
      <form method="post" action="">
    <?php }?>
      
        <td class="col1">
          <div>
            <?=htmlspecialchars($row['id']);?>
          </div>
          
        </td>
        <td class="col2">
          <div class="show_<?=$row['id'];?>">
            <?=htmlspecialchars($row['topic']);?><br>
            <?= (/*$row['topic_order']  != "0" ? */htmlspecialchars($row['topic_order']) /*: ""*/)?>
            <?//=htmlspecialchars($row['topic_order'])?>
          </div>
            <input type="text" class="hide hide_<?=$row['id'];?>" name ="topic" value ="<?=htmlspecialchars($row['topic'])?>" style="width:100px;"></input>
            <input type="text" class="hide hide_<?=$row['id'];?>" name ="topic_order" value ="<?=htmlspecialchars($row['topic_order'])?>" style="width:100px;"></input>
        </td>
        <td class="col3">
          <div class="show_<?=$row['id'];?>">
            <?=htmlspecialchars($row['question']);?>
          </div>
          <div class= "hide hide_<?=$row['id'];?>">
            <textarea class="hide hide_<?=$row['id'];?>" name ="question"><?=htmlspecialchars($row['question'])?></textarea>
            <br>
            <input type="number" name="questionAsset" value="<?=$row['questionAssetId']?>">
        </div>
        </td>
        <td class="col4">
          <div class="show_<?=$row['id'];?>">
            <?=htmlspecialchars($row['img']);?>
          </div>
            <textarea class="hide hide_<?=$row['id'];?>" name ="img"><?=htmlspecialchars($row['img'])?></textarea>
        </td>
        <td class="col5">
          <div class="show_<?=$row['id'];?>">
            <?=htmlspecialchars($row['points']);?>
          </div>
            <textarea class="hide hide_<?=$row['id'];?>" name ="points"><?=htmlspecialchars($row['points'])?></textarea>
        </td>
        <td class="col6">
          <div class="show_<?=$row['id'];?>">
            <?=htmlspecialchars($row['type']);?>
          </div>
            <textarea class="hide hide_<?=$row['id'];?>" name ="type"><?=htmlspecialchars($row['type'])?></textarea>
        </td>
        <td class="col7">
          <div class="show_<?=$row['id'];?>" style="white-space: pre-line;"><?=htmlspecialchars($row['model_answer']);?>
          </div>
          <div class="hide hide_<?=$row['id'];?>">
            <textarea name ="model_answer"><?=htmlspecialchars($row['model_answer'])?></textarea>
            <input type ="text" name ="answer_img" value = "<?=htmlspecialchars($row['answer_img'])?>"></input>  
            <input type ="text" name ="answer_img_alt" value = "<?=htmlspecialchars($row['answer_img_alt'])?>"></input>
            <br>
            <input type="number" name="answerAsset" value="<?=$row['answerAssetId']?>">
          </div>
            
        </td>

        <td>
          <?php if($_SESSION['userid'] == $row['userCreate']) {?>
            <div>
              <button type ="button" id = "button_<?=$row['id'];?>" onclick = "changeVisibility(this, <?=$row['id'];?>)"">Edit</button>
            </div>
            <div class ="hide hide_<?=$row['id'];?>">
              <input type="hidden" name = "id" value = "<?=$row['id'];?>">

              <input type="submit" name="updateValue" value = "Update"></input>
            </div>
          <?php }?>
          
        </td>
        <tr>
    <?php if($_SESSION['userid'] == $row['userCreate']) {?>
      </form>
    <?php }?>


      <?php
    
    
      }

          
    }

  ?>

  </table>
  </p>



  <?php

  }




include "../footer.php";
?>

<script>

var topics = ["1.1.1","1.1.2","1.1.3","1.2.1","1.2.2","1.2.3","1.2.4","1.3.1","1.3.2","1.4.1","1.5.1","1.5.2","1.5.3","1.6.1","1.6.2","1.6.3","1.6.4","1.6.5","1.6.6","1.6.7","1.6.8","1.7.1","1.7.2","1.7.3","2.1.1","2.1.2","2.1.3","2.1.4","2.1.5","2.1.6","2.1.7","2.1.8","2.1.9","2.2.1","2.2.2","2.2.3","2.2.4","2.2.5","2.2.6","2.3.1","2.3.2","2.3.3","2.3.4","2.3.5","3.1.1","3.2.1","3.3.1","3.3.2","3.3.3"]

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
  var cell4 = row.insertCell(4);
  //var cell5 = row.insertCell(5);
  
  var inst = tableLength -1;

  cell0.innerHTML = '<label for="topic_'+inst+'">Topic:</label><select id ="topic_'+inst+'" name="topic_'+inst+'" class="topicSelector"></select><br><label for="topic_order_'+inst+'">Topic Order:</label><input style="width:50px" type="number" step="0.1" name="topic_order_'+inst+'" id="topic_order_'+inst+'"></input>';
  
  cell1.innerHTML = '<label for="question_'+inst+'">Question:</label><br><textarea type="text" id ="question_'+inst+'" name="question_'+inst+'" required></textarea><br><label for="image_'+inst+'">Question img src:</label><br><input type="text" id ="image_'+inst+'" name="image_'+inst+'"></input><br><label for="qusetionAsset_'+inst+'">Question Asset:</label><br><input type="text" id ="qusetionAsset_'+inst+'" name="questionAsset_'+inst+'">';
  //cell2.innerHTML = '';
  cell2.innerHTML = '<label for="points_'+inst+'">Points:</label><input type="number" id ="points_'+inst+'" name="points_'+inst+'"></input>';
  cell3.innerHTML = '<label for="type_'+inst+'">Source:</label><input type="text" id ="type_'+inst+'" name="type_'+inst+'"></input>';
  cell4.innerHTML = '<p>→</p><label for="model_answer_'+inst+'">Model Answer/Mark Scheme:</label><br><textarea type="text" id ="model_answer_'+inst+'" name="model_answer_'+inst+'"></textarea><br><label for="image_ans_'+inst+'">Answer img src:</label><br><input type="text" id ="image_ans_'+inst+'" name="image_ans_'+inst+'"></input><br><label for="image_ans_alt'+inst+'">Answer img_alt:</label><br><input type="text" id ="image_ans_alt'+inst+'" name="image_ans_alt_'+inst+'"></input><br><label for="answerAsset_'+inst+'">Answer Asset:</label><br><input type="text" id ="answerAsset_'+inst+'" name="answerAsset_'+inst+'">';
  
  topicListAmend(inst);
  sourceAmend(inst)
  
  document.getElementById("questionsCount").value = tableLength;

  
}

</script>

</body>




</html>