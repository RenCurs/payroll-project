import { State } from '@/store/index'
import { MutationTree } from 'vuex'

export enum Mutations {
    setLoading = 'setLoading'
}

export const mutations: MutationTree<State> = {
    [Mutations.setLoading] (state: State, load: boolean) {
        state.loading = load
    }
}
