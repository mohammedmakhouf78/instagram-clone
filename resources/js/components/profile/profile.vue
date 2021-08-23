<template lang="">
    <div class="profile">
        <div class="profile-avatar-con">
            <div @click="openModel" class="profile-avatar-image-con">
                <div v-if="avatar==null || avatar==''">
                    <Avatar class="profile-avatar-img" src="https://i.loli.net/2017/08/21/599a521472424.jpg" />
                </div>
                <div v-if="avatar!=null">
                    <Avatar class="profile-avatar-img" :src="`/uploads/${avatar}`" />
                </div>
            </div>
            <div class="profile-name-con">
                <h1>mohammedmakhlouf5</h1>
                <div class="profile-posts-followers">
                    <p class="profile-post-numbers">{{posts.length}} posts</p>
                    <p>{{followers}} followers</p>
                    <p>{{followings}} following</p>
                </div>
            </div>
        </div>

        <div class="profile-tabs">
            <Tabs value="name1">
                <TabPane label="Posts" name="name1" class="profile-tabs-posts">
                    <h2 v-if="posts.length === 0">There is no posts yet...</h2>
                    <div v-else class="profile-post-img-con">
                        <div class="profile-post-img" v-for="(post, index) in posts" :key="index" v-if="post.images.length >= 1">
                            <img class="carousel-image" :src="`/uploads/${post.images[0].img}`" alt="">
                        </div>
                    </div>
                </TabPane>
                <TabPane label="Saved" name="name2" class="profile-tabs-saved">
                    <h2>There is no Saved Posts yet...</h2>
                </TabPane>
            </Tabs>
        </div>


        <Modal
            v-model="profileUploadModel"
            title="upload a profile Picture"
            okText="Upload"
            cancelText="Cancle"
            @on-ok="addProfileImage"
            @on-cancel="cancel">
            <Upload
                    ref="upload"
                    :headers="{'x-csrf-token' : token,'X-Requested-With': 'XMLHttpRequest'}"
                    :show-upload-list="false"
                    :on-success="handleSuccess"
                    :format="['jpg','jpeg','png']"
                    :max-size="5000"
                    :on-format-error="handleFormatError"
                    :on-exceeded-size="handleMaxSize"
                    type="drag"
                    action="/api/post/upload"
                    style="display: inline-block;width:58px;">
                    <div style="width: 58px;height:58px;line-height: 58px;">
                        <Icon type="ios-camera" size="20"></Icon>
                    </div>
                </Upload>
                <div  v-if="profileImage">
                    <span class="demo-upload-list">
                        <img class="add-post-module-img" :src="`/uploads/${profileImage}`">
                        <div class="demo-upload-list-cover">
                            <Icon type="ios-trash-outline"@click="deleteImage"></Icon>
                        </div>
                    </span>
				</div>
        </Modal>
    </div>
</template>
<script>
export default {
    
    data() {
        return {
            posts:[],
            profileUploadModel:false,
            token: '',
            profileImage:'',
            followers:0,
            followings:0
        }
    },

    computed:{
        user: function(){
            return localStorage.getItem('user')
        },
        avatar:function(){
            return this.$store.getters.avatar
        },
    },

    methods:{
        async addProfileImage(){
            if(this.profileImage.trim()==""){
                return this.e("Please enter the Profile Image")
            }

            let profilePic = {
                image: this.profileImage,
                user: this.user
            }

            const response = await this.callApi('post','api/user/profile/upload',profilePic)
            if(response.status === 200){
                this.s("Profile Picture added...")
                this.profileUploadModel = false
                this.profileImage = ''
                this.$refs.upload.clearFiles()
                this.avatar()
            }else{
                this.e("OOPs Something went wrong your profileImage was not added")
            }
        },


        cancel(){

        },
        openModel(){
            this.profileUploadModel = true
        },

        handleSuccess(res,file){
		    this.profileImage = res;
	    },
        handleFormatError (file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: 'File format of ' + file.name + ' is incorrect,please select jpg or png or jpeg.'
            });
        },
        handleMaxSize (file) {
            this.$Notice.warning({
                title: 'Exceeding file size limit',
                desc: 'File  ' + file.name + ' is too large, no morethan 5M.'
            });
        },

        async deleteImage(){
            let image = this.profileImage
            this.profileImage = ''
            // this.$refs.uploads.clearFiles()
            const res = await this.callApi('post','api/post/delete_image',{imageName:image})
            if (res.status != 200){
                this.profileImage = image
                this.i('OOBs something went wrong')
            }
        }


    },

    async created() {
        this.token = window.Laravel.csrfToken

        let data = {
            user: this.user            
        }
        const response = await this.callApi('post','api/getUserPosts',data)
		if (response.status == 200){
			this.posts = response.data
            if(this.posts.length > 0){
                this.followers = this.posts[0].author.followers.length
                this.followings = this.posts[0].author.followings.length
            }
		}
    },
}
</script>
<style scoped>
    .profile-avatar-con{
        width: 90%;
        margin: 0 auto;
        display: flex;
        /* align-items: center; */
        justify-content: space-around;
    }
    .profile-avatar-image-con{
        cursor: pointer;
    }
    .profile-avatar-img{
        width: 200px;
        height: 200px;
    }

    .profile-name-con{
        width: 70%;
        padding-left: 4em;
        padding-top: 5em;
    }

    .profile-posts-followers{
        display: flex;
        margin-top: 1em;
    }

    .profile-posts-followers p{
        margin-left: 3em;
        font-weight: bold;
    }

    p.profile-post-numbers{
        margin-left: 0px;
    }

    .profile-tabs{
        padding: 3em 5em;
    }

    .profile-tabs-posts h2,.profile-tabs-saved h2{
        text-align: center;
        margin-top: 2em;
        font-weight: bold;
    }

    .profile-post-img-con{
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .profile-post-img{
        flex-basis:30%;
        margin: 1%;
    }

    .profile-post-img img{
        width: 100%;
        height: 300px;
    }

    @media ( max-width: 1050px) {

        .profile-post-img {
            flex-basis: 48%;
        }
    }

    @media ( max-width: 850px) {
        .profile-post-img {
            flex-basis: 100%;
        }
    }

    @media ( max-width: 320px) {
        .profile-post-img {
            flex-basis: 100%;
        }
    }

</style>