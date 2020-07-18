<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite($userID)
    {
        $attributes = ['user_id' => $userID];

        if (!$this->favorites()->where($attributes)->exists()){
            $this->favorites()->create($attributes);
        }
    }
}
