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

    private errors: Array<string> = []
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
        this.errors = []
        this.setLoading(true)

        try {
            await this.updateEmployee(employee)
        } catch (err) {
            this.errors = (err as AxiosError<{ errors: Array<string> }>)?.response?.data.errors ??
                [this.$t('error.editEmployee').toString()]
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
