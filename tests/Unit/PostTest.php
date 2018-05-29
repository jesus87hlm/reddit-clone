<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    Use DatabaseMigrations;
    /** @test */
    public function post_determines_its_author()
    {
        // Arrange
        $user = factory(\App\User::class)->create();
        $post = factory(\App\Post::class)->create([
            'user_id' => $user->id
        ]);
        $postByAnotherUser = factory(\App\Post::class)->create();
        // Act
        $postByAuthor= $post->wasCreatedBy($user);
        $postByAnotherAuthor = $postByAnotherUser->wasCreatedBy($user);
        // Assert
        $this->assertTrue($postByAuthor);
        $this->assertFalse(($postByAnotherAuthor));
    }


    /** @test */
    public function post_determines_its_author_if_null_returns_false()
    {
        // Arrange
        $post = factory(\App\Post::class)->create();

        // Act
        $postByAuthor= $post->wasCreatedBy(null);

        // Assert
        $this->assertFalse($postByAuthor);
    }
}
