<html>

<head>

<?php include "../header.php";?>

<style>

#t01 {

background-color: #FFFF99;
padding: 10px;
border: solid 3px red;
display: none;
font-size: 16pt;
}


.ans {
padding: 30px;background-color: pink;
display: none;
border: 1px solid black;

}

table, td, tr, th {

border: 2pt solid black;
border-collapse: collapse;

}

td {

}

li {


}

.ans_link {

display: none;
margin-bottom: 20px;
margin-top: 20px;

}



</style>

</head>


<body><?php include "../navbar.php";?>


<h1>1.2.2 Economic Equilibrium: Game</h1>
<div id ="14">
<h1>Instructions</h1>
<p>This is a role-playing game in which you are going to imagine that you are buying or selling a house.</p>

<ol>
<li>Your character will either be a buyer or a seller.</li>
<li>Do not tell <strong>ANYBODY</strong> about the price that you are willing to sell the house for or pay for a new one. This is private information.</li>
<li>If the price is right, you <strong>MUST</strong> sell/buy for the price that is dictated on the card.</li>
<li>All houses are the same, and there is no point of holding out for something better.</li>
<li>In the first two rounds, the prices will be given by an external source. Act on this information.</li>
</ol>
</div>

<div id="13" style="display:none;">
<h1>Round 2</h1>
<p>You are going back to the market.</p>
<p>This time assume a new identity. Your teacher will assign you a new number.</p>
<p>Sell or buy a house. Talk with the other people there, get a feel for the market.</p>
<p>But:</p>
<p><strong>Do not tell people how much you would be willing to buy or sell your house.</strong></p>
</div>

<p>Your character number (assigned by teacher):
<select name="chars" id="chars">
  <option value="0">1</option>
  <option value="1">2</option>
  <option value="2">3</option>
  <option value="3">4</option>
  <option value="4">5</option>
  <option value="5">6</option>
  <option value="6">7</option>
  <option value="7">8</option>
  <option value="8">9</option>
  <option value="9">10</option>
  <option value="10">11</option>
  <option value="11">12</option>
  <option value="12">13</option>
  <option value="13">14</option>
  <option value="14">15</option>
  <option value="15">16</option>
  <option value="16">17</option>
  <option value="17">18</option>
  <option value="18">19</option>
  <option value="19">20</option>
  <option value="20">21</option>
  <option value="21">22</option>
</select>
</p>


  <br><br>
  <button id="button1" >Click for character information</button>
  <br><br>

<div id ="t01">

<p>You are a <strong><span id = "02"></span></strong> in this market.</p>
<p id="04"></p>

<p><span id="05"></span><strong>&pound;<span id="03"></span>,000 </strong><span id="06"></span></p>


<p><strong>You must make deals if the price is right.</strong></p>
<a href="#/" id="07">Click here for Round 1 Instructions</a>
<a href="#/" id="12" style="display:none;">Round 2: Click when prices are revealed.</a>

</div>
<div id = "08" style="display:none">
<h1>Round 1</h1>
<p>Meet with the other buyers and sellers. Get a feel of who is willing to buy and sell.</p>
<p><strong>Do not tell people how much you would be willing to buy or sell your house.</strong></p>
<p>When the time is right, your teacher will tell you the price that the estate agents think houses in the road will go for.</p>
<a href="#/" id="09">Click here when prices are revealed</a>
<div id ="10" style="display:none">
<h1>Prices Revealed!!!</h1>
<p>Once you learn of the selling price, you can decide what you want to do. Are you going to buy a house? Are you going to sell one?</p>
<p>Once people make up their mind, you want to make a deal. Get the best house that you can! (And don&rsquo;t be shy)</p>
<ol>
<li>How many houses were bought and sold?</li>
<li>How did you decide who got to buy/sell?</li>
<li>Who was happy? Who was not?</li>
<li>What does this suggest about the price?</li>
</ol>
<h1>Discussion</h1>
<p>Who is happy, who is frustrated?</p>
<p>How long were the houses on the market?</p>
<p>Did they get snatched up, or did they linger?</p>
<p>Was it a buyer&rsquo;s or seller&rsquo;s market?</p>
<p>Were the houses allocated fairly?</p>
<p>Once finished, click below for Round 2 instructions:</p>
<a href="#/" id="11">Click here for Round 2 Instructions</a>
</div>
</div>

<div id="15" style="display:none">
<h1>Prices Revealed: Round 2</h1>
<p>Once you learn of the selling price, you can decide what you want to do. Are you going to buy a house? Are you going to sell one?</p>
<p>Once people make up their mind, you want to make a deal. Get the best house that you can! (And don&rsquo;t be shy)</p>
<ol>
<li>How many houses were bought and sold?</li>
<li>How did you decide who got to buy/sell?</li>
<li>Who was happy? Who was not?</li>
<li>What does this suggest about the price?</li>
</ol>
<a href="#/" id="16">Click here when done</a>
</div>

<div id = "17" style="display:none">
<h1>Final Task: Pair up</h1>
<p>You are no longer going to rely on estate agents to set the price. You are now allowed to bargain for any price that you like.</p>
<p>Pair up between buyers and sellers using the following rules:</p>
<h2>Sellers:</h2>
<p>If somebody approaches you and makes you an offer for more than you were willing to sell the house, sell the house.</p>
<p><strong>However: if anybody else comes along and offers you a higher price, take that deal.</strong></p>
<p>Don&rsquo;t settle your pair until you are sure you&rsquo;ve got the best price.</p>
<h2>Buyers:</h2>
<p>If you find a house that a seller is willing to sell at a lower price than you are willing to buy, then buy the house!</p>
<p><strong>However: if you find another house for a lower price, take that deal (these houses are all the same)</strong></p>
<p>Don&rsquo;t settle your pair until you are sure you&rsquo;ve got the best price.</p>
<a href="#/" id="18">Click here for final review: supply and demand graph</a>
</div>

<div id ="19" style= "display:none">
<table id="table1" style="display:none;">

</table>
<p>We will now compare our findings on a supply and demand graph.</p>
<button onclick="draw2()">Click to draw sellers (supply)</button><br>
<button onclick="draw3()">Click to draw buyers (demand)</button><br>
<canvas id="myCanvas" width="700" height="500" style="border:1px solid;"></canvas>

<br>



</div>

<?php include "../footer.php";?>

<script>


var chars = [["Buyer","250"],["Seller","250"],["Buyer","275"],["Seller","275"],["Buyer","225"],["Seller","225"],["Buyer","300"],["Seller","300"],["Buyer","200"],["Seller","200"],["Buyer","325"],["Seller","325"],["Buyer","175"],["Seller","175"],["Buyer","350"],["Seller","350"],["Buyer","150"],["Seller","150"],["Buyer","375"],["Seller","375"],["Buyer","125"],["Seller","125"]];
var selltext = ["You have a house in town that you would like to sell.", "You are willing to sell for ", " and above."];
var buytext = ["You live outside of town and want to move to town.", "You are willing and able to pay ", " or less."];

document.getElementById("button1").onclick = function() {charcard()}

function charcard() {

	document.getElementById("t01").style.display = "block";
	
	var color;
	
	var x
	x = document.getElementById("chars").value;
	
	var buysell = chars[x][0];
	var price = chars[x][1];
	
	var s04;
	var s05;
	var s06;
	
	if (buysell == "Buyer") {s04 = buytext[0]; s05 = buytext[1]; s06=buytext[2]; color = "#B3FAA6";};
	if (buysell == "Seller") {s04 = selltext[0]; s05 = selltext[1]; s06=selltext[2]; color = "#A6F5FA";};
	
	document.getElementById("02").innerHTML = buysell;
	document.getElementById("03").innerHTML = price;
	document.getElementById("04").innerHTML = s04;
	document.getElementById("05").innerHTML = s05;
	document.getElementById("06").innerHTML = s06;
	document.getElementById("t01").style.backgroundColor = color;
	
	
	console.clear();
	console.log(buysell);
	console.log(price);
	console.log(s04, s05, s06);
}

document.getElementById("07").onclick = function() {
	document.getElementById("08").style.display="block";}
	
document.getElementById("09").onclick = function() {
	document.getElementById("10").style.display="block";}
	
document.getElementById("11").onclick = function() {
	document.getElementById("t01").style.display="none"
	document.getElementById("07").style.display="none";
	document.getElementById("08").style.display="none";
	document.getElementById("10").style.display="none";
	document.getElementById("12").style.display="block";
	document.getElementById("13").style.display="block";
	document.getElementById("14").style.display="none";}	
	
document.getElementById("12").onclick = function() {

	document.getElementById("15").style.display="block";}

document.getElementById("16").onclick = function() {
	document.getElementById("17").style.display="block";}
	
document.getElementById("18").onclick = function() {
	document.getElementById("19").style.display="block";}

console.log(chars);


function poptable() {




}


/*Canvas Elements*/ {

var c = document.getElementById("myCanvas");
		var ctx = c.getContext("2d");
		ctx.moveTo(50,450);
		ctx.lineTo(50,50);

		ctx.moveTo(50,450);
		ctx.lineTo(650,450);
		ctx.moveTo(50, 450);
		ctx.lineWidth = 2;
		ctx.stroke();
		ctx.font = "20px Arial"
		ctx.fillText("Quantity", 600 ,480)
		ctx.font = "20px Arial"
		
		ctx.save();
		ctx.translate(100,300);
		ctx.rotate(-0.5*Math.PI);
		ctx.fillText("Price" , 200, -80);
		ctx.restore();
		
	
		
		
		
		
		/*
		ctx.moveTo(100,450);
		ctx.beginPath();
		ctx.arc(100, 450, 5, 0, 2*Math.PI);
		ctx.fill();
		*/
		
		/* X Axis and gridlines */{
		
		var xaxis_values = [];
		var xspacing = 40
		var i;
		for (i=0; i<12; i++)
		{xaxis_values[i] = 50 + xspacing + xspacing*i}
		
		
		
		var i;
		for (i=0; i<xaxis_values.length; i++)
		{
		
		
		ctx.beginPath();
		ctx.moveTo(xaxis_values[i],445);
		ctx.lineTo(xaxis_values[i],455);
		ctx.stroke();
		}
		
		var i;
		for (i=0; i<xaxis_values.length; i++)
		{
		
		ctx.font = "10px Arial";
		ctx.fillText(i+1, xaxis_values[i]-4, 465);
		ctx.stroke();
		}
		
		var i;
		for (i=0; i<xaxis_values.length; i++)
		{
		ctx.setLineDash([1, 5]);/*dashes are 5px and spaces are 3px*/
		ctx.moveTo(xaxis_values[i],445);
		ctx.lineTo(xaxis_values[i],50);
		ctx.lineWidth = 1;
		ctx.stroke();
		
		}
}

		/* Y Axis and Gridlines */{
		
		var yaxis_values = [];
		var yspacing = 25
		var i;
		for (i=0; i<16; i++)
		{yaxis_values[i] = 450 -(yspacing + yspacing*i)}
		
		var i;
		for (i=0; i<yaxis_values.length; i++)
		{
		
		
		ctx.beginPath();
		ctx.moveTo(45, yaxis_values[i]);
		ctx.lineTo(55, yaxis_values[i]);
		ctx.stroke();
		}
		
		var i;
		for (i=0; i<yaxis_values.length; i++)
		{
		
		ctx.font = "10px Arial";
		ctx.fillText((i+1)*25, 25, yaxis_values[i]+2);
		ctx.stroke();
		}
		
		var i;
		for (i=0; i<yaxis_values.length; i++)
		{
		
		
		ctx.beginPath();
		ctx.setLineDash([1, 0]);
		ctx.moveTo(45, yaxis_values[i]);
		ctx.lineTo(55, yaxis_values[i]);
		ctx.stroke();
		}
		
		var i;
		for (i=0; i<yaxis_values.length; i++)
		{
		ctx.setLineDash([1, 5]);/*dashes are 5px and spaces are 3px*/
		ctx.moveTo(55, yaxis_values[i]);
		ctx.lineTo(xaxis_values[10]+xspacing, yaxis_values[i]);
		ctx.lineWidth = 1;
		ctx.stroke()
		}
}
		
		var sellers = [];
		
		var i;
		for (i=0; i<12; i++) {
		
		var x = xaxis_values[i];
		var y = yaxis_values[i] - (4*yspacing);
		sellers[i]= [x,y];
		
		
		}
		
		var buyers = [];
		
		
		
		
		}
		
		var i;
		for (i=0; i<12; i++) {
		
		var x = xaxis_values[i];
		var y = 450 -(15*yspacing - yspacing*i)
		buyers[i]= [x,y];}
		
		
		console.log(sellers);
		
		function draw2() {
		
		var i;
		for (i=0; i<11; i++) {
		
		xval = sellers[i][0];
		yval = sellers[i][1];
	
		/*ctx.lineTo(xval,yval);
		ctx.stroke();
		*/
		ctx.moveTo(xval, yval);
		ctx.beginPath();
		ctx.arc(xval, yval, 3, 0, 2*Math.PI);
		ctx.fillStyle = "red";
		ctx.fill();
		
		
			}
		}
		
		function draw3() {
		
		var i;
		for (i=0; i<11; i++) {
		
		xval = buyers[i][0];
		yval = buyers[i][1];
	
		/*ctx.lineTo(xval,yval);
		ctx.stroke();
		*/
		ctx.moveTo(xval, yval);
		ctx.beginPath();
		ctx.arc(xval, yval, 3, 0, 2*Math.PI);
		ctx.fillStyle = "blue";
		ctx.fill();
		
		
			}
		}
		








</script>

</body>

</html>