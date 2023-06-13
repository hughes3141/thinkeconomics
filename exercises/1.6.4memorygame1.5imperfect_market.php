<!DOCTYPE html>

<html lang="en">


<head>

<?php include "../header.php" ?>

<style>

.grid-container {
  display: grid;
  grid-template-columns: repeat(4, 25%);
  
  background-color: #2196F3;
  padding: 10px;
  
}

.grid-item {
  background-color: rgba(255, 255, 255, 0.8);
  border: 1px solid rgba(0, 0, 0, 0.8);
 // padding: 20px;
  //font-size: 30px;
  //font-size: 200%;
  font-size: 2.5vw;
  text-align: center;
 // height: 170px;
  
	display:flex;justify-content:center;align-items:center;height:170px;
 
 
 
  margin: 10px;
  
  word-wrap: break-word;
overflow:hidden;
  
  }


@media screen and (max-width: 800px) {
  .grid-container {
		display: grid;
		grid-template-columns: repeat(2, 50%);
  
		background-color: #2196F3;
		padding: 10px;
	}

	.grid-item {
		
		font-size:3.5vw;
	}
	

}



 

.noselect {
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome and Opera */
}





/* Variabes */  
$orange: #ffa600;
$grey:#f3f3f3;
$white: #fff;
$base-color:$orange ;


/* Mixin's */  
@mixin transition {
-webkit-transition: all 0.5s ease-in-out;
-moz-transition: all 0.5s ease-in-out;
transition: all 0.5s ease-in-out;
}
@mixin corners ($radius) {
-moz-border-radius: $radius;
-webkit-border-radius: $radius;
border-radius: $radius; 
-khtml-border-radius: $radius; 
}

body {
background:$base-color;
font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; 
height:100%;
}

//.wrapper {
width: 800px;
margin: 30px auto;
color:$white;
text-align:center;
}

//h1, h2, h3 {
  font-family: 'Roboto', sans-serif;
  font-weight: 100;
  font-size: 2.6em;
  text-transform: uppercase;
}

#seconds, #tens, #guesses, #adjusted_time{
  font-size:2em;
}


#feedbackContain {
	//border: solid 5px black;
	//width: 50%;
	position: relative;
	}
	
#resetButton {
	position: absolute;
	right: 0;
	top: 0;
	height: 100%;
	width: 50%;
	font-size: 2em;
}
}


//button{
@include corners (5px);
background:$base-color;
color:$white;
border: solid 1px $white;
text-decoration:none;
cursor:pointer;
font-size:1.2em;
padding:18px 10px;
width:180px;
//width: 100%;
margin: 10px;
 outline: none;
  &:hover{
	@include transition;
	background:$white;
	border: solid 1px $white;
	color:$base-color;
	}
	
	
}	





</style>

</head>

<body onload= "myFunction()">

<?php include "../navbar.php" ?>

<h1>1.6.4 Imperfect Markets Dynamic Changes Matching Game</h1>

<p>Test your memory and your knowledge to match the cards with the correct descriptions and images. How fast can you go? How few incorrect guesses can you make?</p>
<div id ="feedbackContain">
<p>Time: <span id="seconds">00</span>:<span id="tens">00</span></p><p></p>Incorrect Guesses: <span id ="guesses">0</span></p>

<p>Score: <span id="adjusted_time">0</span></p>

<button id ="resetButton" onclick ="myFunction(); stopTime(); resetTime()">Click to Reset</button>
</div>
<div class="grid-container" id="grid" onclick ="myClear()">


 
<!--
</div>


<div class="wrapper">
<h1>Stopwatch</h1>
<h2>Vanilla JavaScript Stopwatch</h2>

<button id="button-start">Start</button>
<button id="button-stop">Stop</button>
<button id="button-reset">Reset</button>
</div> 
-->

<?php include "../footer.php" ?>
<script>





var choices = ["Demand Increases", "", "Demand Decreases", "", "Variable Costs Increase", "", "Variable Costs Decrease", "", "Fixed Costs Increase", "", "Fixed Costs Decrease", ""];



var images = ["", "memgame3_d+.JPG", "", "memgame3_d-.JPG", "", "memgame3_vc+.JPG", "", "memgame3_vc-.JPG", "", "memgame3_fc+.JPG", "", "memgame3_fc-.JPG"];
root ="files/";


// Also consider using Allocative Efficiency instead of positive externalities in production: memgame1_ae.JPG

var key = [0,0,1,1,2,2,3,3,4,4,5,5]

order_g = [];

flip_card = "";


var clicks = 0;
var correct = 0;



function myFunction() {
count = 0;
document.getElementById("guesses").innerHTML = count;
correct = 0;

var order = [];
var tries = [];


	var i;
	for (i=0; i<choices.length; i++) {
		var k = 0;
		var l = false;
		while (l==false) {
			var j= Math.floor(Math.random()*choices.length);
			if (order.includes(j)== false) {order[i]=j; l=true;};
			k++;
		}
		tries [i] = k;
	}


order_g = order;


	var grid_items = document.getElementsByClassName("grid-item")
	var i;
	for (i=0; i<grid_items.length; i) {
	grid_items[i].remove();
	}

	var i;
	for (i=0; i<choices.length; i++) {
	
		var grid = document.getElementById("grid");
		var cell = document.createElement("div");
		cell.className = "grid-item noselect";
		cell.setAttribute("id", "grid"+i);
		
		cell.setAttribute("onclick", "compareCard("+i+"), startTime(), checkTime()");
		cell.innerHTML = flip_card;
		
		
		
		grid.appendChild(cell);
	}
 


}

function flipCard(i) {
	var card = document.getElementById("grid"+i);
	card.innerHTML = choices[order_g[i]];
	card.style.backgroundColor ="yellow";
	
	clicks ++;

	
	
		
	if (images[order_g[i]] !== "") {
		var img = document.createElement("img");
		img.src = root+images[order_g[i]];
		img.style.width = "100%";
		img.style.height = "100%";
		/*img.style.display = "inline-block";*/
		card.appendChild(img);
	
		}
	
}

var compare = [];
var click_order = [];
var count = 0;
var clear_rec = [];



function compareCard(i) {



flipCard(i);


click_order.push(i);
var a = click_order.slice(0, click_order.length-1);
var b = click_order.slice(click_order.length-2);





if (a.includes(i)==false) {
		compare.push(key[[order_g[i]]]);		
		}


		
		if ((compare[0] == compare[1])) {
					
					var j;
					for(j=0; j<click_order.length; j++) {
							document.getElementById("grid"+click_order[j]).style.backgroundColor ="pink";
							document.getElementById("grid"+click_order[j]).setAttribute("onclick", "")
							}
					document.getElementById("grid"+click_order[j])
					/* clear_rec.push(true); */
					compare = [];
					click_order = [];
					
					correct = correct +2;
					
					
					}
					
					
					else {
					
					if (compare.length >=2) {
							clear_rec.push(false);
							
							
							}
					
					} 
					
	
					
		/*
		if ((compare.length==2)&&(b.includes(i)==true))
					
					
					
					}
		*/
		
		/*
		if ((compare.length == 3)) {
					
					var j;
					for(j=0; j<click_order.length; j++) {
							document.getElementById("grid"+click_order[j]).innerHTML = "Flip Card";
							}
					compare = [];
					click_order = [];
					count ++;
					clear_rec = [];
					
					}
		*/




	console.clear();

	console.log("click order: "+click_order);
	console.log("compare: "+compare);
	console.log(clear_rec);
	console.log(clear_rec[clear_rec.length-2]);
	console.log(count);
	document.getElementById("guesses").innerHTML = count;
	console.log(clicks);
	console.log(correct);
	
	
	
	



	


}

function myClear() {



if (clear_rec[clear_rec.length-2] == false) {
					
					var j;
					for(j=0; j<click_order.length; j++) {
							document.getElementById("grid"+click_order[j]).innerHTML = flip_card;
							document.getElementById("grid"+click_order[j]).style.backgroundColor="rgba(255, 255, 255, 0.8)";
							}
							
							
					compare = [];
					click_order = [];
					count ++;
					document.getElementById("guesses").innerHTML = count;
					clear_rec = [];
					
					
					
					
					}


}

function checkTime() {

	if (correct == choices.length) {
						
							
							stopTime();
							//alert("you win");
						}
	
	//For score keeping:
	  //document.getElementById("adjusted_time").innerHTML = 120 - (seconds+count*5);
	 document.getElementById("adjusted_time").innerHTML = correct*10 - (seconds+count*5);
}



  
  var seconds = 00; 
  var tens = 00; 
  var appendTens = document.getElementById("tens")
  var appendSeconds = document.getElementById("seconds")
  var buttonStart = document.getElementById('button-start');
  var buttonStop = document.getElementById('button-stop');
  var buttonReset = document.getElementById('button-reset');
  var Interval ;

function startTime() {
    
    clearInterval(Interval);
     Interval = setInterval(startTimer, 10);
  }
  

buttonStop.onclick = stopTime;
buttonStart.onclick = startTime;
 
 function stopTime() {
       clearInterval(Interval);
  }
  

  

  buttonReset.onclick = resetTime
  
  function resetTime() {
     clearInterval(Interval);
    tens = "00";
  	seconds = "00";
    appendTens.innerHTML = tens;
  	appendSeconds.innerHTML = seconds;
	
	//For score keeping:
	  document.getElementById("adjusted_time").innerHTML = 0;
	
	
	
  }
  
   
  
  function startTimer () {
    tens++; 
    
    if(tens <= 9){
      appendTens.innerHTML = "0" + tens;
    }
    
    if (tens > 9){
      appendTens.innerHTML = tens;
      
    } 
    
    if (tens > 99) {
      console.log("seconds");
      seconds++;
      appendSeconds.innerHTML = "0" + seconds;
      tens = 0;
      appendTens.innerHTML = "0" + 0;
	  
	  //For score keeping:
	  //document.getElementById("adjusted_time").innerHTML = 120 - (seconds+count*5);
	  document.getElementById("adjusted_time").innerHTML = correct*10 - (seconds+count*5);
    }
    
    if (seconds > 9){
      appendSeconds.innerHTML = seconds;
    }
  
  }
  



</script>

</body>

</html>