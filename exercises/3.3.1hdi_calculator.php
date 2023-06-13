<html>

<head>

<?php include "../header.php"; ?>

</head>



<body>


<?php include "../navbar.php"; ?>

<p>Life Expectancy: <input type="number" id="le"></p>
<p>Mean Years Schooling: <input type="number" id="mys"></p>
<p>Expected Years Schooling: <input type="number" id="eys"></p>
<p>GNI: <input type="number" id="gni"></p>
<button id="myButton" onclick="calculate()">Calculate</button>
<p>Health Index: <span id="lex"></span></p>
<p>Expected Years of Schooling Index: <span id="eysx"></span></p>
<p>Mean Years of Schooling Index: <span id="mysx"></span></p>
<p>Education Index: <span id="ex"></span></p>
<p>Income Index: <span id="yx"></span></p>
<p>Human Development Index: <span id="hdix"></span></p>

<?php include "../footer.php"; ?>

<script>



function calculate() {

var le;
var mys;
var eys;
var gni;


	le = document.getElementById("le").value;
	mys = document.getElementById("mys").value;
	eys = document.getElementById("eys").value;
	gni	= document.getElementById("gni").value;
	
	var lex = (le -20)/(85-20);
	var eysx = (eys-0)/(18-0);
	var mysx = (mys-0)/(15-0);
	var ex = (eysx+mysx)/2;
	var yx = (Math.log(gni)-Math.log(100))/(Math.log(75000)-Math.log(100));
	
	var hdix = (lex*ex*yx)**(1/3);
	
	
	document.getElementById("lex").innerHTML = lex.toFixed(4);
	document.getElementById("eysx").innerHTML = eysx.toFixed(4);
	document.getElementById("mysx").innerHTML = mysx.toFixed(4);
	document.getElementById("ex").innerHTML = ex.toFixed(4);
	document.getElementById("yx").innerHTML = yx.toFixed(4);
	document.getElementById("hdix").innerHTML = hdix.toFixed(3);

	console.log(le, mys, eys, gni);
	console.log("Life Expectancy X: "+lex+", Education X: "+ex+", Income X: "+yx);
	console.log("HDI: "+hdix);
}


</script>


</body>


</html>