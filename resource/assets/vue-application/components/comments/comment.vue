<template>
    <li class="list-group-item">
        <div class="row">

            <div class="col-md-9">
                <div class="comment-text" v-if="!edit">{{ comment.comment }}</div>
                <div class="comment-reply" v-if="replyToComment == comment">
                    <comment-form  :comment="comment"></comment-form>
                </div>
                <div class="edit-form" v-if="edit">
                    <form v-on:submit.prevent="updateComment">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" v-model="editText" class="form-control flat" placeholder="Enter your comment" />
                                <span class="input-group-btn">
                                    <button class="btn btn-primary flat" type="submit" >Update</button>
                                    <button class="btn btn-secondary flat" v-on:click.prevent="edit = false" >Cancel</button>
                                </span>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3">
                <a href="#" class="btn btn-success btn-xs flat" v-on:click.prevent="replyToComment = comment">Reply</a>
                <a href="#" class="btn btn-info btn-xs flat" v-on:click.prevent="setEditComment(comment)">Edit</a>
                <a href="#" class="btn btn-danger btn-xs flat" v-if="user.user_id === comment.user_id" v-on:click.prevent="deleteComment(comment)">Delete</a>
            </div>

            <div class="comment-replies col-md-12" v-if="comment.children">
                <comment-feed  :comments="comment.children"></comment-feed>
            </div>
        </div>



    </li>
</template>
<script>
    import CommentFeed from './comments-feed.vue';
    import CommentForm from './comment-reply-form.vue';
    export default{
        name: 'comment',
        props: ['comment'],
        data(){
            return {
                replyToComment: false,
                edit: false,
                editText: '',
            }
        },
        mounted(){
        },
        created(){
            CommentsEvent.listen('replySuccess' , () => {
                this.replyToComment = false;
            });


        },
        components: {
            CommentForm,
            CommentFeed

        },
        computed: {
            user(){
                return this.$store.state.authUserState;
            }
        },
        methods: {
            deleteComment(comment){

            },
            updateComment(comment){

            },
            setEditComment(comment){
                this.edit = !this.edit;
                this.editText = comment.comment;
            }
        }
    }
</script>