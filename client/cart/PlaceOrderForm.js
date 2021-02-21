class PlaceOrderForm {
    constructor() {
        this.fillExistingAddressesList()
            .then(result => {
                this.handleFormSubmission();
                this.placeOrderFormSetupInputs()
                this._useExistingAddressSwitch.checked = true;
                this.onSelectUseExistingAddress();
                this.handleAddressTypeChoice();
            });
    }

    handleFormSubmission() {
        // replace node to remove all previous event listeners
        const form = document.getElementById("placeOrderForm");
        const new_form = form.cloneNode(true);
        form.parentNode.replaceChild(new_form, form);
        const thisForm = this;
        new_form.addEventListener('submit', function(event) {
            thisForm.saveOrder(event)
        });
    }

    saveOrder(event) {
        event.preventDefault();
        if (this.addressIsSelected()) {
            const orderData = {newAddress: !this._useExistingAddressSwitch.checked,
                                addressName: this._addressNameInput.value, 
                                country: this._countryInput.value, 
                                city: this._cityInput.value, 
                                street: this._streetInput.value, 
                                number: this._nrInput.value,
                                postalCode: this._postalCodeInput.value, 
                                addressId: this._addressSelectInput.value, 
                                notes: this._notesInput.value};
            let url = new URL("/Bookstore/server/save_order.php", document.URL);
            let thisForm = this;
            return fetch(url, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(orderData)
                }) 
                .catch(error => console.log('failed to get addresses from server: '+ error))
                .then(response => response.json())
                .catch(error => console.log('failed to parse response: ' + error))
                .then (saveOrderStatus => thisForm.handleSaveOrderStatus(saveOrderStatus));
        } else {
            Dialog.show("Error in order", "You didn't select any shipping address");
        }
    }

    handleSaveOrderStatus(saveOrderStatus) {
        const DATABASE_ERROR = "SaveOrder: Database Error";
        const MISSING_BOOK_ERROR = "SaveOrder: Missing Book Error";
        const DUPLICATE_ADDRESSNAME = "Duplicate AddressName";
        if (saveOrderStatus.successful) {
            Dialog.show("Thank you", "Your order has been succesfully saved.");
        } else if (saveOrderStatus.errorType == MISSING_BOOK_ERROR) {
            Dialog.show("Error", "Seems like the book ".concat(saveOrderStatus.missingBookName).concat(" is not available in this quantity anymore. Please try again later. "));
        } else if (saveOrderStatus.errorType == DUPLICATE_ADDRESSNAME) {
            Dialog.show("Error", "You already have an address with this name. Please choose a new name or use the existing address.");
        } else {
            Dialog.show("Error", "An unexpected error occured so your order could not be saved. Please try again later.");
        }
        Menu.getInstance().initTab();
    }

    placeOrderFormSetupInputs() {
        this._useExistingAddressSwitch = new mdc.switchControl.MDCSwitch(
            document.getElementById('useExistingAddressSwitch'));
        this._addressSelectInput = new mdc.select.MDCSelect(document.getElementById("adress_select_input"));
        this._addressNameInput = new mdc.textField.MDCTextField(
            document.getElementById('addressNameInput'));
        this._countryInput = new mdc.textField.MDCTextField(
            document.getElementById('countryInput'));
        this._cityInput = new mdc.textField.MDCTextField(
            document.getElementById('cityInput'));
        this._streetInput = new mdc.textField.MDCTextField(
            document.getElementById('streetInput'));
        this._nrInput = new mdc.textField.MDCTextField(
            document.getElementById('nrInput'));
        this._postalCodeInput = new mdc.textField.MDCTextField(
            document.getElementById('nrInput'));
        this._notesInput = new mdc.textField.MDCTextField(
            document.getElementById('notesInput'));
        this._postalCodeInput = new mdc.textField.MDCTextField(
            document.getElementById('postalCodeInput'));
        this._sendOrderButtonRipple = new mdc.ripple.MDCRipple(
            document.getElementById('sendOrderBtn'));
    }

    fillExistingAddressesList() {
        const thisForm = this;
        return this.getUsersAddresses()
            .then(addresses => {
                this.clearAddressList();
                for (i in addresses) {
                    document.getElementById("addressList").appendChild(thisForm.createAddressListElement(addresses[i].name, addresses[i].id));
                }
                return true;
            });
    }

    clearAddressList() {
        const list = document.getElementById("addressList");
        while (list.firstChild) {
            list.removeChild(list.lastChild);
        }
    }

    createAddressListElement(addressName, addressId) {
        const li = document.createElement("li");
        li.classList.add("mdc-list-item");
        li.setAttribute("aria-selected", "false");
        li.setAttribute("data-value", addressId);
        li.setAttribute("role", "option");
        const span1 = document.createElement("span");
        span1.classList.add("mdc-list-item__ripple");
        const span2 = document.createElement("span");
        span2.classList.add("mdc-list-item__text");
        span2.innerText = addressName;
        li.appendChild(span1);
        li.appendChild(span2);
        return li;
    }

    getUsersAddresses() {
        var url = new URL("/Bookstore/server/get_addresses_of_user.php", document.URL);
        return fetch(url) 
            .catch(error => console.log('failed to get addresses from server: '+ error))
            .then(response => response.json())
            .catch(error => console.log('failed to parse response: ' + error));
    }
    
    handleAddressTypeChoice() {
        let thisForm = this;
        document.getElementById("useExistingAddressInput").addEventListener("change", function() {
            if (thisForm._useExistingAddressSwitch.checked) {
                thisForm.onSelectUseExistingAddress()
            } else {
                thisForm.onSelectUseNewAddress();
            }
        })
    }

    onSelectUseExistingAddress() {
        document.getElementById("existingAddressSwitchLabel").innerText = "Using exitsing address";
        document.getElementById("newAddressInputs").style.display = "none";
        document.getElementById("existingAddressInputs").style.display = "block";
        this._addressSelectInput.required = true;
        this.makeNewAddressFieldsRequired(false);
    }

    onSelectUseNewAddress() {
        document.getElementById("existingAddressSwitchLabel").innerText = "Creating a new address";
        document.getElementById("newAddressInputs").style.display = "block";
        document.getElementById("existingAddressInputs").style.display = "none";
        this._addressSelectInput.required = false;
        this.makeNewAddressFieldsRequired(true);
    }

    makeNewAddressFieldsRequired(required) {
        let componentIds = ["addressNameInputC", "countryInputC", "cityInputC", "streetInputC", "nrInputC", "postalCodeInputC"];
        if (required) {
            componentIds.forEach(componentId => {
                document.getElementById(componentId).setAttribute("required", true);
            })
        } else {
            componentIds.forEach(componentId => {
                document.getElementById(componentId).removeAttribute("required");
            })
        }
    }

    addressIsSelected() {
        if (this._useExistingAddressSwitch.checked) {
            if (this._addressSelectInput.selectedIndex == -1) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
}