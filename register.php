<?php

include_once('include/init.php');
echoHeader('Register');
session_unset();

echo "
<div id='registration_page'>
";

$errors = array();

if(isset($_REQUEST['register'])){

  validateField('firstName');
  validateField('lastName');
  validateField('email');
  validateField('username');
  validateField('password');
  
  if(sizeof($errors) == 0){
    register();
  }

  if(sizeof($errors) > 0){

    echo "
      <h3 class='error_message'>All fields must be completed</h3>
    ";
  }

}

echo"

      <form action='#' method='post'>

        <h3 class='registration_page_form_heads'>First Name</h3>
        <input type='text' name='firstName' class='registration_page_textbox' /> <br/> <br/>

        <h3 class='registration_page_form_heads'>Last Name</h3>
        <input type='text' name='lastName' class='registration_page_textbox' /> <br/> <br/>

        <h3 class='registration_page_form_heads'>Email Address</h3>
        <input type='email' name='email' class='registration_page_textbox' /> <br/> <br/>

        <h3 class='registration_page_form_heads'>Username</h3>
        <input type='text' name='username' class='registration_page_textbox' /> <br/> <br/>

        <h3 class='registration_page_form_heads'>Password</h3>
        <input type='password' name='password' class='registration_page_textbox' /> <br/> <br/>

        <input type='submit' name='register' value='Sign Up' id='register_button' />

      </form>

      <p class='choose_login'>
      Already Have an Account?
      </p>
      
      <p class='choose_login'>
      <a href='login.php'>Login Here</a>
      </p>

  </div>

";
