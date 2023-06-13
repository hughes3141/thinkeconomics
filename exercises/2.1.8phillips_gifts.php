<!DOCTYPE html>



<html lang=en>

<head>

<?php include "../header.php"; ?>

<style>

table {
	border-collapse: collapse;
	
}

td, th {

	border: solid 1px black;
	padding: 5px;
}

#inputDiv {
border: solid 1px black;
padding: 5px;
background-color: pink;
}

#happiness, .happyCell {
	font-size: x-large;
}

</style>

</head>


<body>

<?php include "../navbar.php"; ?>

<h1>2.1.8 Gift Giving Phillips Curve Game</h1>

<p>You are shopping for gifts for your best friend. You need to decide how many gifts to give them to make them happy.</p>
<p>Their happiness is determined by how many gifts they expect from you that year.</p>
<p>Their expectation of gifts this year is determined by the number of gifts you gave last year.</p>
<p>Play the game to see if you can make your friend happy!</p>


<div id="inputDiv">
<p>Year: <span id="year"></span></p>
<p>Your friend expects <span id="expectation">0</span> gifts this year.</p>
<p>How many gifts do you want to give them?
<select name ="gift" id="gift" onchange="happyCheck()"> 

<option>0</option>
<option>1</option>
</select>
</p>
<p>This will make your friend this happy: <span id="happiness">😐</span></p>
<button onclick="giveGift()">Give Gift</button>
</div>

<p>
Summary Table:
<table id="summaryTable">
<tr>
<th>Year</th>
<th>Gifts Given</th>
<th>Happiness</th>
<th>Gift Expectation</th>
<tr></table>
</p>

<button onclick="reset()">Reset Game</button>

<h2>Summary Questions:</h2>
<ol>
<li>What is the relationship between your friend&rsquo;s happiness, the number of gifts you give them, and their expectations?</li>
<li>What is the problem with always trying to keep your friend happy each year?</li>
<li>How can you get the gift giving back under control?</li>
<li>What do you think will be the best way to make your friend happy in the long run? (Think outside the box here)</li>
<li>How does this game illustrate the concept behind The Phillips Curve?</li>
</ol>


<?php include "../footer.php"; ?>
<script>



var expectation = 0;

var gift;

var happy;

var year = 1;
document.getElementById("year").innerHTML = year;


function reset() {
	expectation = 0;

	year = 1;
	document.getElementById("year").innerHTML = year;
	
	var table = document.getElementById("summaryTable").innerHTML ="<tr><th>Year</th><th>Gifts Given</th><th>Happiness</th><th>Gift Expectation</th><tr>"
	var select = document.getElementById("gift").innerHTML = "<option>0</option><option>1</option>";
}

function happyCheck() {


	var giftGiven = document.getElementById("gift").value;
	if (giftGiven > expectation) {
		happy = "😊"}
	else if (giftGiven == expectation) {
		happy = "😐"}
	else if (giftGiven < expectation) {
		happy = "☹️"}
	document.getElementById("happiness").innerHTML = happy;
	

}

function giveGift() {

	var giftGiven = parseInt(document.getElementById("gift").value);
	if (giftGiven > expectation) {
		happy = "😊"}
	else if (giftGiven == expectation) {
		happy = "😐"}
	else if (giftGiven < expectation) {
		happy = "☹️"}
		
		
var table = document.getElementById("summaryTable");
	var row = table.insertRow(year+1);
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	var cell4 = row.insertCell(3);
	
	cell1.innerHTML = year;
	cell2.innerHTML = giftGiven;
	cell3.innerHTML = happy;
	cell3.classList.add("happyCell")
	cell4.innerHTML = expectation;
		
document.getElementById("happiness").innerHTML = happy;
year++;
document.getElementById("year").innerHTML = year;
expectation = giftGiven;
document.getElementById("expectation").innerHTML = expectation;





var giftSelect = document.getElementById("gift");

giftSelect.innerHTML = "";

	for(var i=1; i>-2; i--) {
	
		var option = document.createElement("option");
		option.text = expectation - i;
		
		if ((expectation - i) == expectation) {
			option.selected = true;
		
		}
		
		if( expectation - i >= 0) {
		
			giftSelect.add(option)
		}
		
		
		
	}
	
	happyCheck();
		

	


}




</script>

</body>





</html>