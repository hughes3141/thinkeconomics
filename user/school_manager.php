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
  $userId = $userInfo['id'];
  $permissions = $userInfo['permissions'];
  if (!(str_contains($permissions, 'main_admin'))) {
    header("location: /index.php");
  }
}

$style_input = "
                .hide {
                  display: none;
                  }
                input {
                  border: 1px solid black;
                }
                
                td, th {
                  padding: 2px;
                  border: 1px solid black;
                }";

include($path."/header_tailwind.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if($_POST['submit']=="Submit") {
    editSchoolDfe($_POST['id'], $_POST['userAdmin']);
    
  }
}

if (count($_GET)>0) {
  if($_GET['submit']=="Search Schools") {
    $searchResults = listSchoolsDfe($_GET['search']);
  }
}







?>


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">Schools Management</h1>
    <div class="font-mono container mx-auto px-0 mt-2 bg-white text-black mb-5">
      <?php
        if (count($_GET)>0) {
          //print_r($_GET);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          //print_r($_POST);
        }
        
        ?>
        <h2>Search Schools</h2>
        <form method = "get" action ="">
          <label>School Name/Postcode:</label>
          <input type="text" name ="search">
          <input type="submit" name="submit" value="Search Schools">
        </form>
        <?php
        if(isset($searchResults)) {
          ?>

          <table class="w-full">
            <tr>
              <th>id</th>
              <th>School Name</th>
              <th>userAdmin</th>
              <th>Address</th>
              <th>Details</th>
              <th>Edit</th>
            </tr>
              <?php
              foreach($searchResults as $result) {
              ?>
              <tr>
                <form method = "post" action ="">
                  <td>
                    <?=htmlspecialchars($result['id'])?>
                  </td>
                  <td>
                    <?=htmlspecialchars($result['SCHNAME'])?>
                  </td>
                  <td>
                    <div class ="show_<?=$result['id']?>">
                      <?=htmlspecialchars($result['userAdmin'])?>
                    </div>
                    
                    <textarea  class="hide hide_<?=$result['id'];?>" name="userAdmin"><?=$result['userAdmin']?></textarea>
                  </td>
                  <td>
                    <?=htmlspecialchars($result['STREET'])?>
                    <br>
                    <?=($result['LOCALITY'] != "") ? htmlspecialchars($result['LOCALITY'])."<br>" : ""?>
                    <?=($result['ADDRESS3'] != "") ? htmlspecialchars($result['ADDRESS3'])."<br>" : ""?>
                    <?=htmlspecialchars($result['TOWN'])?>
                    <br>
                    <?=htmlspecialchars($result['POSTCODE'])?>
                  </td>
                  <td>
                  <?=htmlspecialchars($result['MINORGROUP'])?>
                  <br>
                  <?=htmlspecialchars($result['SCHOOLTYPE'])?>
                  <br>
                  <?=($result['ISPRIMARY'] == 1) ? "Primary<br>" : ""?>
                  <?=($result['ISSECONDARY'] == 1) ? "Secondary<br>" : ""?>
                  <?=($result['ISPOST16'] == 1) ? "Post-16<br>" : ""?>
                  <?=htmlspecialchars($result['GENDER'])?>
                  
                  <?=(($result['RELCHAR'] == "None") || ($result['RELCHAR'] == "Does not apply")) ? "" : "<br>".htmlspecialchars($result['RELCHAR'])?>  
                  </td>

                  <td>
                      <div>
                        <button type ="button" id = "button_<?=$result['id'];?>" onclick = "changeVisibility(this, <?=$result['id'];?>)"">Edit</button>
                      </div>
                      <div class ="hide hide_<?=$result['id'];?>">
                        <input type="hidden" name = "id" value = "<?=$result['id'];?>">
                        <input type="submit" name ="submit" value = "Submit"></input>
                      </div>
                      
                    </td>
                </form>
                
              </tr>

              <?php
              }
              
              }
              ?>
          </table>
    </div>
</div>

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