<?php

/* Session Functions */

function getSessions($userId)
{

  $sessionData = db_Query("
    SELECT *
    FROM session
    WHERE userId = '$userId'
  ")->fetchAll();

  return $sessionData;
}

function displayAllSessions($userId)
{

  $allSessions = getSessions($userId);

  foreach ($allSessions as $individualSession) {

    echo "
      <form action='previous_session.php' method='post'>
        <input type='hidden' name='sessionIdPass' value=" . $individualSession['sessionId'] . " />
        <button name='session_card_button' type='submit' class='logged_session_card'>
          <p class='standard_text'>7/12/23 - 7 Exercises - Chest</p>
        </button>
      </form>
    ";
  }
}

function logSession($userId, $routineId)
{

  db_Query(
    "
    INSERT INTO session(userId, dateLogged, routineId)
    VALUES(:userId, :dateLogged, :routineId)
  ",
    [
      'userId' => $userId,
      'dateLogged' => date('Y-m-d H:i:s'),
      'routineId' => $routineId
    ]

  );
}

/* Routine Functions */

function getRoutines($userId)
{

  $routineData = db_Query("
    SELECT *
    FROM routine
    WHERE userId = '$userId' AND routineId != 1
  ")->fetchAll();

  return $routineData;
}

function getSingleRoutine($userId, $routineId)
{

  $routineData = db_Query("
    SELECT *
    FROM routine
    WHERE userId = '$userId' AND routineId = '$routineId'
  ")->fetch();

  return $routineData;
}


function displayAllRoutines($userId)
{

  $routineData = getRoutines($userId);

  foreach ($routineData as $individualRoutine) {
    echo "
      <button type=submit name='routine_button' class='select_card' value=" . $individualRoutine['routineId'] . ">
        <h3 class='header_text'>" . $individualRoutine['routineName'] . "</h3>
      </button>";
  }
}

function getAllExercisesInRoutine($userId, $routineId)
{

  $exercisesInRoutine = db_Query("
    SELECT *
    FROM routine_exercise
    WHERE userId = '$userId' AND routineId = '$routineId'
  ")->fetchAll();

  return $exercisesInRoutine;
}

function getExerciseById($exerciseId)
{

  $exerciseData = db_Query("
    SELECT *
    FROM exercise
    WHERE exerciseId = '$exerciseId'
  ")->fetch();

  return $exerciseData;
}

function displayAllExercisesInRoutine($userId, $routineId)
{

  $exercisesFromRoutine = getAllExercisesInRoutine($userId, $routineId);

  foreach ($exercisesFromRoutine as $individualExerciseFromRoutine) {

    $exerciseId = $individualExerciseFromRoutine['exerciseId'];
    $exerciseData = getExerciseById($exerciseId);
    $count = 0;


    echo "
      <form method='post'>
        <div class='select_card' id=>
          <h3 class='header_text'>" . $exerciseData['exerciseName'] . "</h3>
          <div class='card_options_row'>
            <button type='submit' name='add_set' class='form_button' value=" . $exerciseId . "></button>
            <button type='submit' name='remove_exercise' class='form_button' value=" . $exerciseId . "></button>
          </div>";
            if(isset($_REQUEST['add_set'])){
              if($exerciseData['workoutTypeId'] == 1){
                  $count++;

                  echo "
                    <div class='log_input_container'>
                      <form method='post'>
                        <div class='log_input_wrapper'>
                          <h3 class='app_direction_text'>Time</h3>
                          <div class='form_input_button'></div>
                        </div>
                        <div class='log_input_wrapper'>
                          <h3 class='app_direction_text'>Distance</h3>
                          <div class='form_input_button'></div>
                        </div>
                      </form>
                    </div>
                  ";
                }
              else {
                  echo "
                    <div class='log_input_container'>
                      <form method='post'>
                        <div class='log_input_wrapper'>
                          <h3 class='app_direction_text'>Reps</h3>
                          <div class='form_input_button'></div>
                        </div>
                        <div class='log_input_wrapper'>
                          <h3 class='app_direction_text'>Weight</h3>
                          <div class='form_input_button'></div>
                        </div>
                      </form>
                    </div>
                  ";
                }
            }
      echo"
        </div>
      </form>";
  }
}

/* Exercise Functions */

function getExercises($userId)
{

  $exerciseData = db_Query("
    SELECT *
    FROM exercise
    WHERE userId = '$userId'
  ")->fetchAll();

  return $exerciseData;
}

function displayAllExercises_fromAddExercise($userId)
{

  $exerciseData = getExercises($userId);

  foreach ($exerciseData as $individualExercise) {
    echo "
      <button type=submit name='add_to_session' class='header_text_container' value=" . $individualExercise['exerciseId'] . " style='background-color: #F0F8EC'>
        <h3 class='header_text'>" . $individualExercise['exerciseName'] . "</h3>
      </button>
    ";
  }
}

function logSessionExercise($sessionId, $exerciseId)
{
  db_Query(
    "
    INSERT INTO session_exercise(sessionId, exerciseId)
    VALUES(:sessionId, :exerciseId)
  ",
    [
      'sessionId' => $sessionId,
      'exerciseId' => $exerciseId,
    ]
  );
}

/* Set Functions */

function getSet($sessionExercise)
{

  $sessionExerciseId = $sessionExercise['sessionExerciseId'];

  $setData = db_Query("
    SELECT *
    FROM set
    WHERE sessionExerciseId = '$sessionExerciseId'
  ")->fetch();

  return $setData;
}

function logSet()
{
}

/* Log Functions */

function displayCardioLog($sessionExercise)
{

  $setData = getSet($sessionExercise);
  $count = 0;

  echo "
    <div class='dropdown_col'>
      <div>
        <p class='standard_text'>Set</p>
      </div>";
  foreach ($setData as $individualSet) {
    $count++;

    echo "
    <div>
      <p class='standard_text'>" . $count . "</p>
    </div>";
  }
  echo "
    </div>
    <div class='dropdown_col'>
      <div>
        <p class='standard_text'>Minutes</p>
      </div>";
  foreach ($setData as $individualSet) {
    $count++;

    echo "
    <div>
      <p class='standard_text'>" . $individualSet['minutes'] . "</p>
    </div>";
  }
  echo "
    </div>
    <div class='dropdown_col'>
      <div>
        <p class='standard_text'>Distance</p>
      </div>";
  foreach ($setData as $individualSet) {
    $count++;

    echo "
    <div>
      <p class='standard_text'>" . $individualSet['distance'] . "</p>
    </div>";

    echo "
    </div>
  ";
  }
}


