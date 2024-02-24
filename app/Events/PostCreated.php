<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\Models\Post;

class PostCreated
{
    use SerializesModels;

    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}
