class Menu {
    static PAGE_NAMES = {
      SHOP: {
        tab_id: 'shop_books_tab',
        index: 0,
        icon: "local_library",
        label: "Shop Books",
      },
      MY_CART: {
        tab_id: "books_cart_tab",
        index: 1,
        icon: "shopping_cart",
        label: "My Cart",
      },
      MY_ORDERS: {
        tab_id: "my_orders_tab",
        index: 1,
        icon: "local_shipping",
        label: "My Orders",
      },
      MY_ACCOUNT: {
        tab_id: "my_account_tab",
        index: 1,
        icon: "account_circle",
        label: "My Account",
      },
    };

    static NO_TABS = 4;
  
    static PAGE_NUMBERS = {
      0: Menu.PAGE_NAMES.SHOP,
      1: Menu.PAGE_NAMES.MY_CART,
      2: Menu.PAGE_NAMES.MY_ORDERS,
      3: Menu.PAGE_NAMES.MY_ACCOUNT,
    };

    static instance = null;
  
    constructor() {
      for (var i = 0; i < Menu.NO_TABS; i++) {
        var tab = this.createMenuTab(i, i==0); 
        document.querySelector('.mdc-tab-scroller__scroll-content').appendChild(tab);
      }
      const tabBar = new mdc.tabBar.MDCTabBar(document.querySelector('.mdc-tab-bar'));
      const tabs = document.querySelectorAll('.mdc-tab');
      tabs[0].focus();
      this.hideAllTabs();
      this._tabIndex = 0;
      this.initTab();
      const menu = this;
      tabBar.listen('MDCTabBar:activated', function (event) {
        menu.hideAllTabs();
        menu._tabIndex = event.detail.index;
        menu.initTab();
      });
      Menu.instance = this;
    }

    static getInstance() {
      if (Menu.instance == null) {
        new Menu();
      }
      return Menu.instance;
    }

    initTab() {
      if (this._tabIndex === 0) {
        bookShopInit();
      } else if (this._tabIndex === 1) {
        bookCartInit();
      } else if (this._tabIndex == 2) {
        ordersInit();
      } else if (this._tabIndex == 3) {
        accountTabInit();
      }
    }
  
    createMenuTab(index, focused) {
      var tab = document.createElement("button");
      tab.setAttribute("class", "mdc-tab");
      if (focused) {
        tab.classList.add("mdc-tab--active")
      }
      tab.setAttribute("role", "tab");
      tab.setAttribute("aria-selected", "true");
      tab.setAttribute("tabindex", index);
      tab.appendChild(this.createTabContent(index));
      tab.appendChild(this.createTabIndicator(focused));
      tab.appendChild(this.createTabRipple());
      return tab;
    }
  
    createTabContent(index) {
      var content = document.createElement("span");
      content.setAttribute("class", "mdc-tab__content");
      content.appendChild(this.createIcon(index));
      content.appendChild(this.createLabel(index));
      return content;
    }
  
    createTabIndicator(focused) {
      var indicator = document.createElement("span");
      indicator.setAttribute("class", "mdc-tab-indicator");
      if (focused) {
        indicator.classList.add("mdc-tab-indicator--active")
      }
      indicator.appendChild(this.createIndicatorContent());
      return indicator;
    }
  
    createTabRipple() {
      var ripple = document.createElement("span");
      ripple.setAttribute("class", "mdc-tab__ripple");
      return ripple;
    }
  
    createIndicatorContent() {
      var indicatorContent = document.createElement("span");
      indicatorContent.classList.add("mdc-tab-indicator__content",
                                      "mdc-tab-indicator__content--underline");
      return indicatorContent;
    }
  
    createLabel(index) {
      var label = document.createElement("span");
      label.setAttribute("class", "mdc-tab__text-label");
      label.innerText = Menu.PAGE_NUMBERS[index].label;
      return label;
    }
  
    createIcon(index) {
      var icon = document.createElement("span");
      icon.classList.add("mdc-tab__icon", "material-icons");
      icon.setAttribute("aria-hidden", true);
      icon.innerText = Menu.PAGE_NUMBERS[index].icon;
      return icon;
    }

    hideAllTabs() {
      for (var i = 0; i < Menu.NO_TABS; i++) {
          var div = document.getElementById(Menu.PAGE_NUMBERS[i].tab_id);
          if (div != null) {
              div.style.display = "none";
          }
      }
    }
  }