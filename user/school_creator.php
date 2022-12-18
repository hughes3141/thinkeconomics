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
    //header("location: /index.php");
  }
}


$style_input = ".hide {
                display: none;
                }
                input, button, textarea, th, td {
                  border: 1px solid black;
                }
                ";

include($path."/header_tailwind.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if($_POST['submit']=="Create New School") {
    createSchool($_POST['name'], $_POST['userAdmin'], $_POST['postcode'],$_POST['type']);
  }
}

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">Schools Management</h1>
    <div class="font-mono container mx-auto px-0 mt-2 bg-white text-black mb-5">
      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        print_r($_POST);
      }
      ?>
      <h2>Create New School</h2>
      <form method="post" action="">
        <label>School Name:<label>
        <input type="text" name="name">
        <br>
        <label>userAdmin:<label>
        <input type="text" name="userAdmin">
        <br>
        <label>Postcode:<label>
        <input type="text" name="postcode">
        <br>
        <label>Type:<label>
        <input type="text" name="type">
        <br>
        <input type="submit" name="submit" value="Create New School">
      </form>

      <h2>List of Schools</h2>
        <table>
          <tr>
            <th>School Name</th>
            <th>userAdmin</th>
            <th>Post Code</th>
            <th>Type</th>
          </tr>
          <?php
            $schools = listSchools();
            foreach ($schools as $school) {
              ?>
              <form method="post" action="">
                <tr>
                  <td>
                    <div class ="show_<?=$school['id']?>">
                      <?=htmlspecialchars($school['name'])?>
                    </div>
                    <textarea  class="hide hide_<?=$school['id'];?>" name="name"><?=$school['name']?></textarea>
                  </td>
                  
                  <td>
                    <div class ="show_<?=$school['id']?>">
                      <?=htmlspecialchars($school['userAdmin'])?>
                    </div>
                    
                    <textarea  class="hide hide_<?=$school['id'];?>" name="userAdmin"><?=$school['userAdmin']?></textarea>
                  </td>

                  <td>
                    <div class ="show_<?=$school['postcode']?>">
                      <?=htmlspecialchars($school['postcode'])?>
                    </div>
                    <textarea  class="hide hide_<?=$school['id'];?>" name="postcode"><?=$school['userAdmin']?></textarea>
                  </td>

                  <td>
                    <div class ="show_<?=$school['id']?>">
                      <?=htmlspecialchars($school['type'])?>
                    </div>
                    <textarea  class="hide hide_<?=$school['id'];?>" name="type"><?=$school['type']?></textarea>
                  </td>

                  <td>
                    <div>
                      <button type ="button" id = "button_<?=$school['id'];?>" onclick = "changeVisibility(this, <?=$school['id'];?>)"">Edit</button>
                    </div>
                    <div class ="hide hide_<?=$school['id'];?>">
                      <input type="hidden" name = "id" value = "<?=$school['id'];?>">
                      <input type="submit" value = "Submit"></input>
                    </div>
                    
                  </td>
                  

                  
                </tr>
              </form>

              <?php
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

