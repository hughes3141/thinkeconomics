<html>


<head>

<?php include "../header.php";
?>


<style>
	
	table, th, td {
		border: 1px solid black;
		/*font-size: 30pt;
		 border-collapse: collapse; */
		 
   
}

th, td {
padding: 5px;


}

.selectedButton {

background-color: pink;

}

#step2, #step3 {

	display: none;
}

#step1, #step2, #step3 {

	border: 2px solid black;
	padding: 5px;
	margin: 5px;

}

canvas {
    padding-left: 0;
    padding-right: 0;
    margin-left: auto;
    margin-right: auto;
    display: block;
    
}
	
	</style>


</head>


<body>
<?php include "../navbar.php";
?>



<h1>PPFs in Econ-Land</h1>
<div id="step1">
<h2>Step 1</h2>
<p>Congratulations- you are in charge of a fictitious country, <strong>Econ-Land!</strong> The two products that are produced here are:</p>
<ul>
<li>Corn</li>
<li>Radios</li>
</ul>
<p>Your country is divided into 5 districts. You are in charge of deciding which product is to be produced by each district. Each district can only produce one type of product.</p>
<p>First, let&rsquo;s assume that each district is equally good at producing each type of product. The summary is below:</p>
<table>
<tbody>
<tr>
<td width="301">
<p>District</p>
</td>
<td width="301">
<p>Production Levels</p>
</td>
</tr>
<tr>
<td width="301">
<p>All Districts</p>
</td>
<td width="301">
<p>3 corn units <em>or </em>3 radio units</p>
</td>
</tr>
</tbody>
</table>

<p>Assign production to districts using the table below, using &ldquo;Perfect Factor Substitution&rdquo;. See what this looks like on the PPF. What do we notice about the shape of this PPF?</p>
<button onclick="next(2)">Next</button>
</div>
<div id="step2">
<h2>Step 2</h2>
<p>Next, let&rsquo;s assume that each different of Econ-land is slightly different; different regions are better-suited to producing certain goods than others. The differences are described in the table below:</p>
<table>
<tbody>
<tr>
<td width="207">
<p>District</p>
</td>
<td width="184">
<p>Description</p>
</td>
<td width="211">
<p>Production Levels</p>
</td>
</tr>
<tr>
<td width="207">
<p>1: Prime Farmland</p>
</td>
<td width="184">
<p>This is the best farmland in the whole country, great for growing corn.</p>
</td>
<td width="211">
<p>5 corn units <em>or</em> 1 radio unit</p>
</td>
</tr>
<tr>
<td width="207">
<p>2: Average Farmland</p>
</td>
<td width="184">
<p>This is average farmland- not the best, but okay.</p>
</td>
<td width="211">
<p>4 corn units <em>or</em> 2 radio units</p>
</td>
</tr>
<tr>
<td width="207">
<p>3: &lsquo;Middle Land&rsquo;</p>
</td>
<td width="184">
<p>These are the exurbs, small towns, and all the places between the farms and the big city.</p>
</td>
<td width="211">
<p>3 corn units <em>or</em> 3 radio units</p>
</td>
</tr>
<tr>
<td width="207">
<p>4: Suburbs</p>
</td>
<td width="184">
<p>This is the outer region of the city, filled with houses and some office blocks.</p>
</td>
<td width="211">
<p>2 corn units <em>or</em> 4 radio units</p>
</td>
</tr>
<tr>
<td width="207">
<p>5: Inner City</p>
</td>
<td width="184">
<p>This is the urban area, full of factories, great for making radios.</p>
</td>
<td width="211">
<p>1 corn unit <em>or</em> 5 radio units</p>
</td>
</tr>
</tbody>
</table>
<p>Assign production to districts using the table below, using &ldquo;Imperfect Factor Substitution&rdquo;. See what this looks like on the PPF. What do we notice about the shape of this PPF?</p>
<button onclick="previous(1)">Previous</button>
<button onclick="next(3)">Next</button>
</div>
<div id="step3">
<h2>Step 3</h2>
<p>Now let&rsquo;s assume that the districts of Econ-land are only suited to producing one type of good. The production is now summarised below:</p>
<table>
<tbody>
<tr>
<td width="301">
<p>District</p>
</td>
<td width="301">
<p>Production Levels</p>
</td>
</tr>
<tr>
<td width="301">
<p>1: Prime Farmland</p>
<p>2: Average Farmland</p>
<p>3: &lsquo;Middle Land&rsquo;</p>
</td>
<td width="301">
<p>4 corn units</p>
<p>0 radio units</p>
</td>
</tr>
<tr>
<td width="301">
<p>4: Suburbs</p>
<p>5: Inner City</p>
</td>
<td width="301">
<p>0 corn units</p>
<p>4 radio units</p>
</td>
</tr>
</tbody>
</table>
<p>Assign production to districts using the table below, using &ldquo;Zero Factor Substitution&rdquo;. See what this looks like on the PPF. What do we notice about the shape of this PPF?</p>
<button onclick="previous(2)">Previous</button>

</div>

<br>


<canvas id="myCanvas" width="350" height="350" style="border:1px solid;"></canvas>

<br>
<br>

<button id="perfbut">Perfect Factor Substitution</button>
<button id="imperfbut">Imperfect Factor Substitution</button>
<button id="zerobut">Zero Factor Substitution</button>
<br>
<br>
<button onclick="penDown()" id="penButton">Click to Draw (Pen Down)</button>
<br>
<br>
<button onclick="clearCanvas(); drawCanvas(); calculate2()" >Click to Clear Canvas</button>
<br>
<br>



<table id="table2">
<tr>
<th>District</th>
<th>Corn</th>
<th>Radios</th>
</tr>
</table>
<br>
<table>
<tbody><tr><th>Corn Production</th><th>Radio Production</th></tr>
<tr><td id="cornprod"></td><td id="radprod"></td></tr>

</tbody></table>

<div>
<p>Questions:</p>
<ol>
<li>What is the <em>opportunity cost</em> of producing radios (in terms of corn) when we had <em>perfect factor substitutability</em>? Did the opportunity cost ever change?</li>
<li>With <em>imperfect factor substitutability</em>, what is the opportunity cost of:
<ol>
<li>Increasing Radio production from 0 to 5 units</li>
<li>Increasing radio production from 14 to 15 units.</li>
</ol>
</li>
<li>Explain why the opportunity cost changes in the way you have described above.</li>
<li>With <em>zero factor substitutability, </em>what is the opportunity cost of producing more radios or corn?</li>
<li>Explain how differences in <strong>factor substitutability</strong> affect the shape of the PPF and the opportunity cost as you move along it.</li>
<li><strong>Extension</strong>: Explain how you could draw a PPF with imperfect substitutability <em>the wrong way around</em>, i.e. <em>convex</em> toward the origin. What would you have to do to achieve this? Why is this not a true PPF?</li>
</ol>
</div>


<?php include "../footer.php";
?>
<script>

var regions = [

"Prime Farmland",
"Average Farmland",
"'Middle Land'",
"Suburbs",
"Inner City"

]


	var corn;
	var radios;
	
	/*
	
	Use this if using 9 regions:
	
	var regionrad = [0,0,0,0,0,0,0,0,0];
	var regioncor = [0,0,0,0,0,0,0,0,0];
	
	
	var imperfect1 = [5,4,4,3,3,3,2,2,1];
	var imperfect2 = [1,2,2,3,3,3,4,4,5];
	
	var imperfect3 = [9,8,7,6,5,4,3,2,1];
	var imperfect4 = [1,2,3,4,5,6,7,8,9];
	
	var perfect1 = [3,3,3,3,3,3,3,3,3];
	var perfect2 = [3,3,3,3,3,3,3,3,3];
	
	var zero1 = [3,3,3,3,3,0,0,0,0];
	var zero2 = [0,0,0,0,0,3,3,3,3];
	
	*/
	
	//Use this if using 5 regions:
	
	
	var regionrad = [0,0,0,0,0,];
	var regioncor = [0,0,0,0,0,];
	
	
	
	
	var imperfect1 = [5,4,3,2,1];
	var imperfect2 = [1,2,3,4,5];
	
	var perfect1 = [3,3,3,3,3];
	var perfect2 = [3,3,3,3,3];
	
	var zero1 = [4,4,4,0,0];
	var zero2 = [0,0,0,4,4];
	
	var xvar1 = perfect1;
	var xvar2 = perfect2;
	
	document.getElementById("perfbut").classList.add("selectedButton");
	
	
	var pathRecord = [];
	var pen = 0;
	
	
	document.getElementById("imperfbut").onclick = function() {
	
	xvar1 = imperfect1;
	xvar2 = imperfect2;
	document.getElementById("imperfbut").classList.add("selectedButton");
	document.getElementById("perfbut").classList.remove("selectedButton");
	document.getElementById("zerobut").classList.remove("selectedButton");
	pen = 0;
	document.getElementById("penButton").innerHTML="Click to Draw (Pen Down)";
	calculate2();
	}
	
	document.getElementById("perfbut").onclick = function() {

	xvar1 = perfect1;
	xvar2 = perfect2;
	document.getElementById("imperfbut").classList.remove("selectedButton");
	document.getElementById("perfbut").classList.add("selectedButton");
	document.getElementById("zerobut").classList.remove("selectedButton");
	pen = 0;
	document.getElementById("penButton").innerHTML="Click to Draw (Pen Down)";
	calculate2();
	}
	
	document.getElementById("zerobut").onclick = function() {

	xvar1 = zero1;
	xvar2 = zero2;
	document.getElementById("imperfbut").classList.remove("selectedButton");
	document.getElementById("perfbut").classList.remove("selectedButton");
	document.getElementById("zerobut").classList.add("selectedButton");
	pen = 0;
	document.getElementById("penButton").innerHTML="Click to Draw (Pen Down)";
	calculate2();
	}
	

var goods = ["Radios", "Corn"];

var max = 15;

var scale = 250/max;

var hashMark = 3;
	

	
var table2 = document.getElementById("table2");

	for(var i=0; i<5; i++)	{

		var row = table2.insertRow(i+1);
		
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);
		
		cell1.innerHTML=(i+1)+": "+regions[i];
		
		cell2.setAttribute("style", "text-align: center");
		cell3.setAttribute("style", "text-align: center");
		
		var input1 = document.createElement("input");
		var input2 = document.createElement("input");
		
		input1.setAttribute("type", "radio");
		input2.setAttribute("type", "radio");
		
		input1.setAttribute("id", "ch_"+i+"1");
		input2.setAttribute("id", "ch_"+i+"2");
		
		input1.setAttribute("name", "radio"+i);
		input2.setAttribute("name", "radio"+i);
		
		input1.setAttribute("onclick", "calculate2("+")");
		input2.setAttribute("onclick", "calculate2("+")");
		
		input1.setAttribute("checked", "true");
		
		cell2.appendChild(input1);
		cell3.appendChild(input2);
		

		}	
		
	calculate2();	
	function calculate2() {
	
	for(var i=0; i<5; i++) {
	
		if (document.getElementById("ch_"+i+"1").checked == true) {
			regioncor[i]=xvar1[i];
		}
		else {
		regioncor[i] = 0
		}
		
		if (document.getElementById("ch_"+i+"2").checked == true) {
			regionrad[i]=xvar2[i];
		}
		else {
		regionrad[i] = 0
		}
	
	
	}
	corn = regioncor[0] + regioncor[1] + regioncor[2] + regioncor[3] + regioncor[4];

	//	+ regioncor[5] + regioncor[6] +	regioncor[7] + regioncor[8];
	
	radios = regionrad[0]+ regionrad[1]+ regionrad[2]+ regionrad[3]+ regionrad[4];
	//+ regionrad[5]+ regionrad[6]+ regionrad[7]+ regionrad[8];
	
	document.getElementById("cornprod").innerHTML= corn;
	document.getElementById("radprod").innerHTML= radios;
	
	console.clear();
	
	console.log(corn);
	console.log(radios)
	
	drawDot(corn, radios);
	keepRecord();
	drawLines(corn, radios);
	
	}
	

console.log(pathRecord);
function keepRecord() {

	var innerRecord = [corn, radios];
	console.log(innerRecord);
	pathRecord.push(innerRecord);
	console.log(pathRecord);



}


function clearRecord() {

	pathRecord.length = 0;
}
	


function penDown() {

	var button = document.getElementById("penButton");
	
	if (button.innerHTML =="Click to Draw (Pen Down)") {
	
		pen = 1;
		button.innerHTML="Click to Stop Drawing (Pen Up)";
		}
		
	else {
		pen = 0;
		button.innerHTML="Click to Draw (Pen Down)";
	
	}


}

function previous(i) {

	document.getElementById("step"+(i+1)).style.display="none";
	document.getElementById("step"+(i)).style.display="block";

}

function next(i) {

	document.getElementById("step"+(i-1)).style.display="none";
	document.getElementById("step"+i).style.display="block";

}
	
/*	
		
		function draw() {
		xval = 50 + (radios*13);
		yval = 450 - (corn*13);
	
		ctx.lineTo(xval,yval);
			
		ctx.stroke();
		
		
		
		
		}
		
		function draw2() {
		xval = 50 + (radios*13);
		yval = 450 - (corn*13);
	*/
		/*ctx.lineTo(xval,yval);
		ctx.stroke();
		*/
		
		/*
		ctx.beginPath();
		ctx.arc(xval, yval, 5, 0, 2*Math.PI);
		ctx.fill();
		ctx.moveTo(xval, yval);
		
		

	document.getElementById("drawbutton").onclick=function() {calculate(); draw2()};
	*/


	
drawCanvas();	
function drawCanvas() {

drawAxes();
labelAxes();


}	
	
//This set of functions control the canvas.



function s(x) {

return scale*x;

}

//The following functions tX() and tY() transform X and Y values to be used in drawing on canvas
function tX(x) {

return x +50;
}

function tY(y) {

return 300 - y;
}


function drawDot(x,y) {


	var c = document.getElementById("myCanvas");
	var ctx = c.getContext("2d");
	//ctx.fillRect(tX(s(x)),tY(s(y)),5,5)
	ctx.beginPath();
	ctx.arc(tX(s(x)), tY(s(y)), 3, 0, 2*Math.PI);
	ctx.fill();
	ctx.moveTo(tX(s(x)), tY(s(y)));
}

function drawLines(x,y) {

if ((pathRecord.length>1)&&(pen==1)) {

	var c = document.getElementById("myCanvas");
	var ctx = c.getContext("2d");
	ctx.beginPath();

	ctx.moveTo(tX(s(pathRecord[(pathRecord.length-2)][0])), tY(s(pathRecord[(pathRecord.length-2)][1])));
	ctx.lineTo(tX(s(pathRecord[(pathRecord.length-1)][0])), tY(s(pathRecord[(pathRecord.length-1)][1])));
	ctx.stroke();

	}



}


function drawAxes() {


var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");
ctx.strokeStyle = "black";
ctx.beginPath();
ctx.moveTo(tX(0), tY(0));
ctx.lineTo(tX(0), tY(250));
//ctx.stroke();

ctx.moveTo(tX(0), tY(0));
ctx.lineTo(tX(250), tY(0));
ctx.stroke();


for(var i=1; i<(max+1); i=i+1) {


	xGrid(s(i));
	yGrid(s(i));
	
	yHash(s(i));
	xHash(s(i));
	
	

}

}


function labelAxes() {

var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");

ctx.font ="12px Courier";
ctx.fillText(goods[1], tX(s(max)), tY(-30));
console.log(max);


ctx.save();
ctx.translate(tX(-30), tY(s(max)));
ctx.rotate(-Math.PI/2);
ctx.textAlign = "center";
ctx.fillText(goods[0], 0, 0);
ctx.restore();

}




//These functions set hashes on the x and y axes. Use hashMark variable to determine how long hash line is.

var hashMark = 3

function yHash(i) {

var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");
ctx.strokeStyle = "black";
ctx.beginPath();
ctx.moveTo(tX(-hashMark), tY(i));
ctx.lineTo(tX(hashMark), tY(i));
ctx.stroke();

ctx.font = "11px Courier";
ctx.textAlign = "right";

ctx.fillText(Math.round(i/scale), tX(-8), tY(i)+3)


}


function xHash(i) {

var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");
ctx.strokeStyle = "black";
ctx.beginPath();
ctx.moveTo(tX(i), tY(-hashMark));
ctx.lineTo(tX(i), tY(hashMark));
ctx.stroke();


ctx.font = "11px Courier";
ctx.textAlign = "center";


ctx.fillText(Math.round(i/scale), tX(i), tY(-15))



}


function xGrid(i) {

var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");
ctx.strokeStyle = "#f0f0f0";
ctx.beginPath();
ctx.moveTo(tX(i), tY(0));
ctx.lineTo(tX(i), tY(s(max)));
ctx.stroke();

}

function yGrid(i) {

var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");
ctx.strokeStyle = "#f0f0f0";
ctx.beginPath();
ctx.moveTo(tX(0), tY(i));
ctx.lineTo(tX(s(max)), tY(i));
ctx.stroke();

}

function drawPPFs(i) {

//alert(i);

/*
var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");
ctx.moveTo(tX(400), tY(0));
ctx.lineTo(tX(0), tY(400));
ctx.stroke();

*/


var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");



ctx.beginPath();


ctx.font ="11px Courier";
ctx.textAlign = "left";

if(i==0) {

	ctx.strokeStyle = "red";
	ctx.fillStyle = "red";
	
	ctx.fillText(countries[0], tX(10), tY(0+s(productionIntercepts[i][0])));
	}
if(i==1) {
	ctx.strokeStyle = "blue";
	ctx.fillStyle = "blue";
	ctx.fillText(countries[1], tX(0+s(productionIntercepts[i][1])), tY(10));
	}

ctx.moveTo(tX(s(productionIntercepts[i][1])), tY(0));
ctx.lineTo(tX(0), tY(s(productionIntercepts[i][0])));

ctx.stroke();

ctx.strokeStyle="black";
ctx.fillStyle="black";
ctx.textAlign = "right";

}

function clearCanvas() {



var canvas = document.getElementById("myCanvas");
var context = canvas.getContext("2d");
context.clearRect(0, 0, canvas.width, canvas.height); //clear html5 canvas

}



</script>




</body></html>