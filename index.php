<?php

include_once('include/init.php');
echoHeader('Home');

$user = getUser($_SESSION['userId']);

echo "
  <h1 id='title_text'>MoveMinder</h1>
  <h3 class='app_direction_text'>Welcome Back ".$user['firstName']."</h3>
  <div id='index_center_interactivity'>
    <div> <- </div>
    <div id='start_session_button'></div>
    <div> -> </div>
  </div>
";
