<template lang="">
    <div>
        <Menu mode="horizontal" :theme="theme" active-name="1" class="iview-menu">
            <MenuItem name="1" class="logo-con">
                <router-link to="/">
                    <img src="/images/logo.png" alt="">
                </router-link>
            </MenuItem>
            <MenuItem name="search" class="nav-search-con">
                <!-- <Input suffix="ios-search" placeholder="Search" style="width: 200px" /> -->
            </MenuItem>
            <MenuItem name="2-con" class="nav-items-con">
                    <MenuItem name="2" v-if="isLoggedIn">
                    <router-link to="/">
                        <Icon type="ios-home" class="nav-icon" />
                    </router-link>
                </MenuItem>
                <MenuItem name="9" v-if="isLoggedIn">
                    <Dropdown>
                        <a v-if="avatar == null || avatar == ''" href="javascript:void(0)" class="nav-icon">
                            <Avatar class="nav-avatar-img" src="https://i.loli.net/2017/08/21/599a521472424.jpg" />
                        </a>
                        <a v-else href="javascript:void(0)" class="nav-icon">
                            <Avatar class="nav-avatar-img" :src="`/uploads/${avatar}`" />
                        </a>
                        <DropdownMenu slot="list">
                             <router-link to="/profile">
                                <DropdownItem>Profile</DropdownItem>
                            </router-link>
                        </DropdownMenu>
                    </Dropdown>
                </MenuItem>

                <MenuItem name="6" v-if="!isLoggedIn">
                    <router-link to="/login">
                        <Icon type="md-log-in" class="nav-icon" />
                    </router-link>
                </MenuItem>
                <MenuItem name="7" v-if="!isLoggedIn">
                    <router-link to="/register">
                        <Icon type="ios-create" class="nav-icon" />
                    </router-link>
                </MenuItem>
                <MenuItem name="8" v-if="isLoggedIn">
                    <router-link to="/logout">
                        <Icon type="md-log-out" class="nav-icon" @click="logout" />
                    </router-link>
                </MenuItem>
            </MenuItem>
        </Menu>
    </div>
</template>
<script>
export default {
    data() {
        return {
            theme:"dark"
        }
    },

    computed:{
        isLoggedIn: function (){
            return this.$store.getters.isLoggedIn
        },
        avatar:function(){
            return this.$store.getters.avatar
        }
    },

    methods:{
        logout: function() {
            this.$store.dispatch('logout')
            .then(() => {
                window.location.href = '/login'
            })
        }
    },

    async created() {
        if (this.isLoggedIn){
            const response = await this.$store.dispatch('getAvatar',localStorage.getItem('user'))
        }
    },
}
</script>
<style scoped>
    .iview-menu{
        background-color: var(--nav-light);
        padding: 0px 3em;
        border-bottom: 1px solid rgb(var(--border));
        position: fixed;
        width: 100%;
    }

    .logo-con{
        padding-left: 0px;
    }

    .nav-items-con{
        padding-top: 3px;
        float: right;
    }

    .nav-search-con{
        margin-left:6em;
    }

    .nav-avatar-img{
        margin-top: -10px;
    }

    @media only screen and (max-width: 1018px) {
        .nav-search-con{
            display: none;
        }
    }


    @media only screen and (max-width: 775px) {
        .iview-menu{
            padding: 0px;
        }
    }

    @media only screen and (max-width: 606px) {
        .nav-icon{
            margin-left: -22px;
        }
    }
</style>