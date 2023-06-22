<?php 


// Initialize the session
session_start();



$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");



include "header_tailwind.php"; 

?>


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Revision Resources</h1>
    <div class="container mx-auto px-0 mt-2 bg-white text-black">
      <ul class="list-none">
        <h2 class="font-mono text-xl bg-pink-300 pl-1"></h2>
          <h3 class="font-mono text-lg bg-pink-200 pl-1">Knowledge Organisers</h3>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?topic=1.1">Knowledge Organiser (1.1 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?topic=1.2">Knowledge Organiser (1.2 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?topic=1.3">Knowledge Organiser (1.3 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?topic=1.4">Knowledge Organiser (1.4 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?topic=2.1">Knowledge Organiser (2.1 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?topic=2.2">Knowledge Organiser (2.2 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?topic=2.3">Knowledge Organiser (2.3 Topics)</a></li>
          <h3 class="font-mono text-lg bg-pink-200 pl-1">FlashCards Collections</h3>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/flashcards.php">FlashCards (All Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/flashcards.php?topics=1.1.1,1.1.2,1.1.3">FlashCards (1.1 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/flashcards.php?topics=1.2.1,1.2.2,1.2.3,1.2.4">FlashCards (1.2 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/flashcards.php?topics=1.3.1,1.3.2">FlashCards (1.3 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/flashcards.php?topics=1.7.1,1.7.2,1.7.3">FlashCards (1.7 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/flashcards.php?topics=2.1.1,2.1.2,2.1,3,2.1.4,2.1.5,2.1.6,2.1.7,2.1.8">FlashCards (2.1 Topics)</a></li>
          <h3 class="font-mono text-lg bg-pink-200 pl-1">Quick Quizzes</h3>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/quick_quiz.php">Quick Quiz (All Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/quick_quiz.php?topics=1.1.1,1.1.2,1.1.3">Quick Quiz (1.1 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/quick_quiz.php?topics=1.2.1,1.2.2,1.2.3,1.2.4">Quick Quiz (1.2 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/quick_quiz.php?topics=1.3.1,1.3.2">Quick Quiz (1.3 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/quick_quiz.php?topics=1.7.1,1.7.2,1.7.3">Quick Quiz (1.7 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/quick_quiz.php?topics=2.1.1,2.1.2,2.1,3,2.1.4,2.1.5,2.1.6,2.1.7,2.1.8">Quick Quiz (2.1 Topics)</a></li>


      </ul>
    </div>
</div>

<?php include "footer_tailwind.php"; ?>