<template>
    <div class="comment-form">
        <form>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" v-model="name" class="form-control" id="name" placeholder="Enter your name">
            </div>
            <div class="form-group">
                <label for="comment">Comments</label>
                <textarea v-model="message" class="form-control" id="comment" rows="3"></textarea>
            </div>
            <button @click="postComment()" type="button" class="btn btn-primary">Post Comment</button>
            <button v-if="showCancel" @click="cancelComment()" type="button" class="btn btn-default">Cancel</button>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['post','selectedComment', 'showCancel'],
        data () {
            return {
                name: '',
                message: '',
                add_comment_message: '',
                parent_comment_id: null,
                nested_level: 0,
            }
        },
        methods: {
            cancelComment() {
                this.$emit('cancel');
            },
            validate(data) {

                if (data.name == '' || data.message == '') {
                    alert('Please check fields or some field is empty!')
                    return false
                }

                let max = 1000;
                
                if (data.name.length > max || data.message.length > max ) {
                    alert('Please check chracter length!')
                    return false
                }

                return true
            },
            postComment() {

                if (this.selectedComment != undefined) {
                    this.parent_comment_id = this.selectedComment.id

                    if (this.selectedComment.nested_level === 0) {
                        this.nested_level = 1
                    }
                    if (this.selectedComment.nested_level === 1) {
                        this.nested_level = 2
                    }

                }

                // remove malicious data
                let message = this.$sanitize(this.message)
                let name = this.$sanitize(this.name)

                let data = {
                    name: name,
                    message: message,
                    post_id: this.post,
                    parent_comment_id: this.parent_comment_id,
                    nested_level: this.nested_level
                }

                if (this.validate(data)) {
                    axios.post('/api/comments', data)
                        .then(result => {
                            this.message = ''
                            this.$store.commit('update_comment', result.data)
                            if (this.selectedComment != '') {
                                this.selectedComment.add_comment = false
                            }
                        }).catch(err => {
                        console.log(err)
                    })
                }
             
            },
        },
    }
</script>
