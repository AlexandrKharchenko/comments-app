<template>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <form action="" method="post" v-on:submit.prevent="store('store')" data-vv-scope="store">

                <div class="form-group" v-bind:class="{ 'has-danger': errors.has('store.comment') }">
                    <label for="new_comment">Your comment</label>
                    <textarea id="new_comment" name="comment" rows="7"
                              v-validate="'required'"
                              placeholder="Your comment" data-vv-as="comment" v-model="newComments.comment" class="form-control flat"></textarea>

                    <div v-show="errors.has('store.comment')" class="form-control-feedback">{{ errors.first('store.comment') }}</div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block flat">Comment</button>
                </div>

            </form>
        </div>
    </div>

</template>

<script>
    export default {
        mounted() {

        },
        data() {
            return {
                authUser: {},
                newComments: {
                    comment: ''
                },
                replyComment: {
                    replyCommentId: null,
                    comment: '',
                },
                comments: [],
                editComments: [],
            }

        },
        methods: {
            store(scope){
                this.$validator.validateAll(scope).then((result) => {
                    if(!result)
                        return false;

                    this.$http.post('/auth/login' ).then(
                        (response) => {


                            if(response.status === 200)
                                window.location  = '/comments';


                        },
                        (error) => {
                            $.toast({
                                icon: 'error',
                                heading: 'Ошибка',
                                text: 'Login or password not valid',
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
