import { EmployeePropertyEnum } from '@/types/EmployeePropertyEnum'

export default interface Employee {
    [EmployeePropertyEnum.id]?: number;
    [EmployeePropertyEnum.fio]: string;
    [EmployeePropertyEnum.dateBirth]: string,
    [EmployeePropertyEnum.address]?: string,
    [EmployeePropertyEnum.salaryType]: string,
    [EmployeePropertyEnum.paymentSchedule]: string,
    [EmployeePropertyEnum.salary]?: number,
    [EmployeePropertyEnum.hourTariff]?: number,
    [EmployeePropertyEnum.commissionRate]?: number,
    [EmployeePropertyEnum.lastPayDate]?: string
    [EmployeePropertyEnum.isUnionAffiliation]: boolean
}
