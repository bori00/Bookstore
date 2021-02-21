class BookCard {
    constructor(book) {
        this._book = book;
        this._card = document.createElement("div");
        this._card.classList.add("mdc-card");
        this._card.appendChild(this.createContentDiv());
        this._card.appendChild(this.createActionButtonsDiv());
    }

    get card() {
        return this._card;
    }

    createContentDiv() {
        const contentDiv = document.createElement("div");
        contentDiv.classList.add("card-content");
        contentDiv.appendChild(this.createMainLine());
        contentDiv.appendChild(this.createWriterHeading());
        contentDiv.appendChild(this.createDescriptionDiv());
        contentDiv.appendChild(this.createEditionHeading());
        return contentDiv;
    }

    createMainLine() {
        const mainDiv = document.createElement("div");
        mainDiv.classList.add("main_line");
        mainDiv.appendChild(this.createTitleHeading());
        mainDiv.appendChild(this.createPriceHeading());
        return mainDiv;
    }

    createTitleHeading() {
        const titleHeading = document.createElement("h1");
        titleHeading.classList.add("title_tag");
        titleHeading.innerHTML = this._book.title;
        return titleHeading;
    }

    createPriceHeading() {
        const priceHeading = document.createElement("h2");
        const priceString = this._book.price.toFixed(2).toString(10);
        priceHeading.innerHTML = priceString.concat(" ron");
        priceHeading.classList.add("price_tag");
        return priceHeading;
    }

    createWriterHeading() {
        const writerHeading = document.createElement("h3");
        writerHeading.innerHTML = "By: " + this._book.writerName;
        return writerHeading;
    }

    createDescriptionDiv() {
        const descDiv = document.createElement("div");
        descDiv.innerHTML = this._book.description;
        return descDiv;
    }

    createEditionHeading() {
        const editionHeading = document.createElement("h5");
        editionHeading.innerHTML= this._book.editionNr + "th edition, " + this._book.editionYear;
        return editionHeading;
    }

    createActionButtonsDiv() {
        const actionDiv = document.createElement("div");
        actionDiv.classList.add("mdc-card__actions");
        const actionIconsDiv = document.createElement("div");
        actionIconsDiv.classList.add("mdc-card__action-icons");
        actionIconsDiv.appendChild(this.createDecreasePiecesInCartButton());
        const noPiecesLabel = document.createElement("div");
        noPiecesLabel.innerText = this._book.quantityInCart;
        actionIconsDiv.appendChild(noPiecesLabel);
        actionIconsDiv.appendChild(this.createAddMoreToCartButton());
        actionDiv.appendChild(actionIconsDiv);
        return actionDiv;
    }

    createAddMoreToCartButton() {
        const addToCartButton = document.createElement("button");
        addToCartButton.classList.add("material-icons",  "mdc-icon-button", "mdc-card__action",  "mdc-card__action--icon");
        addToCartButton.setAttribute("title", "Add to cart");
        addToCartButton.innerHTML = "add_circle_outline";
        if (this._book.quantityInCart >= this._book.availableQuantity) {
            addToCartButton.disabled = true;
        }
        let bookId = this._book.id;
        addToCartButton.addEventListener("click", function() {
            addOneBookToCart(bookId)
        });
        return addToCartButton;
    }

    createDecreasePiecesInCartButton() {
        const decreasePiecesCartButton = document.createElement("button");
        decreasePiecesCartButton.classList.add("material-icons",  "mdc-icon-button", "mdc-card__action",  "mdc-card__action--icon");
        decreasePiecesCartButton.setAttribute("title", "Add to cart");
        decreasePiecesCartButton.innerHTML = "remove_circle_outline";
        if (this._book.quantityInCart == 0) {
            decreasePiecesCartButton.disabled = true;
        }
        let bookId = this._book.id;
        decreasePiecesCartButton.addEventListener("click", function() {
            removeOneBookFromCart(bookId);
        });
        return decreasePiecesCartButton;
    }
}