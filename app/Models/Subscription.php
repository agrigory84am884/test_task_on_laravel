<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Subscription extends Model
{
    protected $fillable = ['website_id', 'email'];

    public function store(Request $request)
    {
    $validated = $request->validate([
        'website_id' => 'required|exists:websites,id',
        'email' => [
            'required',
            'email',
            Rule::unique('subscriptions')->where(function ($query) use ($request) {
                return $query->where('website_id', $request->website_id);
            }),
        ],
    ]);

    $subscription = Subscription::create($validated);

    return response()->json($subscription, 201);
}

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
