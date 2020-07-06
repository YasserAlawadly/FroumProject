<div class="card-body">
    <h4>{{ $reply->body }}</h4>
    <div class="media-body"><a href="#">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}</div>
</div>
