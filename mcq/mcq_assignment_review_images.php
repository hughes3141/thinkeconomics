<!DOCTYPE html>
<head>
<title>
      Think Economics
    </title>
</head>
<body>
<?php

$questions = explode(",",$_GET['questions']);
array_pop($questions);
foreach ($questions as $question) {
  ?>
  <img style="width:50%" src="question_img/<?=$question?>.JPG"><br>
  <?php
}
?>
</body>
</html>