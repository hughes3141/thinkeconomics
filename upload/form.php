<?php


// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");  


if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");
  $userId = $_SESSION['userid'];
  
}

else {
  $userInfo = getUserInfo($_SESSION['userid']);
  $userId = $_SESSION['userid'];
  $schoolId = $userInfo['schoolid'];
  $permissions = $userInfo['permissions'];

  if(!str_contains($permissions, "main_admin")) {
    header("location: /");
  }
  //print_r($userInfo);
  $userGroups = json_decode($userInfo['groupid_array']);
  //print_r($userGroups);
  
}

$style_input = "";

$lastFolder = "";
$lastAltText = "";
$lastNotes = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //Process server upload:

  if(isset($_GET['test'])) {
    print_r($_POST);
  }

  $lastFolder = $_POST['filepath'];
  $lastAltText = $_POST['altText'];
  $lastNotes = $_POST['notes'];

  $uploadMessage = "";

  $target_dir = $_POST['filepath'];
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      $uploadMessage .=  "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      $uploadMessage .=  "File is not an image.";
      $uploadOk = 0;
    }
  }

  // Check if file already exists
  if (file_exists($path.$target_file)) {
    $uploadMessage .=  "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    $uploadMessage .=  "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    $uploadMessage .=  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    $uploadMessage .=  "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $path.$target_file)) {
      $uploadMessage .=  "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
      
      //Update upload_record:
      newUploadsRecord($userId, $target_file, $_POST['altText'], $path, $_POST['notes']);

    } else {
      $uploadMessage .=  "Sorry, there was an error uploading your file.";
    }
  }

}


include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20  w-3/4">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1 ">File Upload</h1>
  <div class="container mx-auto p-4 mt-2 bg-white text-black ">

  <?=(isset($uploadMessage)) ? $uploadMessage : ""?>

  <form action="" method="post" enctype="multipart/form-data">
    Select image to upload:
    <p>
      <input type="file" name="fileToUpload" id="fileToUpload">
    </p>
    <p>
      <label>Folder</label>
      <select name="filepath" id = "filepath">
        <option value ='/assets/' <?=($lastFolder == "/assets/") ? "selected": ""?>>Assets</option>
        <option value = '/mcq/question_img/' <?=($lastFolder == "/mcq/question_img/") ? "selected": ""?>>MCQ Image</option>
        <option value = '/assets/flashcard_img/' <?=($lastFolder == "/assets/flashcard_img/") ? "selected": ""?>>Flashcard Image</option>
        <option value = '/assets/pastpaper_img/' <?=($lastFolder == "/assets/pastpaper_img/") ? "selected": ""?>>Past Paper Images</option>
      </select>
    </p>
    <p>
      <label>Alt Text</label>
      <textarea name= "altText"><?=$lastAltText?></textarea>
    </p>
    <p>
      <label>Notes</label>
      <textarea name= "notes"><?=$lastNotes?></textarea>
    </p>
    <input type="submit" value="Upload Image" name="submit">
  </form>



  </div>
</div>

<?php include ($path."/footer_tailwind.php");

