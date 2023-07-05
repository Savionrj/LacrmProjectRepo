<?php

include_once('include/init.php');
echoHeader('Home');


$user = getUser($_SESSION['userId']);

echo "
  <div id='home_page'>
";

echo "

  <div id='home_header'>
    
    <div id='profile_button'>
    </div>

    <div id='home_greeting'>
      <p>Hi ".$user['firstName']."!</p>
    </div>

    <a href='add_exercise.php' id='plus_mark_link'>
      <div id='home_menu_new_exercise_button'>
        <h3>+</h3>
      </div>
    </a>

  </div>

  <div id='exercises_list'>";
    displayAllExercises();
  echo "</div>

  <div id='home_menu'>
    
    <a href='log_exercise.php' id='start_exercises_link'>
      <div id='home_menu_start_exercise_button'>
        <h3>Start</h3>
      </div>
    </a>

  </div>

  </div>

";
