<?php

include_once('include/init.php');
echoHeader('Register');
session_unset();

if(isset($_REQUEST['register'])){
  register();
}

echo "
  <div class='page_header'>
    <h3 class='head_text'>Sign Up</h3>
  </div>

  <form action='#' method='post' id='register_form' class='text_input_form'>
    <h3 class='form_heading'>Username</h3>
    <input type='text' name='username' class='standard_form_box' required /></br>
    <h3 class='form_heading'>Password</h3>
    <input type='password' name='password' class='standard_form_box' required /></br>
    <h3 class='form_heading'>First Name</h3>
    <input type='text' name='firstName' class='standard_form_box' required /></br>
    <h3 class='form_heading'>Email Address</h3>
    <input type='email' name='email' class='standard_form_box' required />
  </form>

  <div class='page_foot'>
    <p class='minor_text'>Already Have an Account?</p>
    <a href='login.php' class='minor_text'>Login Here</a></br>
    <button type='submit' class='new_page_button' form='register_form' name='register'>Register
    </button>
  </div>
";
