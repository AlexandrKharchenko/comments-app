<template>
    <div>
        <form v-on:submit.prevent="replyTo">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" v-model="commentText" class="form-control flat" placeholder="Enter your comment" />
                    <span class="input-group-btn">
                        <button class="btn btn-secondary flat" type="submit" >Reply</button>
                    </span>
                </div>

            </div>
        </form>

    </div>
</template>
<style>
</style>
<script>
    export default {
        props: ['comment'],
        data() {
            return {
                commentText: ''
            }
        },
        methods: {
            replyTo() {
                this.$http.post('/api/comments/reply', {
                    comment: this.commentText,
                    parent_id: this.comment.id,

                }).then(response => {

                    CommentsEvent.fire('getComments');
                    CommentsEvent.fire('replySuccess');



                });
            }
        }
    }
</script>