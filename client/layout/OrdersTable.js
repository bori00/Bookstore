class OrdersTable {
    
    constructor(orders) {
        this._tableContent = document.getElementById("orders_table_content");
        this.clear();
        this._dataTable = new mdc.dataTable.MDCDataTable(document.querySelector('.mdc-data-table'));
        orders.forEach(order => this._tableContent.appendChild(this.createRow(order)));
    }

    clear() {
        while (this._tableContent.firstChild) {
            this._tableContent.removeChild(this._tableContent.lastChild);
        }
    }

    createRow(order) {
        const row = document.createElement("tr");
        row.classList.add("mdc-data-table__row");
        row.appendChild(this.createIdHeader(order));
        row.appendChild(this.createCellElement(order.time));
        row.appendChild(this.createCellElement(order.address.name));
        row.appendChild(this.createCellElement(order.address.concatAddress()));
        row.appendChild(this.createCellElement(order.address.postalCode));
        row.appendChild(this.createCellElement(order.totalPrice.toFixed(2)));
        row.appendChild(this.createCellElement(order.status));
        return row;
    }

    createIdHeader(order) {
        const header = document.createElement("th");
        header.classList.add("mdc-data-table__cell");
        header.setAttribute("scope", "row");
        header.innerText = order.id;
        return header;
    }

    createCellElement(data) {
        const cell = document.createElement("td");
        cell.classList.add("mdc-data-table__cell");
        cell.innerText = data;
        return cell;
    }
}