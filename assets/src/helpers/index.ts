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
    const rules = {
        [EmployeePropertyEnum.fio]: (fio: string) => validateFio(fio),
        [EmployeePropertyEnum.dateBirth]: (dateBirth: string) => validateBirthDate(dateBirth),
        base: (empl: Employee) => baseValidate(empl)
    }
    const errorsByField: {[key: string]: Array<string>} = {}

    for (const validateField of Object.keys(rules)) {
        let field
        let errors: Array<string>

        if (Object.hasOwnProperty.call(employee, validateField)) {
            field = validateField
            errors = rules[validateField](employee[validateField])
        } else {
            errors = rules[validateField](employee)
            field = 'base'
        }

        if (errors.length > 0) {
            errorsByField[field] = errors
        }
    }

    return errorsByField
}

// TODO Вынести в отдельный класс
// TODO Добавить переводы
// TODO Посмотреть библиотеку для валидации
function validateFio(fio: string): Array<string> {
    const errors: string[] = []

    if (!fio) {
        errors.push('Fio must not be empty')
    } else if (fio.trim().length <= 5) {
        errors.push('Min length of fio must be >= 5')
    }

    return errors
}

function validateBirthDate(dateBirth: string): Array<string> {
    const errors: string[] = []

    if (!dateBirth) {
        errors.push('Must not be empty')
    }

    return errors
}

function baseValidate(employee: Employee): Array<string> {
    const errors: string[] = []

    const salariesProperty: Array<string> = [
        EmployeePropertyEnum.salary,
        EmployeePropertyEnum.hourTariff,
        EmployeePropertyEnum.commissionRate
    ]

    const specifySalaryTypes = salariesProperty.filter((property) => !!employee[property])

    if (specifySalaryTypes.length === 0 || specifySalaryTypes.length > 1) {
        errors.push('Only one of the salary type field must be specify: salary, commission rate, hourly tariff')
    } else {
        const specifyType = specifySalaryTypes[0]

        if (isNaN(employee[specifyType])) {
            errors.push(`${specifyType} must be integer of float`)
        }
    }

    return errors
}

export { getEmptyEmployee, validateEmployee }
