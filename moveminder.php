<?php
include_once('include/init.php');
echoHeader('Login');
session_unset();

echo "
  <div id='moveminder_intro'>
    <h1 class='title_text'>MoveMinder</h1>
    <p class='basic_text'>Your Fitness Journey</br>One `Set` At A Time</p>
  </div>
  <div id='sign_buttons'>
    <a href='register.php' class='new_page_button'>
      Sign Up
    </a>
    <p class='basic_text'>Or</p>
    <a href='login.php' class='new_page_button'>
      Login
    </a>
  </div>
";
