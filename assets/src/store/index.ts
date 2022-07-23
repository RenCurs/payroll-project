import Vue from 'vue';
import Vuex from 'vuex';
import { actions } from '@/store/actions'

Vue.use(Vuex);

export interface State {
    workerId: number
}

const state: State = {
    workerId: 0
}

export default new Vuex.Store<State>({
    state,
    getters: {},
    mutations: {},
    actions,
    modules: {}
});
