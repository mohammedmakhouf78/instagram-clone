import Vue from 'vue'
import Router from 'vue-router'
import home from './components/home/home.vue'
import login from './components/login/login.vue'
import register from './components/register/register.vue'
import secure from './components/secure.vue'
import store from './store'
import profile from './components/profile/profile.vue'
Vue.use(Router)

const router = new Router({
    mode:'history',
    routes:[
        {
            path:'/',
            component:home,
            name:'home',
            meta: {
                requiresAuth: true
            }
        },
    
        {
            path:'/login',
            component:login,
            name:'login',
            meta: {
                requiresNotAuth: true
            }
        },
        
        {
            path:'/register',
            component:register,
            name:'register',
            meta: {
                requiresNotAuth: true
            }
        },
    
        {
            path:'/profile',
            component:profile,
            name:'profile',
            meta: {
                requiresAuth: true
            }
        },

        {
            path:'/secure',
            component:secure,
            name:'secure',
            meta: {
                requiresAuth: true
            }
        },
    
    ]
})

router.beforeEach((to,from,next) => {
        if(to.matched.some(record => record.meta.requiresAuth)){
            if (store.getters.isLoggedIn){
                next()
                return
            }
            next('/login')
    
        }else{
            next()
        }
        if(to.matched.some(record => record.meta.requiresNotAuth)){
            if (!store.getters.isLoggedIn){
                next()
                return
            }
            next('/')
    
        }else{
            next()
        }
    })

export default router

// export default new Router({
//     mode:'history',
//     routes
// }).beforeEach((to,from,next) => {
//     if(to.matched.some(record.meta.requiresAuth)){
//         if (store.getters.isLoggedIn){
//             next()
//             return
//         }
//         next('/login')

//     }else{
//         next()
//     }
// })