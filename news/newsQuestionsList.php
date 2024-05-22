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

  th, td {  

  border: 1px solid black;
  padding: 5px;

  }

  table {
    
    border-collapse: collapse;
    table-layout: fixed;
    width: 100%;
    
  }";

$updateMessage = "";
$updateArray = array();

if($_SERVER['REQUEST_METHOD']=='POST') {

  if($_POST['submit'] == "Create Question") {
    $count = $_POST['questionsCount'];
    $userCreate = $_SESSION['userid'];

    for($x=0; $x<$count; $x++) {
      $question = $_POST['question_'.$x];
      $model_answer = $_POST['model_answer_'.$x];
      $questionAsset = $_POST['questionAsset_'.$x];
      $answerAsset = $_POST['answerAsset_'.$x];
      

      if($_POST['active_entry_'.$x] == "1") {
        insertNewsQuestion($question, $questionAsset, $model_answer, $answerAsset, $userCreate, $_POST['topic'], $_POST['articleId']);
      }
      
    }

  }

  if($_POST['submit'] == "Update") {
    $updateMessage = updateNewsQuestion($_POST['id'], $userId, $_POST['question'], $_POST['questionAssetId'], $_POST['model_answer'], $_POST['answerAssetId'], $_POST['topic'], $_POST['articleId']);

    //$updateMessage = updateNewsQuestion($_POST['id'], $userId, $_POST['question']);
  }

}



$get_selectors = array(
  'id' => (isset($_GET['id']) && $_GET['id'] != "") ? $_GET['id'] : null,
  'topic' => (isset($_GET['topic']) && $_GET['topic'] != "") ? $_GET['topic'] : null,
  'keyword' => (isset($_GET['keyword']) && $_GET['keyword'] != "") ? $_GET['keyword'] : null,
  'startDate' => (isset($_GET['startDate']) && $_GET['startDate'] != "") ? $_GET['startDate'] : null,
  'endDate' => (isset($_GET['endDate']) && $_GET['endDate'] != "") ? $_GET['endDate'] : null,
  'orderBy' => (isset($_GET['orderBy']) && $_GET['orderBy'] != "") ? $_GET['orderBy'] : null,
  'limit' => (isset($_GET['limit']) && $_GET['limit'] != "") ? $_GET['limit'] : 100,
  'searchFor' => (isset($_GET['searchFor']) && $_GET['searchFor'] != "") ? $_GET['searchFor'] : "",
  'noSearch' => (isset($_GET['noSearch']) ) ? 1 : null,
  'link' => (isset($_GET['link']) && $_GET['link'] != "") ? $_GET['link'] : "",
  'searchBar' => (isset($_GET['searchBar']) ) ? 1 : null,
  'video' => (isset($_GET['video'])) ? 1 : null,
  'audio' => (isset($_GET['audio'])) ? 1 : null

);

$questions = array();

$questions = getNewsQuestion();



include($path."/header_tailwind.php");
?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">News Questions List</h1>
  <div class=" container mx-auto px-4 pb-4 mt-2 bg-white text-black mb-5">
    <?php
    //print_r($_POST);
    //print_r($updateArray);
    echo $updateMessage;
    $imgSource = "https://www.thinkeconomics.co.uk";
    ?>
    <div>
      <form method="post" action ="">
        <div>
          <label for="topicInput">Topic: </label>
          <input id="topicInput" type="text" name="topic">

          <label for="articleIdInput">Article Id: </label>
          <input id="articleIdInput" type="number" name="articleId">
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
          <button class="w-full bg-pink-300 rounded border border-black mb-1">Create Question</button>
        </p>
        <input type="hidden" name="questionsCount" id="questionsCount">
        <input class="w-full bg-pink-300 rounded border border-black mb-1" type="hidden" name="submit" value="Create Question">
      </form>
    </div>
    <div>
      <table>
        <tr>
          <th>Question</th>
          <th>Answer</th>
          <th class="w-1/6">Edit</th>
        </tr>
        <?php
          foreach($questions as $question) {
            $questionAssets = explode(",",$question['questionAssetId']);
            foreach ($questionAssets as $key => $asset) { 
              $questionAssets[$key] = trim($asset);
            }
            $answerAssets = explode(",",$question['answerAssetId']);
            foreach ($answerAssets as $key => $asset) { 
              $answerAssets[$key] = trim($asset);
            }
            ?>
            <tr>
              <form method="post" action="">
                <td>
                  <?php
                    //print_r($question);
                  ?>
                  <p><?=$question['id']?></p>
                  <div class="toggleClass_<?=$question['id']?>">
                    <p class="whitespace-pre-wrap">Question: <?=$question['question']?></p>
                    <p><?php
                      if($question['questionAssetId']!="") {
                        foreach($questionAssets as $asset) {
                          //echo $asset;
                          $img = getUploadsInfo($asset)[0];
                          ?>
                          <img alt ="<?=$img['altText']?>" src="<?=$imgSource.$img['path']?>">
                          <?php
                        }
                      }
                      ?>
                    </p>
                    <p><?=$question['topic']?></p>
                    <p><?=$question['articleId']?></p>
                  </div>
                  <div class="hidden toggleClass_<?=$question['id']?>">
                      <label for="questionInput_<?=$question['id']?>"></label>
                      <textarea class="w-full" id="questionInput_<?=$question['id']?>" name="question"><?=$question['question']?></textarea>

                      <label for="quesetionAssetIdInput_<?=$question['id']?>"></label>
                      <input type="text" id="quesetionAssetIdInput_<?=$question['id']?>" name="questionAssetId" value="<?=$question['questionAssetId']?>">

                      <label for="topicInput_<?=$question['id']?>"></label>
                      <input type="text" id="topicInput_<?=$question['id']?>" name="topic" value="<?=$question['topic']?>">

                      <label for="articleIdInput_<?=$question['id']?>"></label>
                      <input type="text" id="articleIdInput_<?=$question['id']?>" name="articleId" value="<?=$question['articleId']?>">
                  </div>
                  
                </td>
                <td>
                  <div class="toggleClass_<?=$question['id']?>">
                    <p class="whitespace-pre-wrap">Answer: <?=$question['model_answer']?></p>
                    <p><?php
                      if($question['answerAssetId'] != "") {
                        foreach($answerAssets as $asset) {
                          //echo $asset;
                          $img = getUploadsInfo($asset)[0];
                          ?>
                          <img alt ="<?=$img['altText']?>" src="<?=$imgSource.$img['path']?>">
                          <?php
                        }
                      }
                      ?>
                    </p>
                  </div>
                  <div class="hidden toggleClass_<?=$question['id']?>">
                      <label for="answerInput_<?=$question['id']?>"></label>
                      <textarea class="w-full" id="answerInput_<?=$question['id']?>" name="model_answer"><?=$question['model_answer']?></textarea>

                      <label for="answerAssetIdInput_<?=$question['id']?>"></label>
                      <input type="text" id="answerAssetIdInput_<?=$question['id']?>" name="answerAssetId" value="<?=$question['answerAssetId']?>">
                      
                      
                  </div>
                </td>
                <td>
                  <div>
                    <button type ="button" class= "w-full bg-pink-300 rounded border border-black mb-1" id = "button_<?=$question['id'];?>" onclick = "toggleHide(this, 'toggleClass_<?=$question['id']?>', 'Edit', 'Hide Edit', 'block');">Edit</button>
                  </div>
                  <div class ="hidden toggleClass_<?=$question['id'];?>">
                    <input type="hidden" name = "id" value = "<?=$question['id'];?>">
                    <input type="hidden" name = "subjectId" value = "<?=$question['subjectId'];?>">
                    <input type="hidden" name = "levelId" value = "<?=$question['levelId'];?>">

                    <input class="w-full bg-sky-200 rounded border border-black mb-1 toggleClass_35" type="submit" name="submit" value = "Update"></input>
                  </div>
                </td>
              </form>
            </tr>

            
          
            <?php
          }
        ?>
      </table>
    </div>
  </div>
</div>

<script>

var questionCount = 0;

addRow();

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


    
    
    
    cell0.innerHTML += '<label for="question_'+inst+'">Question:</label><br><textarea type="text" id ="question_'+inst+'" name="question_'+inst+'" class="w-full h-44" ></textarea><br>';
    
    cell0.innerHTML += '<div class=""><label for="qusetionAsset_'+inst+'">Question Asset:</label><br><input class= "w-1/2"type="text" id ="qusetionAsset_'+inst+'" name="questionAsset_'+inst+'"><br></div>';

   

    
    
    cell1.innerHTML = '<label for="model_answer_'+inst+'">Model Answer/Mark Scheme:</label><br><textarea class="h-36" type="text" id ="model_answer_'+inst+'" name="model_answer_'+inst+'"></textarea><br>';
    
    cell1.innerHTML += '<div class=""><label for="answerAsset_'+inst+'">Answer Asset:</label><br><input type="text" id ="answerAsset_'+inst+'" name="answerAsset_'+inst+'"></div>';


    cell2.innerHTML = "<button class='w-full bg-pink-300 rounded border border-black mb-1' type ='button' onclick='hideRow(this);'>Remove</button>"
    cell2.innerHTML += "<input name='active_entry_"+inst+"' class='w-full' type='hidden' value='1'>";

    

    //sourceAmend(inst);
    
    document.getElementById("questionsCount").value = tableLength;

    questionCount ++;
    


  }

  function hideRow(button) {
    var row = button.parentElement.parentElement;
    var input = button.parentElement.childNodes[1];
    var question_input = row.children[0].children[2];
    console.log(row);
    console.log(question_input);
    console.log(input);
    row.style.display = "none";
    question_input.removeAttribute('required');
    input.value='0';
  }
  
</script>

<?php   include($path."/footer_tailwind.php");?>