<template>
    <ul class="list-group">
        <comment v-for="comment in comments" :comment="comment" :key="comment.id"></comment>


    </ul>
</template>
<script>

    export default{
        props: ['comments'],
        components: {

        },
        data() {
            return {

            };
        },
        computed:{
        },
        beforeCreate: function () {
            this.$options.components.Comment = require('./comment.vue')
        }

    }
</script>