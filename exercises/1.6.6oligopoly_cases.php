<?php 

// Initialize the session
session_start();


$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];


$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");



include($path."/header_tailwind.php"); ?>

<!--
  This page will automatically update with new articles with new additions to the news database with the keyword 'oligopoly case study'


-->

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">1.6.6 Oligopoly Case Studies</h1>
  <div class="container mx-auto px-0 mt-2 bg-white text-black">
    <p class="ml-2 text-xl">Use the case studies below to read information on cartels and oligopolies.</p>

    <ul>

    <?php

    $articles = getNewsArticlesByKeyword("oligopoly case study");

    foreach($articles as $article) {
        ?>
        <li class="ml-2 mr-2 hover:bg-sky-100"><a class="block" target="_blank" href="<?=$article['link']?>"><?=$article['headline']?> (<?=date("d/m/Y", strtotime($article['datePublished']));?>)</a></li>
        <?php
    }
    

    ?>

    </ul>


  </div>
</div>




<?php include($path."/footer_tailwind.php"); ?>
