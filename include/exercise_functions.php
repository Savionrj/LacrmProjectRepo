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

function displayPrevExercise(){


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

function displaySessionOptions(){

    $SessionData = getSessions();
    $count = 1;
      

    foreach($SessionData as $individualSessionData){

      $sessionId = $individualSessionData['sessionId'];
      
      echo"
          <option value=".$individualSessionData['sessionName'].">".$individualSessionData['sessionName']."</option>
      ";

    }


}

function displaySessions($individualSession){

  $session = $individualSession;

  echo"
  <div class='session_card'>
      <div class='session_name_on_card_div'>
        <h3 class='session_name_on_card'>".$session['sessionName']."</h3>
      </div>
      <div class='exercise_count'>
        <h3 class='exercise_count_number'>10</h3>
        <h3 class='exercise_count_label'>exercises</h3>
      </div>
    </div>";

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

function logExerciseAttempt(){

  


}
