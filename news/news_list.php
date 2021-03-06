<?php

session_start();
$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");
  
}


$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/../secrets/secrets.php";
include($path);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




?>


<!DOCTYPE html>

<html lang="en">


<head>

<?php include "../header.php"; ?>

<style>

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



</style>
</head>


<body>

<?php include "../navbar.php"; ?>



<h1>News List</h1>
<?php //if(($_POST)) {print_r($_POST);}

if($_SERVER['REQUEST_METHOD']=='POST') {
  $sql = "UPDATE news_data SET headline = ?, link = ?, datePublished = ?, explanation = ?, explanation_long = ?, topic= ?, keyWords = ? WHERE id = ?";

  $stmt = $conn->prepare($sql);
  //print_r($_POST);
  $stmt->bind_param("sssssssi", $_POST['headline'], $_POST['link'], $_POST['datePublished'], $_POST['explanation'], $_POST['explanation_long'], $_POST['topic'], $_POST['keyWords'],$_POST['id']);
  $stmt->execute();
  //header("Refresh:0");
  
  echo "Record ".$_POST['id']." updated successfully.";
}



?>

  <table>
      <tr>
          <th class='col1'>Topic</th>
          <th class='col2'>Headline</th>
          <th class='col3'>Link</th>
          <th class='col4'>Date Published</th>
          <th>Short Explanation</th>
          <th>Long Explanation</th>
          <th>Key Words</th>
        </tr>

<?php
$loggedid = $_SESSION['userid'];
$sql = "SELECT * FROM news_data WHERE user = ?  ORDER BY dateCreated DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $loggedid);
$stmt->execute();
$result = $stmt->get_result();

  //$result = $conn->query($sql);
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      echo "<tr id = 'row_".$row['id']."'>";

      //print_r($row);
      //echo "<td>".$row['id']."</td>";

      ?>

      <form method="post" action ="">
        <td class='col1'>
          <div class="show_<?=$row['id'];?>">
            <?=$row['topic'];?>
          </div>
          <textarea class="hide hide_<?=$row['id'];?>" name="topic"><?=$row['topic']?></textarea>
        </td>
        <td class='col2'>
          <div class="show_<?=$row['id'];?>">
            <?=$row['headline'];?>
          </div>
          <textarea class="hide hide_<?=$row['id'];?>" name="headline"><?=$row['headline']?></textarea>
        </td>
        <td class='col3'>
          <div class="show_<?=$row['id'];?>">
            <a target ='_blank' href='<?=$row['link'];?>'><?=$row['link'];?></a>
          </div>
          <textarea class="hide hide_<?=$row['id'];?>" name="link"><?=$row['link']?></textarea>
        </td>
        <td class='col4'>
          <div class="show_<?=$row['id'];?>">
            <?=$row['datePublished'];?>
          </div>
          <input class="hide hide_<?=$row['id'];?>" type = "date" value = "<?=$row['datePublished']?>" name="datePublished"></input>
          <!--
          <textarea class="hide hide_<?=$row['id'];?>" name="datePublished"><?=$row['datePublished']?></textarea>
    -->
        </td>
        <td>
          <div class="show_<?=$row['id'];?>">
            <?=$row['explanation'];?>
          </div>
          <textarea class="hide hide_<?=$row['id'];?>" name="explanation"><?=$row['explanation']?></textarea>
        </td>
        <td>
          <div class="show_<?=$row['id'];?>">
            <?=$row['explanation_long'];?>
          </div>
          <textarea class="hide hide_<?=$row['id'];?>" name="explanation_long"><?=$row['explanation_long']?></textarea>
        </td>
        <td>
          <div class="show_<?=$row['id'];?>">
            <?=$row['keyWords'];?>
          </div>
          <textarea class="hide hide_<?=$row['id'];?>" name="keyWords"><?=$row['keyWords']?></textarea>
        </td>
        <td>
          <div>
            <button type ="button" id = "button_<?=$row['id'];?>" onclick = "changeVisibility(this, <?=$row['id'];?>)"">Edit</button>
          </div>
          <div class ="hide hide_<?=$row['id'];?>">
            <input type="hidden" name = "id" value = "<?=$row['id'];?>">
            <input type="submit" value = "Submit"></intput>
          </div>
          
        </td>
      </form>
      </tr>
      <?php
    }
  }
   
  ?> </table>
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

</body>

</html>