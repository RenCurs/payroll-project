<template>
    <div class="loader">
        <div class="d-flex justify-content-center">
            <div class="spinner-border text-primary" style="width: 7rem; height: 7rem;"  role="status"/>
        </div>
    </div>
</template>

<script lang="ts">
import { Vue } from 'vue-property-decorator'
import Component from 'vue-class-component'

@Component
export default class Loader extends Vue {}
</script>

<style scoped>
.loader {
    position: fixed;
    background: #ffffff63;
    width: 100%;
    height: 100%;
    display: flex;
    top: 0;

    /* выравнивание по центру дочернего блока */
    align-items: center;
    justify-content: center;
}
</style>
