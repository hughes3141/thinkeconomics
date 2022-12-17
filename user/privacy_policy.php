<?php

// Initialize the session
session_start();

// Define which page redirected to here
//Storing previous URLs to ensure that we can redirect to page where we cane from
/*
if($_SESSION['this_url'] != $_SERVER['REQUEST_URI']) {
  $_SESSION['last_url'] = $_SESSION['this_url'];
  $_SESSION['this_url'] = $_SERVER['REQUEST_URI'];
}
*/


$previous = "";
if($_SESSION['last_url']) {
  $previous = $_SESSION['last_url'];
}


if (!isset($_SESSION['userid'])) {
  
  //header("location: /login.php");
  
}

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");


//Very little file that only contains the vairabble $version to be ouput to database.
include ("privacy_version.php");

$userId =  $_SESSION['temp_userid'];

function updatePrivacy($userId) {
  global $conn;
  date_default_timezone_set('Europe/London');
  $datetime = date("Y-m-d H:i:s");
  $privacy_bool = 1;
  global $version;

  $sql = "UPDATE users
          SET privacy_agree = ?, privacy_date = ?, privacy_vers = ?
          WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("issi", $privacy_bool, $datetime, $version, $userId);
  $stmt->execute();

  $_SESSION['userid'] = $userId;
  unset($_SESSION['temp_userid']);


  login_log($userId);
  global $previous;

  // Redirect user to previous page
  if(($previous !="")&&($previous !="/")) {
    header("location: ".$previous);
  } else if ($previous == "/") {
    header("location: /user/user3.0.php");
  } else if ($previous == $_SERVER['REQUEST_URI']) { 
    header("location: /user/user3.0.php");
  } else {
    header("location: index.php");
  }


}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  if($_POST['submit'] == "Agree and continue") {
    updatePrivacy($_SESSION['temp_userid']);
  }
  
}

include ($path."/header_tailwind.php");


?>


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">thinkeconomics.co.uk Privacy and Data Policy</h1>
  <div class="container mx-auto p-2 text-lg mt-2 bg-white text-black">
    <?php

    print_r($_POST);
    print_r($_SESSION);
    echo "<br>";
    echo $previous;

      if(isset($_GET['login_redirect'])) {

        ?>
        <p class="bg-pink-400 text-2xl font-mono">Hello!</p>
        <p>Sorry to interrupt you, but we've changed our privacy policy recently. We'd love for you to have a look and agree to the new one before you log in.</p>
        <p>Would you mind having a look and then agreeing you're okay with it? Then you can get back to your learning</p>
        <p>Thanks from the team here at thinkeconomics.co.uk!</p>

        <?php


      }

    ?>
    <p class="bg-pink-400 text-2xl font-mono">Okay, here&rsquo;s the short version without the legal stuff:</p>
      <ul class="list-disc  ml-6">
        <li>Our aim is to help people learn.</li>
        <li>We will collect only enough data about you to help you learn more effectively.</li>
        <li>We will never share or sell your data to third parties. Ever.</li>
      </ul>
    <p>We are teachers. We are not interested in making money off your data.</p>
    <p>That&rsquo;s pretty much it!</p>
    <p>If you want to know the rest, then have a look at the following:</p>
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Detailed Privacy and Data Policy</h1>
    <p>thinkeconomics.co.uk is a small UK-based company. This privacy policy will explain how our organization uses the personal data we collect from you when you use our website.</p>
    <p>Topics:</p>
      <ul class="list-disc  ml-6">
        <li>What data do we collect?</li>
        <li>How do we collect your data?</li>
        <li>How will we use your data?</li>
        <li>How do we store your data?</li>
        <li>Marketing</li>
        <li>What are your data protection rights?</li>
        <li>What are cookies?</li>
        <li>How do we use cookies?</li>
        <li>What types of cookies do we use?</li>
        <li>How to manage your cookies</li>
        <li>Privacy policies of other websites</li>
        <li>Changes to our privacy policy</li>
        <li>How to contact us</li>
        <li>How to contact the appropriate authorities</li>
      </ul>
  <h2 class="font-mono text-xl bg-sky-100 pl-1">What data do we collect?</h2>
    <p>Our Company collects the following data:</p>
      <ul class="list-disc  ml-6">
        <li>Personal identification information (Name, email address)</li>
        <li>Your responses to assignments</li>
        <li>Your input into the news database</li>
      </ul>
  <h2 class="font-mono text-xl bg-sky-100 pl-1">How do we collect your data?</h2>
    <p>You directly provide thinkeconomics.co.uk with most of the data we collect. We collect data and process data when you:</p>
      <ul class="list-disc  ml-6">
        <li>Register online.</li>
        <li>Provide answers to questions.</li>
        <li>Voluntarily complete entries into the News Blog</li>
        <li>Navigate to different parts of the website while you&rsquo;re logged in.</li>
      </ul>
  <h2 class="font-mono text-xl bg-sky-100 pl-1">How will we use your data?</h2>
    <p>thinkeconomics.co.uk collects your data so that we can:</p>
      <ul class="list-disc  ml-6">
        <li>Manage your account.</li>
        <li>Inform your teacher/administrator about your progress.</li>
        <li>Email you with information about upcoming assignments.</li>
      </ul>
    <p>thinkeconomics.co.uk will not share your data with any partner companies.</p>
  <h2 class="font-mono text-xl bg-sky-100 pl-1">How do we store your data?</h2>
    <p>thinkeconomics.co.uk securely stores your data with a UK-based cloud hosting service. All sensitive information is stored with encryption.</p>
    <p>thinkeconomics.co.uk will keep your data for 2 years after your last active login session. Once this time period has expired, we will delete your data.</p>
  <h2 class="font-mono text-xl bg-sky-100 pl-1">Marketing</h2>
    <p>thinkeconomics.co.uk does not use your data for marketing purposes.</p>
  <h2 class="font-mono text-xl bg-sky-100 pl-1">What are your data protection rights?</h2>
    <p>thinkeconomics.co.uk would like to make sure you are fully aware of all of your data protection rights.</p>
    <p>Every user is entitled to the following:</p>
    <p><strong>The right to access </strong>- You have the right to request thinkeconomics.co.uk for copies of your personal data. We may charge you a small fee for this service.</p>
    <p><strong>The right to rectification </strong>- You have the right to request that thinkeconomics.co.uk correct any information you believe is inaccurate. You also have the right to request thinkeconomics.co.uk to complete information you believe is incomplete.</p>
    <p><strong>The right to erasure </strong>- You have the right to request that thinkeconomics.co.uk erase your personal data, under certain conditions.</p>
    <p><strong>The right to restrict processing </strong>- You have the right to request that thinkeconomics.co.uk restrict the processing of your personal data, under certain conditions.</p>
    <p><strong>The right to object to processing </strong>- You have the right to object to thinkeconomics.co.uk&rsquo;s processing of your personal data, under certain conditions.</p>
    <p><strong>The right to data portability </strong>- You have the right to request that thinkeconomics.co.uk transfer the data that we have collected to another organization, or directly to you, under certain conditions.</p>
    <p>If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us at our email:</p>
    <p><a class="hover:bg-sky-100" href="mailto:hello@thinkeconomics.co.uk">hello@thinkeconomics.co.uk</a></p>
  <h2 class="font-mono text-xl bg-sky-100 pl-1">What are cookies?</h2>
    <p>Cookies are text files placed on your computer to collect standard Internet log information and visitor behaviour information.</p>
    <p>When you visit our websites, we may collect information from you automatically through cookies or similar technology.</p>
    <p>For further information, visit <a class="hover:bg-sky-100" href="https://allaboutcookies.org/" target="_blank">allaboutcookies.org</a>.</p>
    <p>thinkeconomics.co.uk does not use cookies.</p>
  <h2 class="font-mono text-xl bg-sky-100 pl-1">How do we use cookies?</h2>
    <p>We don&rsquo;t use cookies.</p>
    <p>If we change this policy in the future we will ask you to sign a new privacy agreement.</p>
    <p>If and when thinkeconomics.co.uk uses cookies, it will be for the following reasons:</p>
      <ul class="list-disc  ml-6">
        <li>Keeping you signed in</li>
        <li>Understanding how you use our website</li>
      </ul>
  <h2 class="font-mono text-xl bg-sky-100 pl-1">What types of cookies do we use?</h2>
    <p>Currently: none.</p>
    <p>If and when we do, we would use the following types:</p>
      <ul class="list-disc  ml-6">
        <li>Functionality - thinkeconomics.co.uk uses these cookies so that we recognize you on our website and remember your previously selected preferences. These could include what language you prefer and location you are.</li>
      </ul>
  <h2 class="font-mono text-xl bg-sky-100 pl-1">How to manage cookies</h2>
    <p>You can set your browser not to accept cookies, and the above website tells you how to remove cookies from your browser.</p>
  <h2 class="font-mono text-xl bg-sky-100 pl-1">Privacy policies of other websites</h2>
    <p>The thinkeconomics.co.uk website contains links to other websites. Our privacy policy applies only to our website, so if you click on a link to another website, you should read their privacy policy.</p>
  <h2 class="font-mono text-xl bg-sky-100 pl-1">Changes to our privacy policy</h2>
    <p>Our Company keeps its privacy policy under regular review and places any updates on this web page. This privacy policy was last updated on 14 December 2022</p>
  <h2 class="font-mono text-xl bg-sky-100 pl-1">How to contact us</h2>
    <p>If you have any questions about thinkeconomics.co.uk&rsquo;s privacy policy, the data we hold on you, or you would like to exercise one of your data protection rights, please do not hesitate to contact us.</p>
    <p>Email us at: <a class="hover:bg-sky-100" href="mailto:hello@thinkeconomics.co.uk">hello@thinkeconomics.co.uk</a></p>
  <h2 class="font-mono text-xl bg-sky-100 pl-1">How to contact the appropriate authority</h2>
    <p>Should you wish to report a complaint or if you feel that thinkeconomics.co.uk has not addressed your concern in a satisfactory manner, you may contact the Information Commissioner's Office.</p>
    <p>Helpline: 0303 123 1113</p>
    <p>Website: <a class="hover:bg-sky-100" href="https://ico.org.uk/" target="_blank" >https://ico.org.uk/</a></p>



    <?php

    if(isset($_GET['login_redirect'])) {

      ?>
    <form method = "post" action ="">

    <input type="submit" name="submit" class=" font-mono bg-sky-500 hover:bg-sky-400 focus:bg-sky-200 focus:shadow-sm focus:ring-4 focus:ring-sky-200 focus:ring-opacity-50 text-white w-full py-2.5 text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block" value="Agree and continue">
  </form>

  <?php 
    }
    ?>

  </div>
</div>





<?php include "../footer_tailwind.php"; ?>