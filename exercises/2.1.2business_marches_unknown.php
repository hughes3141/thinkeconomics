<!DOCTYPE html>

<html lang="en">

<head>
<?php include "../header.php";?>

<style>

.answer {

background-color: pink;
margin-top: 10px;
display: none;
padding:10px;


}

.question {


	margin-top:10px;
	
	}
	
.toggleAnswer {
	display: none;
}


</style>

</head>


<body onload = "populate()">

<?php include "../navbar.php";?>



<h1>2.1.2 British Business Marches Cheerfully Into the Unknown</h1>

<img src = "files/2.1.2_06.jpg" alt="Image: British Business marching"style="max-width: 100%;">
<p><a target="_blank" href="files/Keeping%20calm%20and%20carrying%20onBritish%20business%20marches%20cheerfully%20into%20the%20unknown.pdf">PDF: British Business Marches Cheerfully Into The Unknown</a></p>


<h2>Questions</h2>
<p><a target="_blank" href="https://www.economist.com/news/britain/21728662-firms-may-dislike-prospect-brexit-so-far-it-isnt-curtailing-their-investment">https://www.economist.com/news/britain/21728662-firms-may-dislike-prospect-brexit-so-far-it-isnt-curtailing-their-investment</a></p>
<p><u>Key Term</u>: <strong>Foreign Direct Investment</strong>: Capital equipment purchased in your country using foreign funds, e.g. BMW (a German company) buying machines for its Mini factory in Cowley (located in the UK)</p>
<ol>
<li><p>Why might an economist expect for investment would slump following the Brexit referendum of June 2016?
</p> <button class="toggleAnswer">Click to show answer</button>
<p class="answer">
</p>
</li>

<li><p>What types of items might be included on the list of things that Makar Technology has purchased as part of its investment? What sorts of things might Amazon purchase as part of its expansion in Shoreditch?
</p> <button class="toggleAnswer">Click to show answer</button>
<p class="answer">
</p>
</li>

<li><p>What is the general sense of what is happening to investment in the UK at the time of this article being written? (9 September 2017)
</p> <button class="toggleAnswer">Click to show answer</button>
<p class="answer">	
</p>
</li>

<li><p>&ldquo;Investment is at the root of improvements in productivity and, hence, pay-packets.&rdquo; Explain the link between investment, productivity, and wages.
</p> <button class="toggleAnswer">Click to show answer</button>
<p class="answer">	
</p>
</li>

<li><p>&ldquo;Wear and tear means that some investment is due each year.&rdquo; Explain how <strong>depreciation</strong> of computer systems may have led to higher investment levels in Britain lately.
</p> <button class="toggleAnswer">Click to show answer</button>
<p class="answer">	
</p>
</li>

<li><p>Explain how the cost of borrowing has affected investment levels.
</p> <button class="toggleAnswer">Click to show answer</button>
<p class="answer">	
</p>
</li>

<li><p>Why does business uncertainty not seem to be such a big factor affecting investment levels?
</p> <button class="toggleAnswer">Click to show answer</button>
<p class="answer">	
</p>
</li>

<li><p>Why might corporate tax rates affect business investment?
</p> <button class="toggleAnswer">Click to show answer</button>
<p class="answer">	
</p>
</li>

<li><p>Study the final paragraph. According to this article, what dangers could cause British firms to invest less in the future?
</p> <button class="toggleAnswer">Click to show answer</button>
<p class="answer">	
</p>
</li>

<li><u><p>Extension</u>: Use ideas from this article to make a list of the things that affect investment levels. Rank order these, if possible.
</p> <button class="toggleAnswer">Click to show answer</button>
<p class="answer">	
</p>
</li>
</ol>






<?php include "../footer.php";?>

<script>










function answer(i) {

	var b = document.getElementById("b"+i);

	
	
	
	if (b.innerHTML == "Click for Answer") {
	
		var a = document.getElementById("a"+i);
		a.style.display = "block";
		b.innerHTML="Click to Hide";
		}
		
	
	else if (b.innerHTML == "Click to Hide") {
	
		var a = document.getElementById("a"+i);
		a.style.display = "none";
		b.innerHTML="Click for Answer";
		}



}
	
</script>


</body>

</html>