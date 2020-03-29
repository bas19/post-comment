<template>
    <li transition="slide">
        <div class="comment-form">
            <div class="card d-flex flex-column">
                <div class="card-header">
                    <div class="user-icon"><i class="fa fa-user"> {{ comment.name }}</i></div>
                </div>
                <div class="card-body">
                    <p><i class="fa fa-comments"></i>  {{ comment.message }}</p>
                </div>
                <div class="card-footer" v-if="comment.nested_level < 2">
                    
                    <div class="child">
                        <ul>
                            <comment-list-component v-for="child in comment.grandchildren" :key="child.id" :comment="child"></comment-list-component>
                        </ul>
                    </div>

                    <div v-if="comment.nested_level < 2" class="text-right">
                        <button v-if="!reply" @click="showForm(comment)" type="button" class="btn btn-default">Add Comment</button>
                    </div>
                    
                    <div class="add-comment" v-if="reply == comment">
                        <form-component v-on:cancel="cancel()" :post="1" :showCancel="true" :selected-comment="comment"/>
                    </div>
                    
                </div>
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        props: ['comment'],
        data () {
            return {
                reply: false,
            }
        },
        methods: {
            hasChild(comment) {
                if (comment.grandchildren != null && comment.grandchildren.length > 0 && comment.nested_level < 2) {
                    return true
                }
                return false
            },
            showForm(comment) {
                this.reply = comment
            },
            cancel(comment) {
                this.reply = false
            }
        }
    }
</script>
