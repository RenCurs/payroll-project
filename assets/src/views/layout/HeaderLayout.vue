<template>
    <div>
        <div class="mb-3 header">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" role="button" @click="redirectToAllEmployees">Список сотрудников</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" role="button" @click="redirectToCreateEmployee">Добавить сотрудника</a>
                            </li>
                        </ul>
                        <div class="d-flex">
                            <span class="navbar-text">
                                Current user: Test
                            </span>
                            <a class="nav-link" role="button" @click="redirectToCreateEmployee">Добавить сотрудника</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div>
            <slot name="content"></slot>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';

@Component
export default class HeaderLayout extends Vue {
    private redirectToCreateEmployee() {
        if (this.$router.currentRoute.name !== 'create_employee') {
            this.$router.push({ name: 'create_employee' })
        }
    }

    private redirectToAllEmployees() {
        if (this.$router.currentRoute.name !== 'employee_list') {
            this.$router.push({ name: 'employee_list' })
        }
    }
}
</script>

<style scoped>

</style>
