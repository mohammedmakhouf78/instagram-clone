<template lang="">
    <div>
        <Form ref="formLogin" :model="formLogin" :rules="ruleRegister" inline class="register-form">
            <FormItem prop="email" >
                <Input  class="register-formInput" type="text" v-model="formLogin.email" placeholder="Email">
                    <Icon type="ios-mail-outline" slot="prepend"></Icon>
                </Input>
            </FormItem>

            <FormItem prop="password" >
                <Input class="register-formInput"  type="password" v-model="formLogin.password" placeholder="Password">
                    <Icon type="ios-lock-outline" slot="prepend"></Icon>
                </Input>
            </FormItem>

            <FormItem>
                <Button type="primary" @click="handleSubmit('formLogin')">Log In</Button>
            </FormItem>
        </Form>
    </div>
</template>
<script>
export default {

    // Data Start
    data() {
        return {
            formLogin: {
                    password: '',
                    email:'',
                },
            ruleRegister: {
                email: [
                    { 
                        required: true, 
                        message: 'Mailbox cannot be empty', 
                        trigger: 'blur' 
                    },
                    { 
                        type: 'email', 
                        message: 'Incorrect email format', 
                        trigger: 'blur' 
                    }
                ],

                password: [
                    { 
                    required: true, 
                    message: 'Please fill in thepassword.', 
                    trigger: 'blur' 
                    },
                    { 
                    type: 'string', 
                    min: 6, message: 
                    'The password length cannot be less than 6 bits', trigger:'blur' 
                    }
                ],
            }
        }
    },
    // Data Ends

    methods: {
         handleSubmit(name) {
            this.$refs[name].validate(async(valid) => {
                if (valid) {
                    const response = await this.$store.dispatch('login',
                    {
                        email:this.formLogin.email,
                        password:this.formLogin.password
                    })

                    if (response.status == 200){
                        this.s("You are Logged in!! welcome!!! :)")
                        window.location.href = '/'
                    }else{
                        this.e("OOPs Something went wrong Please try again !!! :(")
                    }
                } else {
                    this.$Message.error('Fail!');
                }
            })
        },
    }

}
</script>
<style scoped>
    .register-form{
        min-width: 30em;
        max-width: 40%;
        margin: 0 auto;
        text-align: center;
        padding: 2em;
        display: flex;
        flex-direction: column;
    }
</style>