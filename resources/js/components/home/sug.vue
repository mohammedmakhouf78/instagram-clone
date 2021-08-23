<template lang="">
    <div class="con">
        <div>
            <Avatar :avatar="sugUser.avatar" />
        </div>
        <div class="name-con">
            <h2>{{sugUser.name}}</h2>
            <div class="follow-btn-con">
                <Button :type="isFollowing?'error':'primary'" @click="follow(sugUser.id)">{{isFollowing ?'Unfollow' : 'Follow'}}</Button>
            </div>
        </div>
    </div>
</template>
<script>
import avatar from '../post/avatar.vue'
export default {
    components:{
        'Avatar':avatar
    },
    props:['sugUser'],
    data() {
        return {
            isFollowing:false,
        }
    },

    computed:{
        user:function(){
            return localStorage.getItem('user')
        },
        isF:{
            get:function(){
                let result = false
                this.sugUser.followers.map(item => {
                    if (item.following_id == this.user){
                        result = true
                    }
                })
                this.isFollowing = result
            },
            set:function(newVal){
                this.isFollowing = newVal
            }
        }
    },

    methods:{
        async follow(followingID){
            const response = await this.callApi('post','api/user/follow',{
                user:this.user,
                willFollow:followingID
            })

            if (response.status == 200){
                if (response.data == 1){
                    this.isF = true
                }else{
                    this.isF = false
                }
            }else{
                this.e("OOPs Something went wrong Failed to add the comment!!!")
            }
        }   

    },

    created() {
        this.isF
    },

}
</script>
<style scoped>
    .con{
        display: flex;
        align-items: center;
        margin-top: 0.7em;
    }
    h2{
        color: rgb(121, 105, 105);
        font-weight: 600;
        font-size: 1em;
    }

    .name-con{
        display: flex;
        margin-left: 0.4em;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }
</style>