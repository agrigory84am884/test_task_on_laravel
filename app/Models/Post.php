<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Post extends Model
{
    protected $fillable = ['website_id', 'title', 'description'];

    public function store(Request $request)
    {
        $validated = $request->validate([
            'website_id' => 'required|exists:websites,id',
            'title' => 'required|max:255',
            'description' => 'string',
        ]);

        $post = Post::create($validated);

        return response()->json($post, 201);
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
