<?php

include_once('include/init.php');
echoHeader('Edit Routine');

$userId = $_SESSION['userId'];
$routineId = $_SESSION['current_routineId'];

$routineExercises = getAllExercisesInRoutine($userId, $routineId);


foreach ($routineExercises as $individualExercise) {
  $exerciseId = $individualExercise['exerciseId'];
  $exercise = getExerciseById($exerciseId);

  echo"
    <div class='select_card'>
      <h3 class='header_text'>" . $exercise['exerciseName'] . "</h3>
      <form method='post' class='card_options_row'>
        <button style='border-color:red' class='standard_button'>
          <img src='include/icons/trash.svg' />
        </button>
      </form>
    </div>
  ";
}

echo"
  <a href='add_to_routine.php' class='create_new_button'>
    <h3 class='header_text'>Add</h3>
  </a>
  <a href='index.php' class='small_button'>
    <p class='small_text'>Back</p>
  </a>";
