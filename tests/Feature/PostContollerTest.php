<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class PostContollerTest extends TestCase
{
    Use DatabaseMigrations;

    /** @test
     * A basic test example.
     *
     * @return void
     */
    public function guess_can_see_posts()
    {
        // Arrange
        $posts = factory(\App\Post::class, 10)->create();
        $this->assertTrue(true);

        // Act
        $response = $this->get(route('posts_path'));
        $response->assertStatus(200);

        // Assert
        foreach ($posts as $post) {
            $response->assertSee($post->title);
        }
    }

    /** @test */
    public function registered_can_see_posts()
    {
        // Arrange
        $user = factory(\App\User::class)->create();
        $this->userSignIn($user);

        // Act
        $posts = factory(\App\Post::class, 10)->create();
        $this->assertTrue(true);

        // Assert
        $response = $this->get(route('posts_path'));
        $response->assertStatus(200);

        foreach ($posts as $post) {
            $response->assertSee($post->title);
        }
    }


    /** @test */
    public function it_sees_posts_author()
    {
        // Arrange
        $posts = factory(\App\Post::class, 10)->create();

        // Act
        $this->assertTrue(true);

        // Assert
        $response = $this->get(route('posts_path'));
        $response->assertStatus(200);

        foreach ($posts as $post) {
            $response->assertSee($post->title);
            $response->assertSee(e($post->user->name));
        }
    }

    /** @test */
    public function a_guest_cannot_see_a_creation_form()
    {
        // Act
        $response = $this->get(route('create_post_path'));

        // Assert
        $response->assertRedirect('/login');

    }

    /** @test */
    public function a_guest_cannot_create_posts()
    {
        // Act
        $response = $this->post(route('store_post_path'));

        // Assert
        $response->assertRedirect('/login');

    }

    /** @test */
    public function a_registered_user_can_create_post()
    {
        // Arrange
        $user = factory(\App\User::class)->create();
        $this->userSignIn($user);

        // Act
        $this->post(route('store_post_path'), [
            'title' => 'Title',
            'description' => 'Description',
            'url' => 'http://www.google.es',
            'user_id' => $user->id
        ]);

        // Assert
        $this->assertSame(App\Post::count(), 1);
        $post = App\Post::first();
        $this->assertSame($user->id, $post->user_id);
    }

    /** @test */
    public function only_author_can_edit_post()
    {
        // Arrange
        $user = factory(\App\User::class)->create();
        $this->userSignIn($user);
        $post = factory(\App\Post::class)->create(['user_id' => $user->id]);

        // Act
        $response = $this->put(route('update_post_path', ['post' => $post->id]),
            [
                'title' => 'editado',
                'description' => 'editado',
                'url' => 'http://www.editado.es'
            ]);

        // Assert
        $post = \App\Post::first();
        $this->assertSame($post->title, 'editado');
        $this->assertSame($post->description, 'editado');
        $this->assertSame($post->url, 'http://www.editado.es');
    }

    /** @test */
    public function if_not_author_cannot_edit_post()
    {
        // Arrange
        $user = factory(\App\User::class)->create();
        $post = factory(\App\Post::class)->create();

        $this->userSignIn($user);
        // Act
        $response = $this->put(route('update_post_path', ['post' => $post->id]),
            [
                'title' => 'editado',
                'description' => 'editado',
                'url' => 'http://www.editado.es'
            ]);

        // Assert
        $post = \App\Post::first();
        $this->assertNotSame($post->title, 'editado');
        $this->assertNotSame($post->description, 'editado');
        $this->assertNotSame($post->url, 'http://www.editado.es');
    }

    /** @test */
    public function only_author_can_delete_post()
    {
        // Arrange
        $user = factory(\App\User::class)->create();
        $post = factory(\App\Post::class)->create(["user_id" => $user->id]);
        $this->userSignIn($user);

        // Act
        $this->delete(route('delete_post_path', ['post' => $post->id]));
        $response = $this->get(route("posts_path"));

        // Assert
        $response->assertDontSee($post->title);
        $post = $post->fresh();
        $this->assertNull($post);
    }

    /** @test */
    public function if_not_author_cannot_delete_post()
    {
        // Arrange
        $user = factory(\App\User::class)->create();
        $post = factory(\App\Post::class)->create();
        $this->userSignIn($user);

        // Act
        $this->delete(route('delete_post_path', ['post' => $post->id]));
        $response = $this->get(route("posts_path"));

        // Assert
        $response->assertSee($post->title);
        $post = $post->fresh();
        $this->assertNotNull($post);
    }

}
