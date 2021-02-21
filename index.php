<?php
    session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Bookstore | Welcome</title>
    <!-- Material Design  -->
    <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> 
    <!-- My Scripts -->
    <script src="client/login/guarantee_login.js"></script>
    <script src="client/layout/Dialog.js"></script>
    <script src="client/cart/PlaceOrderForm.js"></script>
    <script src="client/cart/book_cart_init.js"></script>
    <script src="client/orders/orders_init.js"></script>
    <script src="client/layout/Menu.js"></script>
    <script src="client/layout/OrdersTable.js"></script>
    <script src="client/shop/shop_books_init.js"></script>
    <script src="client/shop/shop_functions.js"></script>
    <script src="client/data/Book.js"></script>
    <script src="client/data/Order.js"></script>
    <script src="client/data/Address.js"></script>
    <script src="client/layout/BookCard.js"></script>
    <script src="client/layout/BookCardList.js"></script>
    <script src="client/account/account_tab_init.js"></script>
    <!-- My Stylesheet -->
    <link rel = "stylesheet" href = "client/style.css">
  </head>
  <body onload="guaranteeLogin(); Menu.getInstance();">
    <header>
      <div class="mdc-tab-bar" id = "menu_bar" role="tablist">
          <div class="mdc-tab-scroller">
              <div class="mdc-tab-scroller__scroll-area">
                  <div class="mdc-tab-scroller__scroll-content">
                  </div>
              </div>
          </div>
      </div>
    </header>

    <div id="shop_books_tab" style="display: none" class="my_tab"> 
      <div class="list_header">
        <h1>Available books: </h1>
      </div>
      <div id="shop_books_list" class="book_list">
      </div>
    </div>

    <div id="books_cart_tab" style="display: none" class="my_tab"> 
      <div class="list_header">
        <h1>Your Cart</h1>
        <h2 id="total_price"></h1>
      </div>
      <div style="text-align: center" id = "empty_cart_message">Your cart is empty! You can place an order only if you have at least one book in your cart!</div>
      <br>
      <div id="cart_books_list" class="book_list">
      </div>
      <br>
      <hr>
      <br>
      <form id = "placeOrderForm" enctype = "multipart/form-data" class="form-card">
        <h2 class="primary-text">Place Order</h2>

        <label for="useExistingAddress" id="existingAddressSwitchLabel">Use existing address</label>
        <div id="useExistingAddressSwitch" class="mdc-switch">
          <div class="mdc-switch__track"></div>
          <div class="mdc-switch__thumb-underlay">
              <div class="mdc-switch__thumb"></div>
              <input type="checkbox" name = "useExistingAddressInput" id = "useExistingAddressInput" class="mdc-switch__native-control" role="switch" aria-checked="true">
          </div>
        </div>

        <div id="existingAddressInputs">
          <div class="mdc-select mdc-select--outlined mdc-select--required form-field" id = "adress_select_input">
            <div class="mdc-select__anchor inner_form_field" aria-labelledby="outlined-select-label">
              <span class="mdc-notched-outline inner_form_field">
                <span class="mdc-notched-outline__leading"></span>
                <span class="mdc-notched-outline__notch">
                  <span id="outlined-select-label" class="mdc-floating-label">Choose the shipping address</span>
                </span>
                <span class="mdc-notched-outline__trailing"></span>
              </span>
              <span class="mdc-select__selected-text-container">
                <span id="demo-selected-text" class="mdc-select__selected-text"></span>
              </span>
              <span class="mdc-select__dropdown-icon">
                <svg
                    class="mdc-select__dropdown-icon-graphic"
                    viewBox="7 10 10 5" focusable="false">
                  <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10">
                  </polygon>
                  <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                </svg> 
              </span>
            </div>

            <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu-surface--fullwidth inner_form_field">
              <ul class="mdc-list" id="addressList" role="listbox" aria-label="Address picker listbox">
              </ul>
            </div>
          </div>
        </div>

        <div id="newAddressInputs">
          <label id= "addressNameInput" class="mdc-text-field mdc-text-field--outlined form-field">
              <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id" name = "addressName" id = "addressNameInputC" pattern = "[A-Za-z0-9\s]+" title = "Enter the name of the new address" maxlength = "100">
              <span class="mdc-notched-outline">
                  <span class="mdc-notched-outline__leading"></span>
                  <span class="mdc-notched-outline__notch">
                      <span class="mdc-floating-label" id="my-label-id">Address name:</span>
                  </span>
                  <span class="mdc-notched-outline__trailing"></span>
              </span>
          </label>

          <label id= "countryInput" class="mdc-text-field mdc-text-field--outlined form-field">
              <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id" name = "country" id = "countryInputC" pattern = "[A-Za-z0-9\s]+" title = "Enter the country" maxlength = "30">
              <span class="mdc-notched-outline">
                  <span class="mdc-notched-outline__leading"></span>
                  <span class="mdc-notched-outline__notch">
                      <span class="mdc-floating-label" id="my-label-id">Country: </span>
                  </span>
                  <span class="mdc-notched-outline__trailing"></span>
              </span>
          </label>

          <label id= "cityInput" class="mdc-text-field mdc-text-field--outlined form-field">
              <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id" name = "city" id = "cityInputC" pattern = "[A-Za-z0-9\s]+" title = "Enter the city" maxlength = "30">
              <span class="mdc-notched-outline">
                  <span class="mdc-notched-outline__leading"></span>
                  <span class="mdc-notched-outline__notch">
                      <span class="mdc-floating-label" id="my-label-id">City: </span>
                  </span>
                  <span class="mdc-notched-outline__trailing"></span>
              </span>
          </label>

          <label id= "streetInput" class="mdc-text-field mdc-text-field--outlined form-field">
              <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id" name = "street" id = "streetInputC" pattern = "[A-Za-z0-9\s]+" title = "Enter the street" maxlength = "40">
              <span class="mdc-notched-outline">
                  <span class="mdc-notched-outline__leading"></span>
                  <span class="mdc-notched-outline__notch">
                      <span class="mdc-floating-label" id="my-label-id">Street: </span>
                  </span>
                  <span class="mdc-notched-outline__trailing"></span>
              </span>
          </label>

          <label id= "nrInput" class="mdc-text-field mdc-text-field--outlined form-field">
              <input type="number" class="mdc-text-field__input" aria-labelledby="my-label-id" name = "nr" id = "nrInputC" title = "Enter the nr.">
              <span class="mdc-notched-outline">
                  <span class="mdc-notched-outline__leading"></span>
                  <span class="mdc-notched-outline__notch">
                      <span class="mdc-floating-label" id="my-label-id">Nr.: </span>
                  </span>
                  <span class="mdc-notched-outline__trailing"></span>
              </span>
          </label>

          <label id= "postalCodeInput" class="mdc-text-field mdc-text-field--outlined form-field">
              <input type="number" class="mdc-text-field__input" aria-labelledby="my-label-id" name = "postalCode" id = "postalCodeInputC" title = "Enter the postal code" min="0" max="999999">
              <span class="mdc-notched-outline">
                  <span class="mdc-notched-outline__leading"></span>
                  <span class="mdc-notched-outline__notch">
                      <span class="mdc-floating-label" id="my-label-id">Postal code: </span>
                  </span>
                  <span class="mdc-notched-outline__trailing"></span>
              </span>
          </label>
        </div>

        <label id="notesInput" class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea form-field">
            <span class="mdc-text-field__resizer">
                <textarea class="mdc-text-field__input" name = "notes" rows = "4" cols = "40" id = "notes"  maxlength = "100" pattern = "[A-Za-z0-9,.:-\s]+" title = "You can only enter letters, numbers, periods, and comas!"></textarea>
                <span class="mdc-text-field-character-counter">0 / 100</span>
            </span>
            <span class="mdc-notched-outline">
                <span class="mdc-notched-outline__leading"></span>
                <span class="mdc-notched-outline__notch">
                    <span class="mdc-floating-label" id="my-label-id">Notes</span>
                </span>
                <span class="mdc-notched-outline__trailing"></span>
            </span>
        </label>

        <button id="sendOrderBtn" type = "submit" class="mdc-button mdc-button--raised form-field">
            <div class="mdc-button__ripple"></div>
            <span class="mdc-button__label">Send Order</span>
        </button>
    
      </form>
    </div>

    <div id="my_orders_tab" class="my_tab"> 
      <div class="list_header">
        <h1>Your orders</h1>
      </div>
      <div id="table_container" style="margin: 10px auto; width: fit-content; font-weight: bold;">
        <div class="mdc-data-table my_table">
          <div class="mdc-data-table__table-container">
            <table class="mdc-data-table__table" aria-label="Orders">
              <thead>
                <tr class="mdc-data-table__header-row mdc-data-table--sticky-header">
                  <th class="mdc-data-table__header-cell" role="columnheader" scope="col">ID</th>
                  <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Time</th>
                  <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Address's name</th>
                  <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Address</th>
                  <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Postal Code</th>
                  <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Total Price</th>
                  <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Status</th>
                </tr>
              </thead>
              <tbody class="mdc-data-table__content" id="orders_table_content">
               
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div id="my_account_tab" class="my_tab"> 
      <div class="list_header">
        <h1>My Account</h1>
        <button id="signOutButton" onClick = "signOut()" class="mdc-button mdc-button--raised">
          <div class="mdc-button__ripple"></div>
          <span class="mdc-button__label">Sign Out</span>
        </button>
      </div>
    </div>

    <div class="mdc-dialog" id="my-dialog">
      <div class="mdc-dialog__container">
        <div class="mdc-dialog__surface"
          role="alertdialog"
          aria-modal="true"
          aria-labelledby="my-dialog-title"
          aria-describedby="my-dialog-content">
          <!-- Title cannot contain leading whitespace due to mdc-typography-baseline-top() -->
          <h2 class="mdc-dialog__title" id="my-dialog-title"></h2>
          <div class="mdc-dialog__content" id="my-dialog-content"></div>
        </div>
      </div>
      <div class="mdc-dialog__scrim"></div>
    </div>
  </body>
</html>