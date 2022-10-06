<template>
    <div>
        <HeaderLayout>
            <template #content>
                <h4 style="text-align: center">{{ $t('employee.edit') }}</h4>
                <EmployeeView
                    :employee="employee"
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

@Component({
    components: { EmployeeView, HeaderLayout }
})
export default class EditEmployee extends Vue {
    @Prop({ type: String, required: true })
    private employeeId

    private employee: Employee = getEmptyEmployee()

    @Mutation(Mutations.setLoading)
    private setLoading: (load: boolean) => void

    @Action(Actions.getEmployeeById)
    private getEmployeeId: (id: number) => Promise<Employee>

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
}

</script>

<style scoped>

</style>
