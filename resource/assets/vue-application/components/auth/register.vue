<template>
    <div class="register-form">

        <form class="form" v-on:submit.prevent="register('register')" data-vv-scope="register" accept-charset="UTF-8" id="register-form">

            <div class="form-group" v-bind:class="{ 'has-danger': errors.has('register.first_name') }">
                <input type="text" name="first_name" class="form-control" placeholder="first name" v-validate="'required'" data-vv-as="first name" v-model="first_name" />
                <div v-show="errors.has('register.first_name')" class="form-control-feedback">{{ errors.first('register.first_name') }}</div>
            </div>

            <div class="form-group" v-bind:class="{ 'has-danger': errors.has('register.last_name') }">
                <input type="text" name="last_name" class="form-control" placeholder="last name" v-validate="'required'" data-vv-as="last name" v-model="last_name" />
                <div v-show="errors.has('register.last_name')" class="form-control-feedback">{{ errors.first('register.last_name') }}</div>
            </div>

            <div class="form-group" v-bind:class="{ 'has-danger': errors.has('register.email') }">
                <input type="email" name="email" class="form-control" placeholder="Email" v-validate="'required|email'" data-vv-as="email" v-model="email" />
                <div v-show="errors.has('register.email')" class="form-control-feedback">{{ errors.first('register.email') }}</div>
            </div>

            <div class="form-group" v-bind:class="{ 'has-danger': errors.has('register.password') }">
                <input type="password" name="password" class="form-control" placeholder="password" v-validate="'required'" data-vv-as="password" v-model="password" />
                <div v-show="errors.has('register.password')" class="form-control-feedback">{{ errors.first('register.password') }}</div>

            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in" aria-hidden="true"></i> Sign Up</button>
                <div class="help-block text-right"><a href="">Restore password ?</a></div>
            </div>

        </form>



    </div>
</template>

<script>

    export default {
        mounted() {

        },
        data() {
            return {
                first_name: 'Alex',
                last_name: 'Test',
                email: 'admin@admin.com',
                password: 'admin',


            }

        },
        methods: {
            register(scope){
                this.$validator.validateAll(scope).then((result) => {
                    if(!result)
                        return false;

                    this.errors.clear();

                    let registerData = {
                        first_name: this.first_name,
                        last_name: this.last_name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                        remember: this.remember,
                    };

                    this.$http.post('/auth/register', registerData).then(
                        (response) => {

                            if(response.user){
                                window.location = "/account";
                            }

                        },
                        (error) => {
                            if(error.status === 500){

                                this.$toast({
                                    icon: 'error',
                                    heading: 'Ошибка',
                                    text: 'Произошла ошибка на сервере',
                                    position: 'top-right',
                                    showHideTransition: 'slide',

                                });

                            } else {
                                console.log(error.data);
                                /*
                                for (let i in error.data) {
                                    this.errors.add(scope + '.' + i, error.data[i][0]);
                                }
                                */
                            }


                        }
                    );


                })
            }
        }
    }
</script>