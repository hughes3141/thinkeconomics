<?php 

// Initialize the session
session_start();


$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];


$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");



include($path."/header_tailwind.php");

$startDate = null;
$endDate = null;

if(isset($_GET['startDate'])) {
  $startDate = $_GET['startDate'];
}
if(isset($_GET['endDate'])) {
  $endDate = $_GET['endDate'];
}
?>

<!--
  This page will automatically update with new articles with new additions to the news database with the keyword 'equilibrium\_stories'

  GET Varibales:

  -startDate = earliest date of articles e.g. 2023-10-05
  -endDate = latest date of articles e.g. 2023-10-05


-->

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">1.2.2 Equilibrium Stories</h1>
  <div class="container mx-auto mt-2 bg-white text-black p-2">
    <h2 class="text-xl font-mono bg-pink-200 mb-2">Instructions</h2>
    <p class=" mb-2">For the following news articles:</p>
    <ol class="list-decimal list-inside pl-2 mb-2">
      <li>Construct a supply diagram to show initial market equilibrium</li>
      <li>Using information from the article, explain whether supply or demand has shifted.</li>
      <li>Explain whether there would be excess supply or excess demand at the old price, after the shift you have described.</li>
      <li>Explain what has happened to the price of the product, as an effect of the excess supply or excess demand.</li>
    </ol>
    <p class=" mb-2"><strong>Bonus</strong>: Try to explain, where possible, what the shape of the supply and demand curves will look like.</p>
    <p class=" mb-2">For example:</p>
    <ul class="list-disc list-inside pl-2">
      <li>Items that are necessities will have steep demand.</li>
      <li>Items that are difficult to increase production ill have steep supply.</li>
    </ul>
    
    <h2 class="my-2 bg-pink-200 font-mono text-xl" >Articles</h2>

    <ol class="list-decimal list-inside">

    <?php

    $articles = getNewsArticles(null, "equilibrium\_stories", null, $startDate, $endDate);
    
    //getNewsArticles($id =null, $keyword=null, $topic=null, $startDate=null, $endDate=null, $orderBy = null)

    echo "<pre>";
    //print_r($articles);
    echo "</pre>";

    
    foreach($articles as $article) {
        ?><div class="mb-2 border-2 rounded border-sky-200 p-1">
          <h3 class=" text-lg bg-sky-100 -mx-1 -mt-1 px-1"><li class=""><span class=""><?=$article['headline']?></span> <span class="inline-block">(<?=date("d M y", strtotime($article['datePublished']));?>)</span></li></h3>
          <p class="truncate"><span class="font-bold">Link</span>: <a class=" hover:bg-sky-100 " target="_blank" href="<?=$article['link']?>"><?=$article['link']?></a></p>
          <?php
            if(($article['explanation'] != "") ) {
              ?>
              <p class="whitespace-pre-line"><span class="font-bold ">Explanation</span>: <?=$article['explanation']?></p>
              <?php
            }
          ?>
        </div>
        <?php
    }
    
    

    ?>

    </ol>


  </div>
</div>




<?php include($path."/footer_tailwind.php"); ?>
