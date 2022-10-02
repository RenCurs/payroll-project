<template>
    <div>
        <div class="employees">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">{{ $t('employee.fields.ID') }}</th>
                        <th scope="col">{{ $t('employee.fields.fio') }}</th>
                        <th scope="col">{{ $t('employee.fields.dateBirth') }}</th>
                        <th scope="col">{{ $t('employee.fields.salaryType') }}</th>
                        <th scope="col">{{ $t('employee.fields.scheduleSalary') }}</th>
                        <th scope="col">{{ $t('employee.actions.title') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(employee, index) of employees"
                        :key="index"
                    >
                        <td>
                            <a class="text-decoration-none" href="#">{{ employee.id}}</a>
                        </td>
                        <td>{{ employee.fio}}</td>
                        <td>{{ employee.dateBirth}}</td>
                        <td>{{ $t(`salaryType.${employee.salaryType}`) }}</td>
                        <td>{{ $t(`paymentSchedule.${employee.paymentSchedule}`) }}</td>
                        <td>
                            <div>
                                <button
                                    type="button"
                                    class="btn btn-outline-info"
                                    @click="$router.push({ name: 'edit_employee', params: { employeeId: String(employee.id) }})"
                                >
                                    {{ $t('employee.actions.edit') }}
                                </button>
                                <button
                                    type="button"
                                    class="ms-1 btn btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#removeModal"
                                    @click="initRemoveEmployee(employee)"
                                >
                                    {{ $t('employee.actions.delete') }}
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!--        Modal window for remove button-->
        <div class="modal fade" id="removeModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Подтвердите удаление</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Вы точно хотите удалить запись? <br> Обратить операцию уже не получится
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-primary"
                            data-bs-dismiss="modal"
                            @click="removeEmployee"
                        >
                            Да
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Нет</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator'
import Employee from '@/types/Employee'
import EditEmployee from '@/components/accountant/edit/EditEmployee.vue'

@Component({
    components: { EditEmployee }
})
export default class Employees extends Vue {
    private static REMOVE_EMPLOYEE_EVENT = 'removeEmployeeEvent'

    @Prop({ type: Array, default: () => [] })
    private employees: Array<Employee>

    private potentialRemoveEmployee?: number;

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
}
</script>

<style scoped>
.employees {
    margin: 15px;
}
</style>
