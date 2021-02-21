function bookShopInit() {
    document.getElementById('shop_books_tab').style.display = "block";
    const booksList = new BookCardList("shop_books_list");
    getAvailableBooks()
        .then(books => {
            booksList.reFill(books);
        });
}

function getAvailableBooks() {
    var url = new URL("/Bookstore/server/get_available_books.php", document.URL);
    return fetch(url)
        .catch(error => console.log('failed to get available books from server: '+ error))
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