@extends('admin.layouts.master')

@section('content')
<div class="content container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0">
            <i class="fas fa-comments me-2"></i> Forum Details
        </h2>
        <a href="{{ route('admin.forum.forumIndex') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <!-- Forum Header Card -->
    <div class="card shadow-sm rounded-4 border-0 mb-4">
        <ul class="nav nav-tabs nav-tabs-solid nav-justified bg-light rounded-top-4" role="tablist" style="border-bottom: 2px solid #dee2e6;">
            <li class="nav-item">
                <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#tab-info" role="tab">
                    <i class="fas fa-info-circle me-1"></i> Information
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#tab-comments" role="tab">
                    <i class="fas fa-comments me-1"></i> Comments ({{ $comments->total() }})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#tab-restricted" role="tab">
                    <i class="fas fa-user-slash me-1"></i> Restricted Users ({{ count($forum->restricted_ids ?? []) }})
                </a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        <!-- Tab 1: Forum Info -->
        <div class="tab-pane fade show active" id="tab-info" role="tabpanel">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4">
                <div class="relative" style="height: 300px; background: #f5f5f5;">
                    @if($forum->banner)
                    <img src="{{ asset('storage/' . $forum->banner) }}"
                        alt="Forum Banner"
                        class="w-100 h-100 object-fit-cover">
                    @else
                    <div class="d-flex justify-content-center align-items-center w-100 h-100 text-muted fw-bold"
                        style="font-size: 1.5rem;">
                        No Banner
                    </div>
                    @endif
                </div>

                <div class="bg-light px-4 py-5">
                    <h3 class="fw-bold mb-3">{{ $forum->name }}</h3>
                    <p><strong>Description:</strong> {{ $forum->description }}</p>
                    <p><strong>Topics:</strong>
                        @if($topics->isNotEmpty())
                        @foreach($topics as $topicName)
                        <span class="badge bg-info me-1">{{ $topicName }}</span>
                        @endforeach
                        @else
                        <span class="text-muted">No topics available</span>
                        @endif
                    </p>
                    <p><strong>Status:</strong>
                        <span class="badge bg-{{ $forum->status == 1 ? 'success' : 'danger' }}">
                            {{ $forum->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                    <p><strong>Added On:</strong> {{ $forum->created_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Tab 2: Comments -->
        <div class="tab-pane fade" id="tab-comments" role="tabpanel">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4" style="height: 75vh; display: flex; flex-direction: column;">

                <!-- Header (Similar Style as Tab-Info) -->
                <div class="bg-light px-4 py-3 border-bottom">
                    <h4 class="fw-bold mb-0">
                        <i class="fas fa-comments me-2"></i> Comments ({{ $comments->total() }})
                    </h4>
                </div>

                <!-- Scrollable Comments Area -->
                <div id="comment-list" class="px-4 py-3 flex-grow-1 overflow-auto" style="background: #fafafa;">
                    @foreach($comments as $comment)
                    @include('admin.forums.forums.partials.comment', ['comment' => $comment, 'forum' => $forum])
                    @endforeach
                </div>

                <!-- Load More Button (Fixed at Bottom) -->
                @if($comments->hasMorePages())
                <div class="p-3 border-top bg-white">
                    <button class="btn w-100" id="load-more-comments"
                        data-next-page="{{ $comments->nextPageUrl() }}">
                        Load More Comments
                    </button>
                </div>
                @endif
            </div>
        </div>

        <!-- Tab 3: Restricted Users -->
        <div class="tab-pane fade" id="tab-restricted" role="tabpanel">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4" style="height: 75vh; display: flex; flex-direction: column;">

                <!-- Header -->
                <div class="bg-light px-4 py-3 border-bottom">
                    <h4 class="fw-bold mb-0">
                        <i class="fas fa-user-slash me-2"></i> Restricted Users ({{ count($forum->restricted_ids ?? []) }})
                    </h4>
                </div>

                <!-- Content -->
                <div class="flex-grow-1 overflow-auto px-4 py-4" style="background: #fafafa;">
                    @php $restrictedUsers = $forum->restricted_ids ?? []; @endphp

                    @if(count($restrictedUsers) > 0)
                    <div class="d-flex flex-wrap gap-4">
                        @foreach($restrictedUsers as $restrictedId)
                        @php $restrictedUser = \App\Models\User::find($restrictedId); @endphp
                        @if($restrictedUser)
                        <div class="card shadow-sm border-0 rounded-4 text-center p-3" style="width: 150px;">
                            <img src="{{ $restrictedUser->profile ?? 'https://www.shutterstock.com/image-vector/vector-flat-illustration-grayscale-avatar-600nw-2264922221.jpg' }}"
                                class="rounded-circle mb-2 border border-3 border-primary mx-3 shadow"
                                width="80" height="80" style="object-fit: cover;" alt="User">
                            <p class="text-truncate fw-semibold mb-2">{{ $restrictedUser->name }}</p>
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-primary view-user-comments"
                                    data-id="{{ $restrictedUser->id }}" data-forum-id="{{ $forum->id }}" title="View Comments">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-success remove-restrict-user"
                                    data-id="{{ $restrictedUser->id }}" data-forum-id="{{ $forum->id }}" title="Remove Restriction">
                                    <i class="fas fa-user-check"></i>
                                </button>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted text-center mb-0">No restricted users.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Instagram-Style Modal -->
<div class="modal fade" id="restrictedUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-body p-0 d-flex" style="height: 80vh;">
                <!-- Left: Profile Section -->
                <div class="bg-dark d-flex align-items-center justify-content-center" style="flex: 1;">
                    <img id="modal-user-image" src="" class="rounded-circle border border-3 border-white shadow"
                        width="150" height="150" alt="User">
                </div>
                <!-- Right: Comments Section -->
                <div style="flex: 2; display: flex; flex-direction: column;">
                    <div class="p-3 border-bottom">
                        <h5 id="modal-user-name" class="mb-0 fw-bold"></h5>
                    </div>
                    <div class="flex-grow-1 overflow-auto p-3" id="restricted-user-content" style="background: #fafafa;">
                        <p class="text-muted text-center">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    const csrfToken = "{{ csrf_token() }}";

    function fetchData(url, data, callback) {
        fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(res => res.json())
            .then(callback)
            .catch(err => console.error(err));
    }

    // Load More Comments
    document.addEventListener('click', e => {
        if (e.target.id === 'load-more-comments') {
            const btn = e.target;
            btn.textContent = 'Loading...';
            fetch(btn.dataset.nextPage)
                .then(res => res.text())
                .then(html => {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;
                    const newComments = tempDiv.querySelector('#comment-list').innerHTML;
                    document.getElementById('comment-list').insertAdjacentHTML('beforeend', newComments);

                    const newLoadBtn = tempDiv.querySelector('#load-more-comments');
                    if (newLoadBtn) {
                        btn.dataset.nextPage = newLoadBtn.dataset.nextPage;
                        btn.textContent = 'Load More Comments';
                    } else {
                        btn.remove();
                    }
                });
        }
    });

    // Load More Replies
    document.addEventListener('click', e => {
        if (e.target.classList.contains('load-more-replies')) {
            const btn = e.target;
            const commentId = btn.dataset.commentId;
            const offset = btn.dataset.offset;
            const forumId = "{{ $forum->id }}"; // Pass forum ID
            btn.textContent = 'Loading...';

            fetchData("{{ route('admin.forum.actionForum') }}", {
                action: 'load_more_replies',
                comment_id: commentId,
                offset: offset,
                forum_id: forumId // Include forum_id
            }, data => {
                document.querySelector(`#replies-${commentId}`).insertAdjacentHTML('beforeend', data.html);
                if (data.has_more) {
                    btn.dataset.offset = parseInt(offset) + data.loaded;
                    btn.textContent = 'View more replies';
                } else {
                    btn.remove();
                }
            });
        }
    });


    // Delete Comment or Reply
    document.addEventListener('click', e => {
        if (e.target.closest('.delete-comment') || e.target.closest('.delete-reply')) {
            const btn = e.target.closest('.delete-comment') || e.target.closest('.delete-reply');
            const id = btn.dataset.id;
            const type = btn.dataset.type;

            Swal.fire({
                title: 'Are you sure?',
                text: `You want to delete this ${type}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('admin.forum.actionForum') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                action: type === 'comment' ? 'delete_comment' : 'delete_reply',
                                comment_id: type === 'comment' ? id : null,
                                reply_id: type === 'reply' ? id : null
                            })
                        }).then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Deleted!', `${type} has been deleted.`, 'success');
                                if (type === 'comment') {
                                    btn.closest('.comment-item').remove();
                                } else {
                                    btn.closest('.reply-item').remove();
                                }
                            } else {
                                Swal.fire('Error!', `Failed to delete ${type}.`, 'error');
                            }
                        });
                }
            });
        }
    });

    // Restrict User
    document.addEventListener('click', e => {
        if (e.target.closest('.restrict-user')) {
            const btn = e.target.closest('.restrict-user');
            const userId = btn.dataset.id;
            const forumId = btn.dataset.forumId;

            Swal.fire({
                title: 'Are you sure?',
                text: `You want to restrict this user from commenting?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f39c12',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, restrict!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('admin.forum.actionForum') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                action: 'restrict_user',
                                user_id: userId,
                                forum_id: forumId
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Restricted!',
                                    text: 'The user has been restricted.',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', 'Failed to restrict the user.', 'error');
                            }
                        });
                }
            });
        }
    });

    // View Restricted User Comments
    document.addEventListener('click', e => {
        if (e.target.closest('.view-user-comments')) {
            const btn = e.target.closest('.view-user-comments');
            const userId = btn.dataset.id;
            const forumId = btn.dataset.forumId;

            // Update user photo & name in modal header
            const imgSrc = btn.closest('.text-center').querySelector('img').src;
            const userName = btn.closest('.text-center').querySelector('p').innerText;
            document.getElementById('modal-user-image').src = imgSrc;
            document.getElementById('modal-user-name').innerText = userName;

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('restrictedUserModal'));
            modal.show();

            // Load comments
            document.getElementById('restricted-user-content').innerHTML = '<p class="text-muted text-center">Loading...</p>';
            fetch("{{ route('admin.forum.actionForum') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'get_user_comments',
                        user_id: userId,
                        forum_id: forumId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('restricted-user-content').innerHTML = data.html || '<p class="text-center text-muted">No comments or replies found.</p>';
                });
        }
    });


    // Remove Restriction
    document.addEventListener('click', e => {
        if (e.target.closest('.remove-restrict-user')) {
            const btn = e.target.closest('.remove-restrict-user');
            const userId = btn.dataset.id;
            const forumId = btn.dataset.forumId;

            Swal.fire({
                title: 'Are you sure?',
                text: `You want to remove restriction for this user?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, remove!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('admin.forum.actionForum') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                action: 'remove_restricted_user',
                                user_id: userId,
                                forum_id: forumId
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Removed!', 'Restriction removed successfully.', 'success')
                                    .then(() => location.reload());
                            } else {
                                Swal.fire('Error!', 'Failed to remove restriction.', 'error');
                            }
                        });
                }
            });
        }
    });
</script>
@endpush