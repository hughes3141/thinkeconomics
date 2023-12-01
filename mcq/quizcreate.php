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
  'orderby' => (isset($_GET['orderby'])&&$_GET['orderby']!="") ? $_GET['orderby'] : null


);

$questions = getMCQquestionDetails2($get_selectors['id'], $get_selectors['questionNo'], $get_selectors['topic'], $get_selectors['keyword'], $get_selectors['search'], $get_selectors['orderby'] );

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
    <div>
      <form method ="get"  action="">
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
          <input type="text" id="search_select" name="search" value="<?=isset($_GET['examBoard']) ? $_GET['search'] : "" ?>"</input>

          <label for="orderby_select">Order By:</label>
          <select id="orderby_select" name="orderby">
            <option value=""></option>
            <option value="question">Question Text</option>
          </select>
          <input type="text" id="orderby_select" name="search" value="<?=isset($_GET['examBoard']) ? $_GET['search'] : "" ?>"</input>

          <input type="submit"  value="Select">
        </form>
    </div>

    <?php
      echo count($questions);
      echo "<br>";
      //print_r($questions);
    ?>
    <div class="grid grid-cols-3 relative">
      <div class="col-span-2">
        <div class = " grid grid-cols-2">
          <?php

          foreach($questions as $question) {
            $imgPath = "";
            if($question['path'] == "") {
              $imgPath = $question['No'].".JPG";
            } else {
              $imgPath = $question['path'];
            }
            $img = $imgSource."/mcq/question_img/".$imgPath;

            $questionDetailsInstance = array(
              'id'=>$question['id'],
              'No'=>$question['No'],
              'question'=>preg_replace( "/[^a-zA-Z0-9\s\p{P}]/", '', $question['question']),
              'path'=>$img
            );
            $questionDetails[$question['id']] = $questionDetailsInstance;

            ?>
            <div class="border border-black mx-1 mb-1 p-1">
              <p>
                <input id="quizSelect_<?=$question['id']?>" type="checkbox" onchange="includeQuestion(<?=$question['id']?>)">
                <label for="quizSelect_<?=$question['id']?>">Include</label>
              </p>
              <p class="text-xs"><?=$question['question']?></p>
              <img src="<?=$img?>" class="" alt = "<?=$question['No']?>">
              <p class="text-xs"><?=$question['examBoard']?> <?=$question['qualLevel']?> <?=$question['component']?> <?=$question['series']?> <?=$question['year']?></p>
              <button class="border border-black rounded bg-pink-200 my-2 p-1"  onclick='toggleHide(this, "toggleClass_<?=$question['id']?>", "Edit Details", "Hide Edit", "block");'>Edit Details</button>
              <div class=" toggleClass_<?=$question['id']?> hidden">
              <form method="post">
                <label for="hide_question_<?=$question['id']?>">Search:</label>
                <input type="text" id="hide_question_<?=$question['id']?>" name="hideQuestion" value="<?=isset($_GET['examBoard']) ? $_GET['search'] : "" ?>"</input>
              </form>
              </div>



            </div>
            <?php
          }

          ?>

        </div>
      </div>
      <div class="border border-black relative">
        <div  class="sticky top-20 ml-1  h-screen">
          
          <p>Quiz Preview</p>
          <div id="previewDiv" class=" overflow-auto h-5/6">
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php
//print_r($questions);
//echo json_encode($questionDetails);

?>

<script>


  const questions = <?=json_encode($questionDetails)?>;
  console.log(questions);

  var selectedQuestions = [];

  function removeItem(array, item) {
    const index = array.indexOf(item);
    return array.splice(index,1);
  }

  function previewPopulate() {
    const div = document.getElementById("previewDiv");
    div.innerHTML = "";
    for (var i=0; i<selectedQuestions.length; i++) {
      var div2 = document.createElement('div');
      var img = document.createElement('img');
      var p = document.createElement('p');
      p.innerHTML = "Q"+(i + 1)+" ";
      var select = document.createElement('select');
      for (var j=0; j<selectedQuestions.length; j++) {
        var option = document.createElement('option');
        option.value = j;
        option.innerHTML = j;
        if (j == i) {
          option.selected = true;
        }
        select.appendChild(option);
      }
      select.setAttribute("onchange", "changeOrder("+selectedQuestions[i]+", this.value)")
      p.appendChild(select);
      img.src = questions[selectedQuestions[i]].path;
      //console.log(questions[selectedQuestions[i]].path);
      //console.log(selectedQuestions[i]);
      img.alt= questions[selectedQuestions[i]].No;
      div2.appendChild(p);
      div2.appendChild(img);
      div.appendChild(div2);
    }


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
      if(i == order) {
        newArray.push(id);
      }
      if(selectedQuestions[i] != id) {
        newArray.push(selectedQuestions[i]);
      }
    }
    console.log(selectedQuestions);
    console.log(newArray);
    previewPopulate();
  }

</script>
<?php   include($path."/footer_tailwind.php");?>