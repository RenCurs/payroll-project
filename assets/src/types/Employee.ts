export default interface Employee {
    id: number | undefined;
    fio: string;
    dateBirth: string,
    salaryType: string,
    paymentSchedule: string,
    salary: number | undefined,
    hourTariff?: number,
    commissionRate?: number | undefined,
    lastPayDate: string
}
