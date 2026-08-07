<?php

$path = $_SERVER['DOCUMENT_ROOT'];
$publicPage = true;
include($path."/php_header.php");
include($path."/php_functions.php");
include($path."/php_email_functions.php");

$email_err = "";
$email_name = "";
$requestSent = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email_name = trim($_POST['email'] ?? '');
  $validEmail = filter_var($email_name, FILTER_VALIDATE_EMAIL);

  if (!$validEmail) {
    $email_err = "Please enter a valid email address.";
  } else {
    $found = generate_password_reset_request_by_email($validEmail, 60 * 60);

    if ($found) {
      $fullName = trim($found['name_first']." ".$found['name_last']);
      send_password_reset_email($validEmail, $fullName, $found['resetCode'], 1);
    }

    //Same message whether or not an account was found, so this form can't
    //be used to check which emails are registered.
    $requestSent = true;
  }
}

$style_input = "";
include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Forgot Password</h1>
  <div class="container mx-auto px-0 mt-2 bg-white text-black p-4">

    <?php if ($requestSent) { ?>

      <p class="pl-1 py-2 text-green-700 bg-lime-100 rounded">
        If an account exists for <b><?=htmlspecialchars($email_name)?></b>, we've sent a link to change the password.
        Please check your email - the link will expire in 1 hour.
      </p>
      <p class="mt-3"><a href="/login.php" class="underline hover:bg-sky-100">Back to login</a></p>

    <?php } else { ?>

      <p class="pl-1 py-2">Enter the email address on your account, and we'll send you a link to change your password.</p>

      <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" autocomplete="off">
        <div class="form-group w-full">
          <label for="email" class="pb-1 mb-2 pt-1">Email:</label>
          <div class="mt-1.5">
            <input type="text" name="email" id="email" class="border px-3 py-2 text-sm w-full mb-2 rounded" placeholder="Email" value="<?=htmlspecialchars($email_name)?>">
          </div>
          <p class="pl-1 mt-1 py-0 text-red-600 bg-lime-300 rounded"><?=htmlspecialchars($email_err)?></p>
        </div>

        <div class="form-group">
          <input type="submit" class="mt-3 rounded bg-sky-500 hover:bg-sky-400 focus:bg-sky-200 focus:shadow-sm focus:ring-4 focus:ring-sky-200 focus:ring-opacity-50 text-white w-full py-2.5 text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block" value="Send reset link">
        </div>
      </form>

      <p class="mt-3"><a href="/login.php" class="underline hover:bg-sky-100">Back to login</a></p>

    <?php } ?>

  </div>
</div>

<?php include $path."/footer_tailwind.php"; ?>
