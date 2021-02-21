class Book {
    constructor(id, ISBN, title, writerName, description, editionNr, editionYear, availableQuantity, quantityInCart, price) {
        this._id = id;
        this._ISBN = ISBN;
        this._title = title;
        this._writerName = writerName;
        this._description = description;
        this._editionNr = editionNr;
        this._editionYear = editionYear;
        this._availableQuantity = availableQuantity;
        this._quantityInCart = quantityInCart;
        this._price = price;
    }

    get id() {
        return this._id;
    }
    
    get ISBN() {
        return this._ISBN;
    }

    get title() {
        return this._title;
    }

    get writerName() {
        return this._writerName;
    }

    get description() {
        return this._description;
    }

    get editionNr() {
        return this._editionNr;
    }

    get editionYear() {
        return this._editionYear;
    }

    get availableQuantity() {
        return this._availableQuantity;
    }

    get quantityInCart() {
        return this._quantityInCart;
    }

    get price() {
        return this._price;
    }
  }