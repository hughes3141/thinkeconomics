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



?>



<!--

GET variables:
-topic = filter by topic
-keyword = filter by keyword
'startDate' 
  'endDate'
  'orderBy'
  'limit' default  100

-->

<?php

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

";

?>






<?php //if(($_POST)) {print_r($_POST);}

if($_SERVER['REQUEST_METHOD']=='POST') {
  $sql = "UPDATE news_data SET headline = ?, link = ?, datePublished = ?, explanation = ?, explanation_long = ?, topic= ?, keyWords = ?, articleAsset = ? WHERE id = ?";

  $stmt = $conn->prepare($sql);
  //print_r($_POST);
  $stmt->bind_param("sssssssii", $_POST['headline'], $_POST['link'], $_POST['datePublished'], $_POST['explanation'], $_POST['explanation_long'], $_POST['topic'], $_POST['keyWords'],$_POST['articleAsset'],$_POST['id']);
  $stmt->execute();
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
  'limit' => (isset($_GET['limit']) && $_GET['limit'] != "") ? $_GET['limit'] : 100

);


$newsArticles = getNewsArticles($get_selectors['id'], $get_selectors['keyword'], $get_selectors['topic'], $get_selectors['endDate'], $get_selectors['endDate'], null, $userId, $get_selectors['limit']);


include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 pt-20 lg:pt-32 xl:pt-20">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1 mb-2">News List</h1>
  <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">


  <table>
      <tr>
          <th class='col1'>Topic</th>
          <th class='col2'>Text</th>

          <th class='col4'>Date Published</th>
          <th>Short Explanation</th>
          <th>Long Explanation</th>
          <th>Key Words</th>
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
                <?=$row['datePublished'];?>
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

</script>

<?php   include($path."/footer_tailwind.php");?>