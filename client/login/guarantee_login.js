function guaranteeLogin() {
    var url = new URL("/Bookstore/server/login_status_check.php", document.URL);
    fetch(url) 
        .catch(error => console.log('failed to check login status on server: '+ error))
        .then(response => {
            return response.json();
        })
        .catch(error => console.log('failed to parse response: ' + error))
        .then(isLoggedIn => {
            if (!isLoggedIn) {
                document.location.href = '/Bookstore/login.php'; //relative to domain
            }
        });
}