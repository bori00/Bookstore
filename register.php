<?php
    session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Bookstore | Register</title>
     <!-- Material Design  -->
     <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> 
     <!-- My Scripts -->
     <script src="client/register/register_form.js"></script>
     <!-- My Stylesheet -->
     <link rel = "stylesheet" href = "client/style.css">
  </head>
  <body  onload = "setupRegisterForm()">

    <form method = "POST" class="form-card" id = "signup_form">
        <h1 class="primary-text align-center">Please sign up!</h1>

        <label id= "userNameInput" class="mdc-text-field mdc-text-field--outlined form-field">
            <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id" name = "UserName" id = "UserName" title = "Username" maxlength = "30" required>
            <span class="mdc-notched-outline">
                <span class="mdc-notched-outline__leading"></span>
                <span class="mdc-notched-outline__notch">
                    <span class="mdc-floating-label" id="my-label-id">Username</span>
                </span>
                <span class="mdc-notched-outline__trailing"></span>
            </span>
        </label>

        <label id= "passwordInput" class="mdc-text-field mdc-text-field--outlined form-field">
            <input type="password" class="mdc-text-field__input" aria-labelledby="my-label-id" name = "Password" id = "Password" title = "Password" maxlength = "30" required>
            <span class="mdc-notched-outline">
                <span class="mdc-notched-outline__leading"></span>
                <span class="mdc-notched-outline__notch">
                    <span class="mdc-floating-label" id="my-label-id">Password</span>
                </span>
                <span class="mdc-notched-outline__trailing"></span>
            </span>
        </label>

        <label id= "passwordAgainInput" class="mdc-text-field mdc-text-field--outlined form-field">
            <input type="password" class="mdc-text-field__input" aria-labelledby="my-label-id" name = "PasswordAgain" id = "PasswordAgain" title = "PasswordAgain" maxlength = "30" required>
            <span class="mdc-notched-outline">
                <span class="mdc-notched-outline__leading"></span>
                <span class="mdc-notched-outline__notch">
                    <span class="mdc-floating-label" id="my-label-id">Password again</span>
                </span>
                <span class="mdc-notched-outline__trailing"></span>
            </span>
        </label>

        <button id="signUpBtn" type = "submit" class="mdc-button mdc-button--raised form-field">
            <div class="mdc-button__ripple"></div>
            <span class="mdc-button__label">Sign Up</span>
        </button>
    </form>

    <div class="mdc-dialog" id="unsuccesful_login_dialog">
      <div class="mdc-dialog__container">
        <div class="mdc-dialog__surface"
          role="alertdialog"
          aria-modal="true"
          aria-labelledby="my-dialog-title"
          aria-describedby="error_signup_dialog_conent">
          <!-- Title cannot contain leading whitespace due to mdc-typography-baseline-top() -->
          <h2 class="mdc-dialog__title" id="my-dialog-title">Unsuccesful Sign-Up</h2>
          <div class="mdc-dialog__content" id="error_signup_dialog_conent">
          </div>
        </div>
      </div>
      <div class="mdc-dialog__scrim"></div>
    </div>
  </body>
</html>