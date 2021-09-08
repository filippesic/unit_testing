<?php

namespace App\Traits;

use App\Models\Like;

trait Likeability {
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function like()
    {
        $like = new Like(['user_id' => auth()->id()]);

        return $this->likes()->save($like);
    }

    public function unlike()
    {
        return $this->likes()->where('user_id', auth()->id())->delete();
    }

    public function isLiked()
    {
        return !!$this->likes()->where('user_id', auth()->id())->count();
    }

    public function toggle()
    {
        return $this->isLiked() ? $this->unlike() : $this->like();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
}
