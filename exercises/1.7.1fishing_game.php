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

$get_selectors = array(
  "number" => (isset($_GET['number'])) ? $_GET['number'] : 4,
  "fish" => (isset($_GET['fish'])) ? $_GET['fish'] : null,
  "h" => (isset($_GET['h'])) ? $_GET['h'] : null,
  "rate" => (isset($_GET['rate'])) ? $_GET['rate'] : 1.5,
);

if($get_selectors['number'] > 10) {
  $get_selectors['number'] = 10;
}

if(!$get_selectors['fish']) {
  $get_selectors['fish'] = $get_selectors['number']*2;
}

?>

<!--
  $GET:
  -number = number of players (default 4, max 10);
  -fish = number of initial fish (default double players)
  -h = height of grid items, expressed in px, overriding tailwind
  -rate = rate of replace, default 1.5
-->

<div class=" mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Fishing Game</h1>
  <div class="  mx-auto p-4 mt-2 bg-white text-black mb-5">
    <?php
    if(isset($_GET['test'])) {
      var_dump($get_selectors);
    }
    ?>
    <div class="flex items-center justify-center rounded-full border border-black inline-block h-20 w-1/3 mx-auto mb-2 bg-sky-100 relative">
      <p class="absolute left-5 top-2 text-2xl hidden lg:inline-block">Fish:<p>
      <p id= "fishCount" class="text-center font-mono text-6xl "></p>
    </div>
    
    <div class="grid grid-cols-2 gap-2 mb-2 select-none">
      <?php
      $bgColours = array("bg-pink-100", "bg-sky-100","bg-pink-200", "bg-sky-200", "bg-pink-300", "bg-sky-300", "bg-pink-100", "bg-sky-100","bg-pink-200", "bg-sky-200", "bg-pink-300", "bg-sky-300", "bg-pink-100", "bg-sky-100","bg-pink-200", "bg-sky-200", "bg-pink-300", "bg-sky-300", "bg-pink-100", "bg-sky-100","bg-pink-200", "bg-sky-200", "bg-pink-300", "bg-sky-300");
      for($x=0; $x<$get_selectors['number']; $x++) {
      ?>
      <div class="text-center rounded  flex items-center justify-center <?=$bgColours[$x]?>" <?=($get_selectors['h']) ? "style = 'height: ".$get_selectors['h']."px'" : ""?> onclick = "goFish(<?=$x?>)">
      <div>
        <p class="text-lg" >Player <?=$x + 1?></p>
        <p>Fish this Round: <span id="fishCount_<?=$x?>" class="fishCountIndDiv"></span></p>
        <p>Total Fish All Rounds: <span class="totalCount"></span></p>
      </div>
        
      </div>
      <?php
      }
      ?>

    </div>
    <button id="startButton" class="w-full border border-black rounded bg-pink-200 mb-1 hidden" onclick="timer()">Start</button>
    <button id="newRoundButton" class="w-full border border-black rounded bg-sky-200 mb-1 disabled:bg-pink-200 disabled:italic" onclick="newRound();">Start Game</button>

    <div class="grid grid-cols-2">
      <div>
        <p class="text-center text-lg"><span class="hidden lg:inline-block">Time Left:</span> <span id="progressBar">10</span> seconds</p>
      </div>
      <div>
        <div id="summaryDiv" class="hidden">
          <h2 class="text-lg underline">Summary</h2>
          <p>There were <span id="fishLeft"></span> fish left in the pool.</p>
          <p>Next round there will be <span id="fishPlus"></span> more fish.</p>
        </div>
        <div id="gameInPlayDiv" class="bg-sky-200 w-full h-full flex items-center justify-center hidden">
          <p>Game in Play</p>
        </div>
        <div id="endOfGame" class="hidden bg-pink-200 w-full h-full flex items-center justify-center">
          <p class="text-center">The game has finished</p>
        </div>
      </div>

    </div>
    
    <div class="hidden">
      <p>Totals:</p>
      <?php
      for($x=0; $x<4; $x++) {
        ?>
        <p class="">Player <?=$x+1?>: <span class=""></span></p>
        <?php
      }
      ?>
    </div>
  </div>
</div>



<script>

  var fishCount = <?=$get_selectors['fish']?>;
  var fishAllocate = [<?php
    for($x=0; $x<$get_selectors['number']; $x++){
      echo "0";
      if($x<($get_selectors['number']-1)) {
        echo ",";
      }
    }
    ?>];
  var totals = [<?php
    for($x=0; $x<$get_selectors['number']; $x++){
      echo "0";
      if($x<($get_selectors['number']-1)) {
        echo ",";
      }
    }
    ?>];
  var round = 0;
  var rate = <?=$get_selectors['rate']?>;

  var started = 0;
  var gameInPlay = 0

  const startButton = document.getElementById("startButton");
  const newRoundButton = document.getElementById("newRoundButton");
  const summaryDiv = document.getElementById("summaryDiv");
  const gameInPlayDiv = document.getElementById("gameInPlayDiv");
  const endOfGame = document.getElementById("endOfGame");

  update();
  updateRound();

  function update() {
    const fishCountDiv = document.getElementById("fishCount");
    fishCountDiv.innerHTML = fishCount;

    const fishCountIndDiv = document.getElementsByClassName('fishCountIndDiv');
    for (var i=0; i<fishCountIndDiv.length; i++) {
      fishCountIndDiv[i].innerHTML = fishAllocate[i];
    }



    //console.log(fishCount);
    //console.log(fishAllocate);
    //console.log(totals);
    //console.log(round);
    
  }

  function updateRound() {
    const countSpans = document.getElementsByClassName('totalCount');
    for (var i=0; i<countSpans.length; i++) {
      countSpans[i].innerHTML = totals[i];

    }

  }

  function updateFinish() {
    const fishLeft = document.getElementById("fishLeft");
    const fishPlus = document.getElementById("fishPlus");
    fishLeft.innerHTML = fishCount;
    fishPlus.innerHTML = Math.floor(fishCount*rate) - fishCount;
  }

  function goFish(i) {
    if(gameInPlay == 1) {
      if(fishCount > 0) {
        fishCount --;
        fishAllocate[i] ++;
      }
      update();
      endGame();
    }

  }

  function updateCount() {
    for(var i=0; i<fishAllocate.length; i++) {
        totals[i] = totals[i]+fishAllocate[i];
        fishAllocate[i] = 0;
      }
      fishCount = Math.floor(fishCount*rate);

  }

  function newRound() {
    if(started == 0) {
      newRoundButton.innerHTML = "Next Round";
      started = 1
    } else {
      updateCount();
      round ++;
    }
    
    


    update();
    updateRound();
    timer();
  }


  function timer()  {
    //Stop all preivous running timers:
    for (var i = 1; i < 99999; i++) {
      window.clearInterval(i);
    }

    var timeleft = 10;
    newRoundButton.disabled = true;
    gameInPlay = 1;
    toggleGameInPlay(1);
    document.getElementById("progressBar").innerHTML = timeleft;
    timeleft -= 1;
    var downloadTimer = setInterval(function(){
      if(timeleft <= 0){
        clearInterval(downloadTimer);
        gameInPlay = 0;
        newRoundButton.disabled = false;
        gameInPlay = 0;
        updateFinish();
        toggleGameInPlay(0);
      }
      document.getElementById("progressBar").innerHTML = timeleft;
      timeleft -= 1;

    }, 1000);
    
    
  }

  

  function toggleGameInPlay(play) {
    
    if(play == 0) {
      summaryDiv.classList.add("block");
      summaryDiv.classList.remove("hidden");
      gameInPlayDiv.classList.add("hidden");
      gameInPlayDiv.classList.remove("block");

    }
    if(play == 1) {
      summaryDiv.classList.add("hidden");
      summaryDiv.classList.remove("block");
      gameInPlayDiv.classList.add("block");
      gameInPlayDiv.classList.remove("hidden");

    }
  }

  function endGame() {
    if(fishCount == 0) {
      //Stop all preivous running timers:
      for (var i = 1; i < 99999; i++) {
        window.clearInterval(i);
      }
    summaryDiv.classList.add("hidden");
    summaryDiv.classList.remove("block");
    gameInPlayDiv.classList.add("hidden");
    gameInPlayDiv.classList.remove("block");

    endOfGame.classList.add("block");
    endOfGame.classList.remove("hidden");

    
    }
    

  }

  
</script>

<?php   include($path."/footer_tailwind.php");?>