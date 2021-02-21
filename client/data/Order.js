class Order {
    constructor(id, address, time, totalPrice, status) {
        this._id = id;
        this._address = address;
        this._time = time;
        this._totalPrice = totalPrice;
        this._status = status;
    }

    get id() {
        return this._id;
    }

    get address() {
        return this._address;
    }

    get time() {
        return this._time;
    }

    get totalPrice() {
        return this._totalPrice;
    }

    get status() {
        return this._status;
    }
}