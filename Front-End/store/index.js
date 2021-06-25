export const strict = false;
export const state = () => ({
  barColor: "rgba(0, 0, 0, .8), rgba(0, 0, 0, .8)",
  barImage: "",
  drawer: null,
  isModalOpened: false,
  modalType: "",
  isViewModalOpened: false,
  alertMessage: "",
  alert: false,
  alertType: 'success',
  locales: ["bn", "en"],
  locale: "en",
});
export const getters = {
  modal(state) {
    return state.isModalOpened;
  },
  viewmodal(state) {
    return state.isViewModalOpened;
  },
  alert(state) {
    return state.alert;
  },
  message(state) {
    return state.alertMessage;
  },
  modaltype(state) {
    return state.modalType;
  },
  alertType(state) {
    return state.alertType;
  }
};
export const mutations = {
  SET_BAR_IMAGE(state, payload) {
    state.barImage = payload;
  },
  SET_DRAWER(state, payload) {
    state.drawer = payload;
  },
  SET_ALERT(state, payload) {
    state.alertMessage = payload.message;
    state.alert = payload.alert;
    state.alertType = payload.type;
  },
  SET_MODAL(state, payload) {
    state.isModalOpened = payload.status;
    state.modalType = payload.type;
  },
  SET_VIEW_MODAL(state, payload) {
    state.isViewModalOpened = payload;
  },
  SET_LANG(state, locale) {
    if (state.locales.indexOf(locale) !== -1) {
      state.locale = locale;
    }
  }
};
export const actions = {};
