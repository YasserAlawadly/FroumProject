<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_channel_has_many_threads()
    {
        $channel = create(Channel::class);
        $this->assertInstanceOf(Collection::class , $channel->threads);
    }
}
