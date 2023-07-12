<?php

include_once('include/init.php');
echoHeader('Log');

$_SESSION['exerciseIdPass'] = $_REQUEST['exerciseIdPass'];;
$exerciseData = getSingleExercise($_SESSION['exerciseIdPass']);

echo "

<div id='log_exercise_page'>

  <h2 id='add_exercise_header'>".$exerciseData['exerciseName']."</h2>

  <div id='log_exercise_body'>";

    displayLogPage($exerciseData);

echo"
  </div>

  </div>
";
