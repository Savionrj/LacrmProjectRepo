<?php

include_once('include/init.php');
echoHeader('Register');
session_unset();

echo "
<div id='registration_page'>
";

if(isset($_REQUEST['register'])){
  register();
}

echo "

      <form action='#' method='post'>
        <div class='form_box_wrapper'>
          <h3 class='form_heading'>First Name</h3>
          <input type='text' name='firstName' class='standard_form_box' required /> <br/> 

          <h3 class='form_heading'>Last Name</h3>
          <input type='text' name='lastName' class='standard_form_box' required /> <br/> 

          <h3 class='form_heading'>Email Address</h3>
          <input type='email' name='email' class='standard_form_box' required /> <br/> 

          <h3 class='form_heading'>Username</h3>
          <input type='text' name='username' class='standard_form_box' required /> <br/> 

          <h3 class='form_heading'>Password</h3>
          <input type='password' name='password' class='standard_form_box' required /> <br/> 
        </div>
        <input type='submit' name='register' value='Sign Up' class='large_button' required />
      </form>
      <div class='switch_page_container'>
        <p class='small_text'>Already Have an Account?</p>
        <a href='login.php' class='small_text'>Login Here</a>
      </div>
  </div>

";
