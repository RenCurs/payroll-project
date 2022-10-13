<template>
    <div>
        <div v-if="employees.length > 0" class="employees">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">{{ $t('employee.fields.ID') }}</th>
                        <th scope="col">{{ $t('employee.fields.fio') }}</th>
                        <th scope="col">{{ $t('employee.fields.dateBirth') }}</th>
                        <th scope="col">{{ $t('employee.fields.salaryType') }}</th>
                        <th scope="col">{{ $t('employee.fields.scheduleSalary') }}</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(employee, index) of employees"
                        :key="index"
                    >
                        <td>
                            <a
                                class="text-decoration-none"
                                role="button"
                                data-bs-toggle="modal"
                                data-bs-target="#employeeModal"
                                @click="initShowEmployee(employee)"
                            >{{ employee.id}}</a>
                        </td>
                        <td>{{ employee.fio}}</td>
                        <td>{{ employee.dateBirth}}</td>
                        <td>{{ $t(`paymentType.${employee.salaryType}`) }}</td>
                        <td>{{ $t(`paymentSchedule.${employee.paymentSchedule}`) }}</td>
                        <td>
                            <div>
                                <button
                                    type="button"
                                    class="btn btn-outline-info"
                                    @click="$router.push({ name: 'edit_employee', params: { employeeId: String(employee.id) }})"
                                >
                                    {{ $t('actions.edit') }}
                                </button>
                                <button
                                    type="button"
                                    class="ms-1 btn btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#removeModal"
                                    @click="initRemoveEmployee(employee)"
                                >
                                    {{ $t('actions.delete') }}
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="empty-employees" v-else>
            <h5 style="color: gray">{{ $t('employeesEmpty') }}</h5>
        </div>

        <!--        Modal window for remove button-->
        <div class="modal fade" id="removeModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $t('employee.deletePrompt.title') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ $t('employee.deletePrompt.confirm') }}
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-primary"
                            data-bs-dismiss="modal"
                            @click="removeEmployee"
                        >
                            {{ $t('employee.deletePrompt.yes') }}
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ $t('employee.deletePrompt.no') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            v-if="!!employeeShow"
            class="modal fade" id="employeeModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $t('employee.titleEmployee', { fio: employeeShow.fio }) }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="only-read">
                            <EmployeeView
                                :employee="employeeShow"
                                :only-read="true"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator'
import Employee from '@/types/Employee'
import EditEmployee from '@/components/accountant/EditEmployee.vue'
import EmployeeView from '@/views/accountant/EmployeeView.vue'

@Component({
    components: { EmployeeView, EditEmployee }
})
export default class Employees extends Vue {
    private static REMOVE_EMPLOYEE_EVENT = 'removeEmployeeEvent'

    @Prop({ type: Array, default: () => [] })
    private employees: Array<Employee>

    private potentialRemoveEmployee?: number;
    private employeeShow = {};

    removeEmployee(): void {
        if (this.employees) {
            this.$emit(Employees.REMOVE_EMPLOYEE_EVENT, this.potentialRemoveEmployee)
        }
    }

    initRemoveEmployee(employee: Employee): void {
        if (employee.id) {
            this.potentialRemoveEmployee = employee.id
        }
    }

    initShowEmployee(employee: Employee): void {
        this.employeeShow = employee
    }
}
</script>

<style scoped>
.empty-employees {
    margin: auto;
    width: 500px;
    text-align: center;
}
.employees {
    margin: 15px;
}

.only-read {
    pointer-events: none;
}
</style>
