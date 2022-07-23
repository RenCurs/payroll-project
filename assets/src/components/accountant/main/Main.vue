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
import { Actions } from '@/store/actions'
import { Action } from 'vuex-class'

@Component({
    components: { HeaderLayout, Employees }
})
export default class Main extends Vue {
    private employees: Array<Employee> = []

    @Action(Actions.getEmployees)
    private getEmployees: () => Promise<Array<Employee>>

    async created(): Promise<void> {
        try {
            this.employees = await this.getEmployees()
        } catch (err) {
            console.log(err)
        }
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
