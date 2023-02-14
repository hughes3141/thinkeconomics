<html>


<head>

<?php include "../header.php"; ?>

<style>


ul {
//list-style-type: none;


}

li {
	
	margin-bottom: 5px;
	
}
</style>


</head>

<body>

<?php include "../navbar.php"; ?>

<h1>UK Productivity: Extension Articles</h1>
<a href = "files/1.1.3 Under the Bonnet.pdf" target = "_blank" ><img src = "files/1.1.3_02.JPG" style="max-width: 100%;"></a><br>
<p>The following articles from <em>The Economist</em> make for excellent reading to help understand the nature of UK productivity figures.</p>
<p>Articles:</p>
<ul>
<li><em><a href="files/1.1.3 British Productivity is Rising at Last.pdf">British productivity is rising at last . . .</a> </em>(14 April 2018)</li>
<li><em><a href="files/1.1.3 Britain's Era of Abysmal Productivity.pdf">Britain&rsquo;s era of abysmal productivity growth could be at an end</a></em> (12 April 2018)</li>
<li><em><a href="files/1.1.3 Efficiency Eludes the Construction Industry.pdf">Efficiency eludes the construction industry</a></em> (17 August 2017)</li>
<li><em><a href="files/1.1.3 The Construction Industry's Productivity Problem.pdf">The construction industry&rsquo;s productivity problem</a> </em>(17 August 2017) (also see article questions <a href = "1.1.3construction_productivity_problem.php">here</a></li>
<li><em><a href="files/1.1.3 Under the Bonnet.pdf">Under the bonnet</a> </em>(30 May 2015)</li>
</ul>

<?php include "../footer.php"; ?>
<script>

var links = document.getElementsByTagName("A");

for(var i=0; i<links.length; i++) {


	links[i].setAttribute("target", "_blank")
}

</script>

</body>


</html>