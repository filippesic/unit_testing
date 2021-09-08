<?php

namespace Tests\Unit;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    function test_it_fetches_trending_articles()
    {
        // Given
        Article::factory()->count(2)->create();
        Article::factory()->create(['reads' => 10]);
        $mostPopular = Article::factory()->create(['reads' => 20]);

        // When
        $articles = Article::trending()->get();

        // Then

        $this->assertEquals($mostPopular->id, $articles->first()->id);
        $this->assertCount(3, $articles);
    }
}
