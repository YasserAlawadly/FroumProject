@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Forum Threads</div>

                    <div class="card-body">
                        <a href="#">{{ $thread->creator->name }}</a>
                        <h4>{{ $thread->title }}</h4>
                        <div class="media-body">{{ $thread->body }}</div>
                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Thread Activities</div>

                    <div class="card-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{ $thread->creator->name }}</a> and currently has
                            {{ $thread->replies_count }}
                            {{ \Illuminate\Support\Str::plural('comment' , $thread->replies_count) }}.
                        </p>
                    </div>

                </div>
            </div>


            <div class="col-md-8 mt-3">
                <div class="card">
                    <div class="card-header">Forum replies</div>

                    <div class="card-body">
                        @foreach($replies as $reply)
                            @include('threads.reply')
                        @endforeach

                        {{ $replies->links() }}
                    </div>

                </div>
            </div>

            @auth()
                <div class="col-md-8 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ $thread->path() . '/replies' }}" method="post">
                                @csrf
                                <div class="form-group">
                                <textarea class="form-control" id="body" rows="3" placeholder="Have something to say?"
                                          name="body"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Post</button>
                            </form>
                        </div>

                    </div>
                </div>
            @else
                <p class="text-center">Please <a href="{{ route('login') }}">SignIn</a> To Reply</p>
            @endauth


        </div>
    </div>
@endsection
