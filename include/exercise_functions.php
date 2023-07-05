<?php

function addExercise(){

  $exerciseTypeId = getExerciseTypeId();

  $exerciseName = $_REQUEST["exerciseName"];
  $session = $_REQUEST["session"];
  $exerciseTarget = $_REQUEST["target"];
  $userId = $_SESSION['userId'];

  debugOutput($_REQUEST);

  db_Query("
    INSERT INTO exercise(exerciseName, typeId, session, target, userId)
    VALUES(:exerciseName, :typeId, :session, :target, $userId)
  ",
  
  [
    'exerciseName' => $exerciseName,
    'typeId' => $exerciseTypeId,
    'session' => $session,
    'target' => $exerciseTarget
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
  $count = 1;
    

  foreach($exerciseTypeData as $individualExerciseType){

    $typeId = $individualExerciseType['typeId'];
    
    echo"
      <option value=".$individualExerciseType['typeName'].">".$individualExerciseType['typeName']."</option>
    ";

  }

}


function getExercises(){

  $userId = $_SESSION['userId'];

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

function displayAllExercises(){

  $allExercises = getExercises();
  
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

function displayLogPage($exerciseData, $nextExerciseId){

  if($exerciseData['typeId'] == 1){
    displayCardio($nextExerciseId);
  }

  else if($exerciseData['typeId'] == 2){
    displayWeights($nextExerciseId);
  }

  else if($exerciseData['typeId'] == 3){
    displayBodyweight($nextExerciseId);
  }

}

function displayCardio(){
  echo"
  <div id='current_attempt'>
    
      <h3 class='log_attempt_header'>Current Attempt</h3>
      <div id='log_exercise_form_layout'>
  
        <form id='log_exercise_form'>
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
  
        <input type='submit' id='log_exercise_submit' name='log_exercise'/>
  
        </form>
  
        <div id='log_page_buttons'>
  
          <div id='log_exercise_button'>
            <label id='log_exercise_button_label' for='log_exercise_submit' tabindex='0'>Log Exercise</label>
          </div>
  
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
            <h3 class='prev_display_input_two'>Minute(s):1</h3>
          </div>

            <div id='inner_prev_box_two_inputs'>
              <div class='prev_display_input_box_for_two_inputs'>
                <h3 class='prev_display_input_two'>Distance:1</h3>
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

function displayWeights($exerciseIdPass){

  echo"
  <div id='current_attempt'>
    
      <h3 class='log_attempt_header'>Current Attempt</h3>
      <div id='log_exercise_form_layout'>
  
        <form id='log_exercise_form'>
  
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
  
        <input type='submit' id='log_exercise_submit' name='log_exercise'/>
  
        </form>
  
        <div id='log_page_buttons'>
  
          <div id='log_exercise_button'>
            <label id='log_exercise_button_label' for='log_exercise_submit' tabindex='0'>Log Exercise</label>
          </div>
  
        </div>
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

function displayBodyweight(){

  echo"
  <div id='current_attempt'>
    
      <h3 class='log_attempt_header'>Current Attempt</h3>
      <div id='log_exercise_form_layout'>
  
        <form id='log_exercise_form'>
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
        <input type='submit' id='log_exercise_submit' name='log_exercise'/>
  
        </form>
  
        <div id='log_page_buttons'>
  
          <div id='log_exercise_button'>
            <label id='log_exercise_button_label' for='log_exercise_submit' tabindex='0'>Log Exercise</label>
          </div>
  
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
            <h3 class='prev_display_input_two'>Set(s):1</h3>
          </div>

            <div id='inner_prev_box_two_inputs'>
              <div class='prev_display_input_box_for_two_inputs'>
                <h3 class='prev_display_input_two'>Rep(s):1</h3>
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

function logWeightExerciseAttempt(){

  $sets = $_REQUEST['sets'];
  $reps = $_REQUEST['reps'];
  $weight = $_REQUEST['weight'];

  $userId = $_SESSION['userId'];
  $exerciseId = $_SESSION['exerciseIdPass'];
  $typeId = $exerciseData['typeId'];

  db_Query("
    INSERT INTO exercise_attempt (userId, weight, sets, reps, exerciseId, typeId)
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

function logCardioExerciseAttempt(){

  $minutes = $_REQUEST['minutes'];
  $distance = $_REQUEST['distance'];

  $userId = $_SESSION['userId'];
  $exerciseId = $exerciseIdPass;
  $typeId = $exerciseData['typeId'];

  db_Query("
    INSERT INTO exercise_attempt(userId, typeId, exerciseId, minutes, distance)
    VALUES(:userId, :typeId, :exerciseId, :minutes, :distance, :weight)
  ",

  [
    'minutes' => $minutes,
    'distance' => $distance,
    'exerciseId' => $exerciseIdPass,
    'typeId' => $typeId,
    'userId' => $userId
  ]
  );

}

function logBodyweightExerciseAttempt(){

  $sets = $_REQUEST['sets'];
  $reps = $_REQUEST['reps'];

  $userId = $_SESSION['userId'];
  $exerciseId = $exerciseIdPass;
  $typeId = $exerciseData['typeId'];

  db_Query("
    INSERT INTO exercise_attempt(userId, typeId, exerciseId, sets, reps)
    VALUES(:userId, :typeId, :exerciseId, :sets, :reps)
  ",

  [
    'sets' => $sets,
    'reps' => $reps,
    'exerciseId' => $exerciseIdPass,
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

function getNextExerciseId(){

  $userId = $_SESSION['userId'];

  $nextExerciseId = db_Query("
    SELECT exerciseId
    FROM exercise
    WHERE userId = $userId
    ORDER BY exerciseId
    LIMIT 1
  ")->fetch();

  return $nextExerciseId;
}
