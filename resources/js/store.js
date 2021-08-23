import axios from 'axios'
import Vue from 'vue'
import vuex from 'vuex'
import common from './common'
Vue.use(vuex)

export default new vuex.Store({
    state:{
        status: '',
        jwt: localStorage.getItem('jwt') || '',
        user: '',
        avatar:''
    },

    getters:{
        isLoggedIn: state => !!state.jwt,
        authStatus: state => state.status,
        user: state => state.user,
        avatar:state => state.avatar,
    },

    mutations:{
        auth_request(state){
            state.status = 'loading'
          },
          auth_success(state, jwt, user){
            state.status = 'success'
            state.jwt = jwt
            state.user = user
          },
          auth_error(state){
            state.status = 'error'
          },
          logout(state){
            state.status = ''
            state.jwt = ''
            state.user = ''
          },
          setAvatar(state,avatar){
              state.avatar = avatar
          }
    },

    actions:{
        async login({commit},user){
            commit('auth_request')
            const response = await common.methods.callApi('post','api/login',user)
            
            if (response.status == 200){
                const jwt = response.data.success.token
                const user = response.data.user.id
                localStorage.setItem('jwt',jwt)
                localStorage.setItem('user',user)
                axios.defaults.headers.common['Authorization'] = jwt
                commit('auth_success',jwt,user)
            } else{
                commit('auth_error')
                localStorage.removeItem('jwt')
            }

            return response

        },

        async register({commit},user){
            commit('auth_request')
            const response = await common.methods.callApi('post','api/register',user)
            
            if (response.status == 200){
                const jwt = response.data.success.token
                const user = response.data.user.id
                localStorage.setItem('jwt',jwt)
                localStorage.setItem('user',user)
                axios.defaults.headers.common['Authorization'] = jwt
                commit('auth_success',jwt,user)
            } else{
                commit('auth_error')
                localStorage.removeItem('jwt')
            }

            return response

        },

        async getAvatar({commit},user){
            const response = await common.methods.callApi('post','api/user/getDetails',{user})
            if (response.status == 200){
                commit('setAvatar',response.data.user.avatar)
            }
            return response
        },

        logout({commit}){
            return new Promise((resolve, reject) => {
              commit('logout')
              localStorage.removeItem('jwt')
              localStorage.removeItem('user')
              delete axios.defaults.headers.common['Authorization']
              resolve()
            })
        }
    }

})