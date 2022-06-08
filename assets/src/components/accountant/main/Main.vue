<template>
    <div>
        <div class="header">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Action 1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Action 2</a>
                            </li>
                        </ul>
                        <div class="d-flex">
                            <span class="navbar-text">
                                Current user: Test
                            </span>
                            <a class="nav-link" href="#">Logout</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</template>

<script lang="ts">
import { Vue } from 'vue-property-decorator'
import Component from 'vue-class-component'

@Component
export default class Main extends Vue {
}
</script>

<style scoped>
</style>
