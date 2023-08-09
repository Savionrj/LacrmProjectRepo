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
  <form method='post'>
    <button type=submit name='routine_button' class='select_card' value='1'>
      <h3 class='header_text'>Freestyle</h3>
    </button>

    <p class='app_direction_text'>Or</br>Pick A Routine</p>";

displayAllRoutinesToLog($userId);

echo "
  </form>
";
