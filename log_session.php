<?php

include_once('include/init.php');
echoHeader('Log Session');

$userId = $_SESSION['userId'];
$routineId = $_SESSION['routineId'];
$routineData = getSingleRoutine($userId, $routineId);

if($routineId == 1){
  echo "
    <h3 style='width:75%; border-bottom:2px solid gray;' class='head_text'  style='margin-bottom:0px;'>Freestyle</h3>";
  displayAllExercisesFreestyleLog($userId);
}
else{
  echo "
    <h3 style='width:75%; border-bottom:2px solid gray;' class='head_text'  style='margin-bottom:0px;'>" . $routineData['routineName'] ."</h3>";
    displayAllExercisesInRoutine($userId, $routineId);
    echo"
  ";
}

echo "
  <div class='bottom_nav'>
    <a href='select_routine.php' class='side_nav_button'>
      <img src='include/icons/undo.svg' />
    </a>
    <a href='index.php' class='nav_button' >
      <img src='include/icons/home.svg' />
    </a>
    <a href='add_freestyle.php' class='side_nav_button'>
      <img height='100' width='100' src='include/icons/plus.svg' />
    </a>
  </div>
";
