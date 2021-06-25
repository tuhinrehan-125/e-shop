export const state = () => ({
  cartItems: [],
  shipping_cost:0,
  tax:0,
  discount:0,
});
export const getters = {
  getcartItems(state) {
    return state.cartItems;
  },
  amountOfTax(state, getters){
    let subTotalPrice = getters.subTotalPrice;
    return (subTotalPrice*state.tax)/100;
  },
  amountOfShippingCost(state){
    return state.shipping_cost
  },
  amountOfDiscount(state, getters){
    let subTotalPrice = getters.subTotalPrice;
    return (subTotalPrice*state.discount)/100;
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
  totalPrice(state, getters) {
    let subTotalPrice = parseFloat(getters.subTotalPrice);
    let totalTax = parseFloat(getters.amountOfTax);
    let shippingCost = parseFloat(getters.amountOfShippingCost);
    return subTotalPrice+totalTax+shippingCost;
  },
  netTotalPrice(state,getters) {
    let discount = parseFloat(getters.amountOfDiscount);
    let totalPrice = parseFloat(getters.totalPrice);
    return totalPrice-discount;
  }
};
export const mutations = {
  ADD_ITEMS(state, payload) {
    let items = state.cartItems;
    if (items) {
      items.push(payload);
    } else {
      state.cartItems = [payload];
    }
  },
  UPDATE_ITEMS(state, payload) {
    state.cartItems = payload;
  },
  UPDATE_TAX(state, payload) {
    state.tax = payload;
  },
  UPDATE_DISCOUNT(state, payload) {
    state.discount = payload;
  },
  UPDATE_SHIPPING_COST(state, payload) {
    state.shipping_cost = payload;
  },
};
export const actions = {
  addItemToCart({ commit,getters }, { product, product_id, quantity, sell_price }) {
    let items = getters.getcartItems;
    let existeditem =  items.findIndex(x => x.product_id === product_id);
    if(existeditem >=0){
      items[existeditem].quantity +=1 ;
      commit("UPDATE_ITEMS", items);
    }else{
      let item = {
        product: product,
        product_id: product_id,
        quantity: quantity,
        price: sell_price,
        sell_price: sell_price,
        subtotal: sell_price
      };
      commit("ADD_ITEMS", item);
    }
  },
  updateCartItem({ commit, getters }, payload) {
    let items = getters.getcartItems;
    if (payload.type == "qtychange") {
      if (items) {
        let index = payload.index;
        items[index].quantity = payload.qty;
        items[index].subtotal = (payload.qty * items[index].sell_price).toFixed(
          2
        );
        commit("UPDATE_ITEMS", items);
      }
    }
    if (payload.type == "tax") {
      if (items && getters.subTotalPrice>0) {
        commit("UPDATE_TAX", payload.tax);
      }
    }
    if (payload.type == "discount") {
      if (items && getters.subTotalPrice>0) {
        commit("UPDATE_DISCOUNT", payload.discount);
      }
    }
    if (payload.type == "shipping_cost") {
      if (items && getters.subTotalPrice>0) {
        commit("UPDATE_SHIPPING_COST", payload.shipping_cost);
      }
    }
  },
  removeCartItem({ commit, getters }, { product, index }) {
    let cartItems = getters.getcartItems;
    if (cartItems) {
      cartItems.splice(index, 1);
      commit("UPDATE_ITEMS", cartItems);
    }
  },
};
