<template lang="">
    <div class="carousel">
        <slot></slot>
        <Icon 
        @click="next" 
        type="ios-arrow-dropright-circle" 
        class="carousel-right"
        v-if="carouselRightVisible"
        />

        <Icon 
        @click="prev" 
        type="ios-arrow-dropleft-circle" 
        class="carousel-left"
        v-if="carouselLeftVisible"
        />
    </div>
</template>
<script>
export default {
    props:['carouselRightVisible','carouselLeftVisible'],
    methods:{
        next(){
            this.$emit('next')
        },
        prev(){
            this.$emit('prev')
        }
    }
}
</script>
<style scoped>
    .carousel{
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    .carousel-left,.carousel-right{
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 2em;
        cursor: pointer;
    }

    .carousel-right{
        right: 0;
    }
</style>