export const state = () => ({
  cartItems: [],
  sellItems: [],
  transferItems: [],
  purchase_discount: 0,
  sell_discount: 0,
  purchase_tax: 0,
  sell_tax: 0,
  shipping_cost: 0,
  sell_shipping_cost: 0,
  transfer_shipping_cost:0
});
export const getters = {
  getcartItems(state) {
    return state.cartItems;
  },
  getSellItems(state) {
    return state.sellItems;
  },
  getTransferItems(state) {
    return state.transferItems;
  },
  transferTotalPrice(state,getters){
    let price = getters.transferSubTotalPrice;
    let shipping_cost = state.transfer_shipping_cost;
    let totalamount = parseInt(price) + parseInt(shipping_cost);
    return totalamount;
  },
  transferSubTotalPrice(state, getters) {
    let items = getters.getTransferItems;
    let price = 0;
    if (items && items.length) {
      items.forEach(item => {
        price += Number(item.subtotal);
      });
    }
    return price;
  },
  totalPrice(state, getters) {
    let price = getters.subTotalPrice;
    let purchase_discount = state.purchase_discount;
    let purchase_tax = state.purchase_tax;
    let shipping_cost = state.shipping_cost;
    let discount_percentage = (price * purchase_tax) / 100;
    let after_tax = price + discount_percentage;
    let after_discount = after_tax - purchase_discount;
    let totalamount = parseInt(after_discount) + parseInt(shipping_cost);
    return totalamount;
  },
  subTotalPrice(state, getters) {
    let items = getters.getcartItems;
    let price = 0;
    if (items && items.length) {
      items.forEach(item => {
        price += Number(item.subtotal);
      });
    }
    return price;
  },
  sellTotalPrice(state, getters) {
    let price = getters.sellSubTotalPrice;
    let sell_discount = state.sell_discount;
    let sell_tax = state.sell_tax;
    let sell_shipping_cost = state.sell_shipping_cost;
    let sell_discount_percentage = (price * sell_tax) / 100;
    let sell_after_tax = price + sell_discount_percentage;
    let sell_after_discount = sell_after_tax - sell_discount;
    let sell_total_amount =
      parseInt(sell_after_discount) + parseInt(sell_shipping_cost);
    return sell_total_amount;
  },
  sellSubTotalPrice(state, getters) {
    let sitems = getters.getSellItems;
    let sprice = 0;
    if (sitems && sitems.length) {
      sitems.forEach(item => {
        sprice += Number(item.subtotal);
      });
    }
    return sprice;
  }
};
export const mutations = {
  SET_PURCHASE_PRODUCTS(state, payload) {
    state.cartItems = payload;
  },
  SET_TRANSFER_PRODUCTS(state, payload) {
    state.transferItems = payload;
  },
  SET_SELL_PRODUCTS(state, payload) {
    state.sellItems = payload;
  },
  SET_ADVANCE(state, payload) {
    state.advance = payload;
  },
  SET_ADVANCE_PAYOUT(state, payload) {
    state.advancepayout = payload;
  },
  ADD_PURCHASE_ITEMS(state, payload) {
    let items = state.cartItems;
    if (items) {
      items.push(payload);
    } else {
      state.cartItems = [payload];
    }
  },
  ADD_SELL_ITEMS(state, payload) {
    let items = state.sellItems;
    if (items) {
      items.push(payload);
    } else {
      state.sellItems = [payload];
    }
  },
  ADD_TRANSFER_ITEMS(state, payload) {
    let items = state.transferItems;
    if (items) {
      items.push(payload);
    } else {
      state.transferItems = [payload];
    }
  },
  REMOVE_SELL_PRODUCT(state, payload) {
    let items = state.sellItems;
    if (items) {
      let product = items.find(product => {
        return product.id == payload.id;
      });

      if (product) {
        let index = items.indexOf(product);
        items = items.splice(index, 1);
      }
    }

  },
  REMOVE_PRODUCT(state, payload) {
    let items = state.cartItems;
    if (items) {
      let product = items.find(product => {
        return product.id == payload.id;
      });

      if (product) {
        let index = items.indexOf(product);
        items = items.splice(index, 1);
      }
    }
  },
  SET_PURCHASE_DISCOUNT(state, payload) {
    state.purchase_discount = payload;
  },
  SET_PURCHASE_TAX(state, payload) {
    state.purchase_tax = payload;
  },
  SET_SHIPPING_COST(state, payload) {
    state.shipping_cost = payload;
  },
  SET_TRASFER_SHIPPING_COST(state,payload){
    state.transfer_shipping_cost = payload;
  },
  SET_SELL_DISCOUNT(state, payload) {
    state.sell_discount = payload;
  },
  SET_SELL_TAX(state, payload) {
    state.sell_tax = payload;
  },
  SET_SELL_SHIPPING_COST(state, payload) {
    state.sell_shipping_cost = payload;
  },
  INIT_CART_ITEMS(state) {
    state.cartItems = [];
  },
  INIT_SELL_ITEMS(state) {
    state.sellItems = [];
  }
};

export const actions = {
  addItemToPurchase(
    { commit },
    {
      product,
      product_id,
      variation_id,
      quantity,
      unit,
      allunit,
      unit_price,
      discount,
      tax
    }
  ) {
    let item = {
      product: product,
      product_id: product_id,
      variation_id: variation_id,
      quantity: quantity,
      unit_price: unit_price,
      purchase_price: unit_price,
      unit: unit,
      allunit: allunit,
      discount: discount,
      tax: tax,
      original_tax: tax,
      subtotal: parseInt(unit_price) + parseInt(tax * unit_price) / 100
    };
    commit("ADD_PURCHASE_ITEMS", item);
  },
  addItemToSell(
    { commit },
    {
      product,
      product_id,
      variation_id,
      sell_quantity,
      unit_price,
      unit,
      allunit,
      discount,
      tax
    }
  ) {
    let item = {
      product: product,
      product_id: product_id,
      variation_id: variation_id,
      sell_quantity: sell_quantity,
      unit_price: unit_price,
      sell_price:unit_price,
      unit: unit,
      allunit: allunit,
      discount: discount,
      tax: tax,
      original_tax: tax,
      subtotal: parseInt(unit_price) + parseInt(tax * unit_price) / 100
    };
    commit("ADD_SELL_ITEMS", item);
  },
  addItemToTransfer(
    { commit },
    { product, product_id,qty_available,variation_id, quantity, unit, purchase_price }
  ) {
    let item = {
      product: product,
      product_id: product_id,
      qty_available: qty_available,
      variation_id: variation_id,
      quantity: quantity,
      unit: unit,
      purchase_price: purchase_price,
      subtotal: parseInt(purchase_price) * parseInt(quantity)
    };
    commit("ADD_TRANSFER_ITEMS", item);
  },
  //sell
  updateSellItem({ commit, getters }, payload) {
    let sellItems = getters.getSellItems;
    if (payload.type == "qtychange") {
      if (sellItems) {
        let index = payload.index;
        let unit = sellItems[index].allunit.find(unit => {
          return unit.id == sellItems[index].unit
        });
        let unit_val= unit.value==null?1:unit.value;
        let newtax = sellItems[index].original_tax * payload.sell_quantity * unit_val;
        let newunitprice = parseFloat(sellItems[index].sell_price) * parseFloat(unit_val);
        let totaltax= sellItems[index].original_tax==null?0:parseFloat(newtax*sellItems[index].sell_price)/100;
        sellItems[index].sell_quantity = payload.sell_quantity;
        sellItems[index].tax = newtax;
        sellItems[index].subtotal =
          (payload.sell_quantity * newunitprice + totaltax-sellItems[index].discount).toFixed(2);
        commit("SET_SELL_PRODUCTS", sellItems);
      }
    }
    if (payload.type == "unitchange") {
      if (sellItems) {
        let index = payload.index;
        let unit = sellItems[index].allunit.find(unit => {
          return unit.id == payload.unitid;
        });
        let unit_val= unit.value==null?1:unit.value;
        sellItems[index].unit = payload.unitid;
        if(unit_val!==1)
        {
          let newtax = sellItems[index].original_tax * sellItems[index].sell_quantity * parseFloat(unit_val);
          let newunitprice = parseFloat(sellItems[index].sell_price) * parseFloat(unit_val);
          let totaltax= sellItems[index].original_tax==null?0:parseFloat(sellItems[index].original_tax * sellItems[index].sell_quantity*newunitprice)/100;
          sellItems[index].tax = newtax;
          sellItems[index].unit_price = newunitprice;
          sellItems[index].subtotal =
          (sellItems[index].sell_quantity * newunitprice + totaltax - sellItems[index].discount).toFixed(2);
          commit("SET_SELL_PRODUCTS", sellItems);
        }else
        {
          let totaltax= sellItems[index].original_tax==null?0:parseFloat( sellItems[index].original_tax * sellItems[index].sell_price)/100;
          sellItems[index].unit_price = parseFloat(sellItems[index].sell_price);
          sellItems[index].subtotal =
          (sellItems[index].sell_quantity * sellItems[index].sell_price + totaltax-sellItems[index].discount).toFixed(2);
          commit("SET_SELL_PRODUCTS", sellItems);
        }
      }
    }
    if (payload.type == "discountchange") {
      if (sellItems) {
        let index = payload.index;
        let unit = sellItems[index].allunit.find(unit => {
          return unit.id == sellItems[index].unit;
        });
        let unit_val= unit.value==null?1:unit.value;
        let newunitprice = parseFloat(sellItems[index].sell_price) * parseInt(unit_val);
        let totaltax= sellItems[index].original_tax==null?0:parseFloat(sellItems[index].original_tax * sellItems[index].sell_quantity * newunitprice)/100;
        sellItems[index].discount = payload.discount;
        sellItems[index].subtotal =
          (sellItems[index].sell_quantity * newunitprice + totaltax-payload.discount).toFixed(2);
        commit("SET_SELL_PRODUCTS", sellItems);
      }
    }
    if (payload.type == "selltax") {
      if (sellItems) {
        commit("SET_SELL_TAX", payload.tax);
      }
    }
    if (payload.type == "selldiscount") {
      if (sellItems) {
        commit("SET_SELL_DISCOUNT", payload.discount);
      }
    }
    if (payload.type == "shippingcost") {
      if (sellItems) {
        commit("SET_SELL_SHIPPING_COST", payload.shipping_cost);
      }
    }
  },

  //purchase

  updateCartItem({ commit, getters }, payload) {
    let cartItems = getters.getcartItems;

    if (payload.type == "pricechange") {
      if (cartItems) {
        let index = payload.index;
        let unit = cartItems[index].allunit.find(unit => {
          return unit.id == cartItems[index].unit
        });
        let unit_val= unit.value==null?1:unit.value;
        let newunitprice = payload.purchase_price * parseFloat(unit_val);
        let totaltax= cartItems[index].original_tax==null?0:parseFloat(cartItems[index].original_tax * cartItems[index].quantity * newunitprice)/100;
        cartItems[index].purchase_price = payload.purchase_price;
        cartItems[index].unit_price = newunitprice;
        cartItems[index].subtotal =
        (newunitprice * cartItems[index].quantity + totaltax -cartItems[index].discount).toFixed(2);
        commit("SET_PURCHASE_PRODUCTS", cartItems);
      }
    }
    
    if (payload.type == "qtychange") {
      if (cartItems) {
        let index = payload.index;
        let unit = cartItems[index].allunit.find(unit => {
          return unit.id == cartItems[index].unit
        });
        let unit_val = unit.value==null?1:unit.value;
        let newtax = cartItems[index].original_tax * payload.quantity * parseFloat(unit_val);
        let newunitprice = parseFloat(cartItems[index].purchase_price) * parseFloat(unit_val);
        let totaltax = cartItems[index].original_tax==null?0:parseFloat(newtax*cartItems[index].purchase_price)/100;
        cartItems[index].quantity = payload.quantity;
        cartItems[index].tax = newtax;
        cartItems[index].subtotal =
          (payload.quantity * newunitprice + totaltax - cartItems[index].discount).toFixed(2);
        commit("SET_PURCHASE_PRODUCTS", cartItems);
      }
    }
    if (payload.type == "unitchange") {
      if (cartItems) {
        let index = payload.index;
        let unit = cartItems[index].allunit.find(unit => {
          return unit.id == payload.unitid;
        });
      
        let unit_val= unit.value==null?1:unit.value;
        cartItems[index].unit = payload.unitid;
        if(unit_val!==1)
        {
          let newtax = cartItems[index].original_tax *  cartItems[index].quantity *  parseFloat(unit_val);
          let newunitprice = parseFloat(cartItems[index].purchase_price) * parseFloat(unit_val);
          let totaltax= cartItems[index].original_tax==null?0:parseFloat(newtax * cartItems[index].purchase_price)/100;
          cartItems[index].tax = newtax;
          cartItems[index].unit_price = newunitprice;
          cartItems[index].subtotal =
          (cartItems[index].quantity * (newunitprice) + totaltax -
            cartItems[index].discount).toFixed(2);
        commit("SET_PURCHASE_PRODUCTS", cartItems);
        }else
        {
          let newtax = cartItems[index].original_tax *  cartItems[index].quantity *  parseFloat(unit_val);
          let totaltax= cartItems[index].original_tax==null?0:parseFloat(newtax * cartItems[index].purchase_price)/100;
          cartItems[index].tax = newtax;
          cartItems[index].unit_price = parseFloat(cartItems[index].purchase_price);
          cartItems[index].subtotal =
          (cartItems[index].quantity * cartItems[index].purchase_price + totaltax- cartItems[index].discount).toFixed(2);
          commit("SET_PURCHASE_PRODUCTS", cartItems);
        }
      }
    }
    if (payload.type == "discountchange") {
      if (cartItems) {
        let index = payload.index;
        let unit = cartItems[index].allunit.find(unit => {
          return unit.id == cartItems[index].unit;
        });
        let unit_val= unit.value==null?1:unit.value;
        let newunitprice = parseFloat(cartItems[index].purchase_price) * parseFloat(unit_val);
        cartItems[index].discount = payload.discount;
        cartItems[index].subtotal =
          (cartItems[index].quantity *
          newunitprice) +
          parseFloat(
            cartItems[index].tax *  cartItems[index].quantity * newunitprice
          ) /
            100 -
          payload.discount;

        commit("SET_PURCHASE_PRODUCTS", cartItems);
      }
    }
    if (payload.type == "taxchange") {
      if (cartItems) {
        let index = payload.index;
        let unit = cartItems[index].allunit.find(unit => {
          return unit.id == cartItems[index].unit;
        });
        let unit_val= unit.value==null?1:unit.value;
        let newunitprice = parseInt(cartItems[index].purchase_price) * parseInt(unit_val);
        cartItems[index].tax = payload.tax;
        cartItems[index].subtotal =
          (cartItems[index].quantity *
          newunitprice) +
          parseInt(
            payload.tax  *
            newunitprice *cartItems[index].quantity
          ) /
            100 -
          cartItems[index].discount;

        commit("SET_PURCHASE_PRODUCTS", cartItems);
      }
    }
    if (payload.type == "totaltax") {
      if (cartItems) {
        commit("SET_PURCHASE_TAX", payload.tax);
      }
    }
    if (payload.type == "totaldiscount") {
      if (cartItems) {
        commit("SET_PURCHASE_DISCOUNT", payload.discount);
      }
    }
    if (payload.type == "shippingcost") {
      if (cartItems) {
        commit("SET_SHIPPING_COST", payload.shipping_cost);
      }
    }
  },

  //transfer
  updateTransferItem({ commit, getters }, payload) {
    let transferItems = getters.getTransferItems;

    if (payload.type == "qtychange") {
      if (transferItems) {
        let index = payload.index;
        if(parseInt(payload.quantity)>parseInt(transferItems[index].qty_available))
        {
          alert('Quantity is not available')
          transferItems[index].quantity=1
          return
        }
        transferItems[index].quantity = payload.quantity;
        transferItems[index].subtotal =
          payload.quantity * transferItems[index].purchase_price;

        commit("SET_TRANSFER_PRODUCTS", transferItems);
      }
    }

    if (payload.type == "pricechange") {
      if (transferItems) {
        let index = payload.index;
        transferItems[index].purchase_price = payload.purchase_price;
        transferItems[index].subtotal =
          payload.purchase_price * transferItems[index].quantity;
        commit("SET_TRANSFER_PRODUCTS", transferItems);
      }
    }
    if(payload.type=="shippingcost"){
      if (transferItems) {
        commit("SET_TRASFER_SHIPPING_COST", payload.shipping_cost);
      }
    }
  },
  updatePrice({ commit, getters }, { product, price, index }) {
    let cartItems = getters.getcartItems;
    if (cartItems) {
      cartItems[index].price = price / 40;
      cartItems[index].total = (price / 40) * cartItems[index].qty;
      commit("SET_PURCHASE_PRODUCTS", cartItems);
    }
  },
  removeCartItem({ commit, getters }, { product, index }) {
    let cartItems = getters.getcartItems;
    if (cartItems) {
      cartItems.splice(index, 1);
      commit("REMOVE_PRODUCT", cartItems);
    }
  },
};
