<template>
    <div>
        <div class="wrap-edit-employee">
            <div class="mb-3">
                <label for="inputFio" class="form-label">ФИО</label>
                <input
                    :class="{'control-error': !!errorsValidation.fio}"
                    v-model="currentEmployee.fio"
                    type="text"
                    class="form-control"
                    id="inputFio"/>
                <div v-if="!!errorsValidation.fio" class="form-text text-danger">
                    {{ errorsValidation.fio }}
                </div>
            </div>
            <div class="mb-3">
                <label for="dateBirth" class="form-label">Дата рождения</label>
                <!--                            TODO вынести даты-->
                <input
                    :class="{'control-error': !!errorsValidation.dateBirth}"
                    v-model="currentEmployee.dateBirth"
                    type="date"
                    class="form-control"
                    id="dateBirth"
                    min="1920-01-01"
                    max="2050-01-01"
                >
                <div v-if="!!errorsValidation.dateBirth" class="form-text text-danger">
                    {{ errorsValidation.dateBirth }}
                </div>
            </div>
            <div class="mb-3">
                <label for="salaryType" class="form-label">Тип оплаты</label>
                <select
                    :class="{'control-error': !!errorsValidation.salaryType}"
                    v-model="currentEmployee.salaryType" id="salaryType"
                    class="form-select"
                >
                    <option disabled value="">Выберите</option>
                    <option
                        v-for="(code, i) of salaryTypes()"
                        :key="i"
                        :value="code"
                    >
                        {{ code }}
                    </option>
                </select>
                <div v-if="!!errorsValidation.salaryType" class="form-text text-danger">
                    {{ errorsValidation.salaryType }}
                </div>
            </div>
            <div class="mb-3">
                <label for="salaryType" class="form-label">Схема оплаты</label>
                <select
                    :class="{'control-error': !!errorsValidation.paymentSchedule}"
                    v-model="currentEmployee.paymentSchedule"
                    id="salaryType"
                    class="form-select"
                >
                    <option disabled value="">Выберите</option>
                    <option
                        v-for="(code, i) of paymentSchedules()"
                        :key="i"
                        :value="code"
                    >
                        {{ code }}
                    </option>
                </select>
                <div v-if="!!errorsValidation.paymentSchedule" class="form-text text-danger">
                    {{ errorsValidation.paymentSchedule }}
                </div>
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">Оклад</label>
                <input v-model="currentEmployee.salary" type="text" class="form-control" id="salary">
                <div v-if="!!errorsValidation.salary" class="form-text text-danger">
                    {{ errorsValidation.salary }}
                </div>
            </div>
            <div class="mb-3">
                <label for="hourTariff" class="form-label">Часовая ставка</label>
                <input v-model="currentEmployee.hourTariff" type="text" class="form-control" id="hourTariff">
                <div v-if="!!errorsValidation.hourTariff" class="form-text text-danger">
                    {{ errorsValidation.hourTariff }}
                </div>
            </div>
            <div class="mb-3">
                <label for="percent" class="form-label">Процент комиссии</label>
                <input v-model="currentEmployee.commissionRate" type="text" class="form-control" id="percent">
                <div v-if="!!errorsValidation.commissionRate" class="form-text text-danger">
                    {{ errorsValidation.commissionRate }}
                </div>
            </div>
            <div class="form-check">
                <label class="form-check-label" for="unionAffiliation">Член профсоюза</label>
                <input v-model="currentEmployee.isUnionAffiliation" type="checkbox" class="form-check-input" id="unionAffiliation">
            </div>

            <button
                type="button"
                class="mt-3 btn btn-secondary"
                @click="changeEmployee"
            >
                Сохранить
            </button>
        </div>
    </div>
</template>

<script lang="ts">
import { Prop, Vue, Watch } from 'vue-property-decorator';
import Employee from '@/types/Employee';
import Component from 'vue-class-component';
import { getEmptyEmployee, validateEmployee } from '@/helpers';

@Component
export default class EmployeeView extends Vue {
    @Prop({ type: Object, default: () => ({}) })
    private employee: Employee

    private errorsValidation: {[key: string]: string} = {}
    private currentEmployee: Employee = getEmptyEmployee()
    private CHANGE_EMPLOYEE_EVENT = 'changeEmployeeEvent'

    @Watch('employee')
    updateEmployee() {
        this.currentEmployee = Object.assign({}, this.employee)
    }

    created() {
        this.currentEmployee = Object.assign({}, this.employee)
    }

    private changeEmployee(): void {
        this.errorsValidation = {}
        const errors = validateEmployee(this.currentEmployee)
        if (Object.keys(errors).length > 0) {
            this.errorsValidation = errors

            return
        }

        this.$emit(this.CHANGE_EMPLOYEE_EVENT, this.currentEmployee)
    }

    private salaryTypes(): Array<string> {
        // TODO вынести
        return ['fixed', 'jobprice', 'hourly']
    }

    private paymentSchedules(): Array<string> {
        return ['monthly', 'weekly', 'biweekly']
    }
}
</script>

<style scoped>
.wrap-edit-employee {
    margin: 25px auto 25px;
    width: 1000px;
    border-radius: 10px;
    box-shadow: 1px 1px 5px 1px;
    padding: 15px;
}

.control-error {
    border-color: #dc3545;
}
</style>
