<template>
    <div>
        <HeaderLayout>
            <template #content>
                <h4 style="text-align: center">Создание сотрудника</h4>
                <EmployeeView
                    @changeEmployeeEvent="createEmployee"
                />
            </template>
        </HeaderLayout>
    </div>
</template>

<script lang="ts">
import { Vue } from 'vue-property-decorator'
import Component from 'vue-class-component'
import Employee from '@/types/Employee'
import HeaderLayout from '@/views/layout/HeaderLayout.vue'
import EmployeeView from '@/views/accountant/EmployeeView.vue'

@Component({
    components: { EmployeeView, HeaderLayout }
})
export default class CreateEmployee extends Vue {
    private createEmployee(employee: Employee) {
        console.log(employee)
        // send request
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
