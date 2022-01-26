<?php

namespace App\Models;

use App\Models\Like;
use App\Models\Link;
use App\Models\User;
use App\Models\Commentofcomment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',
        'rating',
        'user_id',
        'category_id',
        'link_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function link()
    {
        return $this->belongsTo(Link::class);
    }

    public function commentofcomments()
    {
        return $this->hasMany(Commentofcomment::class)->with('user', 'likes');
    }
    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }
}
