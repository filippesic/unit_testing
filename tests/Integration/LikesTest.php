<?php

namespace Tests\Integration;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikesTest extends TestCase
{
    use RefreshDatabase;

    protected $post;

    public function setUp() : void
    {
        parent::setUp();

        $this->post = Post::factory()->create();
        $this->signIn();
    }

    /** @test */
    public function a_user_can_like_a_post()
    {
        $this->post->like();

        $this->assertDatabaseHas('likes', [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post)
        ]);

        $this->assertTrue($this->post->isLiked());
    }

    /** @test */
    public function a_user_can_dislike_a_post()
    {

        $this->post->like();
        $this->post->unlike();

        $this->assertDatabaseMissing('likes', [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post)
        ]);

        $this->assertFalse($this->post->isLiked());
    }

    /** @test */
    public function a_user_may_toggle_a_posts_like_status()
    {
        $this->post->toggle();

        $this->assertTrue($this->post->isLiked());

        $this->post->toggle();

        $this->assertFalse($this->post->isLiked());
    }

    /** @test */
    public function a_post_know_how_mnay_likes_it_has()
    {
        $this->post->toggle();

        $this->assertEquals(1, $this->post->likesCount);
    }
}
