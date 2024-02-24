<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Website extends Model
{
    protected $fillable = ['name'];


    public static function store(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|unique:websites|max:255',
            'url' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return static::create($data);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}