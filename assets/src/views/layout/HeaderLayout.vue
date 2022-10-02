<template>
    <div>
        <div class="mb-3 header">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" role="button" @click="redirectToAllEmployees">{{ $t('employee.list') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" role="button" @click="redirectToCreateEmployee">{{ $t('employee.add') }}</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <div style="margin-right: 20px ;padding-bottom: 0.5em; padding-top: 0.5em;">
                                    <span class="text-success text-bold">{{ $t('currentUser') }} Test</span>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" role="button">{{ $t('logout') }}</a>
                            </li>
                        </ul>
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
