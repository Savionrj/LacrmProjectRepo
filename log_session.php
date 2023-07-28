<?php

include_once('include/init.php');
echoHeader('Log Session');

$userId = $_SESSION['userId'];
$routineId = $_SESSION['routineId'];
$routineData = getSingleRoutine($userId, $routineId);

if (isset($_REQUEST['$exerciseId'])) {
}

echo "

  <h3 class='header_text'  style='margin-bottom:0px;'>" . $routineData['routineName'] . "</h3>";

displayAllExercisesInRoutine($userId, $routineId);



// echo "
//   <a href='add_exercise.php' class='header_text_container'>
//     <h3 class='header_text'>Add Exercise</h3>
//   </a>
// ";
