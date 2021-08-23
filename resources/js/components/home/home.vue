<template lang="">
    <div class="home-page-con">
        <div class="add-post-con" v-if="isLoggedIn">
            <Button type="primary" @click="addPostModalOpen = true">Add a Post...</Button>
            <Modal
                v-model="addPostModalOpen"
                title="Add a post..."
                okText="Post"
                cancelText="Cancle"
                @on-ok="addPost"
                @on-cancel="cancelPost">
                <Input v-model="post.location" placeholder="Location"/>
                <Input v-model="post.desc" type="textarea" :rows="4" placeholder="Post Description" class="post-module-desc" />
                 <Upload
                    ref="upload"
                    :headers="{'x-csrf-token' : token,'X-Requested-With': 'XMLHttpRequest'}"
                    :show-upload-list="false"
                    :default-file-list="postImages"
                    :on-success="handleSuccess"
                    :format="['jpg','jpeg','png']"
                    :max-size="5000"
                    :on-format-error="handleFormatError"
                    :on-exceeded-size="handleMaxSize"
                    multiple
                    type="drag"
                    action="/api/post/upload"
                    style="display: inline-block;width:58px;">
                    <div style="width: 58px;height:58px;line-height: 58px;">
                        <Icon type="ios-camera" size="20"></Icon>
                    </div>
                </Upload>
                <div  v-if="postImages">
                    <span class="demo-upload-list" v-for="(image, index) in postImages" :key="index">
                        <img class="add-post-module-img" :src="`/uploads/${image.name}`">
                        <div class="demo-upload-list-cover">
                            <Icon type="ios-trash-outline"@click="deleteImage(index)"></Icon>
                        </div>
                    </span>
				</div>
            </Modal>
        </div>
        <div class="posts-con">
            <Post v-for="(post, index) in posts" :key="index" :post="post"  />
            <infinite-loading class="infinite-loading" @infinite="infiniteHandler"></infinite-loading>
        </div>
        <div class="follow-sug-con">
        <h2 class="h2-sugg">{{isLoggedIn? 'Suggestions For You' : 'Log in to Follow Users'}}</h2>
            <Sug v-if="isLoggedIn" v-for="(user, index) in sugUsers" :key="index" :sugUser="user" />
        </div>
    </div>
</template>
<script>
import post from '../post/post.vue'
import sug from './sug.vue'
export default {
    components:{
        "Post":post,
        "Sug":sug
    },
    data() {
        return {
            post:{
                location:'',
                desc:''
            },
            postImages:[
            ],
            token: "",
            addPostModalOpen:false,
            posts: [],
            page:0,
            sugUsers:[]
        }
    },

    computed:{
        isLoggedIn: function (){
            return this.$store.getters.isLoggedIn
        },
        user: function (){
            return localStorage.getItem('user')
        }
    },

     methods: {
            async addPost(){
                if(this.post.location.trim()==""){
                    return this.e("Please enter the Location")
                }
                    
                let myPost = {
                    user : this.user,
                    location:this.post.location,
                    desc:this.post.desc,
                    postImages:this.postImages
                }
                const response = await this.callApi('post','api/post/create',myPost)
                if(response.status === 200){
                    this.s("Post Added")
                    this.addPostModalOpen = false
                    this.post.location = ''
                    this.post.desc = ''
                    this.postImages = []
                    this.$refs.upload.clearFiles()
                    this.posts.unshift(response.data[response.data.length-1])
                }else{
                    this.e("OOPs Something went wrong your Post was not added")
                }
            },

            async infiniteHandler($state){
                const response = await this.callApi('post','api/getPosts',{page:this.page+1})
                if(response.data.length != 0){
                    if (response.status == 200){
                        response.data.map((item)=>{
                            this.posts.push(item)
                        })
                        this.page += 1
                        $state.loaded();
                    }else{
                        $state.complete();
                    }
                }else{
                    $state.complete();
                }
            },

            cancelPost(){
                this.addPostModalOpen = false
                this.post.location = ''
                this.post.desc = ''
                this.postImages = []
                this.$refs.upload.clearFiles()
            },

            handleSuccess(res,file){
			    this.postImages.push({name:res});
		    },
            handleFormatError (file) {
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png or jpeg.'
                });
            },
            handleMaxSize (file) {
                this.$Notice.warning({
                    title: 'Exceeding file size limit',
                    desc: 'File  ' + file.name + ' is too large, no more than 5M.'
                });
            },

            async deleteImage(index){
                let image = this.postImages[index]
                this.postImages.splice(index,1)
                // this.$refs.uploads.clearFiles()
                const res = await this.callApi('post','api/post/delete_image',{imageName:image.name})
                if (res.status != 200){
                    this.postImages.push(image)
                    this.i('OOBs something went wrong')
                }
            }

        },

        async mounted () {
            this.uploadList = this.$refs.upload.fileList;
        },

        async created() {
        this.token = window.Laravel.csrfToken
		const response = await this.callApi('post','api/getPosts',{page:this.page})
		if (response.status == 200){
			this.posts = response.data
		}

        const res = await this.callApi('get','api/user/getSugUsers')
		if (res.status == 200){
			this.sugUsers = res.data
		}
	},
}
</script>




<style scoped>
    .home-page-con{
        display: flex;
        justify-content: space-between;
    }

    .follow-sug-con{
        height: 500px;
        width: 36%;
    }

    .add-post-con{
        position: fixed;
        bottom: 0px;
        right:0px ;
    }

    .post-module-desc{
        margin: 1em 0px;
    }

    .add-post-module-img{
        width: 100px;
    }

    .posts-con{
        width: 60%;
    }

    .h2-sugg{
        color: rgba(142,142,142);
        font-weight: 600;
        font-size: 14px;
        line-height: 18px;
    }


   @media only screen and (max-width: 1000px) {
        .follow-sug-con{
            display: none;
            width: 0%;
        }

        .home-page-con{
            justify-content: space-around;
            width: 100%;
        }

        .posts-con{
            width: 100%;
        }
    }
</style>