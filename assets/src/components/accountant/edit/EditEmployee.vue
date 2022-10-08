<template>
    <div>
        <HeaderLayout>
            <template #content>
                <div v-if="error.trim().length > 0" class="alert alert-danger alert-box" role="alert">
                    {{ error }}
                </div>

                <h4 style="text-align: center">{{ $t('employee.edit') }}</h4>
                <EmployeeView
                    :employee="employee"
                    @changeEmployeeEvent="updateEmployeeHandle"
                />
            </template>
        </HeaderLayout>
    </div>
</template>

<script lang="ts">

import { Component, Prop, Vue } from 'vue-property-decorator'
import HeaderLayout from '@/views/layout/HeaderLayout.vue'
import Employee from '@/types/Employee'
import EmployeeView from '@/views/accountant/EmployeeView.vue'
import { getEmptyEmployee } from '@/helpers'
import { Action, Mutation } from 'vuex-class'
import { Actions } from '@/store/actions'
import { Mutations } from '@/store/mutations'
import { AxiosError } from 'axios'

@Component({
    components: { EmployeeView, HeaderLayout }
})
export default class EditEmployee extends Vue {
    @Prop({ type: String, required: true })
    private employeeId

    private error = ''
    private employee: Employee = getEmptyEmployee()

    @Mutation(Mutations.setLoading)
    private setLoading: (load: boolean) => void

    @Action(Actions.getEmployeeById)
    private getEmployeeId: (id: number) => Promise<Employee>

    @Action(Actions.updateEmployee)
    private updateEmployee: (employee: Employee) => Promise<Employee>

    async created (): Promise<void> {
        this.setLoading(true)

        try {
            this.employee = await this.getEmployeeId(Number(this.employeeId))
        } catch (err) {
            console.log(err)
        } finally {
            this.setLoading(false)
        }
    }

    async updateEmployeeHandle(employee: Employee): Promise<void> {
        this.setLoading(true)

        try {
            await this.updateEmployee(employee)
        } catch (err) {
            this.error = (err as AxiosError).message ?? 'An expected error occurred'
        } finally {
            this.setLoading(false)
        }
    }
}

</script>

<style scoped>
.alert-box {
    width: 1000px;
    margin: auto auto 20px auto;
}
</style>
