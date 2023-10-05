<?php 

// Initialize the session
session_start();


$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];


$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");



include($path."/header_tailwind.php"); ?>

<!--
  This page will automatically update with new articles with new additions to the news database with the keyword 'supply_stories'


-->

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">1.2.1 Supply Stories</h1>
  <div class="container mx-auto mt-2 bg-white text-black p-2">
    <h2 class="text-xl font-mono bg-pink-200 mb-2">Instructions</h2>
    <ul class="list-disc list-inside pl-2">
      <li>Read the article.</li>
      <li>Summarise what is implied will happen to the supply of the product.</li>
      <li>Sketch a supply curve shift for the market described.</li>
      <li>What will be the impact on price for this product?</li>
    </ul>
    <h2 class="my-2 bg-pink-200 font-mono text-xl" >Articles</h2>

    <ol class="list-decimal list-inside">

    <?php

    $articles = getNewsArticlesByKeyword("supply_stories");

    //echo "<pre>";
    //print_r($articles);
    //echo "</pre>";

    foreach($articles as $article) {
        ?><div class="mb-2 border-2 rounded border-sky-200 p-1">
          <h3 class=" text-lg bg-sky-100 -mx-1 -mt-1 px-1"><li class=""><span class=""><?=$article['headline']?></span> <span class="inline-block">(<?=date("d M y", strtotime($article['datePublished']));?>)</span></li></h3>
          <p class="truncate"><span class="font-bold">Link</span>: <a class=" hover:bg-sky-100 " target="_blank" href="<?=$article['link']?>"><?=$article['link']?></a></p>
          <?php
            if(($article['explanation'] != "") ) {
              ?>
              <p><span class="font-bold">Explanation</span>: <?=$article['explanation']?></p>
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
