class Address {
    constructor(name, country, city, street, number, postalCode) {
        this._name = name;
        this._country = country;
        this._city = city;
        this._street = street;
        this._number = number;
        this._postalCode = postalCode;
    }

    get name() {
        return this._name;
    }

    get country() {
        return this._country;
    }

    get city() {
        return this._city;
    }

    get street() {
        return this._street;
    }

    get number() {
        return this._number;
    }

    get postalCode() {
        return this._postalCode;
    }

    concatAddress() {
        return this._country.concat(", ").concat(this._city).concat(", ").concat(this._street).concat(", ").concat(this._number);
    }
}