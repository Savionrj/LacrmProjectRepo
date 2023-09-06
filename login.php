<?php
include_once('include/init.php');
echoHeader('Login');
session_unset();

if(isset($_REQUEST['login'])){
  verifyPassword();
}

echo "
  <div class='page_header'>
    <h3 class='head_text'>Login</h3>
  </div>

  <form action='#' method='post' id='login_form'>
    <h3 class='form_heading'>Username</h3>
    <input type='text' name='username' class='standard_form_box' required /> <br/>
    <h3 class='form_heading'>Password</h3>
    <input type='password' name='password' class='standard_form_box' required /> <br/>
  </form>


  <div class='page_foot'>
    <p class='minor_text'>Don't Have an Account?</p>
    <a href='register.php' class='minor_text'>Register Here</a></br>
    <button type='submit' class='new_page_button' form='login_form' name='login'>Login
    </button>
  </div>
";

