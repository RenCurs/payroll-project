<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-8 mx-auto">
                <div class="card login">
                    <h1>{{ $t('signIn') }}</h1>
                    <form class="form-group" @submit.prevent="login">
                        <div class="control-box">
                            <input v-model="client.email" type="email" class="form-control" :placeholder="$t('email')" required>
                            <div v-if="!!error" class="form-text text-danger">
                                {{ error }}
                            </div>
                        </div>

                        <div class="control-box">
                            <input v-model="client.password" type="password" class="form-control" :placeholder="$t('password')" required>
                        </div>
                        <input type="submit" class="btn btn-primary" :value="$t('loginButton')">
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Component from 'vue-class-component'
import { Vue } from 'vue-property-decorator'
import Client from '@/types/Client'

@Component
export default class LoginView extends Vue {
    private error = ''
    private client?: Client = { email: '', password: '' }

    private login(): void {
        this.validate()

        if (this.error.length > 0) {
            return
        }

        this.$emit('loginEvent', { ...this.client })
    }

    private validate (): void {
        this.error = ''
        const regexEmail = /^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/gm;

        if (!regexEmail.test(String(this.client?.email))) {
            this.error = this.$t('error.emailIncorrect').toString()
        }
    }
}
</script>

<style lang="css" scoped>
p {
    line-height: 1rem;
}

.card {
    padding: 20px;
}

.control-box {
    margin-bottom: 20px;
}
h1 {
    margin-bottom: 1.5rem;
}
</style>
