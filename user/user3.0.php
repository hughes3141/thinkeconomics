<?php
// Initialize the session
session_start();

date_default_timezone_set("Europe/London");


$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");


if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");
  
}

else {
  $userInfo = getUserInfo($_SESSION['userid']);
  $userId = $_SESSION['userid'];
  $permissions = $userInfo['permissions'];


}

include "../header_tailwind.php"; 


?>








<!--Following block provides student resources:-->

  <div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
    <h1 class="font-mono text-xl bg-pink-400 pl-1">Dashboard</h1>
      <div class="container mx-auto px-0 mt-2 bg-white text-black">
    
          <p class="pl-1 text-lg bg-sky-100 font-mono my-2">Logged in as <?php echo trim($userInfo['name_first']." ".$userInfo['name_last']);?></p>
        
        <?php
          //print_r($userInfo);
        ?>

          <?php if(str_contains($permissions, "teacher")) 
          { ?>
          <div class="border-2 border-sky-300 rounded m-3 p-1">
            <?php 
          } ?>
            <h1 class="font-mono text-xl bg-pink-300 pl-1">Student Resources</h1>
      <?php if(str_contains($permissions, "teacher")) 
      { ?>
            <p >These are the types of resosurces your students will see (though you need to add yourself to a class if you want to see them too!</p>
        <?php 
      } ?>      
            <div class="m-3 border-pink-300 border-2 p-3">
              <h2>Upcoming Assignments:</h2>
              <?php include "upcoming_assignment_embed1.0.php";?>
            </div>
            <p class="ml-2 hover:bg-sky-100">
              <a class ="block" href="user_mcq_review.php">MCQ Review</a>
            </p>
            <?php
            // Following line is to filter to ensure that user's school has saq_dashboard enabled in permissions.
            if(str_contains($userInfo['school_permissions'], "saq_dashboard")) 
            { ?>
              <p class="ml-2 hover:bg-sky-100">
                <a class ="block" href="user_saq_review2.0.php">Short Answer Questions Review</a>
              </p>
            <?php 
            } ?>
            <p class="ml-2 hover:bg-sky-100">
              <a class ="block" href="user_assign_review.php">All Assignments Review</a>
            </p>
          <?php if(str_contains($permissions, "teacher")) { ?>
          </div>
          <?php } ?>
          
        <?php

        //Following block provides teacher resources:

        if (str_contains($userInfo['permissions'], "teacher")) {
          
          
          ?>
          
          <h1 class="font-mono text-xl bg-pink-300 pl-1" >Teacher Resources</h1>
            <h2 class="font-mono text-lg bg-pink-200 pl-1">Assignments</h2>
              <p class="ml-2 hover:bg-sky-100">
                <a class ="block" href="/assign_create1.0.php">Create Assignment</a>
              </p>
              <p class="ml-2 hover:bg-sky-100">
                <a class ="block" href="/mcq/mcq_assignment_review3.0.php">MCQ Assignment Review</a>
              </p>
              <p class="ml-2 hover:bg-sky-100">
                <a class ="block" href="/user/user_work_review.php">Review All Assignments By User</a>
              </p>

            
            <h2 class="font-mono text-lg bg-pink-200 pl-1">Admin</h2>

              <p class="ml-2 hover:bg-sky-100">
                <a class ="block" href="/user/school_registration.php">Link Account to Your School</a>
              </p>
              <p class="ml-2 hover:bg-sky-100">
                <a class ="block" href="/user/class_creator.php">Create Classes</a>
              </p>
              <p class="ml-2 hover:bg-sky-100">
                <a class ="block" href="/user/group_manager.php">Manage Classes</a>
              </p>
              <p class="ml-2 hover:bg-sky-100">
                <a class ="block" href="/user/user_populate.php">Add New Users</a>
              </p>
              <p class="ml-2 hover:bg-sky-100">
                <a class ="block" href="/user/user_manager.php">Manage Users</a>
              </p>

      <?php 
        }
        ?>

      <?php if(str_contains($permissions, "main_admin")) { 
        ?>
            <h2 class="font-mono text-lg bg-pink-200 pl-1">News Management</h2>
              <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../news/news_input2.1.php">News Input</a></p>
              <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../news/news_list.php">News List</a></p>

            <h2 class="font-mono text-lg bg-pink-200 pl-1">Notes Management</h2>
              <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../notes/notes_list.php">Notes List Update</a></p>

            <h2 class="font-mono text-lg bg-pink-200 pl-1">Revision Management</h2>
              <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../revision/flashcard_collection_entry.php">Flashcard Collection Entry</a></p>
             

            <h2 class="font-mono text-lg bg-pink-200 pl-1">Assignment Management</h2>
              <h3 class="font-mono text-md bg-pink-100 pl-1">Assignments</h3>
                <p class="ml-2 font-bold">Old resources</p>
                <p class="ml-2 hover:bg-sky-100"><a class ="block" href="/mcq/student_assign_review1.1.php">All Assignments By Student</a></p>


                <p class="ml-2 font-bold">New resources</p>
                <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../assign_create1.0.php">Assignment Create and List</a></p>
                <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../user/user_work_review.php">User Work Review (dev)</a></p>
              <h3 class="font-mono text-md bg-pink-100 pl-1">Multiple Choice Questions</h3>
                <p class="ml-2 font-bold">Old resources</p>
                <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../mcq/mcq_list.php">List of MCQ Questions</a></p>
                <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../mcq/mcq_quizcreate.php">MCQ Quiz Creator and List</a></p>
                <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../mcq/mcq_preview.php">MCQ Preview (Old)</a></p>
                <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../mcq/mcq_student_review.php">MCQ Student Work Review</a></p>
                
                
                
                <p class="ml-2 font-bold">New resources</p>
                <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../mcq/mcq_assignment_review3.0.php">MCQ Assignment Review</a></p>
                <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../mcq/mcq_preview_simple.php">MCQ Quiz Preview (Simple)</a></p>
              <h3 class="font-mono text-md bg-pink-100 pl-1">Short Answer Questions</h3>
                <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../saq/saq_list1.1.php">SAQ Question List and Input</a></p>
                <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../saq/saq_exercisecreate1.0.php">SAQ Exercise List and Input</a></p>
                <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../saq/saq_assign_review1.1.php">SAQ Assignment Review</a></p>
                <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../user/class_flashcard_review.php">Class Flashcard Review (dev)</a></p>
              <h3 class="font-mono text-md bg-pink-100 pl-1">Non-Digital Entry</h3>
                <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../nde/nde_exercise_create1.1.php">Non-Digital Entry: Create Exercise</a></p>
                <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../nde/nde_exercise_review1.0.php" >Non-Digital Entry: Review Exercises</a></p>
                <p class="ml-2 hover:bg-sky-100"><a class ="block" href="../nde/nde_exercise_view1.0.php" >Non-Digital Entry: Exercise View</a></p>
                
          
          
          <?php
          
        }


        ?>


        <?php

        //Following block provides admin resources:

        if (str_contains($userInfo['permissions'], "main_admin")) {
          
          
          ?>
          
          <h1 class="font-mono text-xl bg-pink-300 pl-1">Admin Resources</h1>
          <p class="ml-2 hover:bg-sky-100"><a class ="block" href="/user/admin_users.php" >User Details Edit</a></p>
          <p class="ml-2 hover:bg-sky-100"><a class ="block" href="/user/login_log.php" >User Login Log</a></p>
          <p class="ml-2 hover:bg-sky-100"><a class ="block" href="/user/school_creator.php" >School Create and Manage</a></p>
          
                
          
          <?php
          
        }


        ?>
      </div>
  </div>



<?php include "../footer_tailwind.php"; ?>

<script>




</script>

</body>


</html>