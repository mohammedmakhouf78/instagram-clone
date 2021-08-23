<template lang="">
    <div v-show="visibleSlide === index">
        <slot></slot>
    </div>
</template>
<script>
export default {
    props:['visibleSlide','index']
}
</script>
<style lang="">
    
</style>