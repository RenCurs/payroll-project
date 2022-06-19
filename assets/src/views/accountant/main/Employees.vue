<template>
    <div>
        <div class="employees">
            <table class="table">
                <thead>
                    <tr>
                        <!-- TODO В translations-->
                        <th scope="col">ID</th>
                        <th scope="col">ФИО</th>
                        <th scope="col">Дата рождения</th>
                        <th scope="col">Тип платы</th>
                        <th scope="col">Тип выплаты</th>
                        <th scope="col">Действия</th>
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
                        <!-- TODO В translations-->
                        <td>{{ employee.salaryType}}</td>
                        <td>{{ employee.paymentSchedule}}</td>
                        <td>
                            <div>
                                <button
                                    type="button"
                                    class="btn btn-outline-info"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal"
                                >
                                    Редактировать
                                </button>
                                <button
                                    type="button"
                                    class="ms-1 btn btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#removeModal"
                                    @click="initRemoveEmployee(employee)"
                                >
                                    Удалить
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!--        Modal window for edit button-->
        <!--       TODO в отдельный компонент ??? -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Редактирование сотрудника</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="mb-3">
                                <label for="inputFio" class="form-label">ФИО</label>
                                <input type="text" class="form-control" id="inputFio">
                                <div class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                            <div class="mb-3">
                                <label for="dateBirth" class="form-label">Дата рождения</label>
                                <input type="date" class="form-control" id="dateBirth">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="Check1">
                                <label class="form-check-label" for="Check1">Check me out</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-primary"
                            data-bs-dismiss="modal"
                            @click="removeEmployee"
                        >
                            Сохранить
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>

        <!--        Modal window for remove button-->
        <div class="modal fade" id="removeModal" tabindex="-1" aria-hidden="true">
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

@Component
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
