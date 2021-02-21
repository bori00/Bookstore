function ordersInit() {
    document.getElementById("my_orders_tab").style.display = "block";
    // new PlaceOrderForm();
    // const booksList = new BookCardList("cart_books_list");
    getUsersOrders()
        .then(orders => {
            console.log("orders");
            console.log(orders);
            new OrdersTable(orders);
        });
}

function getUsersOrders() {
    var url = new URL("/Bookstore/server/get_orders_of_user.php", document.URL);
    return fetch(url)
        .catch(error => console.log('failed to get orders of user from server '+ error))
        .then(response => {
            return response.json();
        })
        .catch(error => console.log('failed to parse response: ' + error))
        .then(ordersJson => {
            let orders = [];
            for (i in ordersJson) {
                let order = new Order(ordersJson[i].id, new Address(ordersJson[i].addressName, ordersJson[i].country, 
                    ordersJson[i].city, ordersJson[i].street, ordersJson[i].number, ordersJson[i].postalCode), 
                    ordersJson[i].time, Number(ordersJson[i].totalPrice), ordersJson[i].status);
                orders.push(order);
            }
            return orders;
        });
}