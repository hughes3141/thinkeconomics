<?php

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");
include($path."/php_email_functions.php");

$userInfo = getUserInfo($_SESSION['userid']);

$requestSent = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $resetCode = generate_password_reset_request($_SESSION['userid'], 60 * 60);
  $fullName = trim($userInfo['name_first']." ".$userInfo['name_last']);
  send_password_reset_email($userInfo['email'], $fullName, $resetCode, 1);
  $requestSent = true;
}

$style_input = "";
include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Change Password</h1>
  <div class="container mx-auto px-0 mt-2 bg-white text-black p-4">

    <?php if ($requestSent) { ?>

      <p class="pl-1 py-2 text-green-700 bg-lime-100 rounded">
        We've sent a link to <b><?=htmlspecialchars($userInfo['email'])?></b> - please check your email and click the
        link to choose a new password. The link will expire in 1 hour.
      </p>
      <p class="mt-3"><a href="/user/dashboard.php" class="underline hover:bg-sky-100">Back to dashboard</a></p>

    <?php } else { ?>

      <p class="pl-1 py-2">
        We'll send a link to <b><?=htmlspecialchars($userInfo['email'])?></b> so you can confirm your identity and
        choose a new password.
      </p>
      <form method="post">
        <input type="submit" class="mt-3 rounded bg-sky-500 hover:bg-sky-400 focus:bg-sky-200 focus:shadow-sm focus:ring-4 focus:ring-sky-200 focus:ring-opacity-50 text-white w-full py-2.5 text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block" value="Send me a password change link">
      </form>
      <p class="mt-3"><a href="/user/dashboard.php" class="underline hover:bg-sky-100">Cancel, back to dashboard</a></p>

    <?php } ?>

  </div>
</div>

<?php include $path."/footer_tailwind.php"; ?>
