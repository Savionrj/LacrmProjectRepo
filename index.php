<?php

include_once('include/init.php');
echoHeader('Home');

if(empty($_SESSION)){
  header('location:login.php');
}
else{
  $user = getUser($_SESSION['userId']);

echo "
  <h1 id='title_text'>MoveMinder</h1>
  <h3 class='app_direction_text'>Welcome Back " . $user['firstName'] . "</h3>
  <div id='index_center_interactivity'>
    <a href='select_routine.php' id='start_session_link'>
      <div id='start_session_button'></div>
    </a>
  </div>
  <h3 class='header_text'>Start Session</h3>
  <div>
    <button class='slide_up_modal' onclick='slideUp()'>
      
    </button>
  </div>
";
}
