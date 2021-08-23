export default {
    data() {
        return {
            
        }
    },
    methods: {
        async callApi(method,url,dataObj){
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                });
            } catch (error) {
                return error.response
            }
        },

        i (desc,title="Info") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },

        s (desc,title="Success") {
            this.$Notice.success({
                itle: title,
                desc: desc
            });
        },

        w (desc,title="Warning") {
            this.$Notice.warning({
                itle: title,
                desc: desc
            });
        },

        e (desc,title="Error") {
            this.$Notice.error({
                itle: title,
                desc: desc
            });
        }
    },
}