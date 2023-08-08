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

function getCurrentSession($userId)
{
  $currentSession = db_Query("
    SELECT *
    FROM session
    WHERE userId = '$userId'
    ORDER BY sessionId
    DESC
  ")->fetch();

  return $currentSession;
}

function displayAllSessions($userId)
{

  $allSessions = getSessions($userId);

  foreach ($allSessions as $individualSession) {

    $routineId = $individualSession['routineId'];
    $routine = getSingleRoutine($userId, $routineId);
    $sessionId = $individualSession['sessionId'];
    $exercisesInSession = getExercisesInSession($sessionId);
    $exerciseCountInSession = count($exercisesInSession);

    echo "
      <form action='previous_session.php' method='post'>
        <input type='hidden' name='sessionIdPass' value=" . $individualSession['sessionId'] . " />
        <button name='session_card_button' type='submit' class='select_card'>
          <p class='small_text'>" . $individualSession['dateLogged'] . " - " . $exerciseCountInSession . " Exercise(s) - " . $routine['routineName'] . "</p>
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

function getExercisesInSession($sessionId)
{
  $exercisesInSession = db_Query("
    SELECT sessionExerciseId
    FROM session_exercise
    WHERE sessionId = $sessionId
  ")->fetchAll();

  return $exercisesInSession;
}

function getSessionExercise($sessionId, $exerciseId)
{
  $sessionExercise = db_Query("
    SELECT *
    FROM session_exercise
    WHERE sessionId = '$sessionId' AND exerciseId = '$exerciseId'
    LIMIT 1
  ")->fetch();

  return $sessionExercise;
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

  $session = getCurrentSession($userId);
  logSessionExercise($session, $routineId, $userId);

  $exercisesFromRoutine = getAllExercisesInRoutine($userId, $routineId);
  $sessionId = $session['sessionId'];
  $count = 0;

  foreach ($exercisesFromRoutine as $individualExerciseFromRoutine) {
    $exerciseId = $individualExerciseFromRoutine['exerciseId'];
    $exerciseData = getExerciseById($exerciseId);
    $sessionExercise = getSessionExercise($sessionId, $exerciseId);
    $sessionExerciseId = $sessionExercise['sessionExerciseId'];
    $count++;

    echo "
      <div class='select_card'>
        <h3 class='header_text'>" . $exerciseData['exerciseName'] . "</h3>
        <div class='card_options_row'>
          
          <button class='standard_button' id='form_button_id_" . $count . "' onclick='showForm(" . $count . "); switchToConfirmButton(" . $count . ")' >
            <img src='include/icons/plus.svg' alt='plus mark' />
          </button>
          <button style='border-color:red' class='standard_button' id='trash_button_id_" . $count . "' onclick='removeExercise(" . $exerciseId . ")' >
            <img src='include/icons/trash.svg' />
          </button>
        </div>";

    if ($exerciseData['workoutTypeId'] == 1) {
      if (isset($_REQUEST['log_cardio_set'])) {
        $time = $_REQUEST['time'];
        $distance = $_REQUEST['distance'];
        logCardioSet($time, $distance, $sessionExerciseId);
      }
      echo "
        <form method='post' id='log_set_form_" . $count . "' style='display:none;'>
          <div class='card_options_row'>
            <button type='submit' class='standard_button' name='log_cardio_set' id='log_button_id_" . $count . "' style='display:none;' onclick='submitForm(" . $count . ")'>
              <img src='include/icons/check.svg' alt='checkmark' />
            </button>
            <button type='reset' class='standard_button' id='cancel_button_id_" . $count . "' style='display:none; border-color:red;'  onclick='hideForm(" . $count . ")' >
              <img src='include/icons/close.svg' alt='close form' />
            </button>
          </div>
          <div class='log_set_form'>
            <div class='log_input_wrapper'>
              <h3 class='app_direction_text'>Time</h3>
              <input name='time' type='number' min='0' class='form_input' />
            </div>
            <div class='log_input_wrapper'>
              <h3 class='app_direction_text'>Distance</h3>
              <input name='distance' type='number' min='0' class='form_input' />
            </div>
          </div>
        </form>
      </div>
    ";
    } elseif ($exerciseData['workoutTypeId'] == 2) {
      if (isset($_REQUEST['log_weight_set'])) {
        $weight = $_REQUEST['weight'];
        $reps = $_REQUEST['reps'];
        logWeightSet($weight, $reps, $sessionExerciseId);
      }
      echo "
        <form method='post' id='log_set_form_" . $count . "' style='display:none;' >
          <div class='card_options_row'>
            <button type='submit' class='standard_button' name='log_weight_set' id='log_button_id_" . $count . "' style='display:none;' onclick='submitForm(" . $count . ")'>
              <svg width='50' height='50' fill='none' viewBox='0 0 24 24'>
                <path stroke='#A3F8AB' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M5.75 12.8665L8.33995 16.4138C9.15171 17.5256 10.8179 17.504 11.6006 16.3715L18.25 6.75'/>
              </svg>
            </button>
            <button type='reset' class='standard_button' id='cancel_button_id_" . $count . "' style='display:none; border-color:red;'  onclick='hideForm(" . $count . ")' >
              <img src='include/icons/close.svg' height='50' width='50' alt='close' >
            </button>
          </div>
          <div class='log_set_form'>
            <div class='log_input_wrapper'>
              <h3 class='app_direction_text'>Reps</h3>
              <input name='reps' type='number' min='1' class='form_input' />
            </div>
            <div class='log_input_wrapper'>
              <h3 class='app_direction_text'>Weight</h3>
              <input name='weight' type='number' min='0' class='form_input' />
            </div>
          </div>
        </form>
      </div>
    ";
    }
  }


  echo "
    <script type='text/javascript'>
      function showForm(card_count){
        document.getElementById('log_set_form_'+card_count).style.display = 'flex';
      }
      function hideForm(card_count){
        document.getElementById('log_set_form_'+card_count).style.display = 'none';
        document.getElementById('form_button_id_'+card_count).style.display = 'flex';
        document.getElementById('log_button_id_'+card_count).style.display = 'none';
        document.getElementById('trash_button_id_'+card_count).style.display = 'flex';
        document.getElementById('cancel_button_id_'+card_count).style.display = 'none';
      }
      function switchToConfirmButton(confirm_button_number){
        document.getElementById('form_button_id_'+confirm_button_number).style.display = 'none';
        document.getElementById('log_button_id_'+confirm_button_number).style.display = 'flex';
        document.getElementById('trash_button_id_'+confirm_button_number).style.display = 'none';
        document.getElementById('cancel_button_id_'+confirm_button_number).style.display = 'flex';
      }
    </script>
  ";
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

function logSessionExercise($session, $routineId, $userId)
{
  $sessionId = $session['sessionId'];
  $routineData = getSingleRoutine($userId, $routineId);

  $exercisesFromRoutine = getAllExercisesInRoutine($userId, $routineId);
  foreach ($exercisesFromRoutine as $individualExerciseFromRoutine) {
    $exerciseId = $individualExerciseFromRoutine['exerciseId'];

    $alreadyLogged = duplicateSessionExercise($sessionId, $exerciseId);

    if (empty($alreadyLogged)) {
      db_Query("
        INSERT INTO session_exercise(sessionId, exerciseId, userId)
        VALUES(:sessionId, :exerciseId, :userId)
      ",
        [
          'sessionId' => $sessionId,
          'exerciseId' => $exerciseId,
          'userId' => $userId
        ]
      );
    }
  }
}

function duplicateSessionExercise($sessionId, $exerciseId)
{
  
  $duplicateSessionExercise = db_Query("
    SELECT sessionExerciseId
    FROM session_exercise
    WHERE sessionId = $sessionId AND exerciseId = $exerciseId
  ")->fetch();
  return $duplicateSessionExercise;
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

function logCardioSet($time, $distance, $sessionExerciseId)
{
  db_Query(
    "
    INSERT INTO `set`(`time`, `distance`, `sessionExerciseId`)
    VALUES(:time, :distance, :sessionExerciseId)
  ",
    [
      'time' => intval($time),
      'distance' => intval($distance),
      'sessionExerciseId' => $sessionExerciseId
    ]
  );
}


function logWeightSet($weight, $reps, $sessionExerciseId)
{
  db_Query(
    "
    INSERT INTO `set`(`weight`, `reps`, `sessionExerciseId`)
    VALUES(:weight, :reps, :sessionExerciseId)
  ",
    [
      'weight' => intval($weight),
      'reps' => intval($reps),
      'sessionExerciseId' => $sessionExerciseId
    ]
  );
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
