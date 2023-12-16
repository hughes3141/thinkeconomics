<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");


$userInfo = array();
$userId = null;
$permissions = "";

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
}

include($path."/header_tailwind.php");

?>

<div class=" mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-full">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Fishing Game</h1>
  <div class="  mx-auto p-4 mt-2 bg-white text-black mb-5">
    <div id="fishCount"></div>
    <div class="grid grid-cols-2">
      <?php
      for($x=0; $x<4; $x++) {
      ?>
      <div class="text-center">
        <button class="border border-black rounded w-1/2 m-1 " onclick = "goFish(<?=$x?>)">Go Fish!</button>
        <div id="fishCount_<?=$x?>" class="fishCountIndDiv">

        </div>
      </div>
      <?php
      }
      ?>

    </div>
    <button onclick="newRound();">New Round</button>
    <div>
      <p>Totals:</p>
      <?php
      for($x=0; $x<4; $x++) {
        ?>
        <p>Player <?=$x+1?>: <span class="totalCount"></span></p>
        <?php
      }
      ?>
    </div>
  </div>
</div>



<script>

  var fishCount = 8;
  var fishAllocate = [0,0,0,0];
  var totals = [0,0,0,0];
  var round = 0;
  var rate = 1.5;

  update();

  function update() {
    const fishCountDiv = document.getElementById("fishCount");
    fishCountDiv.innerHTML = fishCount;

    const fishCountIndDiv = document.getElementsByClassName('fishCountIndDiv');
    for (var i=0; i<fishCountIndDiv.length; i++) {
      fishCountIndDiv[i].innerHTML = fishAllocate[i];
    }



    console.log(fishCount);
    console.log(fishAllocate);
    console.log(totals);
    console.log(round);
    
  }

  function updateRound() {
    const countSpans = document.getElementsByClassName('totalCount');
    for (var i=0; i<countSpans.length; i++) {
      countSpans[i].innerHTML = totals[i];

    }

  }

  function goFish(i) {
    if(fishCount > 0) {
      fishCount --;
      fishAllocate[i] ++;
    }
    update();

  }

  function newRound() {
    for(var i=0; i<fishAllocate.length; i++) {
      totals[i] = totals[i]+fishAllocate[i];
      fishAllocate[i] = 0;
    }
    fishCount = Math.floor(fishCount*rate);
    round ++;
    update();
    updateRound();
  }

  
</script>

<?php   include($path."/footer_tailwind.php");?>