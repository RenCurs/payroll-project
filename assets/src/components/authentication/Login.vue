<template>
    <div class="wrap-login">
        <div class="horizontal-middle">
            <AlertView :errors="errors" />
            <LoginView
                @loginEvent="loginHandle"
            />
        </div>
    </div>
</template>

<script lang="ts">
import Component from 'vue-class-component'
import { Vue } from 'vue-property-decorator'
import LoginView from '@/views/authentication/LoginView.vue'
import { Action, Mutation } from 'vuex-class'
import { Mutations } from '@/store/mutations'
import { Actions } from '@/store/actions'
import Client from '@/types/Client'
import { AxiosError } from 'axios'
import AlertView from '@/views/AlertView.vue'

@Component({
    components: {
        AlertView,
        LoginView
    }
})
export default class Login extends Vue {
    private errors: Array<string> = []

    @Mutation(Mutations.setLoading)
    private setLoading: (load: boolean) => void

    @Action(Actions.login)
    private login: (client: Client) => Promise<void>

    private async loginHandle(client: Client): Promise<void> {
        this.errors = []
        this.setLoading(true)

        try {
            await this.login(client)
        } catch (err) {
            console.log(err)
            this.errors = (err as AxiosError<{ errors: Array<string> }>)?.response?.data.errors ?? [this.$t('error.auth').toString()]
        } finally {
            this.setLoading(false)
        }
    }
}
</script>

<style scoped>
.wrap-login {
    display: flex;
    align-items: center;
    height: 100vh;
    background-color: #94eeee78;
}
.horizontal-middle {
    margin: auto;
    width: 100%;
}
</style>
