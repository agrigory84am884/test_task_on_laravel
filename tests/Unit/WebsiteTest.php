<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Website;
use App\Models\Subscription;
use App\Jobs\SendNewPostEmail;
use App\Mail\NewPostNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebsiteTest extends TestCase
{
    use RefreshDatabase; // If you want to reset your database after each test

    /** @test */
    public function a_website_has_many_posts()
    {
        $website = Website::factory()->create();
        $post = Post::factory()->create(['website_id' => $website->id]);

        $this->assertTrue($website->posts->contains($post));
    }
    /** @test */
    public function it_dispatches_job_for_new_posts()
    {
        Queue::fake();

        // Assume you have some unsent posts
        $post = Post::factory()->create(['sent' => false]);

        Artisan::call('send:emails-for-new-posts');

        Queue::assertPushed(SendNewPostEmail::class, function ($job) use ($post) {
            return $job->post->id === $post->id;
        });

        // Optionally, check if the post is now marked as sent
        $this->assertTrue(Post::first()->sent);
    }

    /** @test */
    public function a_user_can_subscribe_to_a_website()
    {
        $website = Website::factory()->create();

        $response = $this->post("/api/websites/{$website->id}/subscribe", [
            'email' => 'subscriber@example.com',
        ]);

        $response->assertStatus(201);
        $this->assertCount(1, Subscription::all());
    }

    /** @test */
    public function it_sends_an_email_when_a_post_is_created()
    {
        Mail::fake();

        // Trigger the action that should send the email
        $post = Post::factory()->create();

        // Your logic to dispatch the job that sends the email

        Mail::assertSent(NewPostNotification::class, function ($mail) use ($post) {
            return $mail->post->id === $post->id;
            // Add more assertions here as necessary
        });
    }



}

