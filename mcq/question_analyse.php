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

  
  ";

if($_SERVER['REQUEST_METHOD']==='POST') {
  if(isset($_GET['test'])) {
    print_r($_POST);
  }

  if($_POST['submit'] == "Create New Quiz") {
    $confirm = createMCQquiz($userId, $_POST['questions_id'], $_POST['quizName'], $_POST['topic'], $_POST['notes'], $_POST['description']);
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
  'excludedQuizzes' => (isset($_GET['excludedQuizzes'])&&$_GET['excludedQuizzes']!="") ? $_GET['excludedQuizzes'] : null



);

$run_questions = 0;
$questions = array();
$originalQuestions = array();

foreach ($get_selectors as $key => $element) {
  if($key != "showQuizzes" && $key != "orderby") {
    if(!is_null($element)) {
      $run_questions = 1;
    }
  }
}

if($run_questions == 1) {
  $questions = getMCQquestionDetails2($get_selectors['id'], $get_selectors['questionNo'], $get_selectors['topic'], $get_selectors['keyword'], $get_selectors['search'], $get_selectors['orderby'], $get_selectors['examBoard'], $get_selectors['year']);
  foreach($questions as $question) {
    array_push($originalQuestions, $question['id']);
  }
}

//Controls if questions are brought in from previously-created quiz. If so then the only output is these questions.

$quizid = $get_selectors['quizid'];
$quiz = null;
$quizQuestions = array();
if($quizid) {
  $quiz = getMCQquizInfo($quizid);
  $quizQuestions = explode(",",$quiz['questions_id']);
  $questions = array();
}

//The following appends to $questions any qusestions that were included in previous quiz-creations and are passed back through $GET['selectedQuestions]

$selectedQuestions = array();
if($get_selectors['selectedQuestions']) {
  $selectedQuestions = explode(",",$get_selectors['selectedQuestions']);
}

if($quiz) {
  $selectedQuestions = $quizQuestions;
}

//print_r($selectedQuestions);


$selectedQuestionsRev = array_reverse($selectedQuestions);
//print_r($selectedQuestions);
foreach($selectedQuestionsRev as $questionid) {
  $question = getMCQquestionDetails2($questionid)[0];
  //print_r($question);
  if(!in_array($question,$questions)) {
    array_unshift($questions, $question);
  }

}

foreach ($questions as $key => $question) {
  //Label selected and original questions:

  if(in_array($question['id'], $selectedQuestions)) {
    $questions[$key]['selected'] = 1;
  } else {
    $questions[$key]['selected'] = 0;
  }
  if(in_array($question['id'], $originalQuestions)) {
    $questions[$key]['original'] = 1;
  } else {
    $questions[$key]['original'] = 0;
  }
}


foreach($questions as $key => $question) {
  //Apend field for used quizzes:
  $questions[$key]['usedInQuizzes'] = "";
  }


//Looking now at whether questions are elements of a quiz.

$globalUsedQuizzes = array();

$excludedQuizzes = explode(",", $get_selectors['excludedQuizzes']);
unset($excludedQuizzes[count($excludedQuizzes)-1]);


//Processing quiz details if showQuizzes is enabled:  
if($get_selectors['showQuizzes']) {  
  foreach($questions as $key => $question) {
    $usedQuizzes = getMCQquizDetails(null, null, $question['id'], null, 1, 1);
    $usedQuizzedIds = array();
    //print_r($usedQuizzes);
    
    foreach($usedQuizzes as $key2 => $quiz) {
      
      if(in_array($quiz['id'], $excludedQuizzes)) {
        unset($usedQuizzes[$key2]);
      } else {
        array_push($usedQuizzedIds, $quiz['id']);
        if(!in_array($quiz, $globalUsedQuizzes)) {
          array_push($globalUsedQuizzes, $quiz);
        }
      }
      //print_r($usedQuizzedIds);
      $questions[$key]['usedInQuizzes'] = implode(",",$usedQuizzedIds);

    }
  }

}

//Change $quesitons to be ordered by $globalusedquizzes
if($get_selectors['orderby'] == "usedQuizzes") {
  $questions_filter = array();
  foreach($globalUsedQuizzes as $usedQuiz) {
    foreach($questions as $key => $question) {
      $usedInQuizIds = explode(",",$question['usedInQuizzes']);
      if(in_array($usedQuiz['id'], $usedInQuizIds)) {
        array_push($questions_filter, $question);
        unset($questions[$key]);
      }

    }
  }
  $questions = array_merge($questions_filter, $questions);
  

}

$questionDetails = array();

$imgSource = "https://thinkeconomics.co.uk";


include($path."/header_tailwind.php");





?>

<!-- 

$_GET controls:
-test => isset = shows print_r for $_POST variables

-->

<div class=" mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-full">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">MCQ Quiz Creator</h1>
  <div class="  mx-auto p-4 mt-2 bg-white text-black mb-5">
    <div><?=(isset($confirm)) ? $confirm : ""?></div>


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

          <label for="search_select">Search:</label>
          <input type="text" id="search_select" name="search" value="<?=isset($_GET['search']) ? $_GET['search'] : "" ?>"</input>

          <label for="orderby_select">Order By:</label>
          <select id="orderby_select" name="orderby">
            <option value=""></option>
            <option value="question" <?=($get_selectors['orderby'] == "question") ? "selected" : ""?>>Question Text</option>
            <option value="usedQuizzes" <?=($get_selectors['orderby'] == "usedQuizzes") ? "selected" : ""?>>Used Quizzes</option>
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

    <?php
      echo count($questions);
      echo "<br>";
      //print_r($get_selectors);
      //print_r($questions);
      //print_r($questions_filter);
      //print_r($originalQuestions);
      //print_r($selectedQuestions);
      //print_r($excludedQuizzes);
      //print_r($globalUsedQuizzes);
      /*
      foreach($globalUsedQuizzes as $quiz) {
        echo $quiz['id']." ";
      }
      */
      
      
    ?>
    <?php
      if(count($globalUsedQuizzes)>0) {
        ?>
        <div>
          <h2>Used Quizzes</h2>
          <?php
          foreach($globalUsedQuizzes as $quiz) {
            //print_r($quiz);
            ?>
              <p><a class="underline text-sky-800 hover:bg-sky-200" href="mcq_preview.php?quizid=<?=$quiz['id']?>" target="_blank"><?=$quiz['topic']?> <?=$quiz['quizName']?></a> <a href="quizcreate.php?quizid=<?=$quiz['id']?>" target="_blank" class="bg-pink-200">This Quiz</a> <button class="bg-sky-100  rounded" onclick="excludedQuizzes(<?=$quiz['id']?>);">Exclude</button></p>
            <?php
          }
          ?>
        </div>
        <?php
      }
    ?>
    <div class="nowrap">
      <table class="table-fixed">
        <tbody>
          <tr class=" sticky top-20 bg-white">
            <th>Question</th>
            <?php
            foreach($globalUsedQuizzes as $quiz) {
              ?>
              <th class="w-20">
                <div>
                  <div class=" text-wrap text-xs"><?=$quiz['topic']." ".$quiz['quizName']?></div>
              </div>
              </th>
              <?php
            }
            ?>
          </tr>
          <?php
          foreach($questions as $question) {
            $relevant = $question['relevant'];
            $similar = array();
            if($question['similar'] !="") {
              $similar = explode(",", $question['similar']);
            }
            $background = "";
            if(count($similar)>0) {
              $background = " bg-sky-200 ";
            }
            if($relevant !=1) {
              $background = " bg-pink-200 ";
            }
            ?>
            <tr >
              <td class="<?=$background?>">
              <?php
              if(isset($_GET['test'])) {
                print_r($question);
              }
              
              ?>
              <a class="underline text-sky-700" target="blank" href="mcq_preview.php?questions=<?=$question['id']?>&answerShow=1"><?=$question['id']?></a>
              <span class="text-xs"><?=" ".$question['examBoard']." ".$question['year']?></span>
              </td>
              <?php
              foreach($globalUsedQuizzes as $quiz) {
                $usedInQuizIds = explode(",",$question['usedInQuizzes'])
                ?>
                <td><?php
                if(in_array($quiz['id'], $usedInQuizIds)) {
                  ?>
                  <div class="w-full bg-pink-200 text-center">x</div>
                  <?php
                }
                ?></td>
                <?php
              }
              ?>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>


  </div>
</div>

<?php
//print_r($questions);
//echo json_encode($questionDetails);

?>

<script>


  const questions = <?=(count($questionDetails) > 0) ? json_encode($questionDetails) : "[]"?>;
  console.log(questions);

  var selectedQuestions = [<?=implode(",",$selectedQuestions)?>];

  previewPopulate();

  function removeItem(array, item) {
    const index = array.indexOf(item);
    array.splice(index,1);
    const checkbox = document.getElementById("quizSelect_"+item);
    checkbox.checked = false;
    //console.log(array);
    //console.log(item);
  }

  function previewPopulate() {
    const div = document.getElementById("previewDiv");
    div.innerHTML = "";
    for (var i=0; i<selectedQuestions.length; i++) {
      var div2 = document.createElement('div');
      var img = document.createElement('img');
      var p = document.createElement('p');
      var button = document.createElement('button');
      p.innerHTML = "Q"+(i + 1)+" ";
      var select = document.createElement('select');
      for (var j=0; j<selectedQuestions.length; j++) {
        var option = document.createElement('option');
        option.value = j;
        option.innerHTML = j+1;
        if (j == i) {
          option.selected = true;
        }
        select.appendChild(option);
      }
      select.setAttribute("onchange", "changeOrder("+selectedQuestions[i]+", this.value)")
      p.appendChild(select);
      var p2 = document.createElement('p');
      p2.innerHTML = questions[selectedQuestions[i]].Answer
      p2.classList.add("text-xs");

      const questionDetails = questions[selectedQuestions[i]];
      //console.log(questionDetails);
      var p3 = document.createElement('p');
      p3.innerHTML = questionDetails.examBoard;
      p3.innerHTML += " "+questionDetails.qualLevel;
      p3.innerHTML += " "+questionDetails.component;
      p3.innerHTML += " "+questionDetails.series;
      p3.innerHTML += " "+questionDetails.year;
      p3.innerHTML += " Q"+questionDetails.questionNo;
      p3.innerHTML += " "+questionDetails.Topic;
      p3.classList.add("text-xs");
      button.innerHTML = "Remove";
      button.className = "border border-black mx-1 px-1 bg-pink-200 rounded";
      button.setAttribute("onclick", "removeItem(selectedQuestions, "+selectedQuestions[i]+"); previewPopulate();")
      p.appendChild(button);
      img.src = questions[selectedQuestions[i]].path;
      //console.log(questions[selectedQuestions[i]].path);
      //console.log(selectedQuestions[i]);
      img.alt= questions[selectedQuestions[i]].No;
      div2.appendChild(p);
      div2.appendChild(p3);
      div2.appendChild(p2);
      div2.appendChild(img);
      div.appendChild(div2);

      

    }

    const selectedQuestionsInput = document.getElementById("selectedQuestionsSelect");
    selectedQuestionsInput.value = selectedQuestions;

    const previewPageLink = document.getElementById("previewPageLink");
    selectedQuestionsString = selectedQuestions.toString();
    previewPageLink.href = "/mcq/mcq_preview.php?questions="+selectedQuestionsString;

    const questionsIdInput = document.getElementById("questionsIdInput");
    questionsIdInput.value = selectedQuestions;


  }

  function includeQuestion(id,order) {
    //console.log(id);
    button = document.getElementById("quizSelect_"+id);
    //console.log(button.checked);
    if (button.checked == true) {
      selectedQuestions.push(id)
    }
    if (button.checked == false) {
      removeItem(selectedQuestions, id);
    }
    console.log(selectedQuestions);
    previewPopulate();
  }

  function changeOrder(id, order) {
    oldPosition = selectedQuestions.indexOf(id);
    console.log(id+" "+order+" "+oldPosition);
    newArray = [];

    for(var i=0; i<selectedQuestions.length; i++) {

      if(i == order && order<oldPosition) {
        newArray.push(id);
      }
      if(selectedQuestions[i] != id) {
        newArray.push(selectedQuestions[i]);
      }
      if(i == order && order>oldPosition) {
        newArray.push(id);
      }

    }
    //console.log(selectedQuestions);
    //console.log(newArray);
    selectedQuestions= newArray;
    previewPopulate();
  }

  function toggleForm() {
    const form = document.getElementById("createBox");
    if(form.classList.contains("hidden")) {
      form.classList.remove("hidden");
    } else {
      form.classList.add("hidden");
    }
  }

  function excludedQuizzes(quizid) {
    const excludedQuizzesSelect = document.getElementById("excludedQuizzesSelect");
    const selectForm = document.getElementById("selectForm");
    //console.log(excludedQuizzesSelect);
    //console.log(quizid);
    excludedQuizzesSelect.value += quizid+",";
    selectForm.submit();

  }

  function clearExcludedQuizzes() {
  const excludedQuizzesSelect = document.getElementById("excludedQuizzesSelect");
  excludedQuizzesSelect.value="";
  document.getElementById("selectForm").submit();
  
  }

</script>
<?php   include($path."/footer_tailwind.php");?>