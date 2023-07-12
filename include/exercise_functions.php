<?php

function addExercise(){

  $exerciseTypeId = getExerciseTypeId();

  $exerciseName = $_REQUEST["exerciseName"];
  $session = $_REQUEST["session"];
  $exerciseTarget = $_REQUEST["target"];
  $userId = $_SESSION['userId'];

  db_Query("
    INSERT INTO exercise(exerciseName, typeId, session, target, userId)
    VALUES(:exerciseName, :typeId, :session, :target, :userId)
  ",
  
  [
    'exerciseName' => $exerciseName,
    'typeId' => $exerciseTypeId,
    'session' => $session,
    'target' => $exerciseTarget,
    'userId' => $userId
  ]

  
  );
}

function getExerciseTypes(){

  $exerciseTypeData = db_Query("
    SELECT *
    FROM exercise_type
  ")->fetchAll();

  return $exerciseTypeData;

}

function getExerciseTypeId(){

  $exerciseTypeName = $_REQUEST["exerciseType"];

  $exerciseTypeId = db_Query("
    SELECT typeId
    FROM exercise_type
    WHERE typeName = '$exerciseTypeName'
  ")->fetch();

  return $exerciseTypeId['typeId'];

}

function getExerciseTypeName($individualExercise){

  $typeId = $individualExercise['typeId'];

  $exerciseTypeName = db_Query("
    SELECT typeName
    FROM exercise_type
    WHERE typeId = $typeId
  ")->fetch();

  return $exerciseTypeName['typeName'];

}

function displayExerciseTypeOptions(){

  $exerciseTypeData = getExerciseTypes();
    

  foreach($exerciseTypeData as $individualExerciseType){

    $typeId = $individualExerciseType['typeId'];
    
    echo"
      <option value=".$individualExerciseType['typeName'].">".$individualExerciseType['typeName']."</option>
    ";

  }

}

function getExercises($user){

  $userId = $user['userId'];

  $exerciseData = db_Query("
    SELECT *
    FROM exercise
    WHERE userId = '$userId'
  ")->fetchAll();

  return $exerciseData;

}

function getSingleExercise($exerciseIdPass){

  $exerciseData = db_Query("
    SELECT *
    FROM exercise
    WHERE exerciseId = '$exerciseIdPass' 
  ")->fetch();

  return $exerciseData;

}

function getSessions(){

  $sessionData = db_Query("
    SELECT *
    FROM session
  ")->fetchAll();

  return $sessionData;

}

function displayAllExercises($user){

  $allExercises = getExercises($user);
  
  foreach($allExercises as $individualExercise){
    $exerciseTypeName = getExerciseTypeName($individualExercise);

    echo"
      <label for=".$individualExercise['exerciseId']." />
        <form action='log_exercise.php' method='post'>
          <input type='hidden' name='exerciseIdPass' value=".$individualExercise['exerciseId']." />
          <input type='submit' class='displayed_exercise_submit_button' id=".$individualExercise['exerciseId']." value=''/>
          <div class='exercise_display_card'>
            <div class='exercise_display_namebox'>
              <h3 class='exercise_display_name'>".$individualExercise['exerciseName']."</h3>
            </div>
            <div class='exercise_display_typebox'>
              <h3 class='exercise_display_type'>".$exerciseTypeName."</h3>
            </div>
          </div>
        </form>
      </label>
    ";
  }
}

function displayLogPage($exerciseData){

  if($exerciseData['typeId'] == 1){
    displayCardio($exerciseData);
  }

  else if($exerciseData['typeId'] == 2){
    displayWeights($exerciseData);
  }

  else if($exerciseData['typeId'] == 3){
    displayBodyweight($exerciseData);
  }

}

function displayCardio($exerciseData){

  if(isset($_REQUEST['log_exercise'])){
    logWeightExerciseAttempt($exerciseData, $_REQUEST['minutes'], $_REQUEST['distance']);
  }

  echo"
  <div id='current_attempt'>
    
      <h3 class='log_attempt_header'>Current Attempt</h3>
      <div id='log_exercise_form_layout'>
  
        <form id='log_exercise_form' action='#' method='post'>
          <div id='log_exercise_two_box_form'>
    
            <div class='log_page_formrow'>
              <h3 class='log_exercise_input_labels'>Minutes:</h3>
              <input type='number' name='minutes' class='log_exercise_formbox' />
            </div>
      
            <div class='log_page_formrow'>
              <h3 class='log_exercise_input_labels'>Distance:</h3>
              <input type='number' name='distance' class='log_exercise_formbox' />
            </div>
          </div>
          <input type='submit' id='log_exercise_button' name='log_exercise' value='Log'/>
        </form>
      </div>
    </div>";

$previousAttempt = getPreviousAttempt();
    if($previousAttempt){

      echo"

      <div id='previous_attempt'>

          <h3 class='log_attempt_header'>Previous Attempt</h3>

        <div id='outer_prev_box_two_inputs'>
          <div class='prev_display_input_box_for_two_inputs'>
            <h3 class='prev_display_input'>Minute(s):1</h3>
          </div>

            <div id='inner_prev_box_two_inputs'>
              <div class='prev_display_input_box_for_two_inputs'>
                <h3 class='prev_display_input'>Distance:1</h3>
              </div>
            
            </div>
          </div>
        </div>
      <div>";

    }

    else{
      echo"
        <h3 id='no_prev_attempt_message'>No Previous Attempt</h3>
      ";
    }

    echo"
      </div>
    </div>";
}

function displayWeights($exerciseData){

    if(isset($_REQUEST['log_exercise'])){
    logWeightExerciseAttempt($exerciseData,$_REQUEST['sets'], $_REQUEST['reps'], $_REQUEST['weight']);
  }

  echo "
  <div id='current_attempt'>
    
      <h3 class='log_attempt_header'>Current Attempt</h3>
      <div id='log_exercise_form_layout'>
  
        <form id='log_exercise_form' method='post'>

          <div>
    
            <div class='log_page_formrow'>
              <h3 class='log_exercise_input_labels'>Set(s):</h3>
              <input type='number' name='sets' class='log_exercise_formbox' />
            </div>
    
            <div class='log_page_formrow'>
              <h3 class='log_exercise_input_labels'>Rep(s):</h3>
              <input type='number' name='reps' class='log_exercise_formbox' />
            </div>
    
            <div class='log_page_formrow'>
              <h3 class='log_exercise_input_labels'>Weight:</h3>
              <input type='text' name='weight' class='log_exercise_formbox' />
            </div>
          </div>
          <input type='submit' id='log_exercise_button' name='log_exercise' value='Log'/>
        </form>
      </div>
    </div>";

    $previousAttempt = getPreviousAttempt();
    if($previousAttempt){

      echo"

      <div id='previous_attempt'>

          <h3 class='log_attempt_header'>Previous Attempt</h3>

        <div id='outer_prev_box'>
          <div class='prev_display_input_box'>
            <h3 class='prev_display_input'>Set(s):1</h3>
          </div>

          <div id='middle_prev_box'>
            <div class='prev_display_input_box'>
              <h3 class='prev_display_input'>Rep(s):1</h3>
            </div>

            <div id='inner_prev_box'>
              <div class='prev_display_input_box'>
                <h3 class='prev_display_input'>Weight:1</h3>
              </div>
            
            </div>
          </div>
        </div>
      <div>";

    }

    else{
      echo"
        <h3 id='no_prev_attempt_message'>No Previous Attempt</h3>
      ";
    }

    echo"
      </div>
    </div>";
}

function displayBodyweight($exerciseData){

  if(isset($_REQUEST['log_exercise'])){
    logWeightExerciseAttempt($exerciseData, $_REQUEST['sets'], $_REQUEST['reps']);
  }

  echo"
  <div id='current_attempt'>
    
      <h3 class='log_attempt_header'>Current Attempt</h3>
      <div id='log_exercise_form_layout'>
  
        <form id='log_exercise_form' action='#' method='post'>
          <div id='log_exercise_two_box_form'>
    
            <div class='log_page_formrow'>
              <h3 class='log_exercise_input_labels'>Set:</h3>
              <input type='number' name='sets' class='log_exercise_formbox' />
            </div>
      
            <div class='log_page_formrow'>
              <h3 class='log_exercise_input_labels'>Rep(s):</h3>
              <input type='number' name='log_reps_formbox' class='log_exercise_formbox' />
            </div>
    
          </div>
          <input type='submit' id='log_exercise_button' name='log_exercise' value='Log'/>
        </form>
      </div>
    </div>
  </div>";
$previousAttempt = getPreviousAttempt();
    if($previousAttempt){

      echo"

      <div id='previous_attempt'>

          <h3 class='log_attempt_header'>Previous Attempt</h3>

        <div id='outer_prev_box_two_inputs'>
          <div class='prev_display_input_box_for_two_inputs'>
            <h3 class='prev_display_input'>Set(s):1</h3>
          </div>

            <div id='inner_prev_box_two_inputs'>
              <div class='prev_display_input_box_for_two_inputs'>
                <h3 class='prev_display_input'>Rep(s):1</h3>
              </div>
            
            </div>
          </div>
        </div>
      <div>";

    }

    else{
      echo"
        <h3 id='no_prev_attempt_message'>No Previous Attempt</h3>
      ";
    }

    echo"
      </div>
    </div>";
}

function logWeightExerciseAttempt($exerciseData){

  $sets = $_REQUEST['sets'];
  $reps = $_REQUEST['reps'];
  $weight = $_REQUEST['weight'];

  $userId = $_SESSION['userId'];
  $exerciseId = $exerciseData['exerciseId'];
  $typeId = $exerciseData['typeId'];

  db_Query("
    INSERT INTO exercise_attempt(userId, weight, sets, reps, exerciseId, typeId)
    VALUES(:userId, :weight, :sets, :reps, :exerciseId, :typeId)
  ",

  [
    'userId' => $userId,
    'weight' => $weight,
    'sets' => $sets,
    'reps' => $reps,
    'exerciseId' => $exerciseId,
    'typeId' => $typeId
  ]

  );

}

function logCardioExerciseAttempt($exerciseData){

  $minutes = $_REQUEST['minutes'];
  $distance = $_REQUEST['distance'];

  $userId = $_SESSION['userId'];
  $exerciseId = $exerciseData['exerciseId'];
  $typeId = $exerciseData['typeId'];

  db_Query("
    INSERT INTO exercise_attempt(userId, typeId, exerciseId, minutes, distance)
    VALUES(:userId, :typeId, :exerciseId, :minutes, :distance, :weight)
  ",

  [
    'minutes' => $minutes,
    'distance' => $distance,
    'exerciseId' => $exerciseId,
    'typeId' => $typeId,
    'userId' => $userId
  ]
  );

}

function logBodyweightExerciseAttempt($exerciseData){

  $sets = $_REQUEST['sets'];
  $reps = $_REQUEST['reps'];

  $userId = $_SESSION['userId'];
  $exerciseId = $exerciseData['exerciseId'];
  $typeId = $exerciseData['typeId'];

  db_Query("
    INSERT INTO exercise_attempt(userId, typeId, exerciseId, sets, reps)
    VALUES(:userId, :typeId, :exerciseId, :sets, :reps)
  ",

  [
    'sets' => $sets,
    'reps' => $reps,
    'exerciseId' => $exerciseId,
    'typeId' => $typeId,
    'userId' => $userId
  ]
  );

}

function getPreviousAttempt(){

  $userId = $_SESSION['userId'];
  $exerciseId = $_SESSION['exerciseIdPass'];

  $previousAttempt = db_Query("
    SELECT *
    FROM exercise_attempt
    WHERE userId = $userId AND exerciseId = $exerciseId
    ORDER BY attemptId
    DESC
    LIMIT 1
  ")->fetch();

  return $previousAttempt;

}

