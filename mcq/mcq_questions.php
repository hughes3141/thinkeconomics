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
  if (!(str_contains($permissions, 'teacher'))) {
    header("location: /index.php");
  }

}

$style_input = "
  th, td {
    border: 1px solid black;
  }

  
  ";





include($path."/header_tailwind.php");



?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">MCQ Questions</h1>
    <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">
      <?php
      if($_SERVER['REQUEST_METHOD']==='POST') {
        print_r($_POST);  
      }
      ?>

      <div>
        <h2>Create New Questions</h2>
        <form method="post" action = "">
          <table id="inputTable" class="w-full table-fixed mb-2 border border-black">
            <thead>
              <tr>
                <th>Question No</th>
                <th>Question Text</th>
                <th>Options</th>
                <th>Image Source</th>
                <th>Details</th>

              </tr>
            </thead>

          </table>
          <input type = "hidden" id="inputCount" name="inputCount">
          <button class="w-full rounded bg-sky-300 hover:bg-sky-200 border border-black mb-2" type="button" onclick="addInputRow();">Add row</button> 
          <button>Submit</button>
      </form>
      </div>



    </div>
</div>


<script>

function addInputRow() {
  var table = document.getElementById("inputTable");
  var rowNo = table.rows.length;
  var row = table.insertRow(rowNo);
  var cells = [];
  for (var i=0; i<5; i++) {
    cells[i] = row.insertCell(i);
    switch(i) {
      case 0:
        var label = "questionNo_"+(rowNo-1);
        var value = "value = '"+(rowNo)+"'";
        cells[i].innerHTML = "<input name="+label+" id= "+label+" "+value+"class='w-full rounded'>";
        break;
      case 1:
        var label = "questionText_"+(rowNo-1);
        //var value = "value = '"+(rowNo)+"'";
        cells[i].innerHTML = "<textarea name="+label+" id= "+label+" "+"class='w-full rounded p-1'></textarea>";
        break;
      case 2:
        var label = "options_"+(rowNo-1);
        //var value = "value = '"+(rowNo)+"'";
        cells[i].innerHTML = "<textarea name="+label+" id= "+label+" "+"class='w-full rounded p-1'></textarea>";
        break;
      case 3:
        var label = "imageSRC_"+(rowNo-1);
        var value = "value = '"+(rowNo)+"'";
        cells[i].innerHTML = "<input name="+label+" id= "+label+" "+value+"class='w-full rounded'>";
        break;
    }
  }

}

addInputRow();
addInputRow();


</script>

<?php   include($path."/footer_tailwind.php");?>