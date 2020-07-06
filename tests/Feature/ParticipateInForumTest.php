<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthanticated_user_may_not_add_reply()
    {
        create(User::class);

        $thread = create(Thread::class);

        $reply = raw(Reply::class);
        $this->post($thread->path() . '/replies' , $reply)->assertRedirect('login');
    }

    /** @test */
    public function an_authanticated_user_may_participate_in_forum_threads()
    {
        $user = create(User::class);
        $this->actingAs($user);

        $thread = create(Thread::class);

        $reply = make(Reply::class);
        $this->post($thread->path() . '/replies' , $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_requires_body()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $reply = make(Reply::class , ['body' => null]);

        $this->post($thread->path() . '/replies' , $reply->toArray())->assertSessionHasErrors('body');
    }
}
