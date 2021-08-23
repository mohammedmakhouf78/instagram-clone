<template lang="">
    <div class="single-comment-con">
        <div v-if="comment.author.avatar == null" class="comment-avatar-con">
            <Avatar class="avatar-img" src="https://i.lolinet/2017/08/21/599a521472424.jpg" />
        </div>
        <div v-else class="comment-avatar-con">
            <Avatar class="avatar-img" :src="`/uploads/${comment.author.avatar}`" />
        </div>
        <p class="comment-text">
            {{this.comment.comment}}
        </p>
    </div>
</template>
<script>
export default {
    props:['comment'],
}
</script>
<style scoped>
    .single-comment-con{
        display: flex;
        padding: 1em 1em;
        border-top: 1px solid rgb(var(--border));
        align-items: center;
        justify-content: space-between;
    }
    .comment-avatar-con{
        width: 6%;
        align-self: flex-start;
    }

    .comment-text{
        width: 91%;
        margin-left: 1em;
        font-weight: 600;
    }
</style>