<template>
    <div>
        <HeaderLayout>
            <template #content>
                <div class="alert-box" v-if="errors.length > 0">
                    <div v-for="(error, idx) of errors" :key="idx" class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ error }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>

                <h4 style="text-align: center">{{ $t('employee.create') }}</h4>
                <EmployeeView
                    @changeEmployeeEvent="createEmployeeHandle"
                />
            </template>
        </HeaderLayout>
    </div>
</template>

<script lang="ts">
import { Vue } from 'vue-property-decorator'
import Component from 'vue-class-component'
import Employee from '@/types/Employee'
import HeaderLayout from '@/views/layout/HeaderLayout.vue'
import EmployeeView from '@/views/accountant/EmployeeView.vue'
import { Action, Mutation } from 'vuex-class'
import { Mutations } from '@/store/mutations'
import { Actions } from '@/store/actions'
import { AxiosError } from 'axios'

@Component({
    components: { EmployeeView, HeaderLayout }
})
export default class CreateEmployee extends Vue {
    // TODO Миксин для ошибок ???
    private errors: Array<string> = []

    @Mutation(Mutations.setLoading)
    private setLoading: (load: boolean) => void

    @Action(Actions.createEmployee)
    private createEmployee: (employee: Employee) => Promise<Employee>

    private async createEmployeeHandle(employee: Employee) {
        this.errors = []
        this.setLoading(true)

        try {
            this.setLoading(true)
            await this.createEmployee(employee)
        } catch (err) {
            this.errors = (err as AxiosError<{ errors: Array<string> }>)?.response?.data.errors ??
                [this.$t('error.createEmployee').toString()]
            this.clearError()
        } finally {
            this.setLoading(false)
        }
    }

    private clearError(): void {
        setTimeout(() => { this.errors = [] }, 4000)
    }
}
</script>

<style scoped>
.alert-box {
    width: 1000px;
    margin: auto auto 20px auto;
}
</style>
