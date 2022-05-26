<?php 
// Initialize the session
session_start();


$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

include "header_tailwind.php"; 

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Course Admin</h1>
  <div class="container mx-auto px-0 mt-2 bg-white text-black">
    <ul class="list-none">
      <li class="ml-2 hover:bg-sky-100"><a href="admin/courseguide_21.php" >Course Guide</a></li>
      <li class="ml-2 hover:bg-sky-100"><a href="admin/course_intro.php">Pre-Course Information: What is Economics?</a></li>
      <li class="ml-2 hover:bg-sky-100"><a href="admin/y1_yearplan_21.php">Year 1 Year Plan</a></li>
      <li class="ml-2 hover:bg-sky-100"><a href="admin/y2_yearplan_21.php">Year 2 Year Plan</a></li>
      <li class="ml-2 hover:bg-sky-100"><a href="admin/topic_list.php">Eduqas A Level Topic list</a></li>
      <li class="ml-2 hover:bg-sky-100"><a href ="admin/eduqas-a-economics-spec-from-2015.pdf" target ="_blank">A Level Economics Specification</a></li>
      <li class="ml-2 hover:bg-sky-100"><a href ="admin/files/advanced_info_spec.pdf" target ="_blank">A Level Economics Specification (2022 Edit)</a></li>
      <li class="ml-2 hover:bg-sky-100"><a href ="admin/files/wjec-eduqas-gce-a-level-economics-advance-information-2022.pdf" target ="_blank"> Advanced Information for 2022 Exams (from Eduqas)</a></li>
      <li class="ml-2 hover:bg-sky-100"><a href ="https://www.eduqas.co.uk/qualifications/economics-as-a-level" target="_blank">Eduqas A Level Economics Website</a></li>
      <li class="ml-2 hover:bg-sky-100"><a href="https://truropenwith-my.sharepoint.com/:w:/g/personal/ryanhughes_callywith_ac_uk/Ea7XKox99mdEkm99FUjy7XMBFe9jKLMPIx9nf2ZXbAOSlw?e=e5C6ff" target ="_blank">Textbook Reading Guide</a></li>
      <li class="ml-2 hover:bg-sky-100"><a href="admin/powerpoints.php">Topic PowerPoints</a></li>
      <li class="ml-2 hover:bg-sky-100"><a href="admin/mark_schemes.html">Eduqas AL Economics Mark Schemes</a></li>
    </ul>
    <?php for($x=0; $x<10; $x++) {echo "<br>";}?>
  </div>
</div>



<?php include "footer_tailwind.php"; ?>
