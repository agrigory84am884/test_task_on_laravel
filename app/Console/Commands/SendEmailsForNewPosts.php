<?php
namespace App\Console\Commands;

use App\Models\Post;
use App\Jobs\SendNewPostEmail;
use Illuminate\Console\Command;
use App\Jobs\SendPostEmail; // Ensure this is pointing to your job

class SendEmailsForNewPosts extends Command
{
    protected $signature = 'send:emails-for-new-posts';
    protected $description = 'Send emails to all subscribers for new posts.';

    public function handle()
    {
        $posts = Post::where('sent', false)->get(); // Fetch unsent posts

        foreach ($posts as $post) {
            $subscribers = $post->website->subscriptions; // Assuming a post belongs to a website and a website has many subscriptions

            foreach ($subscribers as $subscriber) {
                dispatch(new SendNewPostEmail($post, $subscriber->email)); // Dispatch job for each subscriber
            }

            $post->sent = true; // Mark post as sent
            $post->save();
        }

        $this->info('Emails have been sent for all new posts.');
    }
}
