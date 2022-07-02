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

@Component({
    components: { EmployeeView, HeaderLayout }
})
export default class EditEmployee extends Vue {
    @Prop({ type: String, required: true })
    private employeeId

    private employee: Employee = getEmptyEmployee()

    async created (): Promise<void> {
        // request to back for get employee by id
        setTimeout(() => {
            this.employee = {
                id: 2,
                fio: 'Петров Максим Артемович',
                dateBirth: '1985-01-01',
                salaryType: 'jobprice',
                paymentSchedule: 'biweekly',
                salary: 130_000,
                lastPayDate: '2022-05-30',
                isUnionAffiliation: false
            }
        }, 2000)
    }
}

</script>

<style scoped>

</style>
