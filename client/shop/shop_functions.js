function addOneBookToCart(bookId) {
    var url = new URL("/Bookstore/server/add_one_book_to_cart.php", document.URL);
    params = {bookId: bookId};
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
    fetch(url)
        .then(response => {
            return response.json();
        })
        .catch(error => console.log('failed to parse response: ' + error))
        .then (success => {
            if (success) {
                Menu.getInstance().initTab();
            }
        });
}

function removeOneBookFromCart(bookId) {
    var url = new URL("/Bookstore/server/remove_one_book_from_cart.php", document.URL);
    params = {bookId: bookId};
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]))
    fetch(url)
        .then(response => {
            return response.json();
        })
        .catch(error => console.log('failed to parse response: ' + error))
        .then (success => {
            if (success) {
                Menu.getInstance().initTab();
            }
        });
}