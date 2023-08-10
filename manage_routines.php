<?php

include_once('include/init.php');
echoHeader('Manage Routines');

$userId = $_SESSION['userId'];

displayAllRoutines($userId);

echo "
  <div class='bottom_nav'>
    <a href='manage.php' class='side_nav_button'>
      <img src='include/icons/undo.svg' />
    </a>
    <a href='index.php' class='nav_button' >
      <img src='include/icons/home.svg' />
    </a>
    <a href='new_routine.php' class='side_nav_button'>
      <img height='100' width='100' src='include/icons/plus.svg' />
    </a>
  </div>
";
