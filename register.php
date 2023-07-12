<?php

include_once('include/init.php');
echoHeader('Register');
session_unset();

echo "
<div id='registration_page'>
";

$errors = array();

if(isset($_REQUEST['register'])){

  register();

}

echo"

      <form action='#' method='post'>
        <div id='registration_page_textbox_wrapper'>
          <h3 class='registration_page_form_heads'>First Name</h3>
          <input type='text' name='firstName' class='registration_page_textbox' required /> <br/> <br/>

          <h3 class='registration_page_form_heads'>Last Name</h3>
          <input type='text' name='lastName' class='registration_page_textbox' required /> <br/> <br/>

          <h3 class='registration_page_form_heads'>Email Address</h3>
          <input type='email' name='email' class='registration_page_textbox' required /> <br/> <br/>

          <h3 class='registration_page_form_heads'>Username</h3>
          <input type='text' name='username' class='registration_page_textbox' required /> <br/> <br/>

          <h3 class='registration_page_form_heads'>Password</h3>
          <input type='password' name='password' class='registration_page_textbox' required /> <br/> <br/>
        </div>
        <input type='submit' name='register' value='Sign Up' class='login_button' required />
      </form>

      <p class='choose_login'>
      Already Have an Account?
      </p>
      
      <p class='choose_login'>
      <a href='login.php'>Login Here</a>
      </p>

  </div>

";
