<?php

/* Session Functions */

function getSessions($userId)
{

  $sessionData = db_Query("
    SELECT *
    FROM session
    WHERE userId = '$userId'
    ORDER BY sessionId
    DESC
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

function getMostRecentSession($userId)
{
  $recentSession = db_Query("
    SELECT *
    FROM session
    WHERE userId = $userId
    ORDER BY dateLogged DESC
    LIMIT 1
  ")->fetch();

  return $recentSession;
}

function displayAllSessions($userId)
{
  $allSessions = getSessions($userId);

  foreach ($allSessions as $individualSession) {

    $sessionId = $individualSession['sessionId'];

    if (isset($_REQUEST['session_card_button'])) {
      if($_REQUEST['session_card_button']== $sessionId){
        $_SESSION['observed_session'] = $sessionId;
        header('location:previous_session.php');
      }
    }
    
    $routineId = $individualSession['routineId'];
    $routine = getSingleRoutine($userId, $routineId);
    $exercisesInSession = getExercisesInSession($sessionId);
    $exerciseCountInSession = count($exercisesInSession);

    echo "
      <form action='#' method='post' class='centered_form'>
        <button name='session_card_button' type='submit' class='minor_select_card' value=".$sessionId.">" . $individualSession['dateLogged'] . "</br>" . $exerciseCountInSession . " Exercises - " . $routine['routineName'] . "</button>
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

function getExerciseIdsFromSesEx($sessionId){
  $exIds = db_Query("
    SELECT exerciseId
    FROM session_exercise
    WHERE sessionId = $sessionId
  ")->fetchAll();

  return $exIds;
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

function addRoutine($routineName)
{
  $userId = $_SESSION['userId'];

  db_Query(
    "
    INSERT INTO routine(routineName, userId)
    VALUES(:routineName, :userId)
  ",
    [
      'routineName' => $routineName,
      'userId' => $userId
    ]
  );
}

function displayRoutineOptions($userId)
{
  $routineData = getRoutines($userId);

  foreach ($routineData as $individualRoutine) {
    $routineId = $individualRoutine['routineId'];
    echo "
      <option value=" . $routineId . " >" . $individualRoutine['routineName'] . "</option>
    ";
  }
}






function displayAllRoutines($userId)
{

  $routineData = getRoutines($userId);

  foreach ($routineData as $individualRoutine) {
    if (isset($_REQUEST['expand_routine'])) {
      $_SESSION['current_routineId'] = $_REQUEST['routineId'];
      header('location:edit_routine.php');
    }
    echo "
    <form method='post' class='centered_form' style='height:30%'>
      <input type='hidden' name='routineId' value=" . $individualRoutine['routineId'] . " />
      <button type='submit' name='expand_routine' class='big_card'>" . $individualRoutine['routineName'] . "</button>
    </form>
    ";
  }
}

function displayAllRoutinesToLog($userId)
{
  $routineData = getRoutines($userId);
  foreach ($routineData as $individualRoutine) {
    echo "
      <button type=submit name='routine_button' class='select_card' value=" . $individualRoutine['routineId'] . ">" . $individualRoutine['routineName'] . "</button>
    ";
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
    WHERE exerciseId = $exerciseId
  ")->fetch();

  return $exerciseData;
}

function getExerciseNameById($exerciseId){

  $exerciseName = db_Query("
    SELECT exerciseName
    FROM exercise
    WHERE exerciseId = $exerciseId
  ")->fetch();

  return $exerciseName['exerciseName'];
}

function displayAllExercisesInRoutine($userId, $routineId)
{

  $session = getCurrentSession($userId);
  logSessionExercise($session, $routineId, $userId);

  $exercisesFromRoutine = getAllExercisesInRoutine($userId, $routineId);
  $sessionId = $session['sessionId'];
  $count = 0;
  $setCount = 0;

  foreach ($exercisesFromRoutine as $individualExerciseFromRoutine) {
    $exerciseId = $individualExerciseFromRoutine['exerciseId'];
    $exerciseData = getExerciseById($exerciseId);
    $sessionExercise = getSessionExercise($sessionId, $exerciseId);
    $sessionExerciseId = $sessionExercise['sessionExerciseId'];
    $count++;
    if (isset($_REQUEST['log_set'])) {
      $setCount++;
    }

    echo "
      <div style='width:65%;' class='texted_select_card'>
          <button style='height:100px; border: 2px #A3F8AB solid;' class='side_nav_button' id='form_button_id_" . $count . "' onclick='showForm(" . $count . "); switchToConfirmButton(" . $count . ")' >
              <img src='include/icons/plus.svg' alt='plus mark' />
            </button>
          <h3 class='header_text'>" . $exerciseData['exerciseName'] . "</h3>";

    if (isset($_REQUEST['log_set'])) {
      if ($_REQUEST['log_set'] == $exerciseId) {
        $weight = $_REQUEST['weight'];
        $reps = $_REQUEST['reps'];
        $minutes = $_REQUEST['minutes'];
        $steps = $_REQUEST['steps'];
        logSet($weight, $reps, $minutes, $steps, $sessionExerciseId);
      }
    }
    echo "
        <form method='post' class='centered_form' action='log_session.php' id='log_form_" . $count . "' style='display:none;' >
          <div class='card_options_row'>
            <button type='submit' class='standard_button' value=" . $exerciseId . " name='log_set' id='log_button_id_" . $count . "' style='display:none;' onclick='submitForm(" . $count . ")'>
              <img src='include/icons/check.svg' height='50' width='50' alt='checkmark' >
            </button>
            <h2 class='form_heading' id='set_count_id_" . $count . "' >" . $setCount . "</h2>
            <button type='reset' class='standard_button' id='cancel_button_id_" . $count . "' style='display:none; border-color:red;'  onclick='hideForm(" . $count . ")' >
              <img src='include/icons/close.svg' height='50' width='50' alt='close' >
            </button>
          </div>
          <div class='log_set_form'>";
    if ($exerciseData['use_reps'] == 1) {
      echo "
                <div class='log_input_wrapper'>
                  <h3 class='app_direction_text'>Reps</h3>
                  <input name='reps' type='number' min='1' class='form_input' />
                </div>
              ";
    } else {
      echo "
                  <input name='reps' type='hidden' class='form_input' value='0' />
              ";
    }

    if ($exerciseData['use_minutes'] == 1) {
      echo "
                <div class='log_input_wrapper'>
                  <h3 class='app_direction_text'>Minutes</h3>
                  <input name='minutes' type='number' min='1' class='form_input' />
                </div>
              ";
    } else {
      echo "
                  <input name='minutes' type='hidden' class='form_input' value='0' />
              ";
    }

    if ($exerciseData['use_steps'] == 1) {
      echo "
                <div class='log_input_wrapper'>
                  <h3 class='app_direction_text'>Steps</h3>
                  <input name='steps' type='number' min='1' class='form_input' />
                </div>
              ";
    } else {
      echo "
                  <input name='steps' type='hidden' class='form_input' value='0' />
              ";
    }

    if ($exerciseData['use_weight'] == 1) {
      echo "
                <div class='log_input_wrapper'>
                  <h3 class='app_direction_text'>Weight</h3>
                  <input name='weight' type='number' min='1' class='form_input' />
                </div>
              ";
    } else {
      echo "
                  <input name='weight' type='hidden' class='form_input' value='0' />
              ";
    }
    echo "
          </div>
        </form>
      </div>
    ";
  }

  echo "
    <script type='text/javascript'>

      function showForm(card_count){
        document.getElementById('log_form_'+card_count).style.display = 'flex';
        document.getElementById('form_button_id_'+card_count).style.display='none';
      }
      function hideForm(card_count){
        document.getElementById('log_form_'+card_count).style.display = 'none';
        document.getElementById('form_button_id_'+card_count).style.display = 'flex';
        document.getElementById('log_button_id_'+card_count).style.display = 'none';
        document.getElementById('trash_button_id_'+card_count).style.display = 'flex';
        document.getElementById('cancel_button_id_'+card_count).style.display = 'none';
        document.getElementById('main_set_count_id_'+card_count).style.display = 'flex';
      }
      function switchToConfirmButton(confirm_button_number){
        document.getElementById('log_button_id_'+confirm_button_number).style.display = 'flex';
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

function addExercise($exerciseName, $use_reps, $use_steps, $use_weight, $use_minutes)
{
  $userId = $_SESSION['userId'];

  db_Query(
    "
    INSERT INTO exercise(exerciseName, userId, use_reps, use_minutes, use_steps, use_weight)
    VALUES(:exerciseName, :userId, :use_reps, :use_minutes, :use_steps, :use_weight)
  ",
    [
      'exerciseName' => $exerciseName,
      'userId' => $userId,
      'use_reps' => $use_reps,
      'use_minutes' => $use_minutes,
      'use_steps' => $use_steps,
      'use_weight' => $use_weight
    ]
  );
}

function updateExercise($exerciseId, $exerciseName, $use_reps, $use_steps, $use_weight, $use_minutes)
{

  debugOutput($exerciseId, $exerciseName, $use_reps, $use_steps, $use_weight, $use_minutes);

  db_Query("
    UPDATE exercise
    SET exerciseName = :exerciseName, use_reps = :use_reps, use_minutes = :use_minutes, use_steps = :use_steps, use_weight = :use_weight
    WHERE exerciseId = $exerciseId
  ",
    [
      'exerciseName' => $exerciseName,
      'use_reps' => intval($use_reps),
      'use_minutes' => intval($use_minutes),
      'use_steps' => intval($use_steps),
      'use_weight' => intval($use_weight)
    ]
);
}

function deleteExercise($exerciseId)
{
  db_Query("
    DELETE
    FROM exercise
    WHERE exerciseId = $exerciseId
  ");

  db_Query("
    DELETE
    FROM routine_exercise
    WHERE exerciseId = $exerciseId
  ");
}

function deleteExerciseFromRoutine($exerciseId, $routineId)
{
  db_Query("
    DELETE
    FROM routine_exercise
    WHERE exerciseId = $exerciseId AND routineId = $routineId
  ");
}

function displayAllExercises($userId)
{

  $exerciseData = getExercises($userId);

  foreach ($exerciseData as $individualExercise) {
    if (isset($_REQUEST['expand_exercise'])) {
      $_SESSION['current_exerciseId'] = $_REQUEST['exerciseId'];
      header('location:edit_exercise.php');
    }
    echo "
    <form method='post' class='centered_form' style='height:20%'>
      <input type='hidden' name='exerciseId' value=" . $individualExercise['exerciseId'] . " />
      <button type='submit' name='expand_exercise' class='big_card'>" . $individualExercise['exerciseName'] . "</button>
    </form>
    ";
  }
}

function displayAllExercisesForAdd($userId, $routineId)
{
  $exerciseData = getExercises($userId);

  foreach ($exerciseData as $individualExercise) {
    $exerciseId = $individualExercise['exerciseId'];
    if (isset($_REQUEST['add_exercise'])) {
      if ($_REQUEST['add_exercise'] == $exerciseId) {
        linkExerciseToRoutine($exerciseId, $routineId, $userId);
        header('location:edit_routine.php');
      }
    }
    echo "
    <form method='post' class='centered_form'>
      <button type='submit' name='add_exercise' class='select_card' value=" . $exerciseId . ">" . $individualExercise['exerciseName'] . "</button>
    </form>
    ";
  }
}

function displayAllExercisesForFreestyle($userId)
{
  $exerciseData = getExercises($userId);

  foreach ($exerciseData as $individualExercise) {
    $exerciseId = $individualExercise['exerciseId'];
    if (isset($_REQUEST['add_exercise_freestyle'])) {
      if ($_REQUEST['add_exercise_freestyle'] == $exerciseId) {
        addToFreestyle($exerciseId, $userId);
        header('location:log_session.php');
      }
    }
    echo "
    <form class='centered_form' method='post'>
      <button type='submit' name='add_exercise_freestyle' class='texted_select_card' value=" . $exerciseId . ">
        <h3 class='header_text'>" . $individualExercise['exerciseName'] . "</h3>
      </button>
    </form>
    ";
  }
}

function linkExerciseToRoutine($exerciseId, $routineId, $userId)
{
  db_Query(
    "
      INSERT INTO routine_exercise(exerciseId, routineId, userId)
      VALUES(:exerciseId, :routineId, :userId)
      ",
    [
      'exerciseId' => $exerciseId,
      'routineId' => $routineId,
      'userId' => $userId
    ]
  );
}

function getFreestyleExercises($userId, $sessionId, $freestyle){
  $freestyleExercises = db_Query("
    SELECT *
    FROM session_exercise
    WHERE userId = $userId AND sessionId = $sessionId and freestyle = $freestyle
  ")->fetchAll();

  return $freestyleExercises;
}

function displayAllExercisesFreestyleLog($userId)
{
  $session = getCurrentSession($userId);
  $sessionId = $session['sessionId'];
  $freestyle = intval(1);

  $freestyleExercises = getFreestyleExercises($userId, $sessionId, $freestyle);

  $count = 0;
  $setCount = 0;

  foreach ($freestyleExercises as $individualFreestyleExercise) {
    $exerciseId = $individualFreestyleExercise['exerciseId'];
    $exerciseData = getExerciseById($exerciseId);
    $sessionExercise = getSessionExercise($sessionId, $exerciseId);
    $sessionExerciseId = $sessionExercise['sessionExerciseId'];
    $count++;
    if (isset($_REQUEST['log_set'])) {
      $setCount++;
    }

    echo "
      <div style='width:65%;' class='texted_select_card'>
      <button style='height:100px; border: 2px #A3F8AB solid;' class='side_nav_button' id='form_button_id_" . $count . "' onclick='showForm(" . $count . "); switchToConfirmButton(" . $count . ")' >
            <img src='include/icons/plus.svg' alt='plus mark' />
          </button>
        <h3 class='header_text'>" . $exerciseData['exerciseName'] . "</h3>";

    if (isset($_REQUEST['log_set'])) {
      if ($_REQUEST['log_set'] == $exerciseId) {
        $weight = $_REQUEST['weight'];
        $reps = $_REQUEST['reps'];
        $minutes = $_REQUEST['minutes'];
        $steps = $_REQUEST['steps'];
        logSet($weight, $reps, $minutes, $steps, $sessionExerciseId);
      }
    }
    echo "
        <form method='post' class='centered_form' action='log_session.php' id='log_form_" . $count . "' style='display:none;' >
          <div class='card_options_row'>
            <button type='submit' class='standard_button' value=" . $exerciseId . " name='log_set' id='log_button_id_" . $count . "' style='display:none;' onclick='submitForm(" . $count . ")'>
              <img src='include/icons/check.svg' height='50' width='50' alt='checkmark' >
            </button>
            <h2 class='form_heading' id='set_count_id_" . $count . "' >" . $setCount . "</h2>
            <button type='reset' class='standard_button' id='cancel_button_id_" . $count . "' style='display:none; border-color:red;'  onclick='hideForm(" . $count . ")' >
              <img src='include/icons/close.svg' height='50' width='50' alt='close' >
            </button>
          </div>
          <div class='log_set_form'>";
    if ($exerciseData['use_reps'] == 1) {
      echo "
        <div class='log_input_wrapper'>
          <h3 class='app_direction_text'>Reps</h3>
          <input name='reps' type='number' min='1' class='form_input' />
        </div>
      ";
    } else {
      echo "
        <input name='reps' type='hidden' class='form_input' value='0' />
      ";
    }

    if ($exerciseData['use_minutes'] == 1) {
      echo "
        <div class='log_input_wrapper'>
          <h3 class='app_direction_text'>Minutes</h3>
          <input name='minutes' type='number' min='1' class='form_input' />
        </div>
      ";
    } else {
      echo "
        <input name='minutes' type='hidden' class='form_input' value='0' />
      ";
    }

    if ($exerciseData['use_steps'] == 1) {
      echo "
        <div class='log_input_wrapper'>
          <h3 class='app_direction_text'>Steps</h3>
          <input style='' name='steps' type='number' min='1' class='form_input' />
        </div>
      ";
    } else {
      echo "
        <input name='steps' type='hidden' class='form_input' value='0' />
      ";
    }

    if ($exerciseData['use_weight'] == 1) {
      echo "
        <div class='log_input_wrapper'>
          <h3 class='app_direction_text'>Weight</h3>
          <input name='weight' type='number' min='1' class='form_input' />
        </div>
      ";
    } else {
      echo "
        <input name='weight' type='hidden' class='form_input' value='0' />
      ";
    }
    echo "
          </div>
        </form>
      </div>
    ";
  }

  echo "
    <script type='text/javascript'>

      function showForm(card_count){
        document.getElementById('log_form_'+card_count).style.display = 'flex';
        document.getElementById('form_button_id_'+card_count).style.display='none';
      }
      function hideForm(card_count){
        document.getElementById('log_form_'+card_count).style.display = 'none';
        document.getElementById('form_button_id_'+card_count).style.display = 'flex';
        document.getElementById('log_button_id_'+card_count).style.display = 'none';
        document.getElementById('trash_button_id_'+card_count).style.display = 'flex';
        document.getElementById('cancel_button_id_'+card_count).style.display = 'none';
        document.getElementById('main_set_count_id_'+card_count).style.display = 'flex';
      }
      function switchToConfirmButton(confirm_button_number){
        document.getElementById('log_button_id_'+confirm_button_number).style.display = 'flex';
        document.getElementById('cancel_button_id_'+confirm_button_number).style.display = 'flex';
        document.getElementById('main_set_count_id_'+confirm_button_number).style.display = 'none';
      }
    </script>
  ";
}

// function displayAllExercises_fromAddExercise($userId)
// {

//   $exerciseData = getExercises($userId);

//   foreach ($exerciseData as $individualExercise) {
//     if(isset($_REQUEST['expand_exercise'])){
//       $_SESSION['current_exerciseId'] = $_REQUEST['exerciseId'];
//       header('location:edit_exercise.php');
//     }
//     echo "
//     <form method='post'>
//       <input type='hidden' name='exerciseId' value=".$individualExercise['exerciseId']."
//       <button type='submit' name='expand_exercise' class='header_text_container' style='background-color: #F0F8EC'>
//         <h3 class='header_text'>" . $individualExercise['exerciseName'] . "</h3>
//       </button>
//     </form>
//     ";
//   }
// }

function logSessionExercise($session, $routineId, $userId)
{
  $sessionId = $session['sessionId'];
  $routineData = getSingleRoutine($userId, $routineId);

  $exercisesFromRoutine = getAllExercisesInRoutine($userId, $routineId);
  foreach ($exercisesFromRoutine as $individualExerciseFromRoutine) {
    $exerciseId = $individualExerciseFromRoutine['exerciseId'];

    $alreadyLogged = duplicateSessionExercise($sessionId, $exerciseId);

    if (!$alreadyLogged) {
      db_Query(
        "
        INSERT INTO session_exercise(sessionId, exerciseId, userId)
        VALUES(:sessionId, :exerciseId, :userId)
      ",
        [
          'sessionId' => $sessionId,
          'exerciseId' => $exerciseId,
          'userId' => $userId
        ]
      );
    } else {;
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

function getSet($sessionExId)
{
  $setData = db_Query("
    SELECT *
    FROM `set`
    WHERE sessionExerciseId = '$sessionExId'
  ")->fetchAll();

  return $setData;
}

function countSets($sessionExerciseId)
{

  $allSets = db_Query("
    SELECT setId
    FROM `set`
    WHERE sessionExerciseId = $sessionExerciseId
  ")->fetchAll();

  $setCount = count($allSets);
  return $setCount;
}

function logSet($weight, $reps, $minutes, $steps, $sessionExerciseId)
{
  $userId = $_SESSION['userId'];

  db_Query(
    "
    INSERT INTO `set`(weight, reps, minutes, steps, sessionExerciseId)
    VALUES(:weight, :reps, :minutes, :steps, :sessionExerciseId)
  ",
    [
      'weight' => $weight,
      'reps' => $reps,
      'minutes' => $minutes,
      'steps' => $steps,
      'sessionExerciseId' => $sessionExerciseId
    ]
  );
}

function AddToFreestyle($exerciseId, $userId)
{
  $session = getCurrentSession($userId);
  $sessionId = $session['sessionId'];
  $freestyle = 1;

  db_Query(
    "
    INSERT INTO session_exercise(exerciseId, userId, sessionId, freestyle)
    VALUES(:exerciseId, :userId, :sessionId, :freestyle)
  ",
    [
      'exerciseId' => $exerciseId,
      'userId' => $userId,
      'sessionId' => $sessionId,
      'freestyle' => intval($freestyle)
    ]
  );
}
