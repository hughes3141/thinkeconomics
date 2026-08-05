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
  $schoolId = $userInfo['schoolid'];
  $permissions = $userInfo['permissions'];

  if(!str_contains($permissions, 'main_admin')) {
    header("location: /login.php");
  }
  
}


$style_input = "

  
  ";

$get_selectors = array(
  'id' => (isset($_GET['id'])&&$_GET['id']!="") ? $_GET['id'] : null,
  'topics' => (isset($_GET['topics'])&&$_GET['topics']!="") ? $_GET['topics'] : null,
  'number' => (isset($_GET['number'])&&$_GET['number']!="") ? $_GET['number'] : null,
  'examBoard' => (isset($_GET['examBoard'])&&$_GET['examBoard']!="") ? $_GET['examBoard'] : null
);

if($_SERVER['REQUEST_METHOD']==='POST') {

}

include($path."/header_tailwind.php");


?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">CMS Entry</h1>
  <div class=" container mx-auto px-0 mt-2 bg-white text-black mb-5">
    <?php
      print_r($_POST);
    ?>
    <form method="post" action ="">
      <div id="inputDiv">
        <p>
          <label>Title</label>
          <input type="text" name="title"></input>
        </p>
      </div>
      <input type="submit" value="Submit">
    </form>
  </div>
</div>

<script>
  function addElement(i) {
    var inputDiv=document.getElementById("inputDiv");
    var sectionDiv = document.createElement("div");
    //sectionDiv.style.border= "1px solid black";
    //sectionDiv.style.padding = "1px";
    sectionDiv.setAttribute("class", " border border-black rounded m-1 p-1");
    //sectionDiv.innerHTML="Test";

    const label_0= document.createElement("label");
    label_0.setAttribute("for", "type_"+i);
    label_0.innerHTML = "Type:";
    const select_0 = document.createElement("select");
    select_0.setAttribute("id", "type_"+i);
    select_0.setAttribute("name", "type_"+i);
    const option_0 = document.createElement("option");
    option_0.setAttribute("value", "p");
    option_0.innerHTML = "Paragraph";
    select_0.appendChild(option_0);

    sectionDiv.appendChild(label_0);
    sectionDiv.appendChild(select_0);

    inputDiv.appendChild(sectionDiv);

  }

  addElement(0);
  addElement(1);
  addElement(2);
  addElement(3);
</script>

<?php   include($path."/footer_tailwind.php");?>