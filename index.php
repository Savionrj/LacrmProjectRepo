<?php

include_once('include/init.php');
echoHeader('Home');

if(empty($_SESSION)){
  header('location:login.php');
}
else{
  $user = getUser($_SESSION['userId']);
  $userId = $_SESSION['userId'];

echo "
  <div id='home_page'>
    <h1 class='title_text'>MoveMinder</h1>
    <h3 class='app_direction_text'>Welcome Back " . $user['firstName'] . "</h3>
    <div id='index_center_interactivity'>
      <div id='nav_arrows'>
        <a href='all_sessions.php'>
          <img src='include/icons/arrow-left.svg' />
        </a>
        <a href='manage.php'>
          <img src='include/icons/arrow-right.svg' />
        </a>
      </div>
      <a href='select_routine.php' id='start_session_link'>
        <div id='start_session_button'></div>
      </a>
    </div>
    <h3 class='header_text'>Start Session</h3>
  </div>
";
}
