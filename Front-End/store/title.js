export const state = () => ({
  loading: false,
  title: '',
});

export const getters = {
  pagetitle(state) {
    return state.title;
  },
}

export const mutations = {
  SET_TITLE(state, payload) {
    state.title = payload
  }
};

export const actions = {
  createTitle({ commit }, payload) {
    commit("SET_TITLE", payload);
  },
};
