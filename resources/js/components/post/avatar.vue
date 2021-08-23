<template lang="">
    <div>
        <div v-if="avatar == null">
            <Avatar class="avatar-img" src="https://i.loli.net/2017/08/21/599a521472424.jpg" />
        </div>
        <div v-else>
            <Avatar class="avatar-img" :src="`/uploads/${avatar}`" />
        </div>
    </div>
</template>
<script>
export default {
    props:['avatar']
}
</script>
<style lang="">
    
</style>