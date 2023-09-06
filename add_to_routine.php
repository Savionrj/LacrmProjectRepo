<?php

include_once('include/init.php');
echoHeader('Add Exercise To Routine');

$userId = $_SESSION['userId'];
$routineId = $_SESSION['current_routineId'];
displayAllExercisesForAdd($userId, $routineId);

echo "
  <div class='bottom_nav'>
    <a href='edit_routine.php' class='side_nav_button'>
      <img src='include/icons/undo.svg' />
    </a>
    <a href='index.php' class='nav_button' >
      <img src='include/icons/home.svg' />
    </a>
    <div class='hidden_nav_button'>
    </div>
  </div>
";
