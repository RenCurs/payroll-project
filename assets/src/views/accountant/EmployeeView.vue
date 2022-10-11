<template>
    <div>
        <div class="wrap-edit-employee">
            <div
                v-for="(errors, fieldName) in errorsValidation"
                :key="fieldName"
                class="alert alert-danger alert-dismissible fade show"
                role="alert"
            >
                <span
                    v-for="(error, idx) of errors"
                    :key="idx"
                >
                    {{ error }}
                </span>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                    @click="clearErrors(fieldName)"
                ></button>
            </div>
            <div class="mb-3">
                <label for="inputFio" class="form-label">{{ $t('employee.fields.fio') }}</label>
                <input
                    v-model="currentEmployee.fio"
                    type="text"
                    class="form-control"
                    id="inputFio"/>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">{{ $t('employee.fields.address.title') }}</label>
                <input
                    v-model="currentEmployee.address"
                    type="text"
                    class="form-control"
                    id="address"
                >
            </div>

            <div class="mb-3">
                <label for="dateBirth" class="form-label">{{ $t('employee.fields.dateBirth') }}</label>
                <input
                    v-model="currentEmployee.dateBirth"
                    type="date"
                    class="form-control"
                    id="dateBirth"
                    min="1920-01-01"
                    max="2050-01-01"
                >
            </div>
            <div class="mb-3">
                <label for="salaryType" class="form-label">{{ $t('employee.fields.salaryType') }}</label>
                <select
                    v-model="currentEmployee.salaryType" id="salaryType"
                    class="form-select"
                >
                    <option disabled value="">Выберите</option>
                    <option
                        v-for="(code, i) of paymentTypes"
                        :key="i"
                        :value="code"
                    >
                        {{ $t(`paymentType.${code}`) }}
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label for="paymentType" class="form-label">{{ $t('employee.fields.scheduleSalary') }}</label>
                <select
                    v-model="currentEmployee.paymentSchedule"
                    id="paymentType"
                    class="form-select"
                >
                    <option disabled value="">{{ $t('choose') }}</option>
                    <option
                        v-for="(code, i) of paymentSchedules"
                        :key="i"
                        :value="code"
                    >
                        {{ $t(`paymentSchedule.${code}`) }}
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">{{ $t('paymentType.fixed') }}</label>
                <input v-model.number="currentEmployee.salary" type="number" class="form-control" id="salary">
            </div>
            <div class="mb-3">
                <label for="hourTariff" class="form-label">{{ $t('paymentType.hourly') }}</label>
                <input v-model.number="currentEmployee.hourTariff" type="text" class="form-control" id="hourTariff">
            </div>
            <div class="mb-3">
                <label for="hourTariff" class="form-label">{{ $t('paymentType.job_price') }}</label>
                <input v-model.number="currentEmployee.commissionRate" type="text" class="form-control" id="percent">
            </div>
            <div class="form-check">
                <label class="form-check-label" for="unionAffiliation">{{ $t('employee.fields.unionAffiliation') }}</label>
                <input v-model="currentEmployee.isUnionAffiliation" type="checkbox" class="form-check-input" id="unionAffiliation">
            </div>

            <button
                v-if="!onlyRead"
                type="button"
                class="mt-3 btn btn-secondary"
                @click="changeEmployee"
            >
                {{ $t('actions.save') }}
            </button>
        </div>
    </div>
</template>

<script lang="ts">
import { Prop, Vue, Watch } from 'vue-property-decorator';
import Employee from '@/types/Employee';
import Component from 'vue-class-component';
import { getEmptyEmployee, validateEmployee, clearedEmptyFieldsEmployees } from '@/helpers';
import paymentSchedules from '@/dictionary/PaymentSchedules'
import paymentTypes from '@/dictionary/PaymentTypes'

@Component
export default class EmployeeView extends Vue {
    @Prop({ type: Boolean, default: false })
    private onlyRead: boolean

    @Prop({ type: Object, default: () => ({}) })
    private employee: Employee

    private errorsValidation: {[key: string]: Array<string>} = {}
    private currentEmployee: Employee = getEmptyEmployee()
    private CHANGE_EMPLOYEE_EVENT = 'changeEmployeeEvent'

    get paymentSchedules(): Array<string> {
        return paymentSchedules
    }

    get paymentTypes(): Array<string> {
        return paymentTypes
    }

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
            this.errorsValidation = { ...errors }

            return
        }

        this.$emit(this.CHANGE_EMPLOYEE_EVENT, clearedEmptyFieldsEmployees(this.currentEmployee))
    }

    private clearErrors(fieldName: string) {
        delete this.errorsValidation[fieldName]
        this.errorsValidation = { ...this.errorsValidation }
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
</style>
