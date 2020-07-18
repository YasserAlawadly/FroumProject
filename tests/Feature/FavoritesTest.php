<?php

namespace Tests\Feature;

use App\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoritesTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    function guests_can_not_favorite_anything()
    {
        $this->post('replies/1/favorites')
        ->assertRedirect('/login');

    }

    /** @test */
    function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1 , $reply->favorites);

    }

    /** @test */
    function an_authenticated_user_may_only_favorite_reply_once()
    {
        $this->signIn();

        $reply = create(Reply::class);

        try {
            $this->post('replies/' . $reply->id . '/favorites');
            $this->post('replies/' . $reply->id . '/favorites');
        }catch (\Exception $e){
            $this->fail('Same record twice');
        }

        $this->assertCount(1 , $reply->favorites);

    }
}
