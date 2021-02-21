function setupRegisterForm() {
    registerFormStyleInputs();
    handleRegisterForm();
}

function registerFormStyleInputs() {
    const userNameInput = new mdc.textField.MDCTextField(
        document.getElementById('userNameInput'));
    const passwordInput = new mdc.textField.MDCTextField(
        document.getElementById('passwordInput'));
    const passwordAgainInput = new mdc.textField.MDCTextField(
        document.getElementById('passwordAgainInput'));
    const signUpButtonRipple = new mdc.ripple.MDCRipple(
        document.getElementById('signUpBtn'));
}

function handleRegisterForm() {
    let form = document.getElementById("signup_form");
    form.addEventListener('submit', register);
}

function register(event) {
    event.preventDefault();
    var url = new URL("/Bookstore/server/register_action.php", document.URL);
    if (document.getElementById("Password").value != document.getElementById("PasswordAgain").value) {
        onUnsuccesfulSignUp("The two passwords that you provided don't match.");
    } else {
        let signupData = {UserName: document.getElementById("UserName").value, Password: document.getElementById("Password").value};
        fetch(url, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(signupData)
            })
            .catch(error => console.log('failed to perform registration on server '+ error))
            .then(response => {
                return response.json();
            })
            .catch(error => console.log('failed to parse response: ' + error))
            .then (registrationStatus => {
                handleRegistrationStatus(registrationStatus);
            });
    }
}

function handleRegistrationStatus(registrationStatus) {
    const SUCCESS = "Succesful SignUp";
    const DUPLICATED_USERNAME = "Duplicated UserName";
    const DATABASE_ERROR = "Database Error";
    if (registrationStatus === SUCCESS) {
        onSuccessfulSignUp();
    } else {
        if (registrationStatus == DUPLICATED_USERNAME) {
            onUnsuccesfulSignUp("This username is elrady taken. Please choose another one");
        } else if (registrationStatus == DATABASE_ERROR) {
            onUnsuccesfulSignUp("There has been an error at accessing the database");
        }
    }
}

function onSuccessfulSignUp() {
    document.location.href = '/Bookstore/login.php'; //relative to domain
}

function onUnsuccesfulSignUp(errorMessage) {
    const dialog = new mdc.dialog.MDCDialog(document.getElementById("unsuccesful_login_dialog"));
    document.getElementById("error_signup_dialog_conent").innerText = errorMessage;
    dialog.open();
}