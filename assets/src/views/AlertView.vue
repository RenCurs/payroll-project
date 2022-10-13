<template>
    <div class="alert-box" v-if="errors.length > 0">
        <div v-for="(error, idx) of errors" :key="idx" class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>

</template>

<script lang="ts">
import Component from 'vue-class-component'
import { Prop, Vue } from 'vue-property-decorator'

@Component
export default class AlertView extends Vue {
    @Prop({ type: Array, default: () => [] })
    private errors
}
</script>

<style scoped>
.alert-box {
    width: 1000px;
    margin: 20px auto 20px auto;
}
</style>
