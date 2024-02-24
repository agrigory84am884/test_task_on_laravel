<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Support\Facades\Artisan;

class SendEmailsForNewPosts
{
    public function handle(PostCreated $event)
    {
        Artisan::call('send:emails-for-new-posts');
    }
}
