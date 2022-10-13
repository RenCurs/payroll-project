<template>
    <div>
        <HeaderLayout>
            <template #content>
                <div class="container-fluid">
                    <div class="row">
                        <div class="alert-box" v-if="error.trim().length > 0">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ error }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>

                        <Employees
                            :employees="employees"
                            @removeEmployeeEvent="removeEmployee"
                        />
                    </div>
                </div>
            </template>
        </HeaderLayout>
    </div>
</template>

<script lang="ts">
import { Vue } from 'vue-property-decorator'
import Component from 'vue-class-component'
import Employees from '@/views/accountant/Employees.vue'
import Employee from '@/types/Employee'
import HeaderLayout from '@/views/layout/HeaderLayout.vue'
import { Actions } from '@/store/actions'
import { Action, Mutation } from 'vuex-class'
import { Mutations } from '@/store/mutations'

@Component({
    components: { HeaderLayout, Employees }
})
export default class Main extends Vue {
    // TODO Во многих компонентах повторяется это св-во в виде массива или строки, может как-то вынести можно?
    private error = ''
    private employees: Array<Employee> = []

    @Mutation(Mutations.setLoading)
    private setLoading: (load: boolean) => void

    @Action(Actions.getEmployees)
    private getEmployees: () => Promise<Array<Employee>>

    @Action(Actions.deleteEmployee)
    private deleteEmployee: (id: number) => Promise<void>

    async created(): Promise<void> {
        this.setLoading(true)
        try {
            this.employees = await this.getEmployees()
        } catch (err) {
            this.error = this.$t('error.geEmployees').toString()
            this.clearError()
        } finally {
            this.setLoading(false)
        }
    }

    private async removeEmployee(employeeId: number): Promise<void> {
        this.error = ''
        this.setLoading(true)

        try {
            await this.deleteEmployee(employeeId)
            const index = this.employees.findIndex((employee) => employee.id === employeeId)
            this.employees.splice(index, 1)
        } catch (err) {
            this.error = this.$t('error.deleteEmployee').toString()
            this.clearError()
        } finally {
            this.setLoading(false)
        }
    }

    private clearError(): void {
        setTimeout(() => { this.error = '' }, 4000)
    }
}
</script>

<style scoped>
.alert-box {
    width: 1000px;
    margin: auto auto 20px auto;
}
</style>
