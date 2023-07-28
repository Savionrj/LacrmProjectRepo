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




        // <div class='select_card'>
        //   <h3 class='header_text'>" . $exerciseData['exerciseName'] . "</h3>
        //   <div class='card_options_row'>
        //     <button type='submit' name='add_set' class='form_button'></button>
        //     <h3 class='header_text'></div>
        //     <button type='submit' name='remove_exercise' class='form_button'></button>
        //   </div>
        // </div>
