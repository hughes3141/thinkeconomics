<?php 


$publicPage = true;
$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");

include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Course Admin</h1>
  <div class="container mx-auto px-0 mt-2 bg-white text-black">
    <ul class="list-none">
      <li class="ml-2 mr-2 hover:bg-sky-100"><a class = "block" href="pastpapers/questions.php">Past Paper Questions Database</a></li>
      <li class="ml-2 mr-2 hover:bg-sky-100"><a class = "block" href="admin/topic_list.php">Eduqas A Level Topic list</a></li>
      <li class="ml-2 mr-2 hover:bg-sky-100"><a class = "block" href ="admin/eduqas-a-economics-spec-from-2015.pdf" target ="_blank">A Level Economics Specification</a></li>
    </ul>
    <?php for($x=0; $x<10; $x++) {echo "<br>";}?>
  </div>
</div>



<?php include "footer_tailwind.php"; ?>
