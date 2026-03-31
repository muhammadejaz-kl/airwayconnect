<script>
    const csrfToken = "{{ csrf_token() }}";
    const forumId = "{{ $forum->id }}";

    function sendAction(data, callback) {
        fetch("{{ route('user.forum.action') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(response => {
                if (callback) callback(response);
            })
            .catch(() => {
                console.error('Action failed');
            });
    }

    // Toggle reply input box
    document.addEventListener('click', e => {
        if (e.target.closest('.toggle-replies')) {
            const btn = e.target.closest('.toggle-replies');
            const commentId = btn.dataset.commentId;
            const replyBox = document.querySelector(`.reply-input[data-parent-id="${commentId}"]`).parentElement;
            replyBox.classList.toggle('hidden');
        }
    });

    // Forum Like
    document.getElementById('like-btn').addEventListener('click', () => {
        const btn = document.getElementById('like-btn');
        const outlineIcon = btn.querySelector('.outline-icon');
        const filledIcon = btn.querySelector('.filled-icon');

        sendAction({
            action: 'like_forum',
            forum_id: forumId
        }, data => {
            document.getElementById('likes-count').innerText = `${data.likes_count} Likes`;

            if (data.status === 'liked') {
                btn.classList.add('liked');
                outlineIcon.classList.add('d-none');
                filledIcon.classList.remove('d-none');
                filledIcon.classList.add('like-animate');
            } else {
                btn.classList.remove('liked');
                outlineIcon.classList.remove('d-none');
                filledIcon.classList.add('d-none');
                outlineIcon.classList.add('like-animate');
            }

            setTimeout(() => {
                outlineIcon.classList.remove('like-animate');
                filledIcon.classList.remove('like-animate');
            }, 300);
        });
    });

    // Add Comment
    document.getElementById('comment-btn').addEventListener('click', () => {
        const btn = document.getElementById('comment-btn');
        const comment = document.getElementById('comment-input').value.trim();
        if (!comment) return;

        btn.textContent = 'Posting...';

        sendAction({
            action: 'add_comment',
            forum_id: forumId,
            comment
        }, data => {
            document.getElementById('comment-list').insertAdjacentHTML('afterbegin', data.comment_html);
            document.getElementById('comments-count').innerText = `${data.comment_count} Comments`;
            document.getElementById('comment-input').value = '';
            btn.textContent = 'Post';
        });
    });

    // Like Comment
    document.addEventListener('click', e => {
        if (e.target.closest('.comment-like-btn')) {
            const btn = e.target.closest('.comment-like-btn');
            const outlineIcon = btn.querySelector('.outline-icon');
            const filledIcon = btn.querySelector('.filled-icon');
            const span = btn.querySelector('span');

            sendAction({
                action: 'like_comment',
                comment_id: btn.dataset.id
            }, data => {
                span.innerText = data.likes_count;

                if (data.status === 'liked') {
                    btn.classList.add('liked');
                    outlineIcon.classList.add('d-none');
                    filledIcon.classList.remove('d-none');
                    filledIcon.classList.add('like-animate');
                } else {
                    btn.classList.remove('liked');
                    outlineIcon.classList.remove('d-none');
                    filledIcon.classList.add('d-none');
                    outlineIcon.classList.add('like-animate');
                }

                setTimeout(() => {
                    outlineIcon.classList.remove('like-animate');
                    filledIcon.classList.remove('like-animate');
                }, 300);
            });
        }
    });

    // Like Reply
    document.addEventListener('click', e => {
        if (e.target.closest('.reply-like-btn')) {
            const btn = e.target.closest('.reply-like-btn');
            const outlineIcon = btn.querySelector('.outline-icon');
            const filledIcon = btn.querySelector('.filled-icon');
            const span = btn.querySelector('span');

            sendAction({
                action: 'like_reply',
                reply_id: btn.dataset.id
            }, data => {
                span.innerText = data.likes_count;

                if (data.status === 'liked') {
                    btn.classList.add('liked');
                    outlineIcon.classList.add('d-none');
                    filledIcon.classList.remove('d-none');
                    filledIcon.classList.add('like-animate');
                } else {
                    btn.classList.remove('liked');
                    outlineIcon.classList.remove('d-none');
                    filledIcon.classList.add('d-none');
                    outlineIcon.classList.add('like-animate');
                }

                setTimeout(() => {
                    outlineIcon.classList.remove('like-animate');
                    filledIcon.classList.remove('like-animate');
                }, 300);
            });
        }
    });

    // Add Reply
    document.addEventListener('click', e => {
        if (e.target.closest('.send-reply')) {
            const btn = e.target.closest('.send-reply');
            const parentId = btn.dataset.parentId;
            const input = document.querySelector(`.reply-input[data-parent-id="${parentId}"]`);
            const replyText = input.value.trim();

            if (!replyText) return;

            btn.textContent = 'Posting...';

            sendAction({
                action: 'add_reply',
                comment_id: parentId,
                reply: replyText
            }, data => {
                if (data.status === 'success') {
                    document.querySelector(`#replies-${parentId}`).insertAdjacentHTML('beforeend', data.reply_html);
                    input.value = '';
                    btn.textContent = 'Post';

                    const replyBtn = document.querySelector(`.toggle-replies[data-comment-id="${parentId}"] span`);
                    if (replyBtn) {
                        let count = parseInt(replyBtn.textContent.match(/\d+/)) || 0;
                        replyBtn.textContent = `Reply (${count + 1})`;
                    }
                }
            });
        }
    });

    // Load More Comments
    document.addEventListener('click', e => {
        if (e.target.closest('#load-more-comments')) {
            const btn = e.target.closest('#load-more-comments');
            const nextPage = btn.dataset.nextPage;

            btn.textContent = 'Loading...';

            sendAction({
                action: 'load_more_comments',
                forum_id: forumId,
                page: nextPage.split('=')[1]
            }, data => {
                document.getElementById('comment-list').insertAdjacentHTML('beforeend', data.comments_html);
                if (data.next_page) {
                    btn.dataset.nextPage = data.next_page;
                    btn.textContent = 'Load More Comments';
                } else {
                    btn.remove();
                }
            });
        }
    });

    // Load More Replies
    document.addEventListener('click', e => {
        if (e.target.closest('.load-more-replies')) {
            const btn = e.target.closest('.load-more-replies');
            const commentId = btn.dataset.commentId;
            const offset = btn.dataset.offset || 2;

            btn.textContent = 'Loading replies...';

            sendAction({
                action: 'load_more_replies',
                comment_id: commentId,
                offset: offset
            }, data => {
                if (data.replies_html) {
                    document.querySelector(`#replies-${commentId}`).insertAdjacentHTML('beforeend', data.replies_html);
                    btn.dataset.offset = parseInt(offset) + data.loaded;
                    if (!data.has_more) {
                        btn.remove();
                    } else {
                        btn.textContent = 'View more pending replies';
                    }
                }
            });
        }
    });
</script>

<!-- <script>
    const csrfToken = "{{ csrf_token() }}";
    const forumId = "{{ $forum->id }}";

    function sendAction(data, callback) {
        fetch("{{ route('user.forum.action') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(response => {
                if (response.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
                if (callback) callback(response);
            })
            .catch(() => {
                Swal.fire('Error', 'Something went wrong!', 'error');
            });
    }

    // Toggle reply input box
    document.addEventListener('click', e => {
        if (e.target.closest('.toggle-replies')) {
            const btn = e.target.closest('.toggle-replies');
            const commentId = btn.dataset.commentId;
            const replyBox = document.querySelector(`.reply-input[data-parent-id="${commentId}"]`).parentElement;
            replyBox.classList.toggle('hidden');
        }
    });

    // Forum Like
    document.getElementById('like-btn').addEventListener('click', () => {
        const btn = document.getElementById('like-btn');
        const icon = btn.querySelector('.like-icon');

        sendAction({
            action: 'like_forum',
            forum_id: forumId
        }, data => {
            document.getElementById('likes-count').innerText = `${data.likes_count} Likes`;

            if (data.status === 'liked') {
                btn.classList.add('liked');
            } else {
                btn.classList.remove('liked');
            }

            icon.classList.add('like-animate');
            setTimeout(() => icon.classList.remove('like-animate'), 400);
        });
    });


    // Add Comment
    document.getElementById('comment-btn').addEventListener('click', () => {
        const btn = document.getElementById('comment-btn');
        const comment = document.getElementById('comment-input').value.trim();
        if (!comment) {
            Swal.fire('Error', 'Please enter a comment!', 'error');
            return;
        }
        btn.textContent = 'Posting...';

        sendAction({
            action: 'add_comment',
            forum_id: forumId,
            comment
        }, data => {
            document.getElementById('comment-list').insertAdjacentHTML('afterbegin', data.comment_html);
            document.getElementById('comments-count').innerText = `${data.comment_count} Comments`;
            document.getElementById('comment-input').value = '';
            btn.textContent = 'Post';
        });
    });

    // Like Comment
    document.addEventListener('click', e => {
        if (e.target.closest('.comment-like-btn')) {
            const btn = e.target.closest('.comment-like-btn');
            const icon = btn.querySelector('.like-icon');
            const span = btn.querySelector('span');

            sendAction({
                action: 'like_comment',
                comment_id: btn.dataset.id
            }, data => {
                span.innerText = data.likes_count;

                if (data.status === 'liked') {
                    btn.classList.add('liked');
                } else {
                    btn.classList.remove('liked');
                }

                icon.classList.add('like-animate');
                setTimeout(() => icon.classList.remove('like-animate'), 400);
            });
        }
    });


    // Like Reply
    document.addEventListener('click', e => {
        if (e.target.closest('.reply-like-btn')) {
            const btn = e.target.closest('.reply-like-btn');
            const icon = btn.querySelector('.like-icon');
            const span = btn.querySelector('span');

            sendAction({
                action: 'like_reply',
                reply_id: btn.dataset.id
            }, data => {
                span.innerText = data.likes_count;

                if (data.status === 'liked') {
                    btn.classList.add('liked');
                } else {
                    btn.classList.remove('liked');
                }

                icon.classList.add('like-animate');
                setTimeout(() => icon.classList.remove('like-animate'), 400);
            });
        }
    });


    // Add Reply
    document.addEventListener('click', e => {
        if (e.target.closest('.send-reply')) {
            const btn = e.target.closest('.send-reply');
            const parentId = btn.dataset.parentId;
            const input = document.querySelector(`.reply-input[data-parent-id="${parentId}"]`);
            const replyText = input.value.trim();

            if (!replyText) {
                Swal.fire('Error', 'Please enter a reply!', 'error');
                return;
            }

            btn.textContent = 'Posting...';

            sendAction({
                action: 'add_reply',
                comment_id: parentId,
                reply: replyText
            }, data => {
                if (data.status === 'success') {
                    document.querySelector(`#replies-${parentId}`).insertAdjacentHTML('beforeend', data.reply_html);
                    input.value = '';
                    btn.textContent = 'Post';

                    const replyBtn = document.querySelector(`.toggle-replies[data-comment-id="${parentId}"] span`);
                    if (replyBtn) {
                        let count = parseInt(replyBtn.textContent.match(/\d+/)) || 0;
                        replyBtn.textContent = `Reply (${count + 1})`;
                    }
                }
            });
        }
    });

    // Load More Comments
    document.addEventListener('click', e => {
        if (e.target.closest('#load-more-comments')) {
            const btn = e.target.closest('#load-more-comments');
            const nextPage = btn.dataset.nextPage;

            btn.textContent = 'Loading...';

            sendAction({
                action: 'load_more_comments',
                forum_id: forumId,
                page: nextPage.split('=')[1]
            }, data => {
                document.getElementById('comment-list').insertAdjacentHTML('beforeend', data.comments_html);
                if (data.next_page) {
                    btn.dataset.nextPage = data.next_page;
                    btn.textContent = 'Load More Comments';
                } else {
                    btn.remove();
                }
            });
        }
    });

    // Load More Replies
    document.addEventListener('click', e => {
        if (e.target.closest('.load-more-replies')) {
            const btn = e.target.closest('.load-more-replies');
            const commentId = btn.dataset.commentId;
            const offset = btn.dataset.offset || 2;

            btn.textContent = 'Loading replies...';

            sendAction({
                action: 'load_more_replies',
                comment_id: commentId,
                offset: offset
            }, data => {
                if (data.replies_html) {
                    document.querySelector(`#replies-${commentId}`).insertAdjacentHTML('beforeend', data.replies_html);
                    btn.dataset.offset = parseInt(offset) + data.loaded;
                    if (!data.has_more) {
                        btn.remove();
                    } else {
                        btn.textContent = 'View more pending replies';
                    }
                } else {
                    Swal.fire('Info', 'No more replies available!', 'info');
                }
            });
        }
    });
</script> -->