<?php

include_once('include/init.php');
echoHeader('All Sessions');

$userId = $_SESSION['userId'];

echo "
  <div id='manage_cards_div'>
    <a href='manage_exercises.php' class='big_card'>Manage Exercises</a>
    <a href='manage_routines.php' class='big_card'>Manage Routines</a>
  </div>

  <a href='moveminder.php' class='big_card'>Sign Out</a>

  <div class='bottom_nav'>
    <a href='index.php' class='nav_button' >
      <img src='include/icons/home.svg' />
    </a>
  </div>
  ";

