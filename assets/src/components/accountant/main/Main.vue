<template>
    <div>
        <div class="header">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Action 1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Action 2</a>
                            </li>
                        </ul>
                        <div class="d-flex">
                            <span class="navbar-text">
                                Current user: Test
                            </span>
                            <a class="nav-link" href="#">Logout</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div>
            <Employees
                :employees="employees"
                @removeEmployeeEvent="removeEmployee"
            />
        </div>
    </div>
</template>

<script lang="ts">
import { Vue } from 'vue-property-decorator'
import Component from 'vue-class-component'
import Employees from '@/views/accountant/main/Employees.vue'
import Employee from '@/types/Employee'

@Component({
    components: { Employees }
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
                lastPayDate: '2022-05-30'
            },
            {
                id: 2,
                fio: 'Петров Максим Артемович',
                dateBirth: '1985-01-01',
                salaryType: 'fixed',
                paymentSchedule: 'monthly',
                salary: 130000,
                lastPayDate: '2022-05-30'
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
