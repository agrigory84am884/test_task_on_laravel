<?php

namespace App\Jobs;

use Exception;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use App\Mail\NewPostNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendNewPostEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;
    protected $email;

    /**
     * Create a new job instance.
     *
     * @param  Post  $post
     * @param  string  $email
     * @return void
     */
    public function __construct(Post $post, string $email)
    {
        $this->post = $post;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{

            Mail::to($this->email)->send(new NewPostNotification($this->post));

            $this->post->sent = true;
            $this->post->save();

        } catch (\Exception $exception) {
            // Handle the exception without throwing it
            Log::error($exception->getMessage());
    
            // Optional: Release the job back onto the queue with a delay
            $this->release(60); // Delay in seconds
        }
        
    }
}