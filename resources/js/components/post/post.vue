<template lang="">
    <div>
        <div class="post-con">
            <div class="avatar">
                <Avatar :avatar="post.author.avatar" />
                <div class="avatar-text-con">
                    <div class="avatar-name-con">
                        <Dropdown>
                        <a href="javascript:void(0)">
                            <a href="" class="avatar-name">{{post.author.name}}</a>
                        </a>
                        <DropdownMenu slot="list" class="drop-menu">
                            <div class="drop-avatar">
                                <Avatar :avatar="post.author.avatar" />
                                <div class="avatar-name-con">
                                    <a href="" class="avatar-name">{{post.author.name}}</a>
                                </div>
                            </div>
                            <div class="drop-follow">
                                <div class="drop-posts-number">
                                    <h4>{{userPosts.length}}</h4>
                                    <p>Posts</p>
                                </div>
                                <div class="drop-followers-number">
                                    <h4>{{followers}}</h4>
                                    <p>Followers</p>
                                </div>
                                <div class="drop-following-number">
                                    <h4>{{followings}}</h4>
                                    <p>Following</p>
                                </div>
                            </div>
                            <div class="drop-follow-buttons-con">
                                <Button>Message</Button>
                                <Button :type="isFollowing?'error':'primary'" @click="follow(post.author.id)">{{isFollowing ?'Unfollow' : 'Follow'}}</Button>
                            </div>
                        </DropdownMenu>
                    </Dropdown>
                    </div>
                    <div>
                        <a href="" class="avatar-location">{{post.location}}</a>
                    </div>
                </div>
            </div>
            <div class="post-img" v-if="post.images.length == 1">
                <img class="carousel-image" :src="`/uploads/${post.images[0].img}`" alt="">
            </div>
            <div class="carosel" v-if="post.images.length > 1">
                <carousel 
                @next="next(post.images)" 
                @prev="prev(post.images)"
                :carouselRightVisible="carouselRightVisible"
                :carouselLeftVisible="carouselLeftVisible"
                >
                    <carousel-slide v-for="(image, index) in post.images" :key="index" :index="index" :visibleSlide="visibleSlide" >
                        <img class="carousel-image" :src="`/uploads/${image.img}`" alt="">
                    </carousel-slide>
                </carousel>
            </div>
            <div class="post-footer-con">
                <div class="post-footer-icons">
                    <Icon @click="likePost(post.id)" type="ios-heart"  class="nav-icon" :class="[liked? 'red' : 'gray']"/>
                    <Icon @click="showComments" type="ios-chatbubbles-outline" class="nav-icon" />
                </div>
                <div class="post-footer-liked">
                    <span class="post-footer-liked-text">Liked by {{likes}}</span>
                </div>
                <div class="post-desc">
                    {{post.desc}}
                </div>
                <div class="post-date">
                    <p>{{new Date(post.created_at).toDateString()}}</p>
                </div>
            </div>
            <div class="post-add-comment">
                <Emoji  ref="emoji" @input="onInput" :value="comment" />
                <Button @click="addComment(post.id)" type="primary">Comment</Button>
            </div>

            <div class="comment-con" v-if="commentsIsShowing">
                <Comment v-for="(comment, index) in comments" :key="index" :comment="comment" />
            </div>
            <div>
                <p class="show-comments-msg" @click="showComments">Show all comments...</p>
            </div>
        </div>

    </div>
</template>


<script>
import carousel from './Carousel.vue'
import CarouselSlide from './CarouselSlide.vue'
import emoji from 'emoji-vue'
import comment from './comment.vue'
import avatar from './avatar.vue'

export default {
    components:{
        'carousel' : carousel,
        'carousel-slide' : CarouselSlide,
        'Emoji':emoji,
        'Comment':comment,
        'Avatar':avatar
    },

    props:['post'],

    data() {
        return {
            visibleSlide:0,
            carouselRightVisible:true,
            carouselLeftVisible:false,
            liked:false,
            comment:'',
            commentsIsShowing:false,
            userPosts:[],
            isFollowing:false,
            followers:0,
            likes:0
        }
    },

    computed:{
        user:function(){
            return localStorage.getItem('user')
        },
        userLikedId:function (){
            return this.post.likes[0].user_id
        },
        comments:function(){
            return this.post.comments
        },
        fers:{
            get:function(){
                this.followers = this.post.author.followers.length
            },
            set:function(newVal){
                this.followers = newVal
            }
        },
        les:{
            get:function(){
                if(this.post.likes.length == undefined){
                    this.likes = 0
                }else{
                    this.likes = this.post.likes.length
                }
            },
            set:function(newVal){
                this.likes = newVal
            }
        },
        // followers:function(){
        //     return this.post.author.followers.length
        // },
        followings:function(){
            return this.post.author.followings.length
        },
        isF:{
            get:function(){
                let result = false
                this.post.author.followers.map(item => {
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

    methods: {
       next(images){
            if(this.visibleSlide >= images.length -1){
                this.visibleSlide = 0
            }else{
                this.visibleSlide++
            }
            this.carouselButtonsVisibile(images)
       },
       prev(images){
           if(this.visibleSlide <= 0 ){
                this.visibleSlide = images.length -1
            }else{
                this.visibleSlide--
            }
            this.carouselButtonsVisibile(images)
       },

       carouselButtonsVisibile(images){
           if(this.visibleSlide == 0){
                this.carouselLeftVisible = false
                this.carouselRightVisible = true
            }
            else if(this.visibleSlide == images.length-1){
                this.carouselRightVisible = false
                this.carouselLeftVisible = true
            }
            else{
                this.carouselLeftVisible = true
                this.carouselRightVisible = true
            }
        },
        async likePost(postID){
            const response = await this.callApi('post','api/post/like',{
                user:this.user,
                postID:postID
            })
            if (response.status == 200){
                if (response.data == 1){
                    this.liked = true
                    this.les = this.likes + 1
                }else{
                    this.liked = false
                    this.les = this.likes - 1
                }
            }
        },
        onInput(event) {
          this.comment = event.data
        },
        showComments(){
            this.commentsIsShowing = !this.commentsIsShowing
        },
        async addComment(postID){
            const response = await this.callApi('post','api/post/comment',{
                user:this.user,
                postID:postID,
                comment:this.comment
            })
            if (response.status == 200){
                this.comment = ''
                this.comments.push(response.data[response.data.length-1])
            }else{
                this.e("OOPs Something went wrong Failed to add the comment!!!")
            }
        },
        async follow(followingID){
            const response = await this.callApi('post','api/user/follow',{
                user:this.user,
                willFollow:followingID
            })

            if (response.status == 200){
                if (response.data == 1){
                    this.isF = true
                    this.fers = this.followers + 1
                }else{
                    this.isF = false
                    this.fers = this.followers - 1
                }
            }else{
                this.e("OOPs Something went wrong Failed to add the comment!!!")
            }
        }   

    },

    async created() {
        if(this.post.likes != undefined)
        {   
             if(this.post.likes[0] != undefined){
                if(this.user == this.userLikedId && this.post.likes[0].liked == 1){
                    this.liked = true
                }else{
                    this.liked = false
                }
            }
        }

        // i don't like this api call
        const response = await this.callApi('post','api/getUserPosts',{
            user:this.post.user_id
        })
		if (response.status == 200){
			this.userPosts = response.data
		}

        this.isF
        this.fers
        this.les
    },
}
</script>


<style scoped>
    .post-con{
        width: 100%;
        background-color: var(--nav-light);
        border: 1px solid rgb(var(--border));
        border-radius: 5px;
        margin-bottom: 1em;
    }


    .post-footer-icons,.avatar,.post-footer-liked,.drop-avatar,.drop-follow{
        display: flex;
    }

    .drop-avatar .avatar-name-con{
        align-self: center;
        margin-left: 1em;
    }

    .drop-avatar .avatar-img{
        width: 70px;
        height: 70px;
    }

    .avatar,.drop-avatar{
        padding: 0.6em;
    }

    .avatar-text-con{
        margin-left: 20px;
    }

    .avatar-name,.avatar-location{
        color: rgb(38, 38, 38);
        text-decoration: none;
    }

    .avatar-name{
        font-weight: 600;
        font-size: 0.9em;        
    }

    .avatar-location{
        font-size: 0.8em;
    }

    .avatar-name-con{
        margin-bottom: -4px;
    }

    .avatar-img,.post-add-comment-avatar{
        width: 42px;
        height: 42px;
    }

    .post-img img{
        width: 100%;
    }

    .post-footer-con{
        padding: 0px 1em;
    }


    .post-footer-liked{
        margin: 10px 0px;
    }

   .post-footer-liked-text{
       margin-top: 3px;
   }

   .post-date p{
       font-size: 10px;
   }

   .post-comment-button{
       font-size: 2em;
   }

   .post-add-comment{
       margin-top: 1em;
       padding: 0.5em 0.7em;
       border-top: 1px solid rgb(var(--border));
       display: flex;
       justify-content: space-between;
       text-align: left;
       align-items: center;
   }

   .post-images-carousel{
       width: 100%;
   }

   .carosel-con{
       position: relative;
   }

   .carousel-image{
       width: 100%;
   }

   .red{
        color: red;
        animation-name: heart;
        animation-duration: 0.5s;
        animation-timing-function: ease-in-out;
   }

   .show-comments-msg{
       padding-left: 1em;
       font-weight: 700;
   }

   .show-comments-msg:hover{
       cursor: pointer;
   }

   .drop-menu{
       width: 500px;
   }

   .drop-follow{
       border-top: 1px solid rgb(var(--border));
       border-bottom: 1px solid rgb(var(--border));
       text-align: center;
   }

   .drop-posts-number,.drop-followers-number{
       border-right: 1px solid rgb(var(--border));
   }

   .drop-posts-number,.drop-followers-number,.drop-following-number{
       padding: 1em 2em;
       width: 32%;
   }

   .drop-images{
       display: flex;
       justify-content: space-evenly;
       padding: 1em;
   }

   .drop-images img{
       width: 30%;
   }

   .drop-follow-buttons-con{
       padding: 1em;
   }

    .drop-follow-buttons-con button{
        width: 45%;
    }

    @keyframes heart{
        0%{transform: scale(1);}
        25%{transform: scale(1.25);}
        50%{transform: scale(1.25);}
        75%{transform: scale(1.25);}
        100%{transform: scale(1);}
    }
   

    @media only screen and (max-width: 1000px) {
        .post-con{
            width: 100%;
        }
    }
</style>