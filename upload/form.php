<?php


?>

<!DOCTYPE html>
<html>
<body>

<form action="upload.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <p>
    <label>Folder</label>
    <select name="filepath" id = "filepath">
      <option value ='../assets/'>Assets</option>
      <option value = '../mcq/question_img/'>MCQ Image</option>
    </select>
  </p>
  <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>