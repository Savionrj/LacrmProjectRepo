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

  $firstName = $_REQUEST["firstName"];
  $lastName = $_REQUEST["lastName"];
  $email = $_REQUEST["email"];
  $username = $_REQUEST["username"];
  $password = $_REQUEST["password"];

  debugOutput($password);

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

verifyPassword();


}

function validateField($name){
  global $errors;

  if(!@$_REQUEST[$name]){
    $errors[$name] = 'required';
  }
}

function verifyPassword(){

  $username = $_REQUEST["username"];

  $result = db_Query("
  SELECT password
  FROM user
  WHERE username='$username'
  ")->fetch();

  if($result){
    $password = $_REQUEST["password"];
    $hashedPass = $result['password'];

    if(password_verify($password, $hashedPass)){

      $user = db_Query("
        SELECT userId
        FROM user
        WHERE username='$username' AND password='$hashedPass'
      ")->fetch();
    
      $_SESSION['userId'] = $user['userId'];
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
