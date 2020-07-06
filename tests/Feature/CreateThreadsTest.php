<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_not_create_thread()
    {
        $thread = create(Thread::class);
        $this->post('/threads', $thread->toArray())->assertRedirect('login');

        $this->get('/threads/create')->assertRedirect('login');
    }


    /** @test */
    public function an_authenticated_user_can_create_new_threads()
    {
        $this->signIn();

        $thread = make(Thread::class);
        $respones = $this->post('/threads', $thread->toArray());

        $this->get($respones->headers->get('Location'))->assertSee($thread->title);
    }

    /** @test */
    public function a_thread_require_title()
    {
        $this->publishThread(['title' => null])->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_require_body()
    {
        $this->publishThread(['body' => null])->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_require_valid_channel_id()
    {
        factory(Thread::class,2)->create();
        $this->publishThread(['channel_id' => null])->assertSessionHasErrors('channel_id');
        $this->publishThread(['channel_id' => 6255])->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = [])
    {
        $this->signIn();

        $thread = make(Thread::class, $overrides);
        return $this->post('/threads', $thread->toArray());
    }
}
