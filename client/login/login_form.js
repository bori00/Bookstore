function setupLoginForm() {
    loginFormStyleInputs();
    handleLoginForm();
}

function loginFormStyleInputs() {
    const userNameInput = new mdc.textField.MDCTextField(
        document.getElementById('userNameInput'));
    const passwordInput = new mdc.textField.MDCTextField(
        document.getElementById('passwordInput'));
    const submitButtonRipple = new mdc.ripple.MDCRipple(
        document.getElementById('loginBtn'));
    const goToRegisterButtonRipple = new mdc.ripple.MDCRipple(
        document.getElementById('goToRegisterBtn'));
}

function handleLoginForm() {
    let form = document.getElementById("login_form");
    form.addEventListener('submit', login);
}

function login(event) {
    event.preventDefault();
    var url = new URL("/Bookstore/server/login_action.php", document.URL);
    let loginData = {UserName: document.getElementById("UserName").value, Password: document.getElementById("Password").value};
    fetch(url, {
            method: 'POST',
           headers: {'Content-Type': 'application/json'},
           body: JSON.stringify(loginData)
        })
        .catch(error => console.log('failed to perform login on server '+ error))
        .then(response => {
            return response.json();
        })
        .catch(error => console.log('failed to parse response: ' + error))
        .then (successfulLogin => {
            if (successfulLogin) {
               onSuccessfulLogin();
            } else {
                onUnsuccesfulLogin();
            }
        });
}

function onSuccessfulLogin() {
    document.location.href = '/Bookstore/index.php'; //relative to domain
}

function onUnsuccesfulLogin() {
    const dialog = new mdc.dialog.MDCDialog(document.getElementById("unsuccesful_login_dialog"));
    dialog.open();
}