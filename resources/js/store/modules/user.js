import * as types from '../constants/mutation_types';

export const state = {
    user: {}
};

export const getters = {
    user: state => state.user
};

export const mutations = {
    [types.UPDATE_USER_DATE](state, payload) {
        state.user = payload;
    },
};

export const actions = {
    updateData({commit}, payload){
        commit(types.UPDATE_USER_DATE, payload);
    }
};