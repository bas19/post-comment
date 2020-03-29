<template>
    <div class="col-md-12">
        <div ng-if="comments.length"  class="comment-form">
            <div v-for="comment in comments" :key="comment.id" class="card d-flex flex-column">
                <div class="card-header">
                    <div class="user-icon"><i class="fa fa-user"> {{ comment.name }}</i></div>
                </div>
                <div class="card-body">
                    <p><i class="fa fa-comments"></i> {{ comment.message }}</p>
                </div>
                <div class="child">
                    <ul>
                        <comment-list-component v-for="child in comment.grandchildren" :key="child.id" :comment="child"></comment-list-component>
                    </ul>
                </div>
                <div class="card-footer">
                    <div class="add-comment" v-if="comment.add_comment">
                        <form-component  v-on:cancel="cancel(comment)" :post="post_id" :showCancel="true" :selectedComment="selectedComment"/>
                    </div>
                    <div class="text-right">
                        <button v-if="!comment.add_comment" @click="addComment(comment)" type="button" class="btn btn-default">Add Comment</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="no-comment" v-if="comments.length === 0">No comment yet... <br></div>
        <form-component :post="post_id" selected-comment=""/>
    </div>
</template>

<script>
    export default {
        created() {
            this.getComments(this.post_id)
        },
        data () {
            return {
                comments: this.$store.state.comments,
                post_id: 1, // default post id
                selectedComment: ''
            }
        },
        methods: {
            cancel(comment) {
                comment.add_comment = false  
            },
            hasChild(comment) {
                if (comment.grandchildren.length > 0) {
                    return true
                }
                return false
            },
            getComments(post_id) {
                axios.get('/api/comments/post/' + post_id)
                    .then(data => {
                        let result;
                        data.data.forEach(element => {
                            result = this.modifyCommentData(element);
                            this.comments.push(result)
                            // check for child comments
                            if (this.hasChild(element)) {
                                element.grandchildren.forEach(item => {
                                    this.modifyCommentData(item)
                                })
                            }
                        });
                        this.$store.commit('set_comments', this.comments)
                    }).catch(err => {
                    console.log(err)
                })
            },
            modifyCommentData(data) {
                // add_comment is used in frontend dynamic comments identifier to toggle the form
                data.add_comment = false
                return data
            },
            addComment(comment) {
                this.selectedComment = comment
                this.$store.commit('show_form_comment', comment)
            },
            cancelComment(comment) {
                comment.add_comment = false
            }
        },
    }
</script>
