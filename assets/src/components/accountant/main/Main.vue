<template>
    <div>
        <HeaderLayout>
            <template #content>
                <Employees
                    :employees="employees"
                    @removeEmployeeEvent="removeEmployee"
                />
            </template>
        </HeaderLayout>
    </div>
</template>

<script lang="ts">
import { Vue } from 'vue-property-decorator'
import Component from 'vue-class-component'
import Employees from '@/views/accountant/main/Employees.vue'
import Employee from '@/types/Employee'
import HeaderLayout from '@/views/layout/HeaderLayout.vue'

@Component({
    components: { HeaderLayout, Employees }
})
export default class Main extends Vue {
    private employees: Array<Employee> = []

    async created(): Promise<void> {
        // request back
        this.employees = [
            {
                id: 1,
                fio: 'Иванов Иван Иванович',
                dateBirth: '2000-01-01',
                salaryType: 'fixed',
                paymentSchedule: 'monthly',
                salary: 30000,
                lastPayDate: '2022-05-30',
                isUnionAffiliation: true
            },
            {
                id: 2,
                fio: 'Петров Максим Артемович',
                dateBirth: '1985-01-01',
                salaryType: 'fixed',
                paymentSchedule: 'monthly',
                salary: 130000,
                lastPayDate: '2022-05-30',
                isUnionAffiliation: true
            }
        ]
    }

    removeEmployee(employeeId: number): void {
        // request back
        const index = this.employees.findIndex((employee) => employee.id === employeeId)
        this.employees.splice(index, 1)
    }
}
</script>

<style scoped>
</style>
