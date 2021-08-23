<template lang="">
    <div>
        <MyNav></MyNav>
        <div class="router-con">
          <router-view />
        </div>
    </div>

   
</template>
<script>
import MyNav from './layouts/nav.vue';
export default {
    data() {
        return {
            
        }
    },
    components:{
        'MyNav' : MyNav
    },

   created: function () {
    this.$http.interceptors.response.use(undefined, function (err) {
      return new Promise(function (resolve, reject) {
        if (err.status === 401 && err.config && !err.config.__isRetryRequest) {
          this.$store.dispatch(logout)
        }
        throw err;
      });
    });
  }
}
</script>
<style scoped>
  .router-con{
    padding: 8em 3em 0px 3em;
  }

   @media only screen and (max-width: 700px) {
        .router-con{
          padding: 8em 0px 0px 0em;
        }
    }
</style>