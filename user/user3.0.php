<?php

session_start();


$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];



?>

<!DOCTYPE html>

<html lang="en">

<head>

<?php include "../header.php"; ?>


<style>

td, th {
  border: solid 1px black;
  padding: 5px;
}

table {
  border-collapse: collapse;
}

</style>


</head>


<body>
<?php include "../navbar.php"; ?>

<?php 

//print_r($_SESSION);

?>

<?php 

if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");
  
}

?>



<?php

//Following block provides student resources:

if (isset($_SESSION['userid'])) {
  
  
  ?>
  
  <p>Name: <?php echo $_SESSION['name'];?>
  
  <h1>Student Resources</h1>
  <h2>Upcoming Assignments</h2>
  <?php include "upcoming_assignment_embed1.0.php";?>
  <p>
    <a href="user_mcq_review2.0.php">MCQ Review</a>
  </p>
  <p>
    <a href="user_saq_review2.0.php">Short Answer Questions Review</a>
  </p>
  <p>
    <a href="user_assign_review.php">All Assignments Review</a>
  </p>
  
  
  <?php
  
}


?>


<?php

//Following block provides teacher resources:

if (($_SESSION['usertype']=="teacher")or($_SESSION['usertype']=="admin")) {
  
  
  ?>
  
  <h1>Teacher Resources</h1>
    <h2>News Management</h2>
      <p><a href="../news/news_input2.1.php">News Input</a></p>
      <p><a href="../news/news_list.php">News List</a></p>
    <h2>Assignment Management</h2>
      <h3>Assignments</h3>
         <p><a href="../mcq/mcq_assigncreate1.1.php">Assignment Creator (Old)</a></p>
         <p><a href="../assign_create1.0.php">Assignment Creator (New)</a></p>
      <h3>Multiple Choice Questions</h3>
        <p><a href="../mcq/mcq_assignment_review2.1.php">MCQ Assignment Review</a></p> 
      <h3>Short Answer Questions</h3>
        <p><a href="../saq/saq_list1.1.php">SAQ Question List and Input</a></p>
        <p><a href="../saq/saq_exercisecreate1.0.php">SAQ Exercise List and Input</a></p>
        <p><a href="../saq/saq_assign_review1.1.php">SAQ Assignment Review</a></p>
       <h3>Non-Digital Entry</h3>
        <p><a href="../nde/nde_exercise_create1.1.php">Non-Digital Entry: Create Exercise</a></p>
        <p><a href="../nde/nde_exercise_review1.0.php" >Non-Digital Entry: Review Exercises</a></p>
        <p><a href="../nde/nde_exercise_view1.0.php" >Non-Digital Entry: Exercise View</a></p>
        
  
  
  <?php
  
}


?>


<?php

//Following block provides admin resources:

if ($_SESSION['usertype']=="admin") {
  
  
  ?>
  
  <h1>Admin Resources</h1>
  
  
  <?php
  
}


?>


<?php include "../footer.php"; ?>

<script>




</script>

</body>


</html>