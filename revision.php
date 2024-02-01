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
            <h4 class="pl-1 ml-1 mr-1 rounded my-1 text-lg bg-sky-100">Year 1 Micro</h4>
              <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?subjectLevel=1_1&examBoardId=1&topicIds=184%2C185%2C186">Knowledge Organiser (1.1 Topics)</a></li>
              <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?subjectLevel=1_1&examBoardId=1&topicIds=187%2C188%2C189%2C190">Knowledge Organiser (1.2 Topics)</a></li>
              <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?subjectLevel=1_1&examBoardId=1&topicIds=187%2C191%2C192">Knowledge Organiser (1.3 Topics)</a></li>
              <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?subjectLevel=1_1&examBoardId=1&topicIds=205%2C206%2C207">Knowledge Organiser (1.7 Topics)</a></li>
            <h4 class="pl-1 ml-1 mr-1 rounded my-1 text-lg bg-sky-100">Year 1 Macro</h4>
              <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?subjectLevel=1_1&examBoardId=1&topicIds=208%2C209%2C210%2C211%2C212%2C215">Knowledge Organiser (2.1 Topics)</a></li>
              <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?subjectLevel=1_1&examBoardId=1&topicIds=218%2C219%2C220%2C221%2C222">Knowledge Organiser (2.2 Topics)</a></li>
              <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php??subjectLevel=1_1&examBoardId=1&topicIds=223%2C224%2C226%2C227">Knowledge Organiser (2.3 Topics)</a></li>
            <h4 class="pl-1 ml-1 mr-1 rounded my-1 text-lg bg-sky-100">Year 2 Micro</h4>
              <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?subjectLevel=1_1&examBoardId=1&topicIds=193">Knowledge Organiser (1.4 Topics)</a></li>
              <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?subjectLevel=1_1&examBoardId=1&topicIds=194%2C195%2C196">Knowledge Organiser (1.5 Topics)</a></li>
              <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?subjectLevel=1_1&examBoardId=1&topicIds=197%2C198%2C199%2C200%2C201%2C202%2C203%2C204">Knowledge Organiser (1.6 Topics)</a></li>
             
        <?php
            /*
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?topic=2.1">Knowledge Organiser (2.1 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?topic=2.2">Knowledge Organiser (2.2 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/knowledge_organiser.php?topic=2.3">Knowledge Organiser (2.3 Topics)</a></li>
            */
              ?>
          <h3 class="font-mono text-lg bg-pink-200 pl-1">FlashCards Collections</h3>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/flashcards.php">FlashCards (All Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/flashcards.php?subjectLevel=1_1&examBoardId=1&topicIds=184">FlashCards (1.1 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/flashcards.php?subjectLevel=1_1&examBoardId=1&topicIds=185">FlashCards (1.2 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/flashcards.php?subjectLevel=1_1&examBoardId=1&topicIds=186">FlashCards (1.3 Topics)</a></li>
            <li class="ml-2 hover:bg-sky-100" ><a class="block" href="revision/flashcards.php?subjectLevel=1_1&examBoardId=1&topicIds=193">FlashCards (1.4 Topics)</a></li>
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
