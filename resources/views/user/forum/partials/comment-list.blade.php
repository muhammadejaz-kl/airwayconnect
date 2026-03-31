@foreach($comments as $comment)
    @include('user.forum.partials.comment', ['comment' => $comment])
@endforeach
