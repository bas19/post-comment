let mutations = {
    update_comment(state, comment) {
        let parent = comment.parent_comment_id;
        if (state.comments.length > 0) {
            if (parent === null) {
                // for first level comment
                comment.add_comment = false
                comment.grandchildren = [];
                state.comments.push(comment)
            } else {
                state.comments.forEach(element => {
                    // for second level comment
                    if (element.id === parent) {
                        comment.add_comment = false;
                        comment.grandchildren = []
                        element.grandchildren.push(comment)
                    }
                    // for third level comment
                    if (element.grandchildren.length > 0) {
                        element.grandchildren.forEach(item => {
                            if (item.id === parent) {
                                comment.grandchildren = []
                                item.grandchildren.push(comment)
                            }
                        })
                    }
                })
            }
        } else {
            comment.add_comment = false;
            comment.grandchildren = [];
            state.comments.push(comment)
        }
    },
    set_comments(state, comments) {
        state.comments = comments
    },
    show_form_comment(state, comment) {
        state.comments.forEach(element => {
            if (element.id === comment.id) {
                element.add_comment = true
            }
        })
    }
}
export default mutations