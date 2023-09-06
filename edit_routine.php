<?php

include_once('include/init.php');
echoHeader('Edit Routine');

$userId = $_SESSION['userId'];
$routineId = $_SESSION['current_routineId'];
$routine = getSingleRoutine($userId, $routineId);

$routineExercises = getAllExercisesInRoutine($userId, $routineId);

echo"
  <h3 class='header_text' style='width:60%; border-bottom:solid gray 2px;'>".$routine['routineName']."</h3>";

foreach ($routineExercises as $individualExercise) {
  $exerciseId = $individualExercise['exerciseId'];
  $exercise = getExerciseById($exerciseId);
  $exerciseName = $exercise['exerciseName'];

  if(isset($_REQUEST['trash_routine'])){
    if($_REQUEST['trash_routine'] == $exerciseId){
      deleteExerciseFromRoutine($exerciseId, $routineId);
      header('location:edit_routine.php');
    }
  }

  echo"
    <div style='width:75%;' class='exerciseRoutine_select_card'>
      $exerciseName
      <form method='post' class='card_options_row'>
        <button class='side_nav_button' type='submit' value='$exerciseId' name='trash_routine' style='border-color:red; width:150px; height:100px;'>
          <img src='include/icons/trash.svg' height='100' width='100' />
        </button>
      </form>
    </div>
  ";
}

echo "
  <div class='bottom_nav'>
    <a href='manage_routines.php' class='side_nav_button'>
      <img src='include/icons/undo.svg' />
    </a>
    <a href='index.php' class='nav_button' >
      <img src='include/icons/home.svg' />
    </a>
    <a href='add_to_routine.php' class='side_nav_button'>
      <img height='100' width='100' src='include/icons/plus.svg' />
    </a>
  </div>";
