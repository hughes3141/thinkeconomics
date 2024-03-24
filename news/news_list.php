<?php

session_start();
$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");

$userId = null;

if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");
  
} else {
  $userId = $_SESSION['userid'];
}



$style_input = "



  .hide {
    display: none;
  }

th, td {
  
  border: 1px solid black;
  padding: 5px;
  word-wrap:break-word;
}

table {
  
  border-collapse: collapse;
  table-layout: fixed;
  width: 100%;
}

textarea, input {
  padding: 0.25rem
}

";


$updateQuestionBool = 0;

//if(($_POST)) {print_r($_POST);}

if($_SERVER['REQUEST_METHOD']=='POST') {
  $updateQuestionBool = 1;
  updateNewsArticle($_POST['id'], $_POST['headline'], $_POST['datePublished'], $_POST['explanation'], $_POST['explanation_long'], $_POST['keyWords'], $_POST['link'], $_POST['articleAsset'], $_POST['active'], $_POST['bbcPerennial'], $_POST['photoAssets'], $_POST['topic'], $_POST['video'], $_POST['audio'], $_POST['photoLinks']);


  /*
  $sql = "UPDATE news_data SET headline = ?, link = ?, datePublished = ?, explanation = ?, explanation_long = ?, topic= ?, keyWords = ?, articleAsset = ? WHERE id = ?";

  $stmt = $conn->prepare($sql);
  //print_r($_POST);
  $stmt->bind_param("sssssssii", $_POST['headline'], $_POST['link'], $_POST['datePublished'], $_POST['explanation'], $_POST['explanation_long'], $_POST['topic'], $_POST['keyWords'],$_POST['articleAsset'],$_POST['id']);
  $stmt->execute();
  */
  //header("Refresh:0");
  
  //echo "Record ".$_POST['id']." updated successfully.";
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


$newsArticles = getNewsArticles($get_selectors['id'], $get_selectors['keyword'], $get_selectors['topic'], $get_selectors['startDate'], $get_selectors['endDate'], $get_selectors['orderBy'], $userId, $get_selectors['limit'], $get_selectors['searchFor'], $get_selectors['link'], null, null, null, $get_selectors['video'], $get_selectors['audio']);


include($path."/header_tailwind.php");

?>

<!--

GET variables:
  'id'
  'topic'
  'keyword' 
  'startDate' 
  'endDate'
  'orderBy' 
  'limit' => default 100
  'searchFor'
  'noSearch' => if this is set then the extended search bar does not come up
  'link'
  'searchBar' => if this is set then extended search bar will be open on load
  'video'
  'audio'

-->

<div class="container mx-auto px-4 pt-20 lg:pt-32 xl:pt-20">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1 mb-2">News List</h1>
  <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">
  <?php
    if(isset($_GET['test'])) {
      print_r($_POST);
    }
    $showSearch = ($get_selectors['searchFor'] || $get_selectors['keyword'] || $get_selectors['startDate'] || $get_selectors['endDate'] || $get_selectors['link'] || $get_selectors['searchBar']) ? 1 : null;
  ?>

      <div id="accordion-collapse" data-accordion="collapse">
        <h2 id="accordion-collapse-heading-1">
          <button type="button" class="flex items-center justify-between w-full p-2 font-medium text-gray-500 border border-gray-200 hover:bg-gray-100  gap-3s font-mono" data-accordion-target="#accordion-collapse-body-1" aria-expanded="<?=($showSearch) ? "true" : "false"?>" aria-controls="accordion-collapse-body-1">
            <span>Search Controls</span>
            <svg data-accordion-icon class="w-3 h-3  shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1 5 5 1 1"/>
            </svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
          <div class="p-3 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
            <form type="get" action="">
              <p class="mb-2 text-gray-500">
                <label for="searchForInput">Headline, Keywords, Explanation:</label>
                <input class="px-1 w-full" id="searchForInput" name="searchFor" value="<?=$get_selectors['searchFor']?>" type="text">
              </p>
              <p class="mb-2 text-gray-500">
                <label for="keyWordInput">Keyword:</label>
                <input class="px-1 w-full" id="keyWordInput" name="keyword" value="<?=$get_selectors['keyword']?>" type="text">
              </p>
              <p class="mb-2 text-gray-500">
                <label for="linkInput">Link:</label>
                <input class="px-1 w-full" id="linkInput" name="link" value="<?=$get_selectors['link']?>" type="text">
              </p>
              <p class="mb-2 text-gray-500">
                <label for="topicInput">Topic:</label>
                <input class="px-1 w-full" id="topicInput" name="topic" value="<?=$get_selectors['topic']?>" type="text">
              </p>
              <div class="mb-2 text-gray-500 grid grid-cols-2 gap-2">
                <div>
                  <label for="startDateInput">Start Date:</label>
                  <input class="px-1 w-full" id="startDateInput" name="startDate" value="<?=$get_selectors['startDate']?>" type="date">
                </div>

                <div>
                  <label for="endDateInput">End Date:</label>
                  <input class="px-1 w-full" id="endDateInput" name="endDate" value="<?=$get_selectors['endDate']?>" type="date">
                </div>

              </div>
              <input class="w-full bg-pink-300" type="submit" value="Search"</input>
              <input type="hidden" value="<?=$get_selectors['topic']?>">
            </form>
          </div>
        </div>   
      </div> 


  <table>
      <tr>
          <th class='col1'>Topic</th>
          <th class='col2'>Text</th>

          <th class='col4'>Date Published</th>
          <th>Short Explanation</th>
          <th>Long Explanation</th>
          <th>Details</th>
          <th>Edit</th>
        </tr>

        <?php
        foreach($newsArticles as $row) {
          echo "<tr id = 'row_".$row['id']."'>";
          ?>

          <form method="post" action ="">
            <td class='col1'>
              <div class="show_<?=$row['id'];?>">
                <?=$row['topic'];?>
              </div>
              <textarea class="w-full hide hide_<?=$row['id'];?>" name="topic"><?=$row['topic']?></textarea>
              <?php //print_r($row);?>
            </td>
            <td class='col2'>
              <label class="font-bold" for="headline_<?=$row['id']?>">Headline:</label>
              <div class="show_<?=$row['id'];?>">
                <p><?=$row['headline'];?><p>
              </div>
              <textarea id="headline_<?=$row['id']?>" class="w-full hide hide_<?=$row['id'];?>" name="headline"><?=$row['headline']?></textarea>

              <label class="font-bold" for="link_<?=$row['id']?>">Link:</label>
              <div class="show_<?=$row['id'];?>">
                <a class="underline text-sky-500  00" target ='_blank' href='<?=$row['link'];?>'><?=$row['link'];?></a>
              </div>
              <textarea id="link_<?=$row['id']?>" class="w-full hide hide_<?=$row['id'];?>" name="link"><?=$row['link']?></textarea>
            </td>
            <td class='col4'>
              <div class="show_<?=$row['id'];?>">
                <?=date("d/m/Y",strtotime($row['datePublished']))?>
              </div>
              
              <input class="w-full hide hide_<?=$row['id'];?>" type = "date" value = "<?=$row['datePublished']?>" name="datePublished"></input>
            </td>
            <td>
              <div class="show_<?=$row['id'];?>">
                <?=$row['explanation'];?>
              </div>
              <textarea class="w-full hide hide_<?=$row['id'];?>" name="explanation"><?=$row['explanation']?></textarea>
            </td>
            <td>
              <div class="show_<?=$row['id'];?>">
                <?=$row['explanation_long'];?>
              </div>
              <textarea class="w-full hide hide_<?=$row['id'];?>" name="explanation_long"><?=$row['explanation_long']?></textarea>
            </td>
            <td>
              <label class="font-bold" for="keyWords_<?=$row['id']?>">Key Words</label>
              <div class="show_<?=$row['id'];?>">
                <?=$row['keyWords'];?>
              </div>
              <textarea id="keyWords_<?=$row['id']?>" class="w-full hide hide_<?=$row['id'];?>" name="keyWords"><?=$row['keyWords']?></textarea>

              <label class="font-bold" for="articleAsset<?=$row['id']?>">Article Asset:</label>
              <div class="show_<?=$row['id'];?>">
                <?=($row['articleAsset'] != "") ? $row['articleAsset'] : ""?>
              </div>
              <input type="text" id="articleAsset<?=$row['id']?>" class="w-full hide hide_<?=$row['id'];?>" name="articleAsset" value= "<?=$row['articleAsset']?>"></input>

              <label class="font-bold" for="photoAssets<?=$row['id']?>">Photo Assets:</label>
              <div class="show_<?=$row['id'];?>">
                
                <?php
                if($row['photoAssets'] != "") {
                  $photoAssets = explode(",", $row['photoAssets']);
                  //print_r($photoAssets);
                  foreach ($photoAssets as $asset) {
                    $asset = getUploadsInfo($asset)[0];
                    //print_r($asset);
                    ?>
                    <a target="_blank" href="<?=$asset['path']?>"><?=$asset['id']?> </a>

                    <?php
                    /*
                    <img alt ="<?=$asset['altText']?>" src="<?=$imgSource.$asset['path']?>">
                    */
                    ?>

                    <?php
                    }
                  }
                ?>
              </div>
              <input type="text" id="photoAssets<?=$row['id']?>" class="w-full hide hide_<?=$row['id'];?>" name="photoAssets" value= "<?=$row['photoAssets']?>"></input>

              <div>
                <label for="photoLinks<?=$row['id']?>" class= "font-bold ">Linked Photos:</label>
                <textarea id="photoLinks<?=$row['id']?>" class="w-full hide hide_<?=$row['id'];?>" name="photoLinks" value=""><?=$row['photoLinks']?></textarea>

                <?php
                  $photoLinks = $row['photoLinks'];
                  $photoLinks = explode(", ", $photoLinks);
                  //print_r($photoLinks);
                  if(count($photoLinks) > 0) {
                    ?>
                    <div class="show_<?=$row['id'];?>">
                      <?php
                      foreach($photoLinks as $link) {
                        $link = trim($link);
                        ?>
                        <img alt="<?=$link?>" src="<?=$link?>">
                        <?php
                      }
                      ?>
                    </div>
                    <?php
                  }
                ?>
              </div>

              <div>
                <p class="show_<?=$row['id'];?>"> <?=($row['active'] == 1) ? "Active" : "<span class='bg-pink-100'>Inactive</span>"?></p>
                <div class="hide hide_<?=$row['id'];?>">
                  <input type="radio" name="active" id="activeSelect_<?=$row['id']?>_1" value="1" <?=($row['active'] == 1) ? "checked" : ""?>><label for="activeSelect_<?=$row['id']?>_1" > Active</label>
                  <input type="radio" name="active" id="activeSelect_<?=$row['id']?>_0" value="0" <?=($row['active'] == 0) ? "checked" : ""?>><label for="activeSelect_<?=$row['id']?>_0"> Inactive</label>
                </div>

                <div>
                <p class="show_<?=$row['id'];?>"> <?=($row['bbcPerennial'] == 1) ? "BBC Explainer" : ""?></p>
                <div class="hide hide_<?=$row['id'];?>">
                  <input type="radio" name="bbcPerennial" id="bbcPerennialSelect_<?=$row['id']?>_1" value="1" <?=($row['bbcPerennial'] == 1) ? "checked" : ""?>><label for="bbcPerennialSelect_<?=$row['id']?>_1" > BBC Explainer</label> <br>
                  <input type="radio" name="bbcPerennial" id="bbcPerennialSelect_<?=$row['id']?>_0" value="0" <?=($row['bbcPerennial'] == 0) ? "checked" : ""?>><label for="bbcPerennialSelect_<?=$row['id']?>_0"> Not Explainer</label>
                </div>

                <p class="show_<?=$row['id'];?>"> <?=($row['video'] == 1) ? "Video" : ""?></p>
                <div class="hide hide_<?=$row['id'];?>">
                  <input type="radio" name="video" id="videoSelect_<?=$row['id']?>_1" value="1" <?=($row['video'] == 1) ? "checked" : ""?>><label for="videoSelect_<?=$row['id']?>_1" > Video</label> <br>
                  <input type="radio" name="video" id="videoSelect_<?=$row['id']?>_0" value="0" <?=($row['video'] == 0) ? "checked" : ""?>><label for="videoSelect_<?=$row['id']?>_0"> Not Video</label>
                </div>

                <p class="show_<?=$row['id'];?>"> <?=($row['audio'] == 1) ? "Audio" : ""?></p>
                <div class="hide hide_<?=$row['id'];?>">
                  <input type="radio" name="audio" id="audioSelect_<?=$row['id']?>_1" value="1" <?=($row['audio'] == 1) ? "checked" : ""?>><label for="audioSelect_<?=$row['id']?>_1" > Audio</label> <br>
                  <input type="radio" name="audio" id="audioSelect_<?=$row['id']?>_0" value="0" <?=($row['audio'] == 0) ? "checked" : ""?>><label for="audioSelect_<?=$row['id']?>_0"> Not Audio</label>
                </div>

                

                
                
              </div>


            </td>
            <td>
              <div>
                <button class = "border border-black rounded bg-pink-200 w-full mb-2" type ="button" id = "button_<?=$row['id'];?>" onclick = "changeVisibility(this, <?=$row['id'];?>)"">Edit</button>
              </div>
              <div class ="hide hide_<?=$row['id'];?> ">
                <input type="hidden" name = "id" value = "<?=$row['id'];?>">
                <input class=" border border-black rounded bg-sky-200 w-full mb-2" type="submit" name="submit" value = "Submit"></input>
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
  <?php

  
  
   
  



?>


<script>

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


function createUpdateRow(id) {
  var row = document.getElementById("row_"+id);
  console.log(row.rowIndex);
}

<?php
if($updateQuestionBool == 1) {
    ?>
      //console.log(document.getElementById('<?=$_POST['id']?>'));
      document.getElementById('row_<?=$_POST['id']?>').scrollIntoView();
    <?php
  
}
?>

</script>

<?php   include($path."/footer_tailwind.php");?>