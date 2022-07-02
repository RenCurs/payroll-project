import Employee from '@/types/Employee'
import { EmployeePropertyEnum } from '@/types/EmployeePropertyEnum'

function getEmptyEmployee(): Employee {
    return {
        fio: '',
        dateBirth: '',
        salaryType: '',
        paymentSchedule: '',
        isUnionAffiliation: false
    }
}

function validateEmployee(employee: Employee) {
    // TODO Или сделать через массив правил???
    const zeroValue = 0
    const errors: {[key: string]: string} = {}
    const salariesProperty: Array<string> = [
        EmployeePropertyEnum.salary,
        EmployeePropertyEnum.hourTariff,
        EmployeePropertyEnum.commissionRate
    ]
    const exceptProperty = [
        EmployeePropertyEnum.id,
        EmployeePropertyEnum.lastPayDate,
        EmployeePropertyEnum.isUnionAffiliation
    ]
    const baseProperties = Object.values(EmployeePropertyEnum)
        .filter((property) => !exceptProperty.includes(property))

    for (const property of baseProperties) {
        if (!employee[property] && employee[property] !== zeroValue) {
            // TODO перевод
            errors[property] = 'Must not be empty'

            continue
        }

        if (salariesProperty.includes(property)) {
            if (isNaN(Number(employee[property]))) {
                errors[property] = 'Must be integer value'
            }
        }
    }

    return errors
}

export { getEmptyEmployee, validateEmployee }
