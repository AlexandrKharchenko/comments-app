<template>
    <form action="" method="post" v-on:submit.prevent="login('login')" data-vv-scope="login">
        <div class="form-group" v-bind:class="{ 'has-error': errors.has('login.email') }">
            <label for="login_email">Email</label>
            <input id="login_email" type="email" name="email" class="form-control" placeholder="Email" v-validate="'required|email'" data-vv-as="email" v-model="email" />
            <span v-show="errors.has('login.email')" class="help-block">{{ errors.first('login.email') }}</span>
        </div>
        <div class="form-group" v-bind:class="{ 'has-error': errors.has('login.password') }">
            <label for="login_psw">Email</label>
            <input type="password" id="login_psw" name="password" class="form-control" placeholder="Пароль" v-validate="'required'" data-vv-as="пароль" v-model="password" />
            <span v-show="errors.has('login.password')" class="help-block">{{ errors.first('login.password') }}</span>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Войти</button>
        </div>

    </form>
</template>

<script>
    export default {
        mounted() {

        },
        data() {
            return {
                email: 'admin@admin.com',
                password: 'admin',
                remember: false,
            }

        },
        methods: {
            login(scope){
                this.$validator.validateAll(scope).then((result) => {
                    if(!result)
                        return false;

                    let authData = {
                        email: this.email,
                        password: this.password,
                        remember: this.remember,
                    };

                    this.$http.post('/auth/login', authData ).then(
                        (response) => {

                            if(response.data.login)
                                window.location  = '/admin';


                        },
                        (error) => {
                            $.toast({
                                icon: 'error',
                                heading: 'Ошибка',
                                text: 'Логин или пароль неверный',
                                position: 'top-right',
                                showHideTransition: 'slide',

                            });
                        }
                    );


                })
            }
        }
    }
</script>
