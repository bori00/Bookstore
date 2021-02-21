function bookCartInit() {
    document.getElementById('books_cart_tab').style.display = "block";
    new PlaceOrderForm();
    const booksList = new BookCardList("cart_books_list");
    getBooksInCart()
        .then(books => {
            setOrderButtonStatus(books.length > 0);
            booksList.reFill(books);
            setEmptyCartMessageVisibility(books.length == 0);
            printTotalPrice(books);
        });
}

function getBooksInCart() {
    var url = new URL("/Bookstore/server/get_books_in_cart.php", document.URL);
    return fetch(url)
        .catch(error => console.log('failed to get books in cart from server '+ error))
        .then(response => {
            return response.json();
        })
        .catch(error => console.log('failed to parse response: ' + error))
        .then(booksJson => {
            let books = [];
            for (i in booksJson) {
                let book = new Book(booksJson[i].id, booksJson[i].ISBN, booksJson[i].title, booksJson[i].writerName, booksJson[i].description, 
                    Number(booksJson[i].editionNr), Number(booksJson[i].editionYear), Number(booksJson[i].availableQuantity), 
                    Number(booksJson[i].quantityInCart), Number(booksJson[i].price));
                books.push(book);
            }
            return books;
        });
}

function setOrderButtonStatus(enabled) {
    document.getElementById("sendOrderBtn").disabled = !enabled;
}

function setEmptyCartMessageVisibility(visible) {
    if (visible) {
        document.getElementById("empty_cart_message").style.display = "block";
    } else {
        document.getElementById("empty_cart_message").style.display = "none";
    }
}

function printTotalPrice(books) {
    let totalPrice = 0;
    books.forEach(book => {
        totalPrice += book.price * book.quantityInCart;
    })
    document.getElementById("total_price").innerText = "Total price: ".concat(totalPrice.toFixed(2).toString());
}