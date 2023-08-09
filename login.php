<?php
include_once('include/init.php');
echoHeader('Login');
session_unset();

if(isset($_REQUEST['login'])){
  verifyPassword();
}

echo "
  <form action='#' method='post'>
    <h3 class='form_heading'>Username</h3>
    <input type='text' name='username' class='standard_form_box' required /> <br/> <br/>
    <h3 class='form_heading'>Password</h3>
    <input type='password' name='password' class='standard_form_box' required /> <br/> <br/>
    <input type='submit' name='login' value='Login' class='large_button' />
  </form>
  <div class='switch_page_container'>
    <p class='small_text'>Don't Have an Account?</p>
    <a href='register.php' class='small_text'>Register Here</a>
  </div>
";

