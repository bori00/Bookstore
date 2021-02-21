class BookCardList {
    constructor(divName) {
        this._listDiv = document.getElementById(divName);
    }

    reFill(books) {
        this.clear();
        books.forEach(book => {
            this._listDiv.appendChild((new BookCard(book)).card);
        });
    }

    clear() {
        while (this._listDiv.firstChild) {
            this._listDiv.removeChild(this._listDiv.lastChild);
        }
    }
}