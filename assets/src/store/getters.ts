import { GetterTree } from 'vuex'
import { State } from '@/store/index'

export enum Getters {
    isLoading = 'isLoading'
}

export const getters: GetterTree<State, State> = {
    [Getters.isLoading] (state: State): boolean {
        return state.loading
    }
}
