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

        <div class="col-md-12">
            <CommentFeed :comments="comments"></CommentFeed>
        </div>
    </div>


</template>

<script>
    import CommentFeed from './comments-feed.vue';
    export default {
        mounted() {
            this.getComments();
        },
        created(){
            CommentsEvent.listen('getComments' , () => {
                this.getComments();
            });
        },
        components: {
            CommentFeed
        },
        data() {
            return {
                authUser: {},
                newComments: {
                    comment: ''
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

                    this.$http.post('/api/comments/store' , this.newComments ).then(
                        (response) => {
                            this.getComments();

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
            },
            getComments(){

                this.$http.get('/api/comments/all').then(
                    (response) => {
                        this.comments = response.data;

                    },
                    (error) => {

                    }
                );

            }
        },

    }
</script>
