<template>
    <div>
        <HeaderLayout>
            <template #content>
                <h4 style="text-align: center">Редактирование сотрудника</h4>
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
import { Action } from 'vuex-class'
import { Actions } from '@/store/actions'

@Component({
    components: { EmployeeView, HeaderLayout }
})
export default class EditEmployee extends Vue {
    @Prop({ type: String, required: true })
    private employeeId

    private employee: Employee = getEmptyEmployee()

    @Action(Actions.getEmployeeById)
    private getEmployeeId: (id: number) => Promise<Employee>

    async created (): Promise<void> {
        try {
            this.employee = await this.getEmployeeId(Number(this.employeeId))
        } catch (err) {
            console.log(err)
        }
    }
}

</script>

<style scoped>

</style>
