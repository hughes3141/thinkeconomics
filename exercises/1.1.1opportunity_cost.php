<html>


<head>

<?php include "../header.php"; ?>

<style>

.sectionDiv {

display:  none;
}

table {
border-collapse: collapse;
border: 1px solid black;


}

td, th {
border: 1px solid black;
padding: 5;}

div {padding:5;}

.correct {


background-color: #b3ffb3;

}

.incorrect {


background-color: #ffffb3;
//#ffd699;
}

</style>

</head>


<body>


<?php include "../navbar.php"; ?>


<h1>Opportunity Cost Exercise</h1>
<div id="div1" class="sectionDiv">
<p>Think of two goods that you would like to purchase:</p>
<p>Good 1: <input type="text" id="f01"></p>
<p>Good 2: <input type="text" id="f02"></p>
<button onclick="next(count), update()">Next</button>
</div>

<div id="div2" class="sectionDiv">
<p>How much do these goods cost?</p>
<p><span class="g1">Good 1</span>: &#163; <input type="text" id="f03"></p>
<p><span class="g2">Good 2</span>: &#163; <input type="text" id="f04"></p>
<button onclick="prev(count), update()">Previous</button>
<button onclick="next(count), update()">Next</button>
</div>

<div id="div3" class="sectionDiv">
<p>Describe the benefit you would get from each good:</p>
<p>&#34;The benefit I recieve from consuming <span class="g1lower">Good 1</span> is: <input type="text" id="f05">&#34;</p>
<p>&#34;The benefit I recieve from consuming <span class="g2lower">Good 2</span> is: <input type="text" id="f06">&#34;</p>
<button onclick="prev(count), update()">Previous</button>
<button onclick="next(count), update()">Next</button>
</div>

<div id="div4" class="sectionDiv">
<p>Now assume that you only have enough money or time to purchase and consume one of the goods. Which good would you choose?</p>

<input type="radio" id="f07" name="choice">
<label for="f07"><span class="g1">Good 1</span></label><br>
<input type="radio" id="f08" name="choice">
<label for="f08"><span class="g2">Good 2</span></label><br>
<br>


<button onclick="prev(count), update()">Previous</button>
<button onclick="next(count), update()">Next</button>
</div>

<div id="div5" class="sectionDiv">
<h2>Summary:</h2>
<p>The table below summarises the information you have provided:</p>
<table>
<tr>
<th></th>
<th>Good 1:<br><span class="g1">
</th>
<th>Good 2:<br><span class="g2">
</th>
</tr>
<tr>
<td>Cost</td>
<td>&#163;<span class="g1price">Good 1</span></td>
<td>&#163;<span class="g2price">Good 2</span></td>
</tr>

<tr>
<td>Benefit</td>
<td><span class="g1benefit">Good 1</span></td>
<td><span class="g2benefit">Good 2</span></td>
</tr>

</table>
<p>In a world of scarcity, you have chosen <b><span class="choice"></span>.</b></p>
<p>Choose the answer that best completes the following statement:</p>
<p><em>The opportunity cost of consuming <b><span class="choice"></span></b> is:</em></p>
<div id="questionDiv">


</div>
<button onclick="prev(count), update()">Previous</button>
<button onclick="submit()">Submit Answer</button>

<div class ="sectionDiv correct" id="div6">
<h2>Correct!</h2>

<p>Well done, you&rsquo;ve identified the correct opportunity cost for consuming <span class="choice"></span>.</p>
<button onClick="reload()">Play again</button>



</div>

<div class ="sectionDiv incorrect" id="div7">
<h2>Oops! Wrong answer</h2>
<p>Don&rsquo;t worry, just try again.</p>
<p>Remember: <strong>Opportunity Cost</strong> is the <em>benefit</em> of the <em>next best alternative foregone</em>.</p>
<p>Look at your summary table again. What item is being <em>foregone</em> when you consume <span class="choice"></span>? What is the benefit of this foregone item?</p>

</div>


</div>


<?php include "../footer.php"; ?>

<script>
var count = 0
next(count);

var good1 = []
var good2 = []
var index = [];
var index2= [];



var choice;


function reload() {

window.location.reload();
}


function update() {

console.clear();

good1[0] = document.getElementById("f01").value;

good2[0] = document.getElementById("f02").value;


	
	
	
	
good1[1] = document.getElementById("f03").value;
good2[1] = document.getElementById("f04").value;

good1[2] = document.getElementById("f05").value;
good2[2] = document.getElementById("f06").value;

good1[3] = 0;
good2[3] = 0;

var check1 = document.getElementById("f07");
var check2 = document.getElementById("f08");

if (check1.checked) {
	good1[3] = 1; good2[3] = 0;
	if(good1[0] != "") {choice = good1[0]; } else {choice = "Good 1"}}

else if (check2.checked) {
	good2[3] = 1; good1[3] = 0;
	if(good2[0] != "") {choice = good2[0]; } else {choice = "Good 2"}}





		
index[0] = ["&#163;"+good1[1], 0];
index[1] = ["&#163;"+good2[1], 0];
index[2] = [good1[2], good2[3]];
index[3] = [good2[2], good1[3]];



var diff;
if (parseFloat(good1[1])>parseFloat(good2[1])) { diff = parseFloat(good1[1])-parseFloat(good2[1])}
else if (parseFloat(good2[1])>parseFloat(good1[1])) { diff =  parseFloat(good2[1])-parseFloat(good1[1])}
else if (parseFloat(good2[1])==parseFloat(good1[1])) { diff =  parseFloat(good2[1])-parseFloat(good1[1])}

console.log(diff);

if (typeof diff !== 'undefined') {index[4] = ["&#163;" + diff.toString(), 0]};


//Include the following if you also wish to make the name of the unchosen good also an option:
//if (good2[3]==1) {index[5]=[good1[0],0]} else if (good1[3]==1) {index[5]=[good2[0],0]};


//Index2 is the randomised version of index1
index2 = [];

while (index.length>0) {

	var j = Math.floor(Math.random()*index.length);
	index2.push(index[j]);
	index.splice(j, 1);



}


var questionDiv = document.getElementById("questionDiv");
questionDiv.innerHTML = "";

for (var i=0; i<index2.length; i++) {

var questionChoice = document.createElement('div');

var button = document.createElement('input');
button.setAttribute("type", "radio");
button.setAttribute("name", "MCQ");
button.setAttribute("id", "h"+i);

var label = document.createElement('label');
label.setAttribute("for", "h"+i);
label.innerHTML = index2[i][0];

var breaker = document.createElement('br');

questionChoice.appendChild(button);
questionChoice.appendChild(label);
questionChoice.appendChild(breaker);

questionDiv.appendChild(questionChoice);





}




//console.log(good1);
//console.log(good2);
//console.log(choice);
console.log("index:");
console.log(index);
console.log("index2:");
console.log(index2);



	if (good1[0] != "") {
		var g1 = document.getElementsByClassName("g1");
		for(var i=0; i<g1.length; i++) {
			g1[i].innerHTML = good1[0];
		}
	}

	if (good2[0] != "") {
		var g2 = document.getElementsByClassName("g2");
		for(var i=0; i<g2.length; i++) {
			g2[i].innerHTML = good2[0];

		}
	}

	if (good1[0] != "") {
		var g1 = document.getElementsByClassName("g1lower");
		for(var i=0; i<g1.length; i++) {
			g1[i].innerHTML = good1[0].toLowerCase();
		}
	}

	if (good2[0] != "") {
		var g2 = document.getElementsByClassName("g2lower");
		for(var i=0; i<g2.length; i++) {
			g2[i].innerHTML = good2[0].toLowerCase();

		}
	}
	
	
	if (good1[1] != "") {
		var g1price = document.getElementsByClassName("g1price");
		for(var i=0; i<g1price.length; i++) {
			g1price[i].innerHTML = good1[1];
		}
	}

	if (good2[1] != "") {
		var g2price = document.getElementsByClassName("g2price");
		for(var i=0; i<g2price.length; i++) {
			g2price[i].innerHTML = good2[1];

		}
	}
	
	
	if (good1[2] != "") {
		var g1benefit = document.getElementsByClassName("g1benefit");
		for(var i=0; i<g1benefit.length; i++) {
			g1benefit[i].innerHTML = good1[2];
		}
	}

	if (good2[2] != "") {
		var g2benefit = document.getElementsByClassName("g2benefit");
		for(var i=0; i<g2benefit.length; i++) {
			g2benefit[i].innerHTML = good2[2];

		}
	}
	

var choiceSpan = document.getElementsByClassName("choice");
		for(var i=0; i<choiceSpan.length; i++) {
			choiceSpan[i].innerHTML = choice;

		}

}


function next(i) {

count ++;


var nextDiv = document.getElementById("div"+count);
nextDiv.style.display="block";

if (count>1) {

	var prevDiv = document.getElementById("div"+(count-1));
	prevDiv.style.display="none";
	}


}

function prev(i) {

count --;


var nextDiv = document.getElementById("div"+count);
nextDiv.style.display="block";



	var prevDiv = document.getElementById("div"+(count+1));
	prevDiv.style.display="none";
	

document.getElementById("div6").style.display="none";
document.getElementById("div7").style.display="none";

document.getElementById("div5").classList.remove("correct");
document.getElementById("div5").classList.remove("incorrect");
}


function submit() {

var answer = [];

for (var i=0; i<index2.length; i++) {

	var button = document.getElementById("h"+i);
	//var checked;
	if (button.checked == true) {answer = i};
	//answers.push(checked);

}

//console.log(answer);

if (index2[answer][1] == 1) {

	document.getElementById("div6").style.display="block";
	document.getElementById("div5").classList.add("correct");
	document.getElementById("div7").style.display="none";
	document.getElementById("div5").classList.remove("incorrect");
	} 

	else {
	
	document.getElementById("div7").style.display="block";
	document.getElementById("div5").classList.add("incorrect");
	document.getElementById("div6").style.display="none";
	document.getElementById("div5").classList.remove("correct");
	}

}

</script>


</body>



</html>