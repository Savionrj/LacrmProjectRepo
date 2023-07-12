<?php
function getUser(){

  $userId = $_SESSION['userId'];

  $user = db_Query("
    SELECT *
    FROM user
    WHERE userId = $userId
  ")->fetch();

  return $user;
}

function register(){

  $duplicateFound = checkForDuplicate();

  if(!$duplicateFound){

    $firstName = $_REQUEST["firstName"];
    $lastName = $_REQUEST["lastName"];
    $email = $_REQUEST["email"];
    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];

    $hash = password_hash($password, PASSWORD_DEFAULT);

    db_Query("
      INSERT INTO user(firstName, lastName, email, username, password)
      VALUES(:firstName, :lastName, :email, :username, :password)
    ",
      [
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'username' => $username,
        'password' => $hash
      ]
    );

    header("location: login.php");
  }

  else{
    echo "Username already exists";
  }


}

function validateField($name){
  global $errors;

  if(!@$_REQUEST[$name]){
    $errors[$name] = 'required';
  }
}

function checkForDuplicate(){

  $username = $_REQUEST["username"];

  $duplicateFound = db_Query("
    SELECT username
    FROM user
    WHERE username='$username'
  ")->fetch();

  return $duplicateFound;

}

function verifyPassword(){

  $username = $_REQUEST["username"];

  $result = db_Query("
    SELECT password, userId
    FROM user
    WHERE username='$username'
  ")->fetch();

  if($result){
    $password = $_REQUEST["password"];
    $hashedPass = $result['password'];

    if(password_verify($password, $hashedPass)){
    
      $_SESSION['userId'] = $result['userId'];
      header("location: index.php");

    }

    else{
      echo "Invalid Password";
    }
  }

  else {
    echo "User Not Found";
  }

}
