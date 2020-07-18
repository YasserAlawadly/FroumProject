<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $thread = create(Thread::class);

        $response = $this->get('/threads')
            ->assertSee($thread->title);
    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        $thread = create(Thread::class);

        $response = $this->get($thread->path())
            ->assertSee($thread->title);
    }

    /** @test */
    public function a_user_can_replies_that_are_associated_with_a_thread()
    {
        $thread = create(Thread::class);

        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $response = $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_tag()
    {
        $channel = create(Channel::class);
        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(Thread::class);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));

        $threadByJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Thread');

        $this->get('/threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

//    function a_user_can_filter_threads_by_popularity()
//    {
//        $threadWithTwoReplies = create('App\Thread');
////        factory(Reply::class , 2)->create(['thread_id' => $threadWithTwoReplies->id]);
//
//        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);
//
//        $threadWithThreeReplies = create('App\Thread');
////        factory(Reply::class , 3)->create(['thread_id' => $threadWithThreeReplies->id]);
//        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);
//
//        $threadWithNoReplies = create('App\Thread');
//
//        $response = $this->getJson('threads?popularity=1')->json();
//
//        $this->assertEquals([3,2,0], array_column($response, 'replies_count'));
//    }

}
