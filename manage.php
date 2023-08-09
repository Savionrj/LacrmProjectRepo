<?php

include_once('include/init.php');
echoHeader('All Sessions');

$userId = $_SESSION['userId'];

echo "
<a href='manage_exercises.php' class='select_card'>
  <h3 class='header_text'>Manage Exercises</h3>
</a>
<a href='manage_routines.php' class='select_card'>
  <h3 class='header_text'>Manage Routines</h3>
</a>
<a href='manage_profile.php' class='select_card'>
  <h3 class='header_text'>Manage Profile</h3>
</a>
  <a href='login.php' id='sign_out_button' class='select_card'>
    <h3 class='header_text'>Sign Out</h3>
  </a>
  ";

