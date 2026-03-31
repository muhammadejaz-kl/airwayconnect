@foreach($replies as $reply)
    @include('user.forum.partials.reply-item', ['reply' => $reply])
@endforeach
