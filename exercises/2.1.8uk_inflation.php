<!DOCTYPE html>

<html lang=en>

<head>

<?php include "../header.php"; ?>

<style>

img {
	width: 1000px;
	max-width: 100%;

}


/* Style the buttons that are used to open and close the accordion panel */
.accordion {
  //background-color: #eee;
      background-color: pink;
  color: #444;
  cursor: pointer;
  //padding: 18px;
  padding: 10px;
  width: 100%;
  text-align: left;
  //border: none;
  border: 1px solid black;
  outline: none;
  transition: 0.4s;
  font-family: "Courier New", Courier, monospace;
}

/* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
.active, .accordion:hover {
  /background-color: #ccc;
  background-color: lightblue;
}

/* Style the accordion panel. Note: hidden by default */
.panel {
  //padding: 0 18px;
  background-color: white;
  display: none;
  overflow: hidden;
}


</style>


</head>


<body>

<?php include "../navbar.php"; ?>

<h1>2.1.8 Phillips Curve: Historical Investigation</h1>
<p>Study the data in the chart below:</p>

<img src="files/pc71_20.png" alt="UK Inflation and Unemployment: 1971-2020">
<p>
<ol>
<li>Describe the trends in the data shown.</li>
<li>Does there appear to be any relationship between inflation and unemployment?</li>
</ol>
</p>
<p>After you have answered these questions, click through the panels below to investigate different time periods in further depth.</p>

<button class="accordion">Section 1: 1971-1995</button>
<div class="panel">
	<img src="files/pc71_95.png" alt="UK Inflation and Unemployment: 1971-1995">
  <p>
  <ol start = 3>
	<li>Identify <em>four</em> periods in which there appeared to be Phillips Curve relationship.</li>
	<li>What could have caused the economy to switch from one Phillips Curve to the next?</li>
	<li>Comment on the values of the inflation and unemployment figures in the following time periods:
		<ul>
		<li>1974-1979</li>
		<li>1980-1986</li>
		<li>1987-1995</li>
		</ul></li>
  </ol></p>
  
</div>



<button class="accordion">Section 2: 1996-2020</button>
<div class="panel">
	<img src="files/pc96_20.png" alt="UK Inflation and Unemployment: 1996-2020">
  <p>
  <ol start =6>
	<li>What appears to have happened to the Phillips Curve relationship in this time period?</li>
	<li>Comment on the values of the inflation and unemployment figures in this time.</li>
	<li>Explain, using an AS/AD diagarm, how an economy can experience low unemployment without causing inflation</li>
  </ol></p>
</div>



<p>When finished:</p>
<p>
  <ol start =9>
	
	<li>Explain how the role of <em>inflationary expectations</em> can affect the Phillips Curve.</li>
	<li>Explain the reason why inflationary expectations may have changed at the following points:
	<ul>
		<li>1974-1975</li>
		<li>1985-1987</li>
		
		</ul></li>
  </ol></p>

<button class="accordion">When finished: Check out this GIF</button>
<div class="panel">
	<img src="files/philips_curve.gif" alt="Phillips Curve GIF" style="//margin: 10px;">
  <p>This animation does a nice job to explain what we have seen earlier: that the Phillips Curve can shift around and become more or less favourable, depending on inflationary expectations.
  </p>
</div>

<?php include "../footer.php"; ?>

<script>

var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    /* Toggle between adding and removing the "active" class,
    to highlight the button that controls the panel */
    this.classList.toggle("active");

    /* Toggle between hiding and showing the active panel */
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}



</script>
</body>


</html>

