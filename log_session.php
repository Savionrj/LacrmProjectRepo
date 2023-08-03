<?php

include_once('include/init.php');
echoHeader('Log Session');

$userId = $_SESSION['userId'];
$routineId = $_SESSION['routineId'];
$routineData = getSingleRoutine($userId, $routineId);

echo "
  <h3 class='header_text'  style='margin-bottom:0px;'>" . $routineData['routineName'] . "</h3>";
  displayAllExercisesInRoutine($userId, $routineId);

