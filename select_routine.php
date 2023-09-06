<?php

include_once('include/init.php');
echoHeader('Select A Routine');

$userId = $_SESSION['userId'];

if (isset($_REQUEST['routine_button'])) {
  $_SESSION['routineId'] = $_REQUEST['routine_button'];
  $routineId = $_SESSION['routineId'];
  logSession($userId, $routineId);
  header("location: log_session.php");
}

echo "
  <form method='post' class='centered_form'>
    <button type=submit name='routine_button' class='select_card' value='1'>Freestyle</button>

    <p class='direction_text'>Or</br>Pick A Routine</p>";

    $allRoutines = getRoutines($userId);
    if(!empty($allRoutines)){
      displayAllRoutinesToLog($userId);
    }
    else{
      echo "
        <div class='full_page_text'>
          <h3 class='direction_text'>No Routines Yet</h3>
          <a href='new_routine.php'>
            <h3 class='direction_text'>Create One Here</h3>
          </a>
        </div>
      ";
    }

echo "
  </form>

  <div class='bottom_nav'>
  <div class='hidden_nav_button'>
  </div>
    <a href='index.php' class='nav_button' >
      <img src='include/icons/home.svg' />
    </a>
    <div class='hidden_nav_button'>
    </div>
  </div>
";
