<template lang="">
    <div>
        <Form ref="formRegister" :model="formRegister" :rules="ruleRegister" inline class="register-form">

            <FormItem prop="name" >
                <Input  class="register-formInput" type="text" v-model="formRegister.name" placeholder="Username">
                    <Icon type="ios-person-outline" slot="prepend"></Icon>
                </Input>
            </FormItem>

            <FormItem prop="email" >
                <Input  class="register-formInput" type="text" v-model="formRegister.email" placeholder="Email">
                    <Icon type="ios-mail-outline" slot="prepend"></Icon>
                </Input>
            </FormItem>

            <FormItem prop="password" >
                <Input class="register-formInput"  type="password" v-model="formRegister.password" placeholder="Password">
                    <Icon type="ios-lock-outline" slot="prepend"></Icon>
                </Input>
            </FormItem>
            <FormItem prop="password_confirmation" >
                <Input class="register-formInput"  type="password" v-model="formRegister.password_confirmation" placeholder="Confirm Password">
                    <Icon type="ios-lock-outline" slot="prepend"></Icon>
                </Input>
            </FormItem>

            <FormItem>
                <Button type="primary" @click="handleSubmit('formRegister')">Register</Button>
            </FormItem>

        </Form>
    </div>
</template>
<script>
export default {
    data() {
        // Data Start
        return {
            formRegister: {
                    name: '',
                    password: '',
                    email:'',
                    password_confirmation:''
                },
            ruleRegister: {
                name: [
                    { 
                        required: true, 
                        message: 'Please fill in the User Name', 
                        trigger: 'blur' 
                    }
                ],

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

                password_confirmation: [
                    {
                        validator: this.validatePassCheck, 
                        trigger: 'blur' 
                    },
                    {
                        min:6,
                        message:'Please enter at least 6 bits'
                    }
                ],
            }

        }

    },
    // Data Ends

     methods: {
        handleSubmit(name) {
            this.$refs[name].validate(async(valid) => {
                if (valid){

                 const response = await this.$store.dispatch('register',
                    {
                        email:this.formRegister.email,
                        password:this.formRegister.password,
                        name:this.formRegister.name,
                        password_confirmation:this.formRegister.password_confirmation
                    })
                    if (response.status == 200){
                        this.s("Thank you for registering :)")
                        window.location.href = '/'
                        const res = await this.callApi('post','api/post/create',{
                            user : localStorage.getItem('user'),
                            location:"instgram",
                            desc:"Just made an instgram account",
                            postImages:[{name:'1.jpeg'}]
                        })
                    }else{
                        this.e("OOPs Something went wrong Please try again !!! :(")
                    }
                }else {
                    this.$Message.error('Fail!');
                }
            })
        },

        validatePassCheck(rule, value, callback){
            if (value === '') {
                return callback(new Error('Please enter yourpassword again'));
            } else if (value !== this.formRegister.password) {
                return callback(new Error('Passwords do notmatch twice'));
            } else {
                callback();
            }
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