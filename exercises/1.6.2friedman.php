<?php 

// Initialize the session
session_start();


$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];


$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");



//include($path."/header_tailwind.php"); ?>

<html>

<head>

<?php include "../header.php"; ?>

<style>

table {

border: 1px solid black;
border-collapse: collapse;
}

td, th {
border: 1px solid black;
padding: 5px;
}

img, iframe {
	
	
display: block;
  margin-left: auto;
  margin-right: auto;
}
.correct {


background-color: #b3ffb3;

}

.incorrect {


background-color: #ffffb3;
//#ffd699;

}

.col3 {

	display: none;
}

</style>

</head>

<body>
<?php include "../navbar.php";?>
<h1>1.6.2 Objectives of Firms: Milton Friedman's Viewpoint</h1>
<p>Consider the views of Milton Friedman, summarised below.</p>
<p>To what extent do you agree with these views?</p>

<img src="files/1.6.2friedman.png">

<br>
<iframe width="560" height="315" src="https://www.youtube.com/embed/RWsx1X8PV_A" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<br>
<iframe width="560" height="315" src="https://www.youtube.com/embed/ev_Uph_TLLo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<br>
<a href ="files/1.6.2 Friedman CSR Article.pdf" target="_blank">Link to Milton Friedman's 1970 NYT Article</a>
<h2>Other interesting news articles:</h2>

<ul id ="newsList">

  <?php
    $articles = $articles = getNewsArticlesByTopic("1.6.2");

    foreach($articles as $article) {
      ?>
        <li><a target="_blank" href="<?=$article['link']?>"><?=$article['headline']?></a> (<?=date("d-M-Y", strtotime($article['datePublished']));?>)</li>
      <?php
    }

  ?>

</ul>





<?php include "../footer.php";?>
<script>
</script>

</body>

</body>


</html>