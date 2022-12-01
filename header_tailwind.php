<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>
      Think Economics
    </title>
    <meta name="description" content="A website to help learn Economics" />
    <meta name="keywords" content="" />
    <meta name="author" content="Ryan Hughes" />
    
    <!--
      Use below once tailwind is built:

    <link rel="stylesheet" href="/dist/output.css"/>
      -->  
    <!--
      Use below for development
    
      -->  
    <script src="https://cdn.tailwindcss.com"></script>

   

    <!--Replace with your tailwind.css once created-->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet" />
    <!-- Define your gradient here - use online tools to find a gradient matching your branding-->
    <style>
      .gradient {
        background: linear-gradient(90deg, #7dd3fc 0%, #f9a8d4 100%);
        //This colour is bg-sky-300 and bg-pink-300
      }

      .group:hover .group-hover\:block {
        display: block !important;
      }
      <?php echo $style_input;?>

    

      
    </style>
  </head>

  <body class="leading-normal tracking-normal text-white gradient" style="font-family: 'Source Sans Pro', sans-serif;">
    <!--Nav-->
    <nav id="header" class="fixed w-full z-30 top-0 text-white">
      <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-2">
        <div class="pl-4 flex items-center">
          <a class="toggleColour text-white no-underline hover:no-underline font-bold text-2xl lg:text-4xl font-mono" href="/">
            <!--Icon from: http://www.potlabicons.com/ -->
            <svg class="h-8 fill-current inline" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><style>@keyframes check {
              to {
                stroke-dashoffset: 0;
              }
            }</style>
              <rect width="16" height="16" x="4" y="4" stroke="#0A0A30" stroke-width="1.5" rx="2.075"/>
              <path 
                stroke="#7dd3fc" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 15l2.658-4.5 3.158 3.5L16.5 9" style="animation:check 2s infinite cubic-bezier(.99,-.1,.01,1.02)" stroke-dashoffset="100" stroke-dasharray="100"
                />
            </svg>
            thinkeconomics.co.uk
          </a>
        </div>
        <div class="block lg:hidden pr-4">
          <button id="nav-toggle" class="flex items-center p-1 text-pink-800 hover:text-gray-900 focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
            <svg class="fill-current h-6 w-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <title>Menu</title>
              <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
            </svg>
          </button>
        </div>
        <div class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden mt-2 lg:mt-0 bg-white lg:bg-transparent text-black p-4 lg:p-0 z-20" id="nav-content">
          <ul class="list-none p-0 lg:flex justify-end flex-1 items-center">
            <li class="mr-3">
              <a class="block text-black no-underline hover:bg-sky-100 lg:hover:bg-inherit py-2 px-4" href="/notes.php">
                Notes
              </a>
            </li>
            <li class="mr-3">
              <a class="block text-black no-underline hover:bg-sky-100 lg:hover:bg-inherit py-2 px-4" href="/news.php">
                News
              </a>
            </li>
            <li class="mr-3">
              <a class="block text-black no-underline hover:bg-sky-100 lg:hover:bg-inherit py-2 px-4" href="/exercises.php">
                Exercises
              </a>
            </li>
            <li class="mr-3">
              <a class="block text-black no-underline hover:bg-sky-100 lg:hover:bg-inherit py-2 px-4" href="/mcq.php">
                MCQs
              </a>
            </li>
            <li class="mr-3">
              <a class="block text-black no-underline hover:bg-sky-100 lg:hover:bg-inherit py-2 px-4" href="/admin.php">
                Admin
              </a>
            </li>
            
          </ul>
          <button
            id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
            class="flex items-center mx-auto lg:mx-0 hover:underline bg-pink-200 lg:bg-white text-gray-800 font-bold rounded-full mt-4 lg:mt-0 py-4 px-8 shadow opacity-75 focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out"
            
          
            <?php
            
            if(!isset($_SESSION['userid'])||($_SESSION['userid']=="")) {
              echo " onclick=\"location.href = '/login.php'\">Sign In";
            } else {
              $userInfo = getUserInfo($_SESSION['userid']);
              echo ">".trim($userInfo['name_first']." ".$userInfo['name_last']);
              ?> 
              <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
              <?php
            }
            
            ?>
           
          </button>
            <?php if(isset($_SESSION['userid'])) { ?>
            <!-- Dropdown menu -->
            <div id="dropdownNavbar" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-800 dark:divide-gray-600">
                <ul class="py-1 text-sm text-gray-800 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                  <li>
                    <a href="/user/user3.0.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                  </li>
                  <!--
                  <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                  </li>
                  
                  <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                  </li>
                  -->
                </ul>
                <div class="py-1">
                  <a href="/signout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">Sign out</a>
                </div>
            </div>

            <?php } ?>



        </div>
      </div>
      <hr class="border-b border-gray-100 opacity-25 my-0 py-0" />
      <?php //print_r($_SESSION);?>
    </nav>