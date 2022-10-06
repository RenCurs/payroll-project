import Vue from 'vue';
import Vuex from 'vuex';
import { actions } from '@/store/actions'
import { getters } from '@/store/getters'
import { mutations } from '@/store/mutations'

Vue.use(Vuex);

export interface State {
    workerId: number;
    loading: boolean;
}

const state: State = {
    workerId: 0,
    loading: false
}

export default new Vuex.Store<State>({
    state,
    getters,
    mutations,
    actions
});
