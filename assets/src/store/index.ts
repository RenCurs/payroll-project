import Vue from 'vue';
import Vuex from 'vuex';
import { actions } from '@/store/actions'
import { getters } from '@/store/getters'
import { mutations } from '@/store/mutations'
import Employee from '@/types/Employee'

Vue.use(Vuex);

export interface State {
    employee?: Employee
    loading: boolean;
}

const state: State = {
    employee: undefined,
    loading: false
}

export default new Vuex.Store<State>({
    state,
    getters,
    mutations,
    actions
});
